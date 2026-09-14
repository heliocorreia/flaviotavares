---
layout: base.njk
permalink: /en/index.html
pageTitle: "English"
htmlId: "index-page"
langCode: "en-US"
bodyClass: "wp-singular page-template-default page page-id-7 page-parent wp-theme-flaviotavares top-page-slug-en"
styleAttr: ""
showHeader: true
menuName: "main-en"
lang: "en"
currentSlug: "main"
scripts: ["picturefill","jquery","bxslider"]
---

<div id="gallery-1" class="gallery galleryid-7 gallery-columns-3 gallery-size-smart">
<dl class="gallery-item item-odd">
<div class="gallery-icon"><a href="/assets/uploads/2013/04/img-01a-full.jpg" data-href-smart="/assets/uploads/2013/04/img-01a-full-480x300.jpg" data-href-tablet="/assets/uploads/2013/04/img-01a-full-800x500.jpg" data-href-desktop="/assets/uploads/2013/04/img-01a-full-1024x640.jpg" data-href-original="/assets/uploads/2013/04/img-01a-full.jpg" data-title="Um Sonho" data-caption="Óleo sobre tela 180 x 140 cm, 2008."><span data-picture="" data-alt="Um Sonho"><span data-src="/assets/uploads/2013/04/img-01a-full-480x300.jpg"></span><span data-src="/assets/uploads/2013/04/img-01a-full-800x500.jpg" data-media="(min-width: 600px)"></span><span data-src="/assets/uploads/2013/04/img-01a-full-1024x640.jpg" data-media="(min-width: 768px)"></span><span data-src="/assets/uploads/2013/04/img-01a-full.jpg" data-media="(min-width: 1024px)"><img alt="Um Sonho" src="/assets/uploads/2013/04/img-01a-full.jpg"></span><noscript><img decoding="async" src="/assets/uploads/2013/04/img-01a-full-480x300.jpg" alt="Um Sonho" data-title="Um Sonho" data-caption="Óleo sobre tela 180 x 140 cm, 2008." /></noscript></span></a></div>
<dd class="wp-caption-text gallery-caption"><span class="gallery-caption-outer"><span class="gallery-caption-inner">Um Sonho.<br>
Óleo sobre tela 180 x 140 cm, 2008.</span></span></dd>
</dl>
<dl class="gallery-item item-even">
<div class="gallery-icon"><a href="/assets/uploads/2013/04/img-01b-full.jpg" data-href-smart="/assets/uploads/2013/04/img-01b-full-480x300.jpg" data-href-tablet="/assets/uploads/2013/04/img-01b-full-800x500.jpg" data-href-desktop="/assets/uploads/2013/04/img-01b-full-1024x640.jpg" data-href-original="/assets/uploads/2013/04/img-01b-full.jpg" data-title="Sonho Tropical" data-caption="Óleo sobre tela 180 x 140 cm, 2008."><span data-picture="" data-alt="Sonho Tropical"><span data-src="/assets/uploads/2013/04/img-01b-full-480x300.jpg"></span><span data-src="/assets/uploads/2013/04/img-01b-full-800x500.jpg" data-media="(min-width: 600px)"></span><span data-src="/assets/uploads/2013/04/img-01b-full-1024x640.jpg" data-media="(min-width: 768px)"></span><span data-src="/assets/uploads/2013/04/img-01b-full.jpg" data-media="(min-width: 1024px)"><img alt="Sonho Tropical" src="/assets/uploads/2013/04/img-01b-full.jpg"></span><noscript><img decoding="async" src="/assets/uploads/2013/04/img-01b-full-480x300.jpg" alt="Sonho Tropical" data-title="Sonho Tropical" data-caption="Óleo sobre tela 180 x 140 cm, 2008." /></noscript></span></a></div>
<dd class="wp-caption-text gallery-caption"><span class="gallery-caption-outer"><span class="gallery-caption-inner">Sonho Tropical.<br>
Óleo sobre tela 180 x 140 cm, 2008.</span></span></dd>
</dl>
<dl class="gallery-item item-odd">
<div class="gallery-icon"><a href="/assets/uploads/2013/04/img-01c-full.jpg" data-href-smart="/assets/uploads/2013/04/img-01c-full-480x300.jpg" data-href-tablet="/assets/uploads/2013/04/img-01c-full-800x500.jpg" data-href-desktop="/assets/uploads/2013/04/img-01c-full-1024x640.jpg" data-href-original="/assets/uploads/2013/04/img-01c-full.jpg" data-title="No Reinado dos Sentidos" data-caption="Óleo sobre tela 130 x 200 cm, 1982."><span data-picture="" data-alt="No Reinado dos Sentidos"><span data-src="/assets/uploads/2013/04/img-01c-full-480x300.jpg"></span><span data-src="/assets/uploads/2013/04/img-01c-full-800x500.jpg" data-media="(min-width: 600px)"></span><span data-src="/assets/uploads/2013/04/img-01c-full-1024x640.jpg" data-media="(min-width: 768px)"></span><span data-src="/assets/uploads/2013/04/img-01c-full.jpg" data-media="(min-width: 1024px)"><img alt="No Reinado dos Sentidos" src="/assets/uploads/2013/04/img-01c-full.jpg"></span><noscript><img decoding="async" src="/assets/uploads/2013/04/img-01c-full-480x300.jpg" alt="No Reinado dos Sentidos" data-title="No Reinado dos Sentidos" data-caption="Óleo sobre tela 130 x 200 cm, 1982." /></noscript></span></a></div>
<dd class="wp-caption-text gallery-caption"><span class="gallery-caption-outer"><span class="gallery-caption-inner">No Reinado dos Sentidos.<br>
Óleo sobre tela 130 x 200 cm, 1982.</span></span></dd>
</dl>
</div>

<script>
head.ready('_jquery', function(){
head.ready('_picturefill', function(){
	head.ready('_bxslider', function(){
		var $w = $(window),
			$bxSlider,
			$bxViewPort,
			$gallery = $('.gallery'),
			resize = function() {
				resizeBxViewPort($bxViewPort);
				$gallery.find('img').each(function(){
					resizeImage($(this));
				});
			},
			resizeImage = function($el){
				var win_w = $w.width(),
					win_h = $w.height(),
					img_w_orig = $el.outerWidth(),
					img_h_orig = $el.outerHeight(),
					img_ratio = img_w_orig / img_h_orig,
					scale_h = win_w / img_w_orig,
					scale_v = win_h / img_h_orig,
					scale = scale_h > scale_v ? scale_h : scale_v;

				var dimensions = ((img_h_orig * scale) > win_h)
					? {width: win_w, height: 'auto'}
					: {width: 'auto', height: win_h};

				$el.css(dimensions);
			},
			resizeBxViewPort = function($el) {
				$el.css('height', $w.height() + 'px');
			};

		$gallery.bind('DOMNodeInserted', function(e) {
			if (e.target.tagName === 'IMG') {
				resizeImage($(e.target));
			}
		});

		$bxSlider = $gallery.bxSlider({
			auto: true,
			autoHover: true,
			captions: false,
			controls: true,
			easing: 'linear',
			mode: 'horizontal',
			pager: false,
			pause: 5000,
			randomStart: true,
			speed: 750
		});

		$bxViewPort = $bxSlider.parent('.bx-viewport');
		resizeBxViewPort($bxViewPort);

		$w
		.load(resize)
		.resize(resize)
		.keydown(function(event){
			var btnPrev = function() { $bxSlider.goToPrevSlide(); },
				btnNext = function() { $bxSlider.goToNextSlide(); },
				action = function(fn) {
				event.preventDefault();
				fn();
			};
			if (event.keyCode == 37) { action(btnPrev); }
			if (event.keyCode == 39) { action(btnNext); }
		});
	});
});
});
</script>
