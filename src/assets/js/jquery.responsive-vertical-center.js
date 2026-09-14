(function( $ ) {
	$.fn.responsiveVerticalCenter = function (options) {
		var defaults = {
				attribute : 'margin-top',
				parentSelector : null
			},
			opts = $.extend(defaults, options);

		return this.each(function () {
			var $this = $(this);

			var resizer = function () {
				$this.css(
					opts.attribute, (($this.parents(opts.parentSelector).first().height() - $this.height())/2)
				);
			}

			resizer();
			$(window).resize(resizer);
		});
	};
})(jQuery);