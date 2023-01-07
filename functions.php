<?php
function deepi_admin_notice($message,$status = 'info') {
	if($status=='success'){
		$class = 'notice notice-success';
	}
	elseif($status=='error'){
		$class = 'notice notice-error';
	}
	elseif($status=='warning'){
		$class = 'notice notice-warning';
	}
	elseif($status=='info'){
		$class = 'notice notice-info';
	}
	else{
		$class = 'notice notice-info';
	}
	
	
	echo "<div class='".esc_html($class)."' is-dismissible'><p>".esc_html($message)."</p></div>";
	
   
}

function deepi_dumper($any){
	echo "<br /><pre dir='ltr' style='text-align:left;'>";
	var_dump($any);
	echo "</pre><br />";
}

function deepi_log($path){
	$deepi_log = fopen("deep_log.txt", "w") or die("Unable to open file!");
	$txt = $request_data."\n";
	fwrite($deepi_log, $txt);
	fclose($deepi_log);
}

function deepi_is_key($input){
	//$pattern = "~^[a-zA-Z0-9]+$~";
	if(preg_match("/^[a-zA-Z0-9-_\s]+$/" , $input ) == 0){
		return false;
	}
	else {
        return true;
	}
}


function deepi_fetch_key($key){
    global $wpdb;
	$table_name = $wpdb->prefix . "deepi";
	$sql = "select * from `$table_name` where `key` = '$key';";
	$result = $wpdb->get_results($sql);
	if(!isset($result[0]->key)){
		return "";
	}
    else {
        return $result[0]->value;
    }
}

function old_deepi_save_key($key, $new_value){
    global $wpdb;
	$table_name = $wpdb->prefix . "deepi";

    $old_key = deepi_fetch_key($key);
    if($old_key == ''){
        $sql = "insert into `$table_name` (`key`, `value`) values ('$key', '$new_value') ;";
    }
    else {
        $sql = "update `$table_name` set `value` = '$new_value' where `key`='$key';";
    }
    $result = $wpdb->query($sql);
    if($result){
        $msg = __('Value is saved successfully.','deepi');
        deepi_admin_notice($msg,'success');
    }	
    else {
        $msg = __('Failed saving the value.','deepi');
        deepi_admin_notice($msg,'error');
    }
}

function deepi_save_settings($data){
	global $wpdb;
	$table_name = $wpdb->prefix . "deepi";

	$form_visibility = (isset($data['form_visibility']) and $data['form_visibility']==1)?'0':'1';
	$deepi_link_visibility = (isset($data['deepi_link_visibility']) and $data['deepi_link_visibility']==1)?'0':'1';
	$deepi_post_link = (isset($data['deepi_post_link']) and $data['deepi_post_link']==1)?'0':'1';

	$sqls = ['secret_key' => "update `$table_name` set `value` = '". $data['secret_key'] ."' where `key`='secret_key';", 
			'slug' => "update `$table_name` set `value` = '". $data['slug'] ."' where `key`='slug';" , 
			'style' => "update `$table_name` set `value` = '". $data['style'] ."' where `key`='style';",
			'form_visibility' => "update `$table_name` set `value` = '". $data['form_visibility'] ."' where `key`='form_visibility';",
			'deepi_link_visibility' => "update `$table_name` set `value` = '". $data['deepi_link_visibility'] ."' where `key`='deepi_link_visibility';",
			'deepi_post_link' => "update `$table_name` set `value` = '". $data['deepi_post_link'] ."' where `key`='deepi_post_link';",
];

	foreach($sqls as $key => $sql){
		$result = $wpdb->query($sql);
	}
	
	$msg = __('Values are saved successfully.','deepi');
	deepi_admin_notice($msg,'info');
}

function deepi_is_active(){
	$slug = deepi_fetch_key('slug');
	$api  = "https://www.deepi.ir/dashboard/api/v1/active/$slug/";
// 	$api  = "http://www.deepi.lab/dashboard/api/v1/active/$slug/";
	$json = @file_get_contents($api);
	$array = json_decode($json, true);
	if($json == false or $array['active']==false){
		return false;
	}
	elseif($array['active']==true){
		return true;
	}
}

function deepi_is_active_2(){
	$slug = deepi_fetch_key('slug');
	//$slug = "sa";
	$api  = "https://www.deepi.ir/dashboard/api/v1/info/$slug/";
// 	$api  = "http://www.deepi.lab/dashboard/api/v1/info/$slug/";

	$request_data = 			
				array(
					'headers'=> [
						'Authorization'=> deepi_fetch_key('secret_key') ,
					]
				);		
	 
	$response = wp_remote_get( $api, $request_data );

	//deepi_dumper($response);

	//return $response['response']['code'];
	return $response;
}

function deepi_get_cached_delay(){
	$response = deepi_is_active_2();
	$json = $response['body'];
	$array = json_decode($json, true);
	return $array['cached_delay'];
}


function deepi_check(){
	$status = deepi_is_active_2();
	if($status['response']['code'] == 200){
		$active = json_decode($status['body'], true)['active'];
		if($active){
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}	
}

function deepi_is_active_msg(){
	$status = deepi_is_active_2();
	if($status['response']['code'] == 200){
		$msg = __('Your account in Deepi is active.','deepi');
		$color = 'success';
	}
	elseif($status['response']['code'] == 404){
		$msg = __('The project slug is incorrect.','deepi');
		$color = 'error';
	}
	elseif($status['response']['code'] == 403) {
		$msg = __('Your API key is invalid.','deepi');
		$color = 'error';
	}	
	deepi_admin_notice($msg, $color);
}


function deepi_select_unsubmited(){
	global $wpdb;
	$table_name = $wpdb->prefix . "posts";
	$sql = "select `ID` from `$table_name` where `deepi_status` = 'unsubmitted' AND  `post_status` = 'publish' and `ping_status` = 'open' ;";
	$result = $wpdb->get_results($sql, 'ARRAY_A');
	return $result;
}

function deepi_select_posts_by_status($status='submitted'){
	global $wpdb;
	$table_name = $wpdb->prefix . "posts";
	$sql = "select `ID` from `$table_name` where `deepi_status` = '$status' AND  `post_status` = 'publish' and `ping_status` = 'open' ;";
	$result = $wpdb->get_results($sql, 'ARRAY_A');
	return $result;
}

function deepi_post_status($ID){
	global $wpdb;
	$table_name = $wpdb->prefix . "posts";
	$sql = "select `deepi_status` from `$table_name` where `ID` = '$ID' ;";
	$result = $wpdb->get_results($sql, 'ARRAY_A');
	return $result[0]['deepi_status'];
}

function deepi_save_status($post, $status='submitted'){
	global $wpdb;
	$table_name = $wpdb->prefix . "posts";
	$sql = "update `$table_name` set `deepi_status` = '$status' where `ID`='" . $post->ID . "';";
	$wpdb->query($sql);
}

function deepi_submit_request($post){
	$image = (get_the_post_thumbnail_url($post))?get_the_post_thumbnail_url($post):'';
	$request_data = 
			json_encode(
				array(
					'project' => deepi_fetch_key('slug'), 
					'title' => $post->post_title, 
					'content_type' => 1,
					'content' => $post->post_content, 
					'mtime' => strtotime($post->post_modified),  
					'path' => $post->guid, 
					'image' => $image, 
					'lang' => substr(get_bloginfo( 'language' ), 0, 2), 
				)			
		);
		//deepi_dumper($post);
		//deepi_dumper($request_data);
		
		

		//////////////////////////////////////////

		$url = 'https://www.deepi.ir/dashboard/api/v1/files/';
// 		$url = 'http://www.deepi.lab/dashboard/api/v1/files/';

		 
		$options = [
			'body'        => $request_data,
			'headers'     => [
				'Content-Type' => 'application/json',
				'Authorization'=> deepi_fetch_key('secret_key') ,
			],
			'sslverify'   => false,
			'data_format' => 'body',
		];
		 
		$response = wp_remote_post( $url, $options );

		////////
		//deepi_dumper($response);
		if($response){
			//$response_array = json_decode($response, true);
			$response_status = $response['response']['code'];
			if($response_status == 201 or substr($response_status, 0, 2) == 20 or $response_status == 406){
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
		
}

function deepi_submit_request_delete($post){
	$request_data = 
			json_encode(
				array(
					'project' => deepi_fetch_key('slug'),
					'path' => $post->guid,
				)			
		);
		//deepi_dumper($request_data);

		$url = 'https://www.deepi.ir/dashboard/api/v1/files/'.deepi_fetch_key('slug').'/?path='.$post->guid;
// 		$url = 'http://www.deepi.lab/dashboard/api/v1/files/'.deepi_fetch_key('slug').'/?path='.$post->guid;

		 
		$options = [
			'method' 	=> 'DELETE', 
			'body'        => $request_data,
			'headers'     => [
				'Content-Type' => 'application/json',
				'Authorization'=> deepi_fetch_key('secret_key') ,
			],
			'sslverify'   => false,
			'data_format' => 'body',
		];
		 
		$response = wp_remote_request( $url, $options );

		////////
		//deepi_dumper($response);
		if($response){
			//$response_array = json_decode($response, true);
			$response_status = $response['response']['code'];
			if($response_status == 204 or substr($response_status, 0, 2) == 20){
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
}

function deepi_reset(){
	global $wpdb;
	$table_name = $wpdb->prefix . "posts";
	$sql = "update `$table_name` set `deepi_status` = 'unsubmitted' ;";
	$wpdb->query($sql);
	header('location: /wp-admin/admin.php?page=deepi_settings');
	exit;
}

// this is the safest method I could find atm to separate 'update' and 'publish'
add_action( 'wp_after_insert_post', 'deepi_post_submit', 10, 4 );

//add_action( 'transition_post_status', 'deepi_post_submit', 10, 3 );
//function deepi_post_submit( $new_status, $old_status, $post ) { 

function deepi_post_submit( $post_id, $post, $update, $post_before ) { 
    //if ( $new_status == 'publish' && $old_status != 'publish' ) {
	if(deepi_check()!=true){
		deepi_save_status($post, 'unsubmitted');
	}
	else{
    	if ( 'publish' == $post->post_status ) {
			$submit = deepi_submit_request($post);
			if($submit){
				deepi_save_status($post);
			}

			$not_submited_ones = deepi_select_unsubmited();	
			if($not_submited_ones){
				foreach($not_submited_ones as $nso){
					$post = get_post($nso['ID']);
					$submit = deepi_submit_request($post);
					if($submit){
						deepi_save_status($post);
					}
				}
			}

		}
		elseif ( $post->post_status == 'trash' ) {
			$submit = deepi_submit_request_delete($post);
			if($submit){
				deepi_save_status($post, 'unsubmitted');
			}
		}
	}
}


add_filter( 'the_content', 'deepi_post_link', 1 );
function deepi_post_link($content){
	global $post;

	

	$deepi_post_link = deepi_fetch_key('deepi_post_link');

	if($deepi_post_link == 0 or deepi_is_active()!=true or deepi_post_status($post->ID)!="submitted"){
		return $content;
	}

	$delay = deepi_get_cached_delay();
	$post_timestamp = strtotime($post->post_modified);
	$current_timestamp = current_time('timestamp') ;

	if($current_timestamp-$post_timestamp<$delay){
		return $content;
	}
	$logo_url = deepi__PLUGIN_URL."/resources/img/logo.png";
	$link = "https://www.deepi.ir/". substr(get_bloginfo( 'language' ), 0, 2) ."/".deepi_fetch_key('slug')."/cached/?path=".$post->guid;
	$text = __('Deepi version','deepi');
// 	$html = "<div id='deepi_post_link'><a href='$link' target='_blank'><img src='$logo_url'>$text</a></div>";
	$html = "<div id='deepi_post_link'><a href='$link' target='_blank'><div><img src='$logo_url'></div><div>$text</div></a></div>";
	return $content.$html;
}





/////status
function deepi_all_status(){
    $submitted = deepi_select_posts_by_status('submitted');
    $unsubmitted = deepi_select_posts_by_status('unsubmitted');
    $crawled = deepi_select_posts_by_status('crawled');
    $error = deepi_select_posts_by_status('error');
    $all_posts=[
        'submitted' => $submitted,
        'unsubmitted' => $unsubmitted,
        'crawled' => $crawled,
        'error' => $error,
    ];
    return $all_posts;
}

function deepi_all_to_index(){
    $all = deepi_all_status();
    $to_index = array_merge($all['unsubmitted'], $all['crawled'], $all['error']);
    return $to_index;
}

function deepi_index_submit(){
	if(deepi_check()!==true){
		return;
	}
	else{
		$all_to_index = deepi_all_to_index();
		if($all_to_index){
			foreach($all_to_index as $nso){
				$post = get_post($nso['ID']);
				$submit = deepi_submit_request($post);
				if($submit){
					deepi_save_status($post);
				}
			}
			header('location: /wp-admin/admin.php?page=deepi_settings');
			exit;
		}
		else {
			$msg = __('You have no unsubmitted posts.');
			deepi_admin_notice($msg, 'info');
		}
	}
}

