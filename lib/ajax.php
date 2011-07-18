<?php 

add_action('wp_print_footer_scripts','esdc_print_js_string');
add_action('wp_print_footer_scripts','esdc_print_ajax_js');
add_action('wp_print_footer_scripts','esdc_print_ajax_date_search_js');

if( is_admin() ){
	//add ajax hooks if logged in as admin
	add_action('wp_ajax_nopriv_esdcCount','esdc_count');
	add_action('wp_ajax_esdcCount','esdc_count');
	add_action('wp_ajax_esdcDateSearch','esdc_date_search');
}else{
	//add ajax hooks if not logged in as admin (ajax is not enabled on frontend wordpress by default)
	add_action('wp_ajax_nopriv_esdcCount','esdc_count');
}


function esdc_count(){
	$data = esdc_add_to_count($_POST['file']);
	print_r(esdc_get_count($_POST['file']));
	die;
}

function esdc_print_js_string(){ ?>
	<script type="text/javascript">
		<?php 
		$fileTypeArray = get_option('esdc_file_types');
		$jsFileTypeString = "esdcFileType = \"";
		$i = 0;
		while($i < count($fileTypeArray)){
			$jsFileTypeString .= "a[href $='".$fileTypeArray[$i]."']";
			if($i != count($fileTypeArray)-1){
				$jsFileTypeString .= ", ";
			}
			$i++;
		}
		$jsFileTypeString .= "\"\n";
		echo $jsFileTypeString.";";
		?>
	</script>
<?php }

function esdc_print_ajax_js(){ ?>
	<script type="text/javascript">
		function esdc_count_download(filename,url){
		    jQuery.ajax({
		        type: "post",
		        url: "<?php echo get_admin_url(); ?>admin-ajax.php",
		        data: {
		                action: 'esdcCount',
		                file: filename,
		                _ajax_nonce: '<?php echo $esdcCount_nonce; ?>'
		        },
		        beforeSend: function () {
		                //$('input[name=searchparam]').addClass('loading');
		        },
		        complete: function () {
		                //$('input[name=searchparam]').removeClass('loading');
		        },
		        success: function (html) { //so, if data is retrieved, store it in html
		                window.location = url;
		        },
		        error: function(){
		            alert('There has been an error, Please try again');
		            return false;
		        }
	    	});
		}
	</script>
<?php } 

function esdc_print_ajax_date_search_js(){ ?>
	<script type="text/javascript">
		function esdc_search_dates(from,to){
		    jQuery.ajax({
		        type: "post",
		        url: "<?php echo get_admin_url(); ?>admin-ajax.php",
		        data: {
		                action: 'esdcDateSearch',
		                fromdate: from,
		                todate: to,
		                _ajax_nonce: '<?php echo $esdcDateSearch_nonce; ?>'
		        },
		        beforeSend: function () {
		        		jQuery('div#esdc-search-results-loading').show();
		        },
		        complete: function () {
		        		jQuery('div#esdc-search-results-loading').hide();
		        },
		        success: function (html) { //so, if data is retrieved, store it in html
		                jQuery('div#esdc-search-results').html(html);
		        },
		        error: function(){
		            alert('There has been an error, Please try again');
		            return false;
		        }
	    	});
		}
	</script>
<?php } 

function esdc_date_search(){
	esdc_populate_stats($_POST['fromdate'],$_POST['todate'],'',30);
	die;
}

?>
