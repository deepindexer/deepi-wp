<?php

$to_submit_count = count(deepi_all_to_index());
$submitted_count = count(deepi_all_status()['submitted']);
require_once(ABSPATH . 'wp-admin/includes/screen.php');

function deepi_settings_html() {
    global $to_submit_count, $submitted_count;
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    global $wpdb;

    if(!function_exists('wp_get_current_user')) { include(ABSPATH . "wp-includes/pluggable.php"); }

if(isset($_POST['deepi_settings_submit'])){    
    if(!current_user_can('manage_options')){
        $msg = __("you don't have enough privileges to perform this operation.",'deepi');
        deepi_admin_notice($msg,'error');
    }
    // check if necessary data is sent:
    elseif(
        !isset($_POST['secret_key']) or 
        !isset($_POST['slug']) or 
        !isset($_POST['style']) 
    ){
        $msg = __('Invalid inputs.','deepi');
        deepi_admin_notice($msg,'error');
    }
    // validating data :
    elseif(
        deepi_is_key($_POST['secret_key']) != true or 
		deepi_is_key($_POST['slug']) != true or 
		!in_array($_POST['style'], ['default', 'classic'])  
    ){
        $msg = __('Invalid inputs.','deepi');
        deepi_admin_notice($msg,'error');
    }
    else {
        // These data can only 0 or 1;
        $form_visibility = (isset($_POST['form_visibility']) and $_POST['form_visibility']==1)?'0':'1';
        $deepi_link_visibility = (isset($_POST['deepi_link_visibility']) and $_POST['deepi_link_visibility']==1)?'0':'1';
	    $deepi_post_link = (isset($_POST['deepi_post_link']) and $_POST['deepi_post_link']==1)?'0':'1';

        $data = [
            'secret_key' => sanitize_text_field($_POST['secret_key']),
            'slug' => sanitize_text_field($_POST['slug']),
            'style' => sanitize_text_field($_POST['style']),
            'form_visibility' => $form_visibility, 
            'deepi_link_visibility' => $deepi_link_visibility,
            'deepi_post_link' => $deepi_post_link,
        ];
        deepi_save_settings($data);
    }
      
}

if(isset($_POST['deepi_index_submit'])){
    if(!current_user_can('manage_options')){
        $msg = __("you don't have enough privileges to perform this operation.",'deepi');
        deepi_admin_notice($msg,'error');
    }
    else {
        deepi_index_submit();
    }
    
}

if(isset($_POST['deepi_reset_submit'])){
    if(!current_user_can('manage_options')){
        $msg = __("you don't have enough privileges to perform this operation.",'deepi');
        deepi_admin_notice($msg,'error');
    }
    else {
        deepi_reset();
    }
    
}
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <br />
    <?php 
    deepi_is_active_msg();
    ?>
    <br />
    <form method='post'>
        <label for='secret_key' ><?php _e('Enter your API key here.','deepi'); ?></label>
        <br />
        <input name='secret_key' type='text' class='' autocomplete='off' value='<?php echo esc_html(deepi_fetch_key('secret_key')); ?>'  >
    

    <br />
    <br />
    
        <label for='slug' ><?php _e('Enter your project slug here.','deepi'); ?></label>
        <br />
        <input name='slug' type='text' class='' autocomplete='off' value='<?php echo esc_html(deepi_fetch_key('slug')); ?>'  >
   

    <br />
    <br />
    
        <label for='style' ><?php _e('choose style of the search form.','deepi'); ?></label>
        <br />
        <select name='style' autocomplete='off'>
            <option <?php echo (deepi_fetch_key('style')=='default')?'selected':''; ?> value='default'><?php _e('Default', 'deepi'); ?></option>
            <option <?php echo (deepi_fetch_key('style')=='classic')?'selected':''; ?> value='classic'><?php _e('Classic', 'deepi'); ?></option>
        </select>

    <br />    
    <br />

    <input <?php echo (deepi_fetch_key('deepi_post_link')=='0')?'checked':''; ?> name="deepi_post_link" type='checkbox' value="1">
    <label for='style' ><?php _e('Remove "Deepi version" link','deepi'); ?></label>
    <br />    
    <br />
    
    <input <?php echo (deepi_fetch_key('form_visibility')=='0')?'checked':''; ?> name="form_visibility" type='checkbox' value="1">
    <label for='form_visibility' ><?php _e("Don't display Deepi search form.",'deepi'); ?></label>
    <br />    
    <br />
    <input <?php echo (deepi_fetch_key('deepi_link_visibility')=='0')?'checked':''; ?> name="deepi_link_visibility" type='checkbox' value="1">
    <label for='deepi_link_visibility' ><?php _e("Remove Deepi powered by logo link.",'deepi'); ?></label>
    <br />    
    <br />
        <input type="submit" name="deepi_settings_submit" id="submit" class="button button-primary" value="<?php _e('save', 'deepi'); ?>">
    </form>
	
    <br /><br />
    <h2><?php _e('Post status','deepi'); ?></h2>
    <div class="notice notice-info ">
        <p>
            <?php 
            _e('unsubmitted posts: ','deepi'); 
            echo esc_html($to_submit_count)."<br />";
            _e('submitted posts: ','deepi');
            echo esc_html($submitted_count); 
            $status = deepi_is_active_2();
          if($status['response']['code']==200){
            $remaining = json_decode($status['body'], true)['concept_remaining_size'];
          //echo esc_html($remaining);
          if($remaining > 0 ){
            printf("<br />");
            printf(__('Number of sentences required to start Deepi searchbar: %s','deepi'), $remaining);
          }
          }  
          
        
        ?>
    
    
    </p>
    </div>
    <?php
  
    
    if($to_submit_count>0){
        printf(__('You have %s unsubmitted posts. click on index button to submit them.','deepi'), $to_submit_count );
    }
    else {
        _e("All of your posts are submitted.",'deepi');
    }
    ?>
    <br />
    <br />
    <form method='post'>
        <input <?php echo (deepi_check()!==true or $to_submit_count==0)?"disabled":""; ?> type="submit" name="deepi_index_submit" id="submit" class="button button-primary" value="<?php _e('index', 'deepi'); ?>">
    </form>
    <br />
    <br />
    <h2><?php _e('Reset Posts status','deepi'); ?></h2>
    <?php _e('Click the reset button to resubmit all your posts.','deepi'); ?>
    <br /><br />
    <form method='post'>
        <input style="background: red; border-color: red;" type="submit" name="deepi_reset_submit" id="submit" class="button button-primary" value="<?php _e('reset', 'deepi'); ?>">
    </form>

<?php
echo "</div>";
}



