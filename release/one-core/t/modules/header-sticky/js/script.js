jQuery(function($) {
	var $document = $(document);
	var $header = $("#masthead");
	var lastScrollTop = 0;

	var $header_inner;
	var header_height, header_offset;
	var sticky_timer_show;
	var sticky_timer_hide;
	$header_inner = $("#masthead-inner");
	$header = $("#masthead");

	function setup_cover_padding_top() {
		header_height = $header_inner.height();
		$("#page-cover").css("padding-top", "");
		if ($("body").hasClass("is-header-transparent")) {
			var ph_top = $("#page-cover").css("padding-top");
			ph_top = parseInt(ph_top);
			if (isNaN(ph_top) || ph_top <= 0) {
				$("#page-cover").css("padding-top", header_height);
			}
		} else {
			$("#page-cover").css("padding-top", "");
		}
	}

	function setup_header_sticky_data() {
		setup_cover_padding_top();

		$header.removeAttr("style");
		$header.css("min-height", "auto");
		if ($header.length) {
			header_height = $header.height();
			$header.css({ "min-height": header_height, display: "block" });
			header_offset = $header.offset();
		} else {
			header_offset = {
				top: 0,
				left: 0
			};
		}

		setup_cover_padding_top();

		var ht = 0;
		if ($("#wpadminbar").length) {
			ht = $("#wpadminbar").height();
		}
		$header_inner.css("top", ht);
	}

	setup_cover_padding_top();
	setup_header_sticky_data();

	var sticky_header = function(top) {
		var diff = 100;
		if (typeof top === "undefined") {
			top = $(window).scrollTop();
		}
		if (typeof header_offset !== "object") {
			header_offset = {
				top: 0,
				left: 0
			};
		}
		var sticky_pos = header_offset.top + header_height + diff;

		if (top > sticky_pos) {
			var ht = 0;
			if ($("#wpadminbar").length) {
				ht = $("#wpadminbar").height();
				if ($("#wpadminbar").css("position") == "absolute") {
					ht = 0;
				}
			}
			$header.removeClass("sticky-hiding");
			$header.addClass("sticky");
			$header_inner.css("top", ht);
			if (sticky_timer_hide) {
				clearTimeout(sticky_timer_hide);
				sticky_timer_hide = false;
			}
			if (!$header.hasClass("sticky-active") && !sticky_timer_show) {
				// backup transparent if have
				$(".header--sticky", $header).each(function() {
					if ($(this).hasClass("header--transparent")) {
						$(this)
							.removeClass("header--transparent")
							.attr("data-ht", 1);
					}
				});
				sticky_timer_show = setTimeout(function() {
					$header.addClass("sticky-active");
					$(document.body).trigger("tophive_sticky_active");
					sticky_timer_show = false;
				}, 50);
			}
		} else {
			if (sticky_timer_show) {
				clearTimeout(sticky_timer_show);
				sticky_timer_show = false;
			}
			clearTimeout(sticky_timer_hide);
			if (top >= header_offset.top + header_height && top <= sticky_pos) {
				$header.addClass("sticky-hiding");
				sticky_timer_hide = setTimeout(function() {
					$header.css("top", "");
					$header.removeClass("sticky sticky-active sticky-hiding");
					$(document.body).trigger("tophive_sticky_active");
					$(".header--sticky", $header).each(function() {
						var is_ht = $(this).attr("data-ht") || false;
						if (is_ht) {
							$(this).addClass("header--transparent");
						}
					});
				}, 300);
			} else {
				clearTimeout(sticky_timer_hide);
				sticky_timer_hide = false;
				$header_inner.css("top", "");
				$header.removeClass("sticky sticky-active sticky-hiding");
				$(document.body).trigger("tophive_sticky_active");
				$(".header--sticky", $header).each(function() {
					var is_ht = $(this).attr("data-ht") || false;
					if (is_ht) {
						$(this).addClass("header--transparent");
					}
				});
			}
		}
	};

	var sticky_header_up = function(top, direction) {
		if (typeof direction === "undefined") {
			direction = "down";
		}

		var diff = 100;
		var sticky_pos = header_offset.top + header_height + diff;

		if (top > sticky_pos) {
			var ht = 0;
			if ($("#wpadminbar").length) {
				ht = $("#wpadminbar").height();
				if ($("#wpadminbar").css("position") == "absolute") {
					ht = 0;
				}
			}
			$header.removeClass("sticky-hiding");
			$header.addClass("sticky");
			$header_inner.css("top", ht);

			if (direction === "up") {
				if (!$header.hasClass("sticky-active") && !sticky_timer_show) {
					sticky_timer_show = setTimeout(function() {
						$header.addClass("sticky-active");
						sticky_timer_show = false;
						$(document.body).trigger("tophive_sticky_active");
					}, 300);
				}
			} else {
				if (sticky_timer_show) {
					clearTimeout(sticky_timer_show);
					sticky_timer_show = false;
				}
				$header.addClass("sticky-hiding");
				sticky_timer_hide = setTimeout(function() {
					$header.css("top", "");
					$header.removeClass("sticky sticky-active sticky-hiding");
					$(document.body).trigger("tophive_sticky_active");
					$(".header--sticky", $header).each(function() {
						var is_ht = $(this).attr("data-ht") || false;
						if (is_ht) {
							$(this).addClass("header--transparent");
						}
					});
				}, 300);
			}
		} else {
			if (sticky_timer_show) {
				clearTimeout(sticky_timer_show);
				sticky_timer_show = false;
			}
			clearTimeout(sticky_timer_hide);
			if (top >= header_offset.top + header_height && top <= sticky_pos) {
				$header.addClass("sticky-hiding");
				sticky_timer_hide = setTimeout(function() {
					$header_inner.css("top", "");
					$header.removeClass("sticky sticky-active sticky-hiding");
					$(document.body).trigger("tophive_sticky_active");
					$(".header--sticky", $header).each(function() {
						var is_ht = $(this).attr("data-ht") || false;
						if (is_ht) {
							$(this).addClass("header--transparent");
						}
					});
				}, 300);
			} else {
				clearTimeout(sticky_timer_hide);
				sticky_timer_hide = false;
				$header_inner.css("top", "");
				$header.removeClass("sticky sticky-active sticky-hiding");
				$(document.body).trigger("tophive_sticky_active");
				$(".header--sticky", $header).each(function() {
					var is_ht = $(this).attr("data-ht") || false;
					if (is_ht) {
						$(this).addClass("header--transparent");
					}
				});
			}
		}
	};

	/**
	 * Trigger event
	 *
	 * after_auto_render_css
	 * selective-refresh-content-rendered
	 *
	 */

	var time_refresh;

	$document.on(
		"selective-refresh-content-rendered  after_auto_render_css",
		function(event, id, field_name) {

			try {
				if (typeof field_name === "undefined") {
					field_name = "";
				}
				if (id === "tophive_customize_render_header") {
					if (
						$("#masthead .header--row.header--transparent").length > 0
					) {
						$("body").addClass("is-header-transparent");
					} else {
						$("body").removeClass("is-header-transparent");
					}
				}
	
				if (time_refresh) {
					clearTimeout(time_refresh);
				}
	
				if (
					id === "after_auto_render_css" &&
					field_name === "header_cover_padding_top"
				) {
					setup_cover_padding_top();
					return;
				}
	
				setup_header_sticky_data();
				var scroll_top = $document.scrollTop();
				if (
					OneCoreCustomizer_JS.header_sticky_up === "1" ||
					OneCoreCustomizer_JS.header_sticky_up == 1
				) {
					sticky_header_up(scroll_top, "down");
				} else {
					sticky_header(scroll_top);
				}
				$document.scroll();
			} catch ( e ) {
				
			}
		}
	);

	$(window).resize(function() {
		setTimeout(function() {
			setup_header_sticky_data();
			var scroll_top = $document.scrollTop();
			if (OneCoreCustomizer_JS.header_sticky_up === "1") {
				sticky_header_up(scroll_top, "down");
			} else {
				sticky_header(scroll_top);
			}
			lastScrollTop = scroll_top;
		}, 50);
	});

	// When page scroll
	$document.scroll(function() {
		var scroll_top = $document.scrollTop();
		var direction = "";
		if (scroll_top > lastScrollTop) {
			direction = "down";
		} else {
			direction = "up";
		}
		if (OneCoreCustomizer_JS.header_sticky_up === "1") {
			sticky_header_up(scroll_top, direction);
		} else {
			sticky_header(scroll_top);
		}
		lastScrollTop = scroll_top;
	});
});
