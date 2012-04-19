<?php 

class Esdc_ajax{

    function __construct(){
        if( is_admin() ){
        	//add ajax hooks if logged in as admin
        	add_action('wp_print_scripts',array(&$this,'print_js_string'));
        	add_action('admin_print_footer_scripts',array(&$this,'print_ajax_js'));
        	add_action('admin_print_footer_scripts',array(&$this,'print_ajax_date_search_js'));		
        	add_action('wp_ajax_nopriv_esdcCount',array(&$this,'count'));
        	add_action('wp_ajax_esdcCount',array(&$this,'count'));
        	add_action('wp_ajax_esdcDateSearch',array(&$this,'date_search'));
        }else{
        	//add ajax hooks if not logged in as admin (ajax is not enabled on frontend wordpress by default)
        	add_action('wp_print_scripts',array(&$this,'print_js_string'));
        	add_action('wp_print_scripts',array(&$this,'print_ajax_js'));	
        	add_action('wp_ajax_nopriv_esdcCount',array(&$this,'count'));
        }
    }
    
    /**
     * @method count()
     * Adds $_POST['file'] to the download count
     * @return N/A
     */
    function count(){
        wp_verify_nonce('esdcCount');
        $db = new Esdc_db();
    	$data = $db->add_to_count($_POST['file']);
    	die;
    }
    
    function print_js_string(){ ?>
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
    		$jsFileTypeString .= "\"";
    		echo $jsFileTypeString.";";
    		?>
    	</script>
    <?php }
    
    function print_ajax_js(){ ?>
    	<?php global $esdc; ?>
    	<script type="text/javascript">
    		function esdc_count_download(filename,url,target){
    		    jQuery.ajax({
    		        type: "post",
    		        url: "<?php echo get_admin_url(); ?>admin-ajax.php",
    		        data: {
    		                action: 'esdcCount',
    		                file: filename,
    		                _ajax_nonce: '<?php echo $esdc->count_nonce; ?>'
    		        },
    		        beforeSend: function () {
    		                //$('input[name=searchparam]').addClass('loading');
    		        },
    		        complete: function () {
    		                //$('input[name=searchparam]').removeClass('loading');
    		        },
    		        success: function (html) { //so, if data is retrieved, store it in html
        		        //check if the link was meant to open in a new window or now
        		        if(target!="_blank"){
            		        //redirect to url
    		                window.location = url;
        		        }else{
            		        //open a new window with the url
            		        window.open(url);
        		        }
    		        },
    		        error: function(){
    		            alert('There has been an error, Please try again');
    		            return false;
    		        }
    	    	});
    		}
    	</script>
    <?php } 
    
    function print_ajax_date_search_js(){ ?>
    	<?php global $esdc; ?>
    	<script type="text/javascript">
    		function esdc_search_dates(from,to){
    		    jQuery.ajax({
    		        type: "post",
    		        url: "<?php echo get_admin_url(); ?>admin-ajax.php",
    		        data: {
    		                action: 'esdcDateSearch',
    		                fromdate: from,
    		                todate: to,
    		                _ajax_nonce: '<?php echo $esdc->dateSearch_nonce; ?>'
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
    
    function date_search(){
        wp_verify_nonce('esdcDateSearch');
    	Esdc_options::populate_stats($_POST['fromdate'],$_POST['todate']);
    	die;
    }

}

$esdcAjax = new Esdc_ajax();