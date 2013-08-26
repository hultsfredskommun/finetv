(function($) {

	var active_slide = 0;
	var slide_count = 0;
	var update_count = 0;
	var blank_screen_from = "";
	var blank_screen_to = "";
	var slide_t, update_t;
	$(document).ready(function(){
		if ($.cookie('infotv_redirect') !== undefined && $("body").hasClass("home")) {
			window.location = $.cookie('infotv_redirect');
		}
		// tools
		$(".forcesize").each(function() {
			$(this).hover(function() {
				$(this).css("text-decoration","underline");
			},function() {
				$(this).css("text-decoration","none");
			}).click(function() {
				res = $(this).attr("res");
				res = res.split("x");

				var windowName = "popUp";//$(this).attr("name");
				res = "width="+res[0]+",height="+res[1];
				window.open(document.URL, windowName, res);
			});
		});
		$(".play").click(play);
		$(".pause").click(pause);
		$(".forward").click(function() {do_slide();});
		$(".back").click(function() {do_slide(-1);});
		
		$("body").dblclick(function() {
			$("#debug").toggleClass("hidden");
			$("#tools").toggleClass("hidden");
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

	
	$("html").keyup(function(ev) {
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

	$("html").click(function(ev) {
		$("html").css("cursor","default");
	});

	
	
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
	
	function do_slide(add) {
		if ($("#progressbar").hasClass("pause")) 
			return;
		
		add = typeof add == 'undefined' ? 1 : -1;
		active_slide+=add;

		$("html").css("cursor","none");

		if (!$("#progressbar").hasClass("update"))
			$("#progressbar").show();
		
		slide_count++;
		slide = $("#source .item-" + active_slide);
		now_time = TimeString(new Date());
		
		// do blank
		if (blank_screen_from < now_time || blank_screen_to > now_time)
		{
			if ($("#black").hasClass("hidden"))
				$("#black").removeClass("hidden");
		}
		else // remove blank
		{
			if (!$("#black").hasClass("hidden"))
				$("#black").addClass("hidden");
		}
		
		// do time
		$("#clock").toggle($("#source .settings .clock").html() == "1").html(now_time);
		
		// check if active slide exist
		if (slide.length < 1) {
			if (active_slide == 1) { 
				clearTimeout(slide_t);
				slide_t=setTimeout(do_slide,10000); // wait 10s and try again
				$("#slide").html("Error, no slides. " + slide_count + " time.");
				return;
			}
			if (add == 1)
				active_slide = 1;
			else 
				active_slide = $("#source .slide-item").length - 1;
			slide = $("#source .item-" + active_slide);
		}
		
		// add new active slide
		if (slide.length >= 1) {
			//$("#slide").hide();
			$("#slide").html($(slide).html());
			fix_js_styling();
			//$("#slide").show();
		}
		else
			$("#slide").html("Error, still no slide.");
		
		slide_duration = $("#slide .slide_duration").html() * 1000;
		if (isNaN(slide_duration) || slide_duration == 0)
			slide_duration = 10000;
			
		// debug info
		$("#debug .slide").html("screen size: " + $("#slide").width() + "x" +$("#slide").height() + "<br>" +
		"slide_duration: " + slide_duration + "<br>" +
		"slide_count: " + slide_count + "<br>" +
		"active_slide: " + active_slide + "<br>" +
		"now: " + now_time + "<br>" +
		"blank_screen_from: " + blank_screen_from + "<br>" +
		"blank_screen_to: " + blank_screen_to + "<br>"
		);
		
		// wait for next slide
		clearTimeout(slide_t);

		if (!$("#progressbar").hasClass("update"))
			$("#progressbar").fadeOut("slow");
		slide_t=setTimeout(do_slide,slide_duration);
	
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
					location.reload();
				}
				$("#source").html("Uppdaterad " + Date());
				newsource.find(".slide-item").each(function() {
					newcount++;
					$("#source").append($(this));
				});
				//active_slide = 0;

				// set new settings
				set_settings();
				
			}
				
			$("#debug .update").html("update_count: " + update_count + "<br>slide-items: " + (newcount - 1) + "<br>Updated " + DateString(new Date()));
			
			$("#progressbar").fadeOut("slow",function() { $(this).removeClass("update"); });
			
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

	
	
	function fix_js_styling() {
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

		
		// vertical align
		/*if ($("#slide").height() > $("#slide .slide_image img").height())
			$("#slide .slide_image").css("margin-top", ($("#slide").height() - $("#slide .slide_image img").height()) / 2 + "px");
		else
			$("#slide .slide_image").css("margin-top", "0px");
		*/		
		$("#slide .content").css("margin-top", ($("#slide").height() - $("#slide .content").height()) / 2 + "px");

		
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
	
	function DateString(d){
		function pad(n){return n<10 ? '0'+n : n}
		return d.getUTCFullYear()+'-'
			  + pad(d.getUTCMonth()+1)+'-'
			  + pad(d.getUTCDate())+' '
			  + pad(d.getUTCHours())+':'
			  + pad(d.getUTCMinutes());

	}
	function TimeString(d){
		function pad(n){return n<10 ? '0'+n : n}
		return pad(d.getHours())+':'
			  + pad(d.getMinutes());

	}
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