<?php

$to_submit_count = count(deepi_all_to_index());
$submitted_count = count(deepi_all_status()['submitted']);

if(isset($_POST['deepi_settings_submit'])){    
    deepi_save_settings($_POST);  
}

if(isset($_POST['deepi_index_submit'])){
    deepi_index_submit();
}

if(isset($_POST['deepi_reset_submit'])){
    deepi_reset();
}

function deepi_settings_html() {
    global $to_submit_count, $submitted_count;
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    global $wpdb;
?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <br />
    <?php 
    deepi_is_active_msg();
    ?>
    <br />
    <form method='post'>
        <label for='secret_key' ><?php _e('Enter your secret key here.','deepi'); ?></label>
        <br />
        <input name='secret_key' type='text' class='' autocomplete='off' value='<?php echo deepi_fetch_key('secret_key'); ?>'  >
    

    <br />
    <br />
    
        <label for='slug' ><?php _e('Enter your project slug here.','deepi'); ?></label>
        <br />
        <input name='slug' type='text' class='' autocomplete='off' value='<?php echo deepi_fetch_key('slug'); ?>'  >
   

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
            echo $to_submit_count."<br />";
            _e('submitted posts: ','deepi');
            echo $submitted_count; 
            $status = deepi_is_active_2();
          if($status['response']['code']==200){
            $remaining = json_decode($status['body'], true)['concept_remaining_size'];
          //echo $remaining;
          if($remaining > 0 ){          
            printf(__('Concept remaining size: %s','deepi'), $remaining);
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
        <input <?php echo ($to_submit_count==0)?"disabled":""; ?> type="submit" name="deepi_index_submit" id="submit" class="button button-primary" value="<?php _e('index', 'deepi'); ?>">
    </form>
    <br />
    <br />
    <h2><?php _e('Reset Posts status','deepi'); ?></h2>
    <?php _e('Click reset button to change status of all your posts to `unsubmitted` so you may submit them again. ','deepi'); ?>
    <br /><br />
    <form method='post'>
        <input style="background: red; border-color: red;" type="submit" name="deepi_reset_submit" id="submit" class="button button-primary" value="<?php _e('reset', 'deepi'); ?>">
    </form>

<?php
echo "</div>";
}



