<?php

add_action('admin_menu', 'create_esdc_options_page');
add_action('admin_init', 'register_and_build_esdc_options');

function create_esdc_options_page() {
  add_options_page('Download Counter', 'Download Counter', 'administrator', __FILE__, 'esdc_options_page');
}

function esdc_links(){ ?>
	<ul id="esdc-navigation">
		<li><a href="#" class="esdc-lastweek">Last 7 Days</a></li>
		<li><a href="#" class="esdc-lastmonth">Last 30 Days</a></li>
		<li><a href="#" class="esdc-topten">Top Ten</a></li>
		<li><a href="#" class="esdc-search">Search Dates</a></li>
		<li><a href="#" class="esdc-options">Plugin Options</a></li>
	</ul>
<?php }

function esdc_options(){ ?>	
	<form method="post" action="options.php">
      <?php settings_fields('esdc_file_types'); ?>
      <?php do_settings_sections(__FILE__); ?>
      <p class="submit">
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
      </p>
    </form>	
<?php }

function esdc_populate_stats($from="", $to="", $file="",$limit=""){
	$results = esdc_get_data($from, $to, $file, $limit); ?>

	<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<th>File Name</th>
			<th>Download Count</th>
		</tr>
	<?php
	$oddEven = 'odd';
	foreach($results as $result){
		echo "<tr class=\"";
		$oddEven = ( $oddEven == 'odd') ? 'even' : 'odd';
		echo $oddEven;
		echo "\">";
		echo "<td>".$result->download_name."</td><td class=\"esdc-result-count\">".$result->count."</td>";
		echo "</tr>";
	} ?>
	
	</table>
	
	<?php
}

function esdc_options_page() {
?>
  <div id="theme-options-wrap">
    <div class="icon32" id="icon-tools"> <br /> </div>
    <h2>Electric Studio Download Counter</h2>
    <p><?php _e('View all your download stats here.'); ?></p>
    <?php esdc_links(); ?>
    
    <div class="esdc-lastweek esdc-container">
    	<?php
		$lastweek = date( "Y-m-d" ,mktime(0, 0, 0, date("m"), date("d")-7,   date("Y")));
    	esdc_populate_stats($lastweek, current_time('mysql'));
    	?>
    </div>
    <div class="esdc-lastmonth esdc-container">
    	<?php
		$lastmonth = date( "Y-m-d" ,mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
    	esdc_populate_stats($lastmonth, current_time('mysql'));
    	?>
    </div>
    <div class="esdc-topten esdc-container">
    	<?php
    	esdc_populate_stats('','','',10);
    	?>
    </div>
    <div class="esdc-search esdc-container">
    	<form method="POST" action="" id="esdc-search-form">
    		<label for="escd_from_date">From (YYYY-MM-DD): </label>
    		<input type="text" name="escd_from_date" id="escd_from_date" />
    		<label for="escd_to_date">To (YYYY-MM-DD): </label>
    		<input type="text" name="escd_to_date" id="escd_to_date" />
    		<input type="submit" value="submit" class="button" />
			<br class="clear" />
    	</form>
    	<div id="esdc-search-results-loading" style="display:none">Loading...</div>
    	<div id="esdc-search-results">
    		<?php esdc_populate_stats('','','',10); ?>
    	</div>
    </div>
	<div class="esdc-options esdc-container"><?php esdc_options(); ?></div>
	
    <p>Plugin Created By <a href="http://www.electricstudio.co.uk/2011/05/wordpress-auto-post-expire-plugin/">Electric Studio</a></p>
  </div>
<?php
}

function register_and_build_esdc_options(){
  register_setting('esdc_file_types','esdc_file_types', 'validate_esdc_file_types');
  add_settings_section('main_section', 'Download Settings','esdc_section_callback',__FILE__);
  add_settings_field('esdc_file_types','File Types: ','esdc_file_types',__FILE__,'main_section');  
}

function validate_esdc_file_types($option){
	$option = explode(',',$option);
	array_map('esdc_remove_whitespaces',$option);
    //put any validation on the option here.
    return $option;
}

function esdc_remove_whitespaces($var){
	return preg_replace('/ /','',$var);
}

function esdc_section_callback(){}

function esdc_file_types(){
	$optionValue = implode(get_option('esdc_file_types'),',');
    $option = "";
    $option .= "<input type=\"text\" name=\"esdc_file_types\" value=\"".$optionValue."\"/><p>eg. pdf,mp3,wma";
    echo $option;
}

?>
