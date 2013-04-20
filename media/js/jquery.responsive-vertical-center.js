(function( $ ) {
	$.fn.responsiveVerticalCenter = function (attribute) {
		return this.each(function () {
			var $this = $(this),
			attribute = attribute || 'margin-top';

		var resizer = function () {
			console.log($this);
			$this.css(
				attribute, (($this.parent().height() - $this.height())/2)
			);
		}

		resizer();
		$(window).resize(resizer);
	});
	};
})(jQuery);