const fs = await import('node:fs');
const BASE = 'http://localhost:8082';
const PAGES = [
 'en/gallery/engravings','en/gallery/others','en/gallery/on-sale','en/gallery/panels',
 'en/gallery/paintings','en/gallery/drawings','pt_br/galeria/desenhos','pt_br/galeria/gravuras',
 'pt_br/galeria/pinturas','pt_br/galeria/paineis','pt_br/galeria/objetos','pt_br/galeria/a-venda',
];
function norm(s) {
  return s.replace(/'/g, '"')
     .replace(/http:\/\/localhost:8082\/wp-content\/uploads/g, '/assets/uploads')
     .replace(/<br\s*\/>/gi, '<br>')
     .replace(/\s+/g, ' ')
     .trim();
}
function items(html) {
  const start = html.indexOf('<div id="t-gallery-items">');
  const region = html.slice(start);
  const sc = region.indexOf('<script>');
  const gallery = region.slice(0, sc);
  const re = /<dl class=\\?['"]gallery-item[^]*?<\/dl>/g;
  const blocks = [...gallery.matchAll(re)].map((m) => norm(m[0]));
  return blocks;
}
for (const p of PAGES) {
  const live = await (await fetch(BASE + '/' + p + '/')).text();
  const built = fs.readFileSync('site/_site/' + p + '/index.html', 'utf8');
  const a = items(live), b = items(built);
  let diffs = 0;
  for (let i = 0; i < Math.max(a.length, b.length); i++) {
    if (a[i] !== b[i]) diffs++;
  }
  const ok = diffs === 0 && a.length === b.length;
  console.log(`${p.padEnd(26)} live=${a.length} built=${b.length} itemDiffs=${diffs} ${ok ? 'OK' : '<-- REVIEW'}`);
}
