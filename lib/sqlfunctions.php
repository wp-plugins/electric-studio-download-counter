<?php

function esdc_add_to_count($filename){
	global $wpdb;
	$tableName = $wpdb->prefix."es_download_counter";
	
	$sql = "INSERT INTO $tableName (time, download_name) VALUES ('".current_time('mysql')."', '$filename')";

	$wpdb->query($sql);
}

function esdc_get_count($filename, $from="", $to=""){
	global $wpdb;
	
	if($to==""){
		$to = current_time('mysql');
	}
	
	if($from==""){
		$from = '0000-00-00';
	}
	
	$tableName = $wpdb->prefix."es_download_counter";
	
	$sql = $wpdb->prepare("SELECT id, time FROM ".$tableName." WHERE download_name = '%s' AND time BETWEEN %s AND %s",$filename,$from,$to);

	$results = $wpdb->query($sql);
	
	return $results;
}


function esdc_get_data($from="", $to="", $filename="", $limit=""){
	global $wpdb;
	$tableName = $wpdb->prefix."es_download_counter";
	$whereClause = false;
	
	$sql = "SELECT count(id) as count, download_name FROM  $tableName";
	if($filename != ""){
		$sql .= " WHERE download_name='$filename'";
		$whereClause = true;
	}
	
	if($from != "" || $to != ""){
		if($from == ""){
			$from = "0000-00-00";
		}
		
		if($to == ""){
			$to = current_time('mysql');
		}
		
		if($whereClause == true){
			$sql .= " AND time";
		}else{
			$sql .= " WHERE time";
		}
		
		$sql .= " BETWEEN '$from' AND '$to'";
	}
	
	$sql .= " GROUP BY download_name ORDER BY count DESC";
	
	if($limit != ""){
		$sql .= " LIMIT 0,$limit";
	}
	
	
	$sql = $wpdb->prepare($sql);
	
	$results = $wpdb->get_results($sql);

	return $results;
}
?>