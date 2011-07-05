<?php
global $wpdb;

function electric_studio_download_counter_install() {
	/* Registers version number */
	add_option('electric_studio_download_counter','0.5');
	/* Creates new database */
	global $wpdb;
	
	$tableName = $wpdb->prefix."es_download_counter";
	
	$sqlCreateTable = "CREATE TABLE ".$tableName." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  download_name text NOT NULL,
	  UNIQUE KEY id (id)
	);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sqlCreateTable);
	
	add_option("esdc_file_types", array("pdf","doc","xls","docx","xlsx","csv"), '', 'yes');
}

function electric_studio_download_counter_remove() {
	$tableName = $wpdb->prefix."es_download_counter";
	
	/* Drops Table created for plugin */
	$sqlDropTable = "DROP TABLE IF EXISTS ".$tableName.";";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sqlDropTable);
		
	/* Deletes the database field */
	delete_option('esdc_file_types');
}

?>
