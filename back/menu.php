<?php
//guide
//add_menu_page( 
//	string $page_title, 
//	string $menu_title, 
//	string $capability, 
//	string $menu_slug, 
//	callable $function = '', 
//	string $icon_url = '', 
//	int $position = null 
//)

//add_submenu_page( 
//	string $parent_slug,
//	string $page_title,
//	string $menu_title,
//	string $capability,
//	string $menu_slug,
//	callable $function = '',
//	int $position = null 
//)


function deepi_options_page()
{
    // add top level menu page
   	add_menu_page(
        __( 'Deepi', 'deepi' ),
        __( 'Deepi', 'deepi' ),
        'manage_options',
        'Deepi',
        'deepi_main_html',
        'dashicons-search'
    );

   	add_submenu_page( 
   	 	'Deepi', 
   	 	__( 'Settings', 'deepi' ), 
   	 	__( 'Settings', 'deepi' ), 
   	 	'manage_options', 
   	 	'deepi_settings', 
   	 	'deepi_settings_html'
   	 );
	
	//add_submenu_page( 
   	//	'Deepi', 
   	//	__( 'Index status', 'deepi' ), 
   	//	__( 'Index status', 'deepi' ), 
   	//	'manage_options', 
   	//	'deepi_index', 
   	//	'deepi_index_html'
   	// );
	
}
add_action('admin_menu', 'deepi_options_page');