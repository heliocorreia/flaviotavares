// DOM-parity for content (non-gallery) pages: extract the main content region from
// the live WP page (:8082) and from the static build, normalize non-content
// differences, and diff significant blocks (headings / address / img anchors).
//
// Live vs built legitimately differ in ways that are NOT content; the normalizer
// strips them so only true content mismatches surface:
//   - quote style, upload URL form (/wp-content/uploads -> /assets/uploads)
//   - lazy-load / perf img hints the static build intentionally omits
//   - HTML entities (em dash, smart quotes), self-closing <img /> whitespace
//   - runs of whitespace (live uses tabs/newlines, the .md uses spaces)
// Pre-existing source mojibake (live WP "Atelier Flavio" vs our correct "Flávio",
// unchanged in HEAD) is accepted as a source-fidelity note, not a regression.
import { createServer } from 'http';
import { readFileSync, statSync, mkdtempSync, rmSync } from 'fs';
import { join, extname } from 'path';
import { fileURLToPath } from 'url';
import { execFileSync } from 'child_process';
import { tmpdir } from 'os';

const REPO = fileURLToPath(new URL('../../..', import.meta.url));
const SITE = join(REPO, 'site');
const OUT = mkdtempSync(join(tmpdir(), 'ftp-parity-'));
const SITE_DIR = join(OUT, '_site');
execFileSync(join(SITE, 'node_modules/.bin/eleventy'), ['--output=' + SITE_DIR], { cwd: SITE, stdio: 'pipe' });
const WP = 'http://localhost:8082';

// { live (fetched URL), built (output file), sel (content-region id, with #) }
const PAGES = [
   { live: '/pt_br/videos/',  built: 'pt_br/videos/index.html',  sel: 't-videos' },
   { live: '/pt_br/contato/', built: 'pt_br/contato/index.html', sel: 't-contact' },
   { live: '/en/video/',      built: 'en/video/index.html',      sel: 't-videos' },
   { live: '/en/contact/',    built: 'en/contact/index.html',    sel: 't-contact' },
];

const MIME = { '.html':'text/html; charset=utf-8', '.css':'text/css', '.js':'application/javascript',
       '.jpg':'image/jpeg', '.jpeg':'image/jpeg', '.png':'image/png', '.gif':'image/gif', '.svg':'image/svg+xml', '.pdf':'application/pdf' };

function startServer() {
   return new Promise((resolve)=>{
     const s = createServer(async (req, res)=>{
      let p = decodeURIComponent(req.url.split('?')[0]);
      p = p === '/' ? 'index.html' : p.replace(/^\/+/, '');
      let fp = join(SITE_DIR, p);
      try { if (statSync(fp).isDirectory()) fp = join(fp, 'index.html'); } catch {}
      try {
        const d = await readFileSyncPromise(fp);
        res.writeHead(200, { 'Content-Type': MIME[extname(fp)] || 'application/octet-stream' });
        res.end(d);
       } catch { res.writeHead(404); res.end('no'); }
     });
     s.listen(0, ()=>resolve(s));
    });
}
async function readFileSyncPromise(fp) {
   const { readFile } = await import('fs/promises');
   return readFile(fp);
}

function norm(s) {
   return s
       .replace(/'/g, '"')
       .replace(/https?:\/\/localhost:8082\/wp-content\/uploads/g, '/assets/uploads')
       .replace(/\/wp-content\/uploads/g, '/assets/uploads')
       .replace(/\s+loading="[^"]*"/g, '')
       .replace(/\s+decoding="[^"]*"/g, '')
       .replace(/\s+fetchpriority="[^"]*"/g, '')
       .replace(/&#8211;/g, '–').replace(/&#8217;/g, '’').replace(/&#8216;/g, '‘')
       .replace(/&#8220;/g, '“').replace(/&#8221;/g, '”').replace(/&nbsp;/g, ' ')
       .replace(/<br\s*\/>/gi, '<br>')
       .replace(/"(?:\s*\/)?>/g, '">')   // unify self-closing img: " /" -> ">".
       .replace(/\s+/g, ' ')
       .trim();
}

// Pull the significant block-level units inside the content region, normalized.
function blocksFrom(html, sel) {
   const open = html.indexOf('id="' + sel + '"');
   const close = html.indexOf('</section>', open);
   const region = open >= 0 && close >= 0 ? html.slice(open, close + 10) : '';
   const re = /<h1\b[^>]*>[\s\S]*?<\/h1>|<h2\b[^>]*>[\s\S]*?<\/h2>|<address\b[\s\S]*?<\/address>|<a\b[^>]*>\s*<img\b[^>]*>/g;
   const out = [];
   let m;
   while ((m = re.exec(region))) out.push(norm(m[0]));
   return out;
}

async function main() {
   const s = await startServer();
   let fails = 0;
   for (const p of PAGES) {
     const liveHtml = await (await fetch(WP + p.live)).text();
     const builtHtml = readFileSync(join(SITE_DIR, p.built), 'utf8');
     const a = blocksFrom(liveHtml, p.sel);
     const b = blocksFrom(builtHtml, p.sel);
     let diffs = 0;
     for (let k = 0; k < Math.max(a.length, b.length); k++) {
       if (a[k] !== b[k]) {
         diffs++;
         if (diffs <= 4) console.log(`       L${k}: live=${JSON.stringify(a[k]||'(none)')}\n             built=${JSON.stringify(b[k]||'(none)')}`);
         }
       }
     const ok = diffs === 0 && a.length > 0;
     if (!ok) fails++;
     console.log(`${ok ? 'OK   ' : 'DIFF '} ${p.live.padEnd(18)} blocks=${a.length}/built=${b.length} diffs=${diffs}`);
     }
   s.close();
   rmSync(OUT, { recursive: true, force: true });
   console.log(fails ? `\n${fails} page(s) differ` : `\nAll content pages DOM-match live source (content only)`);
   process.exit(fails ? 1 : 0);
}
main().catch((e)=>{ console.error(e); process.exit(1); });
