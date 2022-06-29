<?php
function deepi_install(){
    //// Default Table of Deepi
    global $wpdb;
    
    $table_name = $wpdb->prefix . "deepi";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        `id` int(9) NOT NULL AUTO_INCREMENT,
        `key` varchar(255) NOT NULL,
        `value` varchar(255) NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;
		";
    
      
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta($sql);
      
      $table_name = $wpdb->prefix . "deepi";
      global $wpdb;
      $keys = ['secret_key', 'slug', 'style', 'form_visibility', 'deepi_link_visibility', 'deepi_post_link']; 
      foreach($keys as $key){
          if(deepi_fetch_key($key) == ""){
              $wpdb->insert($table_name, array(
                  'key' => $key,
                  'value' => 1,
                  ) );
          }
      }  
      
    
    //// Post Status
    $table_name = $wpdb->prefix . "posts";
	$column_name_1 = 'deepi_status';
	$sql = "ALTER TABLE $table_name ADD `$column_name_1` enum('crawled', 'submitted', 'error', 'unsubmitted') NOT NULL DEFAULT 'unsubmitted' AFTER `ID` ;"; 	
	$sql2 = "update `$table_name` set `deepi_status` = 'crawled' where `deepi_status`='unsubmitted' ;";
	$if_column_exist_1 = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = '$table_name' AND column_name = '$column_name_1'"  );

	if(empty($if_column_exist_1)){
		$wpdb->query($sql);
        $wpdb->query($sql2);
	}
    

}