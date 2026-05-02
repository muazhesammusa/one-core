jQuery(document).ready(function($) {
	/**
	 * Check if typpy loaded
	 */
	if (typeof tippy !== "undefined") {
		$(".wc-product-inner .cd-btn.display-icon").each(function() {
			var title = $(this).attr("title") || false;
			if (title) {
				$(this).removeAttr("title");
				$(this).attr("data-tippy-content", title);
			}
		});

		tippy(
			document.querySelectorAll(".wc-product-inner .cd-btn.display-icon"),
			{
				delay: 100,
				arrow: true,
				arrowType: "round",
				size: "regular",
				duration: 300,
				animation: "scale"
			}
		);
	}
});
