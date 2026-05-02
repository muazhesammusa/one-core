(function($, window, document) {
	"use strict";

	$.fn.tophiveInfinityLoad = function(options) {
		var infinity = function(options) {
			if (!$(this).length) {
				return;
			}
			var opts = $.extend(
					{
						type: "auto",
						nextSelector: false,
						navSelector: false,
						itemSelector: false,
						parentSelector: false,
						contentSelector: false,
						maxPage: false,
						loader: false,
						button: false,
						is_shop: false,
						loadingText: "",
						loadMoreText: ""
					},
					options
				),
				loading = false,
				finished = false,
				desturl = $(opts.nextSelector).attr("href"); // init next url

			var $parent = opts.parentSelector
				? $(opts.parentSelector)
				: $(document);
			var isMasonry = false;

			// validate options and hide std navigation
			if (
				$(opts.nextSelector, $parent).length &&
				$(opts.navSelector, $parent).length &&
				$(opts.itemSelector, $parent).length &&
				$(opts.contentSelector, $parent).length
			) {
				$(opts.navSelector, $parent).hide();
				if (opts.type === "click" && opts.button) {
					$(opts.navSelector, $parent).after(
						'<div class="tophive-infinity-loader">' +
							opts.button +
							"</div>"
					);
				}
			} else {
				// set finished true
				$(".tophive-infinity-loader", $parent).remove();
				finished = true;
			}

			var updateURL = function(url) {
				// IE only supports pushState() in v10 and above, so don't bother if those conditions aren't met.
				if (!window.history.pushState) {
					return;
				}
				history.pushState(null, null, url);
			};

			var ajax_load = function() {
				var last_elem = $(opts.contentSelector, $parent)
					.find(opts.itemSelector)
					.last();
				// set loader and loading

				if (opts.loader && opts.type !== "click") {
					if (opts.loader) {
						$(opts.navSelector, $parent).after(
							'<div class="tophive-infinity-loader">' +
								opts.loader +
								"</div>"
						);
					}
				} else {
					$(
						".tophive-infinity-loader .tophive-infinity-button",
						$parent
					).addClass("loading");
				}

				$(
					".tophive-infinity-loader .tophive-infinity-button",
					$parent
				).html(opts.loadingText);

				loading = true;
				updateURL(desturl);
				// decode url to prevent error
				desturl = decodeURIComponent(desturl);
				desturl = desturl.replace(/^(?:\/\/|[^\/]+)*\//, "/");

				var instanceShuffle;
				if (window.Shuffle) {
					if (
						$(opts.contentSelector).hasClass("layout--blog_masonry")
					) {
						instanceShuffle = window.posts_shuffleInstance || false;
					} else if (
						$(opts.contentSelector).hasClass(
							"layout--product_masonry"
						)
					) {
						instanceShuffle =
							window.products_shuffleInstance || false;
					}

					if (instanceShuffle) {
						isMasonry = true;
					}
				}

				// ajax call
				$.ajax({
					// params
					url: desturl,
					dataType: "html",
					success: function(data) {
						var $data = $(data);
						var obj;
						if (
							opts.parentSelector &&
							$(opts.parentSelector, $data).length
						) {
							obj = $(opts.parentSelector, $data);
						} else {
							obj = $data;
						}

						var elem = obj.find(opts.itemSelector),
							next = obj.find(opts.nextSelector),
							current_url = desturl;

						if (next.length) {
							desturl = next.attr("href");
						} else {
							// No more pages to load
							// set finished var true
							finished = true;
							if (opts.type === "click" && opts.button) {
								$(
									".tophive-infinity-loader",
									$parent
								).remove();
							}
							$(document).trigger(
								"tophive_infinity_scroll_finished"
							);
						}

						if (isMasonry) {
							elem.each(function(index) {
								var node = this;
								setTimeout(function() {
									instanceShuffle.element.appendChild(node);
									instanceShuffle.add([node]);
								}, 150 * index);
							});
						} else {
							last_elem.after(elem);
						}

						if (opts.type !== "click") {
							$(".tophive-infinity-loader", $parent).remove();
						} else {
							$(
								".tophive-infinity-loader .tophive-infinity-button",
								$parent
							)
								.removeClass("loading")
								.html(opts.loadMoreText);
						}

						$(document).trigger("tophive_infinity_adding_item", [
							elem,
							current_url
						]);

						elem.addClass("tophive-infinity-animated");

						setTimeout(function() {
							loading = false;
							// remove animation class
							elem.removeClass("tophive-infinity-animated");
							// loading Completed
						}, 1000);
					}
				});
			};

			if (opts.type === "click") {
				$parent.on("click", ".tophive-infinity-button", function(e) {
					e.preventDefault();
					ajax_load();
				});
			} else {
				// set event
				$(window).on("scroll touchstart", function() {
					$(this).trigger("tophive_infinity_start");
				});

				$(window).on("tophive_infinity_start", function() {
					var t = $(this),
						elem = $(opts.itemSelector, $parent).last();
					if (typeof elem == "undefined") {
						return;
					}
					if (
						!loading &&
						!finished &&
						t.scrollTop() + t.height() >=
							elem.offset().top + elem.height()
					) {
						ajax_load();
					}
				});
			}
		};
		return this.each(function() {
			return new infinity(options);
		});
	};
})(jQuery, window, document);

jQuery(document).ready(function($) {
	var posts_options = {},
		products_options = {};

	if (OneCoreCustomizer_JS.infinity_load.products.enable) {
		products_options = {
			type: OneCoreCustomizer_JS.infinity_load.products.load_type,
			nextSelector: ".next",
			navSelector: ".navigation",
			itemSelector: "li.product",
			parentSelector: ".woocommerce-listing",
			contentSelector: ".products",
			loadingText: OneCoreCustomizer_JS.infinity_load.products.loading_text,
			loadMoreText:
				OneCoreCustomizer_JS.infinity_load.products.load_more_text,
			loader:
				'<span class="tophive-infinity-button loading">' +
				OneCoreCustomizer_JS.infinity_load.products.loading_text +
				"</span>",
			button:
				'<span class="tophive-infinity-button button">' +
				OneCoreCustomizer_JS.infinity_load.products.load_more_text +
				"</span>",
			is_shop: false
		};

		$(".woocommerce-listing").tophiveInfinityLoad(products_options);
	}

	if (OneCoreCustomizer_JS.infinity_load.posts.enable) {
		posts_options = {
			type: OneCoreCustomizer_JS.infinity_load.posts.load_type,
			nextSelector: ".next",
			navSelector: ".navigation",
			itemSelector: "article.entry",
			parentSelector: ".posts-layout-wrapper",
			contentSelector: ".posts-layout",
			loadingText: OneCoreCustomizer_JS.infinity_load.posts.loading_text,
			loadMoreText: OneCoreCustomizer_JS.infinity_load.posts.load_more_text,
			loader:
				'<span class="tophive-infinity-button loading">' +
				OneCoreCustomizer_JS.infinity_load.posts.loading_text +
				"</span>",
			button:
				'<span class="tophive-infinity-button button">' +
				OneCoreCustomizer_JS.infinity_load.posts.load_more_text +
				"</span>",
			is_shop: false
		};

		$(".posts-layout-wrapper .posts-layout").tophiveInfinityLoad(
			posts_options
		);
	}

	$(document).on("selective-refresh-content-rendered", function(event, id) {
		try {
			if (OneCoreCustomizer_JS.infinity_load.posts.enable) {
				if (id === "tophive_blog_posts") {
					$(".posts-layout-wrapper .posts-layout").tophiveInfinityLoad(
						posts_options
					);
				}
				if (id === "woocommerce_content") {
					$(".woocommerce-listing").tophiveInfinityLoad(
						products_options
					);
				}
			}
		} catch ( e ) {
			
		}
	});
});
