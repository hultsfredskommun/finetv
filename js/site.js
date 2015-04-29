(function ($) {
	var slide_duration, to_timestamp = "", from_timestamp = "", show_slide, the_slide, the_arr, slide, important_arr, slide_arr, active_slide = -1, active_important_slide = -1, slide_count = 0, update_count = 0, blank_screen_from = "", blank_screen_to = "", show_important = true, slide_t, update_t;

	
	function DateString(d) {
		function pad(n) { return n < 10 ? '0' + n : n; }
		return d.getUTCFullYear() + '-'
			  + pad(d.getUTCMonth() + 1) + '-'
			  + pad(d.getUTCDate()) + ' '
			  + pad(d.getUTCHours()) + ':'
			  + pad(d.getUTCMinutes());

	}
	function TimeString(d) {
		function pad(n) { return n < 10 ? '0' + n : n; }
		return pad(d.getHours()) + ':'
			  + pad(d.getMinutes());

	}
	function do_slide(add) {

		// stop previous video
		$("#slide").find("video").stop();
		
		// set clock
		var now_time = TimeString(new Date()), now_timestamp = Math.round(new Date() / 1000);
		$("#clock").toggle($("#source .settings .clock").html() === "1").html(now_time);

		// halt if pause
		if ($("#progressbar").hasClass("pause")) { return; }
		
		// hide cursor
		$("html").css("cursor", "none");
			
		// set default add one step forward
		if (typeof add === 'undefined') { add = 1; }
			
		// do blank
		if (blank_screen_from < now_time || blank_screen_to > now_time) {
			if ($("#black").hasClass("hidden")) {
				$("#black").removeClass("hidden");
            }
		} else { // remove blank
			if (!$("#black").hasClass("hidden")) {
				$("#black").addClass("hidden");
            }
		}
		
		// show progressbar
		if (!$("#progressbar").hasClass("update")) {
			$("#progressbar").show();
        }

		if (slide_arr === undefined && important_arr === undefined) {
			clearTimeout(slide_t);
			slide_t = setTimeout(do_slide, 1000); // wait 10s and try again
			return;
		}
		
		
		if (important_arr === undefined || important_arr.length === 0) {
			show_important = false;
        } else if (slide_arr === undefined || slide_arr.length === 0) {
			show_important = true;
        }
		
		// get next slide
		if (show_important) {
			active_important_slide += add;
			the_slide = active_important_slide;
			the_arr = important_arr;
		} else {
			active_slide += add;
			the_slide = active_slide;
			the_arr = slide_arr;
		}
		
		slide = the_arr[the_slide];
		
		// check if active slide exist
		if (slide === undefined) {
			if (the_slide === 0) {
				clearTimeout(slide_t);
				slide_t = setTimeout(do_slide, 10000); // wait 10s and try again
				$("#slide").html("Error, no slides. " + slide_count + " time.");
				return;
			}
			if (add === 1) {
				the_slide = 0;
            } else {
				the_slide = the_arr.length - 1;
            }
			// set active slide variables
			if (show_important) {
				active_important_slide = the_slide;
            } else {
				active_slide = the_slide;
            }
			slide = the_arr[the_slide];
		}

		if (slide) {
			// set current time and slide time
            now_time = TimeString(new Date());
			now_timestamp = Math.round(new Date() / 1000);
			
			to_timestamp = $(slide).find(".slide_to").attr("timestamp");
			from_timestamp = $(slide).find(".slide_from").attr("timestamp");
			
			
			// check if valid time
			show_slide = false;
			if (now_timestamp > from_timestamp && "" === to_timestamp) {
				show_slide = true;
            } else if ("" === from_timestamp && now_timestamp < to_timestamp) {
				show_slide = true;
            } else if (now_timestamp > from_timestamp && now_timestamp < to_timestamp) {
				show_slide = true;
            } else if ("" === from_timestamp && "" === to_timestamp) {
				show_slide = true;
            }
			// set slide duration
			slide_duration = $(slide).find(".slide_duration").html() * 1000;
			if (isNaN(slide_duration) || slide_duration === 0) {
				slide_duration = 10000;
            }
			
			// check if toggle show_important
            // toggle if all important has been shown
			if (show_important && active_important_slide === important_arr.length - 1) {
				show_important = !show_important; 
                active_important_slide = -1;
            } else if (show_slide && !show_important) {
				show_important = !show_important; 
			}
			
			// do slide again if not showing this slide
			if (!show_slide) {
				do_slide(add);
				return;
			}

			// count actual slides shown
			slide_count++;


			// NOW make the switch to the new active slide
			//$("#slide").hide();
			if ($("#slide").attr("data-id") != $(slide).attr("data-id")) {	
				$("#slide").html($(slide).html());
				$("#slide").attr("data-id",$(slide).attr("data-id"));
				//$("#slide").show();
				// start video if present
				if ($("#slide").find("video").length > 0) {
					if ($("#slide").find(".nofullscreenvideo").length === 0) {
						$("#slide").find(".content").css("margin", "0");
						$("#slide").find("video").css("width", "100%").css("height", "100%");
						$("#slide").find("video").parent().css("width", "100%").css("height", "100%");
					}
					if ($("#slide").find(".playaudio").length === 0) {
						$("#slide").find("video").get(0).volume = 0;
					} else {
						$("#slide").find("video").get(0).volume = 1;
					}
					
					$("#slide").find("video").get(0).play();
				}
				fix_js_styling(slide_duration);
			}
			// debug info
			notimportant_length = (slide_arr)?slide_arr.length:0;
			important_length = (important_arr)?important_arr.length:0;
			$("#debug .slide").html("screen size: " + $("#slide").width() + "x" +$("#slide").height() + "<br>" +
			"slide_duration: " + slide_duration + "<br>" +
			"slide_count: " + slide_count + "<br>" +
			"active_slide: " + active_slide + "<br>" +
			"active_important_slide: " + active_important_slide + "<br>" +
			"not important slides: " + notimportant_length + "<br>" +
			"important slides: " + important_length + "<br>" +
			"now: " + now_time + "<br>" +
			"blank_screen_from: " + blank_screen_from + "<br>" +
			"blank_screen_to: " + blank_screen_to + "<br>" +
			"from: " + from_timestamp + "<br>" +
			"now: " + now_timestamp + "<br>" +
			"to: " + to_timestamp + "<br>" +
			"from: " + $("#slide .slide_from").html() + "<br>" +
			"now: " + now_time + "<br>" +
			"to: " + $("#slide .slide_to").html() + "<br>" +
			"show_slide: " + show_slide + "<br>" +
			"next slide important: " + show_important + "<br>"
			);
			
		
			// wait for next slide
			clearTimeout(slide_t);
			if (!$("#progressbar").hasClass("update"))
				$("#progressbar").fadeOut("slow");
			slide_t=setTimeout(do_slide,slide_duration);
		
			
		}
		else {
			$("#slide").html("<div class='content'>Ingen information att visa just nu.</div>");
			// wait and try again
			clearTimeout(slide_t);
			if (!$("#progressbar").hasClass("update"))
				$("#progressbar").fadeOut("slow");
			slide_t=setTimeout(do_slide,10000);
		}
	}
	
	
	
	function do_update() {
		$("#progressbar").show().addClass("update");

		update_count++;
		
		// Get new slide-items
		$.get(document.URL, function(data) {
			newsource = $(data);
			newcount = 0;
			if (newsource.find(".slide-item").length > 0) {
				// do hard refresh every hour
				if (update_count > 60) {
					location.reload(true);
				}
				$("#source").html("Uppdaterad " + Date());
				newsource.find(".slide-item").each(function() {
					newcount++;
					$("#source").append($(this));
				});
				slide_arr = $("#source .slide-item.notimportant");
				important_arr = $("#source .slide-item.important");
				//active_slide = 0;

				// set new settings
				set_settings();
				
				/* preload images */
				$("#source").find("img").each( function() {
					console.log('loading image ' + $(this).attr("src"));
					$("<img />").addClass("hidden newimg").attr("src",$(this).attr("src")).load(function() {
						if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
							console.log('broken image!');
						} else {
							console.log('image loaded!');
						}
						$(".newimg").remove();
					});
				});
				/* preload video */
				/*$("#source").find("video").each( function() {
					console.log('loading video ' + $(this).find("source").attr("src"));
					
					$.get($(this).attr("src"),null,function() {
						console.log('video loaded?');
					}).done(function() {
						console.log( "success" );
					  })
					  .fail(function() {
						console.log( "error" );
					  })
					  .always(function() {
						console.log( "finished" );
					  });
					//$(this).attr("preload","auto").load();
					$("<video />").attr("preload","auto").addClass("hidden newvideo").append("<source />").attr("src",$(this).attr("src")).load(function() {
						if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
							console.log('broken video!');
						} else {
							console.log('video loaded!');
						}
						$(".newvideo").remove();
					});
				});*/
				
			}
				
			$("#debug .update").html("update_count: " + update_count + "<br>slide-items: " + (newcount - 1) + "<br>Updated " + DateString(new Date()));
			
			$("#progressbar").fadeOut("slow",function() { $(this).removeClass("update"); });
			
			doCount();
		}).error(function() { 
			$("#debug .update").html("Error fetching data. Try again.");
			clearTimeout(update_t);
			update_t=setTimeout(do_update,60000);
			
		});

		
		$("#debug .update").html("update_count: " + update_count + "<br>"
		);
		
		clearTimeout(update_t);
		update_t=setTimeout(do_update,60000);
	
	}

	
	
	function fix_js_styling(slide_duration) {
	
		if (slide_duration > 4000)  slide_duration -= 2000;
	
		// fill image
		screen_ratio = $("#slide").height() / $("#slide").width();
		img_ratio = $("#slide .slide_image img").height() / $("#slide .slide_image img").width();
		if ($("#slide .slide_image").hasClass("whole")) {
			if ( screen_ratio > img_ratio ) {
				$("#slide .slide_image img").width("auto").height("100%");
			} else {
				$("#slide .slide_image img").width("100%").height("auto");
			}
		}
		else if ($("#slide .slide_image").hasClass("half")) {
			if ( screen_ratio > img_ratio/2 ) {
				$("#slide .slide_image img").width("auto").height("100%");
			} else {
				$("#slide .slide_image img").width("100%").height("auto");
			}
		}

		
		footerheight = 0;
		if ($("#footer").is(":visible"))
			footerheight = $("#footer").height();

		// vertical align image
		if ($("#slide").height() - footerheight > $("#slide .slide_image img").height())
			$("#slide .slide_image").css("margin-top", ($("#slide").height() - footerheight - $("#slide .slide_image img").height()) / 2 + "px");
		else
			$("#slide .slide_image").css("margin-top", "0px");
		
		// vertical align text
		if ($("#slide").height() - footerheight > $("#slide .content").height()) {
			$("#slide .content").css("margin-top", ($("#slide").height() - footerheight - $("#slide .content").height()) / 2 + "px");
		}
		else {
			if ($( "#slide").find("video").length == 0) {
				$("#slide .content").css("margin-top", "50px");
				$( "#slide .content" ).animate({
					top: "-=" + ($("#slide .content").height() - $("#slide").height() + footerheight + 60)
				  }, slide_duration, function() {
					// Animation complete.
				});
			}
			else {
				$("#slide .content").css("margin-top", ($("#slide").height() - footerheight - $("#slide .content").height()) / 2 + "px");
			}
		}

		
		if ($("#slide .slide_background_color").html() != "")
			$("#slide").css("background-color", $("#slide .slide_background_color").html());
		else
			$("#slide").css("background-color", "transparent");
			
		if ($("#slide .slide_text_color").html() != "")
			$("#slide").css("color", $("#slide .slide_text_color").html());
		else
			$("#slide").css("color", "inherit");
			
		
	}
	
	
	function set_settings() {
		$("#frame").toggle(($("#source .settings .frame_image").html() != ""));
		$("#frame_image").attr("src",$("#source .settings .frame_image").html());
		
		$("#header").toggle(($("#source .settings .header_logo").html() != ""));
		$("#header_logo").attr("src",$("#source .settings .header_logo").html());
		
		$("#footer").toggle(($("#source .settings .footer_text").html() != ""));
		$("#footer .padding").html($("#source .settings .footer_text").html());
		
		$("#footer").css("background-color", $("#source .settings .footer_background_color").html());
		$("#footer").css("color", $("#source .settings .footer_text_color").html());
		blank_screen_from = $("#source .settings .blank_screen_from").html();
		blank_screen_to = $("#source .settings .blank_screen_to").html();
		if (blank_screen_to == "")
			blank_screen_to = "00.00";
		if (blank_screen_from == "")
			blank_screen_from = "23:59";
		$("body").css("font-size", $("#source .settings .screen_font_scale").html() + "%");
		if ($("#source .settings .screen_background_color").html() != "")
			$("body").css("background-color", $("#source .settings .screen_background_color").html());
		if ($("#source .settings .screen_text_color").html() != "")
			$("body").css("color", $("#source .settings .screen_text_color").html());
	}				
	
	function doCount() {
		browser = "other";
		if ($.browser.webkit)
			browser = "webkit-" + $.browser.version;
		else if ($.browser.msie)
			browser = "msie-" + $.browser.version;
		else if ($.browser.opera)
			browser = "opera-" + $.browser.version;
		else if ($.browser.mozilla)
			browser = "mozilla-" + $.browser.version;
		else if ($.browser.safari)
			browser = "safari-" + $.browser.version;

		data = {action: 'infotv_count', unique: $.cookie('infotv_unique'), plats: $("#place").html(), browser: browser, screensize: $("#slide").width() + "x" + $("#slide").height(), date: DateString(new Date()) };
		$.post(infotv_data.admin_ajax_url, data, function(data, textStatus, jqXHR ){
			$("#debug .ajax").html(textStatus + " " + data); 
		});
	}
    function play() {
		clearTimeout(slide_t);
		$("#progressbar").html("");
		$("#progressbar").removeClass("pause");
		do_slide();
	}
	function pause() {
		clearTimeout(slide_t);
		$("#progressbar").html("pause");
		$("#progressbar").addClass("pause");
	}

    $(document).ready(function () {
		if ($.cookie('infotv_unique') === undefined) {
			var d = new Date(), m = d.getMilliseconds(), s = d.getSeconds();
			$.cookie('infotv_unique', Math.random() * m * s);
		}
		if ($.cookie('infotv_redirect') !== undefined && $("body").hasClass("home")) {
			window.location = $.cookie('infotv_redirect');
		}
		
		// tools
		$(".forcesize").each(function () {
			$(this).hover(function () {
				$(this).css("text-decoration", "underline");
			}, function () {
				$(this).css("text-decoration", "none");
			}).click(function () {
				var res = $(this).attr("res"), windowName = "info_popUp";//$(this).attr("name");
                res = res.split("x");
				res = "width=" + res[0] + ",height=" + res[1];
				window.open(document.URL, windowName, res);
			});
		});
		$(".play").click(play);
		$(".pause").click(pause);
		$(".forward").click(function () { do_slide(); });
		$(".back").click(function () { do_slide(-1); });
		$(".force_update").click(function (ev) { do_update(); ev.preventDefault(); });
		$(".force_reload").click(function (ev) { location.reload(true); ev.preventDefault(); });
		
		$("body").dblclick(function () {
			if(window.name == 'info_popUp') {
				window.close();
			}
			else {
				$("#debug").toggleClass("hidden");
				$("#tools").toggleClass("hidden");
			}
		});
		set_settings();
		
		if ($("#source").length > 0) {
			/* HANDLE SLIDESHOW */
			do_slide();
			
			/* UPDATE SLIDES FROM SERVER */
			do_update();

		}
		else {
			// just fix some js styling
			fix_js_styling();
		}
	});

	
	$("html").keyup(function (ev) {
		console.log("Handler for .keyup() called." + ev.keyCode);
		switch(ev.keyCode) {
			case 80: // p
				if ($("#progressbar").hasClass("pause")) {
					play();
				}
				else {
					pause();
				}
				break;
			case 39:
				do_slide();
				break;
			case 37:
				do_slide(-1);
				break;
			case 27: // esc
				play();
				$("#debug").toggleClass("hidden");
				$("#tools").toggleClass("hidden");
			default:
				break;
		}
	});

	$("html").click(function (ev) {
		$("html").css("cursor","default");
	});

	
	
	
})(jQuery);


/*!
 * jQuery Cookie Plugin v1.3.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function decode(s) {
		if (config.raw) {
			return s;
		}
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	function decodeAndParse(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		s = decode(s);

		try {
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	var config = $.cookie = function (key, value, options) {

		// Write
		if (value !== undefined) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				config.raw ? key : encodeURIComponent(key),
				'=',
				config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {};
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				result = decodeAndParse(cookie);
				break;
			}

			if (!key) {
				result[name] = decodeAndParse(cookie);
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			// Must not alter options, thus extending a fresh object...
			$.cookie(key, '', $.extend({}, options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));