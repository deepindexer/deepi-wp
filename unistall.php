<?php
function deepi_unistall(){
    global $wpdb;
    $table_name = $wpdb->prefix . "deepi";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");

    $table_name = $wpdb->prefix . "posts";
    $sql = "ALTER TABLE $table_name DROP COLUMN `deepi_status`";
    $wpdb->query($sql);
}