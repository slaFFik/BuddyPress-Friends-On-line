<?php
/*
Plugin Name: BuddyPress Friends On-line (FOL)
Plugin URI: http://wp-bp.com/products#friends_article
Description: Plugin will display on your Friends page a new tab called Online with a list of currently online friends. <a href="http://wp-bp.com">Powered by WP-BP.com</a>
Author: WP-BP
Version: 0.4.2
Author URI: http://wp-bp.com/
*/

add_action('bp_init', 'fol_menu');
function fol_menu(){
    global $bp;

    load_plugin_textdomain( 'fol', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );
    
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
        $type    = 'online';
        $user_id = bp_loggedin_user_id();
    }
    return BP_Core_User::get_users( $type, $per_page, $page, $user_id, $include, $search_terms, $populate_extras, $exclude, $meta_key, $meta_value );
}

if ( file_exists( dirname(__File__) . '/bpfol-custom-widget.php' ) )
	include (dirname(__File__) . "/bpfol-custom-widget.php");
?>