jQuery(document).ready(function($){
	$("ul#esdc-navigation li a:first").addClass("active");
	$("div.esdc-container:not(:first)").hide();
	$("ul#esdc-navigation li a").click(function(){
		if(!$(this).hasClass("active")){
			var esdc_identifier = $(this).attr("class");
			$("ul#esdc-navigation li a").removeClass("active");
			$("ul#esdc-navigation li a." + esdc_identifier).addClass("active");
			$("div.esdc-container").hide();
			$("div." + esdc_identifier).show();
		}
		return false;
	});
});