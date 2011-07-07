jQuery(function($){

	$(esdcFileType).bind('click',function(){
		
		var link_path = $(this).attr('href');
		var url = link_path;
		link_path = link_path.split('/');
		filename = link_path[link_path.length-1];
		if(filename !== ""){
			esdc_count_download(filename,url);
			return false;
		}
	});
	
	$('form#esdc-search-form input[type=submit]').click(function(){
		var from = $('form#esdc-search-form input[name=escd_from_date]').val(),
			to = $('form#esdc-search-form input[name=escd_to_date]').val();
		esdc_search_dates(from,to);
		return false;
	});
	
});

