// Verifies the tosros lightbox centers identically on live WP (:8082) vs the
// static build (:8080) for gallery + video pages. Clicks the first gallery/video
// anchor and compares the opened .tos-wrapper geometry + centered content.
import { chromium } from '@playwright/test';

const PAGES = [
  { label: 'en/on-sale', live: '/en/gallery/on-sale/', static: '/en/gallery/on-sale/' },
  { label: 'en/video', live: '/en/video/', static: '/en/video/' },
  { label: 'pt_br/pinturas', live: '/pt_br/galeria/pinturas/', static: '/pt_br/galeria/pinturas/' },
];

async function measure(wrapper, host, page) {
  const box = await wrapper.boundingBox();
  const win = { w: await page.evaluate(() => window.innerWidth), h: await page.evaluate(() => window.innerHeight) };
  // the centered content element inside the active slide
  const content = await wrapper.$('.tos-slide > *, .tos-content, img');
  let cbox = null, ctag = null;
  if (content) {
    cbox = await content.boundingBox();
    ctag = await content.evaluate((el) => el.tagName + '.' + (el.className || '').toString().slice(0, 20));
  }
  return { host, box, win, cbox, ctag };
}

const browser = await chromium.launch();
const ctx = await browser.newContext({ viewport: { width: 1280, height: 800 } });
let failures = 0;

for (const { label, live: livePath } of PAGES) {
   // ---- live :8082 ----
  const pLive = await ctx.newPage();
  const liveErrors = [];
  pLive.on('pageerror', (e) => liveErrors.push(e.message));
  await pLive.goto('http://127.0.0.1:8082' + livePath, { waitUntil: 'networkidle' });
  await pLive.addStyleTag({ content: '#header, #nav-main, nav.nav-main, #top-main { display:none !important; }' });
  await pLive.waitForTimeout(1200);
  await pLive.locator('#t-gallery-items .gallery a, #t-videos .section a').first().click({ force: true });
  await pLive.waitForFunction(() => {
      const w = document.querySelector('.tos-wrapper');
      return w && getComputedStyle(w).display !== 'none';
    }, { timeout: 15000 });
  await pLive.waitForTimeout(400);
  const liveWrapper = pLive.locator('.tos-wrapper').first();
  const liveVis = await liveWrapper.isVisible();
  const Rlive = await measure(liveWrapper, 'LIVE:8082', pLive);

   // ---- static :8080 ----
  const pStat = await ctx.newPage();
  const statErrors = [];
  pStat.on('pageerror', (e) => statErrors.push(e.message));
  await pStat.goto('http://127.0.0.1:8080' + livePath, { waitUntil: 'networkidle' });
  await pStat.addStyleTag({ content: '#header, #nav-main, nav.nav-main, #top-main { display:none !important; }' });
  await pStat.waitForTimeout(1200);
  await pStat.locator('#t-gallery-items .gallery a, #t-videos .section a').first().click({ force: true });
  await pStat.waitForFunction(() => {
      const w = document.querySelector('.tos-wrapper');
      return w && getComputedStyle(w).display !== 'none';
     }, { timeout: 15000 });
  await pStat.waitForTimeout(400);
  const statWrapper = pStat.locator('.tos-wrapper').first();
  const statVis = await statWrapper.isVisible();
  const Rstat = await measure(statWrapper, 'STATIC:8080', pStat);

  const near = (a, b, t = 3) => a != null && b != null && Math.abs(a - b) <= t;
  const boxOk = near(Rlive.box.x, Rstat.box.x) && near(Rlive.box.y, Rstat.box.y) && near(Rlive.box.width, Rstat.box.width) && near(Rlive.box.height, Rstat.box.height);
  const centeringOk = Rstat.box.x !== undefined && near(Rstat.box.x, 0, 1) && near(Rstat.box.y, 0, 1) && near(Rstat.box.width, Rstat.win.w, 2) && near(Rstat.box.height, Rstat.win.h, 2);

  console.log('--- ' + label + ' ---');
  console.log('  LIVE   box=', JSON.stringify(Rlive.box), 'visible=', liveVis, 'content=', Rlive.ctag, 'liveErrs=', liveErrors.length);
  console.log('  STATIC box=', JSON.stringify(Rstat.box), 'visible=', statVis, 'content=', Rstat.ctag, 'statErrs=', statErrors.length);
  console.log('  boxParity(live==static):', boxOk ? 'OK' : 'DIFF', '| static centered-to-viewport:', centeringOk ? 'OK' : 'FAIL');
  if (!centeringOk) failures++;
  await pLive.close();
  await pStat.close();
}

await browser.close();
console.log('\n' + (failures ? `${failures} page(s) NOT centered` : 'All pages: lightbox centered ✓'));
process.exit(failures ? 1 : 0);
