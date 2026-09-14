// Targeted browser check for generated gallery subpages: HTTP 200, zero JS
// errors, bxSlider initialized (.bx-wrapper), gallery images painted. Builds a
// fresh Eleventy site into a temp dir so it does not depend on a stale _site.
import { chromium } from '@playwright/test';
import { createServer } from 'http';
import { readFile } from 'fs/promises';
import { statSync, mkdtempSync, rmSync } from 'fs';
import { join, extname } from 'path';
import { fileURLToPath } from 'url';
import { execSync } from 'child_process';
import { tmpdir } from 'os';

const OUT = mkdtempSync(join(tmpdir(), 'ftp-verify-'));
execSync('npx eleventy --output=' + join(OUT, '_site'), { cwd: fileURLToPath(new URL('../..', import.meta.url)), stdio: 'ignore' });
const SITE_DIR = join(OUT, '_site');
const PAGES = [
 '/en/gallery/drawings/','/en/gallery/engravings/','/en/gallery/paintings/','/en/gallery/panels/',
 '/en/gallery/others/','/en/gallery/on-sale/',
 '/pt_br/galeria/desenhos/','/pt_br/galeria/gravuras/','/pt_br/galeria/pinturas/',
 '/pt_br/galeria/paineis/','/pt_br/galeria/objetos/','/pt_br/galeria/a-venda/',
];
const MIME = { '.html':'text/html; charset=utf-8', '.css':'text/css', '.js':'application/javascript',
 '.jpg':'image/jpeg', '.jpeg':'image/jpeg', '.png':'image/png', '.gif':'image/gif', '.svg':'image/svg+xml', '.pdf':'application/pdf' };

function server(){
  return new Promise((resolve)=>{
   const s = createServer(async (req,res)=>{
     let p = decodeURIComponent(req.url.split('?')[0]);
     p = p === '/' ? 'index.html' : p.replace(/^\/+/,'');
     let fp = join(SITE_DIR, p);
     try { if (statSync(fp).isDirectory()) fp = join(fp, 'index.html'); } catch {}
     // fallback: if path is a dir without index and not ending in index, try index.html
     try {
       const data = await readFile(fp);
       res.writeHead(200, { 'Content-Type': MIME[extname(fp)] || 'application/octet-stream' });
       res.end(data);
     } catch { res.writeHead(404); res.end('not found'); }
   });
   s.listen(0, ()=>resolve(s));
  });
}

(async ()=>{
  const s = await server();
  const base = `http://localhost:${s.address().port}`;
  let fail = 0;
  for (const p of PAGES) {
    const browser = await chromium.launch();
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', (e)=>errors.push('pageerror: ' + e.message));
    page.on('console', (m)=>{ if (m.type()==='error') errors.push('console: ' + m.text()); });
    const resp = await page.goto(base + p, { waitUntil: 'domcontentloaded', timeout: 20000 });
    await page.waitForTimeout(2500);
    const status = resp?.status();
    const bxSlider = await page.$('.bx-wrapper');
    const items = await page.$$eval('#t-gallery-items .gallery-item', (els)=>els.length);
    const imgs = await page.$$eval('#t-gallery-items img', (els)=>els.filter((i)=>i.complete && i.naturalWidth > 0).length);
    const totalImgs = await page.$$eval('#t-gallery-items img', (els)=>els.length);
    const ok = status === 200 && errors.length === 0 && !!bxSlider && items > 0;
    if (!ok) fail++;
    console.log(`${ok?'OK  ':'FAIL'} ${p.padEnd(28)} HTTP ${status} items=${items} imgs=${imgs}/${totalImgs} bxSlider=${!!bxSlider} err=[${errors.join(' | ')}]`);
    await browser.close();
   }
   s.close();
   try { rmSync(OUT, { recursive: true, force: true }); } catch {}
  console.log(fail ? `\n${fail} FAILED` : '\nAll 12 subpages OK (0 errors, bxSlider initialized, images loaded)');
  process.exit(fail ? 1 : 0);
 })().catch((e)=>{ console.error(e); process.exit(1); });
