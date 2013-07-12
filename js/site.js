(function($) {

	var active_slide = 1;
	var slide_count = 0;
	var update_count = 0;
	var blank_screen_from = "";
	var blank_screen_to = "";
	var slide_t, update_t;
	$(document).ready(function(){
		$("body").dblclick(function() {
			$("#debug").toggleClass("hidden");
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

	function do_slide() {
		$("#progressbar").show();
		
		slide_count++;
		slide = $("#source .item-" + active_slide);
		now_time = TimeString(new Date());
		
		// do blank
		if ((blank_screen_from != "" && now_time && blank_screen_from > now_time) || (blank_screen_to != "" && blank_screen_to < now_time))
		{
			if ($("#black").hasClass("hidden"))
				$("#black").removeClass("hidden");
		}
		else // remove blank
		{
			if (!$("#black").hasClass("hidden"))
				$("#black").addClass("hidden");
		}
		
		// check if slides
		if (slide.length < 1) {
			if (active_slide == 1) { 
				clearTimeout(slide_t);
				slide_t=setTimeout(do_slide,10000); // wait 10s and try again
				$("#slide").html("Error, no slides. " + slide_count + " time.");
				return;
			}
			active_slide = 1;		
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
		active_slide++;
		clearTimeout(slide_t);
		
		$("#progressbar").fadeOut("slow");
		slide_t=setTimeout(do_slide,slide_duration);
	
	}
	
	function do_update() {
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
				active_slide = 1;

				// set new settings
				set_settings();
				
			}
				
			$("#debug .update").html("update_count: " + update_count + "<br>slide-items: " + (newcount - 1) + "<br>Updated " + DateString(new Date()));
			

		  
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
		// vertical align
		if ($("#slide").height() > $("#slide .slide_image img").height())
			$("#slide .slide_image").css("margin-top", ($("#slide").height() - $("#slide .slide_image img").height()) / 2 + "px");
		else
			$("#slide .slide_image").css("margin-top", "0px");
		
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
		$("#header_logo").toggle(($("#source .settings .header_logo").html() != ""));
		$("#header_logo").attr("href",$("#source .settings .header_logo").html());
		
		$("#footer").toggle(($("#source .settings .footer_text").html() != ""));
		$("#footer .padding").html($("#source .settings .footer_text").html());
		
		$("#footer").css("background-color", $("#source .settings .footer_background_color").html());
		$("#footer").css("color", $("#source .settings .footer_text_color").html());
		blank_screen_from = $("#source .settings .blank_screen_from").html();
		blank_screen_to = $("#source .settings .blank_screen_to").html();
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
		return pad(d.getUTCHours())+':'
			  + pad(d.getUTCMinutes());

	}
})(jQuery);

