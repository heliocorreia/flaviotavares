<?php wp_footer(); ?>
<script>
var $submenu = $('.sub-menu');
if ($submenu) {
	$(window).resize(function(){
		$submenu.css({
		    marginTop: 0,
			top: ($(window).height() - $submenu.outerHeight())/2
		});
	});
	$(window).resize();
}
</script>
</div>
</body>
</html>