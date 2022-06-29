<?php



function deepi_index_html() {
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
<?php
echo "</div>";
}


