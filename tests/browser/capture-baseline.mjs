import { chromium } from '@playwright/test';
import { mkdirSync, writeFileSync, existsSync } from 'fs';
import { dirname } from 'path';

const BASE = 'http://127.0.0.1:8082';
const OUT_DIR = new URL('../baseline', import.meta.url).pathname;

const VIEWPORTS = [
   { name: 'mobile',  width: 375, height: 812 },
   { name: 'tablet',  width: 768, height: 1024 },
   { name: 'desktop', width: 1440, height: 900 },
];

// Representative URLs: all 5 custom templates + home + 404 + both locales
const URLS = [
   { path: '/',                        label: 'home' },
    { path: '/en/',                    label: 'en-landing' },
    { path: '/pt_br/',                 label: 'pt-br-landing' },
    { path: '/en/biography/',           label: 'en-biography' },
   { path: '/en/contact/',             label: 'en-contact' },
   { path: '/en/gallery/',             label: 'en-gallery' },
   { path: '/en/gallery/drawings/',    label: 'en-gallery-drawings' },
   { path: '/en/video/',               label: 'en-videos' },
   { path: '/pt_br/biografia/',        label: 'pt-br-biografia' },
   { path: '/nonexistent-page-xyz/',   label: '404-probe' },
];

// Fixed wait (ms) after domcontentloaded for JS-init (head.js, bxSlider, picturefill)
const SETTLE_MS = 2500;

// Each URL×viewport runs in its own browser context to avoid the "browser closed"
// issue seen when reusing a single browser across many newPage() calls.
async function capture() {
  const results = [];
  for (const { path: urlPath, label } of URLS) {
    for (const vp of VIEWPORTS) {
      const url = `${BASE}${urlPath}`;
      const consoleErrors = [];
      let html = '';
      let status = null;
      let finalUrl = url;
      let error = null;
      try {
        const browser = await chromium.launch();
        try {
          const context = await browser.newContext({ viewport: { width: vp.width, height: vp.height } });
          const page = await context.newPage();

          page.on('console', m => { if (m.type() === 'error') consoleErrors.push(m.text()); });
          page.on('pageerror', e => consoleErrors.push(`[pageerror] ${e.message}`));

          const resp = await page.goto(url, {
            waitUntil: 'domcontentloaded',
            timeout: 20000,
          });
          status = resp?.status() ?? null;
          finalUrl = page.url();

          // Give JS-init a fixed settle window instead of networkidle (the head.js
          // loader can leave a request in flight).
          await page.waitForTimeout(SETTLE_MS);

          const title = await page.title();
          html = await page.content();

          const subdir = `${OUT_DIR}/${label}/${vp.name}`;
          mkdirSync(subdir, { recursive: true });
          writeFileSync(`${subdir}/page.html`, html);
          await page.screenshot({ path: `${subdir}/page-${vp.name}.png`, fullPage: true });

          results.push({
            url, label, vp: vp.name,
            status, finalUrl,
            htmlBytes: html.length,
            title,
            consoleErrors,
          });
        } finally {
          await browser.close();
        }
      } catch (err) {
        error = String(err).split('\n')[0];
        results.push({ url, label, vp: vp.name, status: null, error });
      }
      console.log(
        `${error ? 'FAIL' : 'ok  '}  ${url.padEnd(44)} ${vp.name.padEnd(8)}  ` +
        `${error ? 'ERR' : `HTTP ${status}`}  ${error ? error.slice(0, 60) : `${html.length}b html`}` +
        `${consoleErrors.length ? `  ⚠ ${consoleErrors.length} console error(s)` : ''}`
      );
    }
  }
  return results;
}

(async () => {
console.log('Capturing WordPress browser baseline…');
const results = await capture();

const summaryFile = `${OUT_DIR}/baseline-summary.json`;
writeFileSync(summaryFile, JSON.stringify(results, null, 2));

let pass = 0, fail = 0, errCount = 0;
for (const r of results) {
   if (r.error) { fail++; continue; }
   const expected = r.label === '404-probe' ? 404 : 200;
   const ok = r.status === expected;
   ok ? pass++ : fail++;
   if (r.consoleErrors.length) errCount += r.consoleErrors.length;
}
console.log(`\nSummary: ${pass} PASS / ${fail} FAIL / ${errCount} console errors`);
console.log(`Screenshots + HTML: ${OUT_DIR}/<label>/<viewport>/`);
console.log(`Summary JSON:       ${summaryFile}`);

process.exit(fail === 0 ? 0 : 1);
})().catch(e => { console.error(e); process.exit(1); });
