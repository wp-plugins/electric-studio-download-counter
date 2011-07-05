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

	
	
});

