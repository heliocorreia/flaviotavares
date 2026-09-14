import { chromium } from '@playwright/test';

const PAGES = [' /en/gallery/on-sale/'.trim(), '/en/video/', '/pt_br/galeria/pinturas/'];
const browser = await chromium.launch();
const ctx = await browser.newContext({ viewport: { width: 1280, height: 800 } });

async function openAndMeasure(port, path) {
    const page = await ctx.newPage();
    const navs = [];
    page.on('request', (r) => { if (r.resourceType === 'document' && r.url().includes('/uploads/')) navs.push(r.url()); });
    await page.goto(`http://127.0.0.1:${port}${path}`, { waitUntil: 'networkidle' });
    await page.addStyleTag({ content: '#header,#nav-main,#top-main{display:none!important;position:absolute;pointer-events:none;}' });
    await page.waitForTimeout(2500); // let head.js chain + tosrus bind
       // real mouse click on first anchor center
    const anchor = page.locator('#t-gallery-items .gallery a, #t-videos .section a').first();
    const bb = await anchor.boundingBox();
    if (!bb) { await page.close(); return { err: 'no anchor' }; }
    await page.mouse.click(bb.x + bb.width / 2, bb.y + bb.height / 2);
       // poll up to 10s for an open (display!=none)
    let opened = false;
    for (let i = 0; i < 50; i++) {
      opened = await page.evaluate(() => {
        const w = document.querySelector('.tos-wrapper');
        return !!(w && getComputedStyle(w).display !== 'none');
       });
      if (opened) break;
      await page.waitForTimeout(200);
      // re-click in case it closed
      await page.mouse.click(bb.x + bb.width / 2, bb.y + bb.height / 2).catch(() => {});
     }
    const res = await page.evaluate(() => {
       const w = document.querySelector('.tos-wrapper');
      if (!w) return { display: 'no-wrapper' };
      const s = getComputedStyle(w);
      const img = w.querySelector('.tos-slide > img, .tos-slide > *');
      const ib = img && img.getBoundingClientRect ? img.getBoundingClientRect() : null;
      const ws = w.getBoundingClientRect();
       // centered = img roughly centered in viewport
      const vp = { w: innerWidth, h: innerHeight };
      const imgCenterX = ib ? ib.x + ib.width / 2 : null;
      const imgCenterY = ib ? ib.y + ib.height / 2 : null;
      const centeredX = imgCenterX != null && Math.abs(imgCenterX - vp.w / 2) < vp.w * 0.15;
      const centeredY = imgCenterY != null && Math.abs(imgCenterY - vp.h / 2) < vp.h * 0.2;
      return {
        display: s.display,
        wrapper: { x: ws.x, y: ws.y, w: ws.width, h: ws.height },
        img: ib ? { x: ib.x, y: ib.y, w: ib.width, h: ib.height, cx: imgCenterX, cy: imgCenterY } : null,
        viewport: vp,
        imgCenteredX: centeredX,
        imgCenteredY: centeredY,
        slideChildren: Array.from(w.querySelectorAll('.tos-slide')).map((sl) => ({ w: sl.getBoundingClientRect().width, h: sl.getBoundingClientRect().height, child: sl.children[0]?.tagName })),
       };
     });
    await page.close();
    return res;
}

for (const path of PAGES) {
    const live = await openAndMeasure('8082', path);
    const stat = await openAndMeasure('8080', path);
    console.log(`\n=== ${path} ===`);
    console.log('LIVE  ', JSON.stringify(live));
    console.log('STATIC', JSON.stringify(stat));
}
await browser.close();
