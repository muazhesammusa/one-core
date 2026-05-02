(function(deparam) {
	if (
		typeof require === "function" &&
		typeof exports === "object" &&
		typeof module === "object"
	) {
		try {
			var jquery = require("jquery");
		} catch (e) {}
		module.exports = deparam(jquery);
	} else if (typeof define === "function" && define.amd) {
		define(["jquery"], function(jquery) {
			return deparam(jquery);
		});
	} else {
		var global;
		try {
			global = (false || eval)("this"); // best cross-browser way to determine global for < ES5
		} catch (e) {
			global = window; // fails only if browser (https://developer.mozilla.org/en-US/docs/Web/Security/CSP/CSP_policy_directives)
		}
		global.deparam = deparam(global.jQuery); // assume jQuery is in global namespace
	}
})(function($) {
	var deparam = function(params, coerce) {
		var obj = {},
			coerce_types = { true: !0, false: !1, null: null };

		// If params is an empty string or otherwise falsy, return obj.
		if (!params) {
			return obj;
		}

		// Iterate over all name=value pairs.
		params
			.replace(/\+/g, " ")
			.split("&")
			.forEach(function(v) {
				var param = v.split("="),
					key = decodeURIComponent(param[0]),
					val,
					cur = obj,
					i = 0,
					// If key is more complex than 'foo', like 'a[]' or 'a[b][c]', split it
					// into its component parts.
					keys = key.split("]["),
					keys_last = keys.length - 1;

				// If the first keys part contains [ and the last ends with ], then []
				// are correctly balanced.
				if (/\[/.test(keys[0]) && /\]$/.test(keys[keys_last])) {
					// Remove the trailing ] from the last keys part.
					keys[keys_last] = keys[keys_last].replace(/\]$/, "");

					// Split first keys part into two parts on the [ and add them back onto
					// the beginning of the keys array.
					keys = keys
						.shift()
						.split("[")
						.concat(keys);

					keys_last = keys.length - 1;
				} else {
					// Basic 'foo' style key.
					keys_last = 0;
				}

				// Are we dealing with a name=value pair, or just a name?
				if (param.length === 2) {
					val = decodeURIComponent(param[1]);

					// Coerce values.
					if (coerce) {
						val =
							val && !isNaN(val) && +val + "" === val
								? +val // number
								: val === "undefined"
								? undefined // undefined
								: coerce_types[val] !== undefined
								? coerce_types[val] // true, false, null
								: val; // string
					}

					if (keys_last) {
						// Complex key, build deep object structure based on a few rules:
						// * The 'cur' pointer starts at the object top-level.
						// * [] = array push (n is set to array length), [n] = array if n is
						//   numeric, otherwise object.
						// * If at the last keys part, set the value.
						// * For each keys part, if the current level is undefined create an
						//   object or array based on the type of the next keys part.
						// * Move the 'cur' pointer to the next level.
						// * Rinse & repeat.
						for (; i <= keys_last; i++) {
							key = keys[i] === "" ? cur.length : keys[i];
							cur = cur[key] =
								i < keys_last
									? cur[key] ||
									  (keys[i + 1] && isNaN(keys[i + 1])
											? {}
											: [])
									: val;
						}
					} else {
						// Simple key, even simpler rules, since only scalars and shallow
						// arrays are allowed.

						if (
							Object.prototype.toString.call(obj[key]) ===
							"[object Array]"
						) {
							// val is already an array, so push on the next value.
							obj[key].push(val);
						} else if ({}.hasOwnProperty.call(obj, key)) {
							// val isn't an array, but since a second value has been specified,
							// convert val into an array.
							obj[key] = [obj[key], val];
						} else {
							// val is a scalar.
							obj[key] = val;
						}
					}
				} else if (key) {
					// No value was defined, so set something meaningful.
					obj[key] = coerce ? undefined : "";
				}
			});

		return obj;
	};
	if ($) {
		$.prototype.deparam = $.deparam = deparam;
	}
	return deparam;
});

var tophive_get_customize_fields = function(control_id) {
	var section = top.wp.customize.control(control_id).section();
	var panel = top.wp.customize.section(section).panel();
	var customize_data = {};
	// var all_settings = top.wp.customize.get();
	_.each(top.wp.customize.panel(panel).sections(), function(section) {
		_.each(section.controls(), function(control) {
			customize_data[control.id] = 1;
		});
	});

	return JSON.stringify(customize_data);
};

wp.ajax.o_send = wp.ajax.send;

wp.ajax.send = function(action, options) {
	if (_.isObject(action)) {
		action.data["msid"] = OneCoreCustomizer_MS.id;
		action.data["builder_id"] = top._current_builder_panel;
	} else {
		options.data["msid"] = OneCoreCustomizer_MS.id;
		options.data["builder_id"] = top._current_builder_panel;
		options.data["customize_fields"] = tophive_get_customize_fields(
			"multiple_headers"
		);
	}

	// success for calback
	console.log("WP.AJAX", action);
	return this.o_send(action, options);
};

/**
 * Change current url
 * @param url
 */
top._redirect_ms_header_url = false;
top._redirect_msid = false;
top._save_button = false;
function tophive_customize_ms_change_url(preview_url, msid) {
	top._redirect_ms_header_url = preview_url;
	top._redirect_msid = msid;
	console.log("_redirect_msid", msid);

	OneCoreCustomizer_MS.id = parseInt(OneCoreCustomizer_MS.id);
	if (OneCoreCustomizer_MS.id != msid) {
		top._save_button.trigger("click");
	}
}

(function($, api) {
	top._save_button = jQuery("input#save");
	api.bind("saved", function() {
		if (top._redirect_ms_header_url) {
			OneCoreCustomizer_MS.id = parseInt(OneCoreCustomizer_MS.id);
			jQuery(window).off("beforeunload.customize-confirm");
			var urlParser = document.createElement("a");
			urlParser.href = location.href;
			var queryParams = _.extend(
				jQuery.deparam(urlParser.search.substr(1)),
				{
					autofocus: {
						control: "multiple_headers"
					},
					msid: top._redirect_msid,
					url: top._redirect_ms_header_url
				}
			);

			urlParser.search = $.param(queryParams);
			console.log("Redirect to irlParser.href", urlParser.href);
			location.replace(urlParser.href);
		}
		// window.location = urlParser.href;
	});

	api.bind("save-request-params", function(e) {
		e.msid = OneCoreCustomizer_MS.id;
		e.builder_id = top._current_builder_panel;
		e.customize_fields = tophive_get_customize_fields("multiple_headers");
	});

	$(document).on("tophive_builder_panel_loaded", function(e, id, el) {
		if (id === "header") {
			$(".tophive--cb-actions", el.container).prepend(
				'<a data-id="multiple_headers" class="focus-section button button-secondary" href="#">' +
					OneCoreCustomizer_MS.l10n.multiple_text +
					"</a>"
			);
			if (OneCoreCustomizer_MS.id > 0) {
				var button = $(
					'<a class="display-condition" href="#">' +
						OneCoreCustomizer_MS.l10n.display +
						"</a>"
				);
				$(".tophive--cb-devices-switcher", el.container).append(
					button
				);

				var panel_body = $(
					'<div class="tophive--device-panel tophive--display-panel tophive--panel-hide"></div>'
				);
				$(".tophive--cb-body", el.contailner).append(panel_body);

				// Change Preview URL when conditions changes
				panel_body.tophive_condition({
					save_cb: function(res, data) {
						wp.customize.previewer.previewUrl.set(res.url);
						var urlParser = _.clone(window.location);
						var url =
							urlParser.origin +
							urlParser.pathname +
							"?autofocus[control]=multiple_headers&msid=" +
							data.msid +
							"&url=" +
							encodeURIComponent(res.url);
						window.history.pushState(url, "", url);
					}
				});

				button.on("click", function(e) {
					e.preventDefault();
					$(
						".tophive--cb-devices-switcher a",
						el.container
					).removeClass("tophive--tab-active");
					button.addClass("tophive--tab-active");
					$(".tophive--device-panel", el.contailner).addClass(
						"tophive--panel-hide"
					);
					$(".tophive--display-panel", el.contailner).removeClass(
						"tophive--panel-hide"
					);
				});
			}
		}
	});

	api.bind("ready", function() {
		$(".multiple-section-list").each(function() {
			var list = $(this);
			var data = {
				action: "tophive/load-sections",
				builder_id: list.attr("data-builder-id") || "",
				control_id: list.attr("data-control-id") || "",
				msid: OneCoreCustomizer_MS.id
			};

			$.ajax({
				url: ajaxurl,
				data: data,
				type: "GET",
				success: function(res) {
					list.html(res);
					var editing = list.find(".li-boxed-editing a");
					if (editing.length) {
						var previewing_url = editing.attr("data-url");
						//var preview_url = wp.customize.previewer.previewUrl.get();

						var current_urlParser = document.createElement("a");
						current_urlParser.href = location.href;
						var current_Params = jQuery.deparam(
							current_urlParser.search.substr(1)
						);
						if (_.isUndefined(current_Params.msid)) {
							current_Params.msid = 0;
						}
						if (!_.isNumber(current_Params.msid)) {
							current_Params.msid = 0;
						}

						if (current_Params.msid) {
							if (current_Params.msid !== OneCoreCustomizer_MS.id) {
								var urlParser = _.clone(window.location);
								var queryParams = _.extend(
									api.utils.parseQueryString(
										urlParser.search.substr(1)
									),
									{
										autofocus: {
											control: "multiple_headers"
										},
										url: previewing_url
									}
								);

								urlParser.search = $.param(queryParams);
								var url = urlParser.href;
								window.history.pushState(url, "", url);
							}
						}
					}
				}
			});
		});
	});

	$(document).ready(function($) {
		var $document = $(document);

		$document.on("click", ".multiple-section-action .button", function(e) {
			e.preventDefault();
			var f = $(this).closest(".multiple-section-action");

			var data = {
				title: $(".new-input-name", f).val() || "",
				builder_id:
					$(".new-input-name", f).attr("data-builder-id") || "",
				control_id:
					$(".new-input-name", f).attr("data-control-id") || "",
				copy: $(".new-copy", f).is(":checked") ? 1 : ""
			};
			if (data.title) {
				// empty input filed
				$(".new-input-name", f).val("");

				data["action"] = "tophive/save-section";
				data["customize_fields"] = tophive_get_customize_fields(
					data.control_id
				);
				data["_nonce"] = OneCoreCustomizer_MS._nonce;
				data["current_msid"] = OneCoreCustomizer_MS.id;

				$.ajax({
					url: ajaxurl,
					data: data,
					type: "POST",
					success: function(res) {
						wp.customize
							.control(data.control_id)
							.container.find(".multiple-section-list")
							.append(res);
					}
				});
			}
		});

		// edit
		$document.on("click", ".multiple-section-list .load-tpl", function(e) {
			e.preventDefault();
			var id = $(this).attr("data-id") || "";
			var control = $(this).attr("data-control-id") || "";
			var urlParser = _.clone(window.location);
			var url = $(this).attr("data-url") || "";
			// if (!url) {
			// 	url = wp.customize.previewer.previewUrl.get();
			// }

			var toUrl = urlParser.origin+urlParser.pathname+'?autofocus[control]='+control+'&msid='+id;
			if ( url ) {
				toUrl += '&url='+encodeURIComponent( url );
			}
			top.location.href = toUrl;
			
		});

		// Remove
		$document.on("click", ".multiple-section-list .remove-tpl", function(
			e
		) {
			e.preventDefault();
			var id = $(this).attr("data-id") || "";
			var control = $(this).attr("data-control-id") || "";
			var urlParser = _.clone(window.location);
			$(this)
				.closest("li.li-boxed")
				.remove();

			var data = {
				msid: id,
				do_remove: 1
			};
			data["action"] = "tophive/save-section";
			data["_nonce"] = OneCoreCustomizer_MS._nonce;

			$.ajax({
				url: ajaxurl,
				data: data,
				type: "POST",
				success: function(res) {
					top.location.href =
						urlParser.origin +
						urlParser.pathname +
						"?autofocus[control]=" +
						control;
				}
			});
		});
	});
})(jQuery, wp.customize);
