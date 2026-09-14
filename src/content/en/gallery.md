---
layout: base.njk
permalink: /en/gallery/index.html
pageTitle: "Gallery"
htmlId: "index-page"
langCode: "en-US"
bodyClass: "wp-singular page-template page-template-t-gallery page-template-t-gallery-php page page-id-13 page-parent page-child parent-pageid-7 wp-theme-flaviotavares top-page-slug-en"
styleAttr: ""
showHeader: true
menuName: "main-en"
lang: "en"
currentSlug: "gallery"
scripts: ["picturefill","jquery","verticalcenter"]
initJs: "head.ready('_verticalcenter', function(){ var $content = $('#t-gallery').find('.content'); if ($('html').hasClass('gt-640')) { $content.responsiveVerticalCenter({parentSelector:'body'}); } $content.find('a').each(function(){ var $that = $(this); $that.attr('rel', $that.find('img').first().attr('alt')); }); });"
---

<div id="t-gallery">
<div class="container">
     <section class="content">
         <h1 class="main-title">Gallery</h1>
          <p><a href="./drawings/" rel="Drawings"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-406" alt="Drawings" src="/assets/uploads/2013/04/galeria-desenhos.jpg" width="224" height="224"></a></p>
          <p><a href="./engravings/" rel="Engravings"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-407" alt="Engravings" src="/assets/uploads/2013/04/galeria-gravaturas.jpg" width="224" height="224"></a></p>
          <p><a href="./paintings/" rel="Paintings"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-410" alt="Paintings" src="/assets/uploads/2013/04/galeria-pinturas.jpg" width="224" height="224"></a></p>
          <p><a href="./panels/" rel="Panels"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-409" alt="Panels" src="/assets/uploads/2013/04/galeria-paineis.jpg" width="224" height="224"></a></p>
          <p><a href="./others/" rel="Others"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-408" alt="Others" src="/assets/uploads/2013/04/galeria-outros.jpg" width="224" height="224"></a></p>
          <p><a href="./on-sale/" rel="On Sale"><img loading="lazy" decoding="async" class="alignnone size-full wp-image-405" alt="On Sale" src="/assets/uploads/2013/04/galeria-avenda.jpg" width="224" height="224"></a></p>
     </section>
</div>
</div>
