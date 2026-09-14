// Compare the built Eleventy static site (_site) against the captured WordPress
// browser baseline (tests/baseline). Mirrors capture-baseline.mjs: same URLs,
// same viewports, same settle window — but serves the static _site so we can prove
// the migrated DOM is equivalent once WordPress runtime noise is stripped.
//
// Two signals, reported separately:
//   1. HTML diff (authoritative): rendered _site HTML vs baseline page.html,
//      normalized to remove WP-only runtime noise (emoji/speculation scripts,
//      sourceURL comments, host+query). Reports an unified diff.
//   2. Screenshot diff (visual reference): PNG size + byte-equality vs baseline.
//      Note: screenshots depend on JS execution; head.js/bxslider/picturefill
//      init may differ, so treat byte inequality as "review the diff", not fail.

import { chromium } from '@playwright/test';
import { createServer } from 'http';
import { mkdirSync, writeFileSync, existsSync, readFileSync } from 'fs';
import { readFile, stat } from 'fs/promises';
import { dirname, join, normalize } from 'path';
import { fileURLToPath } from 'url';

const SITE_DIR = fileURLToPath(new URL('../../_site', import.meta.url));
const BASELINE_DIR = fileURLToPath(new URL('../baseline', import.meta.url));
const OUT_DIR = new URL('../compare', import.meta.url).pathname;

const VIEWPORTS = [
   { name: 'mobile',  width: 375,  height: 812 },
   { name: 'tablet',  width: 768,  height: 1024 },
   { name: 'desktop', width: 1440, height: 900 },
];

// label -> served path (leading slash). Matches capture-baseline URLS.
const ROUTES = [
    { path: '/',                        label: 'home' },
    { path: '/en/',                     label: 'en-landing' },
    { path: '/pt_br/',                 label: 'pt-br-landing' },
    { path: '/en/biography/',           label: 'en-biography' },
   { path: '/en/contact/',             label: 'en-contact' },
   { path: '/en/gallery/',             label: 'en-gallery' },
   { path: '/en/gallery/drawings/',    label: 'en-gallery-drawings' },
   { path: '/en/video/',               label: 'en-videos' },
   { path: '/pt_br/biografia/',        label: 'pt-br-biografia' },
];

const SETTLE_MS = 2500;

const MIME = {
   '.html': 'text/html; charset=utf-8',
   '.css':  'text/css',
   '.js':   'application/javascript',
   '.jpg':  'image/jpeg', '.jpeg': 'image/jpeg',
   '.png':  'image/png',  '.gif':  'image/gif',
   '.svg':  'image/svg+xml',
};

// Serve the static _site. Trailing-slash paths resolve to index.html.
function startServer() {
  return new Promise((resolve) => {
    const server = createServer(async (req, res) => {
      let urlPath = decodeURIComponent(req.url.split('?')[0]);
      let rel = urlPath === '/' ? 'index.html' : urlPath.replace(/^\/+/, '');
      let filePath = normalize(join(SITE_DIR, rel));
      if (!filePath.startsWith(SITE_DIR)) { res.writeHead(403); res.end('forbidden'); return; }
      // directory -> index.html
      try {
        const st = await stat(filePath);
        if (st.isDirectory()) filePath = normalize(join(filePath, 'index.html'));
      } catch { /* fall through to stat below */ }
      try {
        const data = await readFile(filePath);
        const ext = filePath.slice(filePath.lastIndexOf('.'));
        res.writeHead(200, { 'Content-Type': MIME[ext] || 'application/octet-stream' });
        res.end(data);
      } catch {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('404 not found');
      }
    });
    server.listen(0, '127.0.0.1', () => resolve(server));
  });
}

// Strip WordPress runtime noise so the two DOMs can be compared on structure.
function stripWpNoise(html) {
   return html
        .replace(/<script type="module">[\s\S]*?<\/script>/g, '')        // wp-emoji loader
        .replace(/<script type="speculationrules">[\s\S]*?<\/script>/g, '')
        .replace(/<script id="wp-emoji-settings"[^>]*>[\s\S]*?<\/script>/g, '')
        .replace(/<!--\s*#\s*sourceURL=[^\n]*\n/g, '')                    // /*# sourceURL..*/
        .replace(/<link rel="https:\/\/api\.w\.org\/"[^>]*>/g, '')
        .replace(/<link rel="EditURI"[^>]*>/g, '')
        .replace(/<link rel="alternate"[^>]*>/g, '')
        .replace(/<!\[if[^\]]*\]>|<!\[endif\]-->/gi, '')                // IE conditional soup
        .replace(/<!-->[\s\S]*?<!\[endif\]-->/gi, '')
        .replace(/<\!\[endif\]-->/gi, '')
        // Per-page WP-inline stylesheets (not theme content; identical shape).
         .replace(/<style id="wp-[^"]*"[^>]*>[\s\S]*?<\/style>/g, '')
        .replace(/<style id="classic-theme-styles-inline-css">[\s\S]*?<\/style>/g, '')
        .replace(/<style id="global-styles-inline-css">[\s\S]*?<\/style>/g, '')
        // <html>/<body> class attribute soup is produced by different JS at runtime
        // in each capture (WP's modernizr + our head.js). Normalize to compare inner
        // structure instead.
         .replace(/<(html|body)([^>]*?)class="[^"]*"/gi, (m, tag, rest) =>
              `<${tag}${rest.replace(/\s*class="[^"]*"/, '')}`)
        .replace(/http:\/\/localhost:\d+/g, 'http://BASE')              // host normalization
        .replace(/http:\/\/127\.0\.0\.1:\d+/g, 'http://BASE')
        .replace(/\s+/g, ' ')                                            // collapse whitespace
        .trim();
    }

// Minimal unified diff over normalized lines (good enough to eyeball deltas).
function diffLines(a, b) {
  const A = a.split('\n'), B = b.split('\n');
  const out = [];
  // trivial line-by-line LCS-free alignment: report only if counts differ,
  // else surface the first divergence index.
  if (A.length === 1 && B.length === 1 && A[0] === B[0]) return { same: true, out: [] };
  let max = Math.max(A.length, B.length);
  for (let i = 0; i < max; i++) {
    const la = A[i] ?? '<eof>', lb = B[i] ?? '<eof>';
    if (la !== lb) {
      out.push(`@ line ${i + 1}`);
      out.push(`- ${la.slice(0, 300)}`);
      out.push(`+ ${lb.slice(0, 300)}`);
    }
  }
  return { same: out.length === 0, out };
}

async function capture() {
  const server = await startServer();
  const { port } = server.address();
  const base = `http://127.0.0.1:${port}`;
   const results = [];
   const only = process.env.LABELS ? new Set(process.env.LABELS.split(/\s+/)) : null;
  for (const { path: urlPath, label } of ROUTES) {
   if (only && !only.has(label)) continue;
    for (const vp of VIEWPORTS) {
      const url = `${base}${urlPath}`;
      const baselineHtml = join(BASELINE_DIR, label, vp.name, 'page.html');
      const baselinePng  = join(BASELINE_DIR, label, vp.name, `page-${vp.name}.png`);
      const outSub = join(OUT_DIR, label, vp.name);
      mkdirSync(outSub, { recursive: true });
       const row = { label, vp: vp.name, url, status: null };
       let html = '';
       try {
         const browser = await chromium.launch();
         try {
           const ctx = await browser.newContext({ viewport: { width: vp.width, height: vp.height } });
           const page = await ctx.newPage();
           const resp = await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 20000 });
           row.status = resp?.status() ?? null;
           await page.waitForTimeout(SETTLE_MS);
           html = await page.content();
           writeFileSync(join(outSub, 'page.html'), html);
           await page.screenshot({ path: join(outSub, `page-${vp.name}.png`), fullPage: true });
          } finally { await browser.close(); }

        // HTML structure compare vs baseline (normalized).
        if (existsSync(baselineHtml)) {
          const baseHtml = stripWpNoise(readFileSync(baselineHtml, 'utf-8'));
          const siteHtml = stripWpNoise(html);
          const d = diffLines(baseHtml, siteHtml);
          row.htmlDiff = d;
        } else {
          row.htmlDiff = { same: false, out: ['no baseline page.html'] };
        }
        // Screenshot compare (byte size + identity).
        if (existsSync(baselinePng)) {
          const siteSize = (await stat(join(outSub, `page-${vp.name}.png`))).size;
          const baseSize = (await stat(baselinePng)).size;
          row.png = { baseBytes: baseSize, siteBytes: siteSize, delta: siteSize - baseSize };
        }
        } catch (e) { row.error = String(e && e.stack || e).split('\n')[0]; }
      results.push(row);
    }
  }
  server.close();
  return results;
}

(async () => {
  console.log('Comparing _site vs WordPress baseline…');
  const results = await capture();
  writeFileSync(join(OUT_DIR, 'compare-summary.json'), JSON.stringify(results, null, 2));

  let htmlSame = 0, htmlDiff = 0, failed = 0;
  for (const r of results) {
    if (r.error) { failed++; console.log(`FAIL  ${r.label}/${r.vp}: ${r.error}`); continue; }
    const tag = String(r.status).padEnd(4);
    console.log(`${r.htmlDiff?.same ? 'match' : 'DIFF '}  ${r.label.padEnd(16)} ${r.vp.padEnd(7)} HTTP ${tag}` +
      (r.png ? `  png ${r.png.baseBytes}→${r.png.siteBytes} (${r.png.delta >= 0 ? '+' : ''}${r.png.delta})` : ''));
    r.htmlDiff?.same ? htmlSame++ : htmlDiff++;
  }
  console.log(`\nHTML: ${htmlSame} match / ${htmlDiff} diff · ${failed} failed`);
  console.log(`Screenshots + HTML: ${OUT_DIR}/<label>/<viewport>/`);
  console.log(`Summary JSON:       ${join(OUT_DIR, 'compare-summary.json')}`);
  process.exit(0);
})().catch(e => { console.error(e); process.exit(1); });
