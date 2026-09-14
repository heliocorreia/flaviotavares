// Comprehensive per-page check across all languages: HTTP 200, zero JS pageerrors,
// and page-specific widget init. Builds a fresh Eleventy site into a temp dir and
// serves it (independent of the locked _site / --serve process).
import { chromium } from '@playwright/test';
import { createServer } from 'http';
import { readFile } from 'fs/promises';
import { statSync, mkdtempSync, rmSync } from 'fs';
import { join, extname } from 'path';
import { fileURLToPath } from 'url';
import { execFileSync } from 'child_process';
import { tmpdir } from 'os';

// ../../.. from site/tests/browser/ is the repo root.
const REPO = fileURLToPath(new URL('../../..', import.meta.url));
const SITE = join(REPO, 'site');
const OUT = mkdtempSync(join(tmpdir(), 'ftp-all-'));
const SITE_DIR = join(OUT, '_site');
execFileSync(join(SITE, 'node_modules/.bin/eleventy'), ['--output=' + SITE_DIR], { cwd: SITE, stdio: 'pipe' });
try { statSync(SITE_DIR); } catch { throw new Error('build did not produce output at ' + SITE_DIR); }

// Every menu href (both languages) + landing pages.
const PAGES = [
   // en
   '/en/','/en/biography/','/en/gallery/','/en/video/','/en/contact/',
   '/en/gallery/drawings/','/en/gallery/engravings/','/en/gallery/paintings/',
   '/en/gallery/panels/','/en/gallery/others/','/en/gallery/on-sale/',
   // pt_br
   '/pt_br/','/pt_br/biografia/','/pt_br/galeria/','/pt_br/videos/','/pt_br/contato/',
   '/pt_br/galeria/desenhos/','/pt_br/galeria/gravuras/','/pt_br/galeria/pinturas/',
   '/pt_br/galeria/paineis/','/pt_br/galeria/objetos/','/pt_br/galeria/a-venda/',
   // root
   '/',
];
// widget selector expected per page. bxSlider (.bx-wrapper) inits on gallery-*
// subpages and the video page; gallery index / contact / biography use
// responsiveVerticalCenter (no bxWrapper), so they are not checked for it.
function expectWidget(u) {
   const isSubpage = /(gallery|galeria)\/[^/]+\/$/.test(u); // /x/gallery/drawings/
   const isVideo = /\/videos?\/?$/.test(u);                  // /en/video/, /pt_br/videos/
   return isSubpage || isVideo ? '.bx-wrapper' : null;
}

const MIME = { '.html':'text/html; charset=utf-8', '.css':'text/css', '.js':'application/javascript',
   '.jpg':'image/jpeg', '.jpeg':'image/jpeg', '.png':'image/png', '.gif':'image/gif', '.svg':'image/svg+xml', '.pdf':'application/pdf' };

async function main() {
  const server = new Promise((resolve)=>{
   const s = createServer(async (req,res)=>{
     let p = decodeURIComponent(req.url.split('?')[0]);
     p = p === '/' ? 'index.html' : p.replace(/^\/+/,'');
     let fp = join(SITE_DIR, p);
     try { if (statSync(fp).isDirectory()) fp = join(fp, 'index.html'); } catch {}
     try {
       const data = await readFile(fp);
       res.writeHead(200, { 'Content-Type': MIME[extname(fp)] || 'application/octet-stream' });
       res.end(data);
      } catch { res.writeHead(404); res.end('not found'); }
    });
   s.listen(0, ()=>resolve(s));
   });
  const port = (await server).address().port;
  const base = `http://localhost:${port}`;

  let fail = 0;
  for (const u of PAGES) {
    const browser = await chromium.launch();
    const page = await browser.newPage();
    const errs = [];
    page.on('pageerror', (e)=>errs.push(e.message));
    page.on('console', (m)=>{ if (m.type()==='error') errs.push('['+m.type()+'] '+m.text()); });
    let status;
    try { const r = await page.goto(base + u, { waitUntil: 'domcontentloaded', timeout: 20000 }); status = r?.status(); }
    catch (e) { status = 'ERR:'+ (e.message||'').split('\n')[0]; }
    await page.waitForTimeout(1800);
    const widget = expectWidget(u);
    const widgetOk = widget ? await page.$(widget) : true ;
    // content sanity: body has non-whitespace text
    const bodyText = await page.evaluate(()=>document.body ? document.body.innerText.trim().length : 0).catch(()=>0);
    const ok = status === 200 && errs.length === 0 && !!widgetOk && bodyText > 0;
    if (!ok) fail++;
    const wv = widget ? ` widget=${widget}=${!!widgetOk}` : '';
    console.log(`${ok?'OK  ':'FAIL'} ${u.padEnd(28)} HTTP ${String(status).padEnd(6)} body=${bodyText} err=[${errs.join(' | ')}]${wv}`);
    await browser.close();
   }
  (await server).close();
  rmSync(OUT, { recursive: true, force: true });
  console.log(fail ? `\n${fail} FAILED of ${PAGES.length}` : `\nAll ${PAGES.length} pages OK (0 errors, widgets init, content present)`);
  process.exit(fail ? 1 : 0);
}
main().catch((e)=>{ console.error(e); process.exit(1); });
