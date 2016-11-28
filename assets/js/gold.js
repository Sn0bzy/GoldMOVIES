jQuery(document).ready(function($){
	$(".select-movie-genre").fadeIn('slow');
	$(".select-movie-genre").click(function (e) {
		e.stopPropagation();$("#select-movie-genre").fadeToggle(50);
	});
	$(document).click(function () {
		var $el = $("#select-movie-genre");
		if ($el.is(":visible")) {
			$el.fadeIn(50);
			$el.fadeOut(50);
		}
	});
	$(".select-movie-genre").mouseleave(function() {
		$("#select-movie-genre").css('display', 'none');
	});
    $("#main-nav-toggle").click(function(event)
    {
        $(".sidebar").animate({width: 'toggle'});      
    });
    $("#close-aside").click(function(event)
    {
        $(".sidebar").animate({width: 'toggle'});      
    });
});
jQuery(function($){
	$("#comment_value").keyup(function(){
    	$(".char_num").text($(this).val().length);
	});
	$('#loginform').submit(function(e){
		return false;
	});
});

jQuery("#login_button").live('click', function(){
	username=$("#signin-email").val();
	password=$("#signin-password").val();
	$.ajax({
		type: "POST",
		url: "/gold-app/gold-includes/GOLD.php",
		data: "gold=login&name="+username+"&password="+password,
		success: function(html){
			if(html=='true') {
				//$("#add_err").html("right username or password");
				window.location="/admin";
			} else {
				$("#cd-error-message").css('display', 'inline', 'important');
				$("#cd-error-message").html(html);
			}
		}
	});
	return false;
});
		
jQuery("#cd-error-message").hide();

jQuery(function($){
	function handleResize() {
	    var w = $(window).width();
	    var h = $(window).height();
	    if(logged_in == '1') {
		    $('#featuresparallax').css({'height':(h - 32)+'px'});
		} else {
		    $('#featuresparallax').css({'height':(h - 0)+'px'});
		}
	    $('#homesidebar').css({'height':h - detect_h +'px'});
	    $('#homecontent').css({'width':w - 265 +'px'});
	    $('#homecontent').css({'height':h - detect_h +'px'});
	}

	handleResize();
	    
	$(window).resize(function(){
		handleResize();
	});

	function ins2pos(str, id) {
		var TextArea = document.getElementById(id);
		var val = TextArea.value;
		var before = val.substring(0, TextArea.selectionStart);
		var after = val.substring(TextArea.selectionEnd, val.length);
		TextArea.value = before + str + after;
	}

	$(".social-share").click(function(event) {
		var width  = 575,
       		height = 400,
        	left   = ($(window).width()  - width)  / 2,
        	top    = ($(window).height() - height) / 2,
        	url    = this.href,
        	opts   = 'status=1' +
                	 ',width='  + width  +
               		 ',height=' + height +
       	         	 ',top='    + top    +
        	    	 ',left='   + left;
	    
	    	window.open(url, 'twitter', opts);
 		return false;
	});
});
jQuery(window).load(function(){
	jQuery('.overlay').fadeOut(200);
});
jQuery(document).ready(function(){
	jQuery('.movie-element').addClass("hidden").viewportChecker({
		classToAdd: 'slideUp', // Class to add to the elements when they are visible
		offset: 0
	});
	jQuery('.large-slide').addClass("hidden").viewportChecker({
		classToAdd: 'slideUp', // Class to add to the elements when they are visible
		offset: 0
	});
	jQuery('.normal-slide').addClass("hidden").viewportChecker({
		classToAdd: 'slideDown', // Class to add to the elements when they are visible
		offset: 0
	});
	jQuery('.small-slide').addClass("hidden").viewportChecker({
		classToAdd: 'slideUp', // Class to add to the elements when they are visible
		offset: 0
	});
	jQuery('#homesidebar ul li a').addClass("hidden").viewportChecker({
		classToAdd: 'slideDown', // Class to add to the elements when they are visible
		offset: 0
	});
});