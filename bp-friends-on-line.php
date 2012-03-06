<?php
/*
Plugin Name: BuddyPress Friends On-line (FOL)
Plugin URI: http://cosydale.com/my-plugin-buddypress-friends-on-line.html
Description: Plugin will display on your Friends page a new tab called Online with a list of currently online friends.
Author: slaFFik
Version: 0.2.1
Author URI: http://ovirium.com/
*/

/**
 * Adding language support.
 */
if ( file_exists( dirname(__File__) . '/friends-on-line-' . get_locale() . '.mo' ) )
	load_textdomain( 'friends-on-line', dirname(__File__) . '/friends-on-line-' . get_locale() . '.mo' );

add_action('bp_init', 'fol_menu');
function fol_menu(){
    global $bp;

    $friends_link = trailingslashit( $bp->loggedin_user->domain . bp_get_friends_slug() );

    $sub_nav = array(
        'name'            => __( 'Online', 'fol' ),
        'slug'            => 'online',
        'parent_url'      => $friends_link,
        'parent_slug'     => bp_get_friends_slug(),
        'screen_function' => 'friends_screen_my_friends',
        'position'        => 15,
        'item_css_id'     => 'friends-online',
        'user_has_access' => bp_is_my_profile()
    );
    bp_core_new_subnav_item($sub_nav);
}

// get the online friends list 
add_filter('bp_core_get_users', 'fol_get_online', 10, 2);
function fol_get_online($data, $params){
    extract( $params, EXTR_SKIP );
    if(bp_is_user_friends() && bp_is_current_action( 'online') ){
        $type = 'online';
        $user_id = bp_loggedin_user_id();
    }
    return BP_Core_User::get_users( $type, $per_page, $page, $user_id, $include, $search_terms, $populate_extras, $exclude, $meta_key, $meta_value );
}
 

?>