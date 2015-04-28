<?php 
function register_team_cpt() {
	$labels = array( 
		'name' 					=> 'Team Members',
		'singular_name'			=> 'Team Member',
		'add_new' 				=> 'Add New',
		'all_items' 			=> 'All Team Members',
		'add_new_item' 			=> 'Add New Team Member',
		'edit_item'				=> 'Edit Team Member',
		'new_item' 				=> 'New Team Member',
		'view_item' 			=> 'View Team Member',
		'search_items' 			=> 'Search Team Members',
		'not_found' 			=> 'No Team Members Found',
		'not_found_in_trash' 	=> 'No Team Members Found in Trash',
		'parent_item_colon' 	=> 'Parent Team Member Team Member:',
		'menu_name' 			=> 'Team Members',
	);
	$args = array( 
		'labels' 				=> $labels,
		'description' 			=> 'This for the Team Members section',
		'public' 				=> true,
		'exclude_from_search' 	=> false,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_nav_menus' 	=> true,
		'show_in_menu' 			=> true,
		'show_in_admin_bar' 	=> true,
		'menu_position' 		=> 25,
		/*
		  5 - below Posts
		 10 - below Media
		 15 - below Links
		 20 - below Pages
		 25 - below comments
		 60 - below first separator
		 65 - below Plugins
		 70 - below Users
		 75 - below Tools
		 80 - below Settings
		100 - below second separator
		*/
		'menu_icon' 			=> NULL, /*get_stylesheet_directory_uri().'/images/your-image.png', */
		'capability_type' 		=> 'post',
		'capabilities' 			=> array(	
										'edit_post', 
										'read_post', 
										'delete_post',
										'edit_posts',
										'edit_others_posts',
										'publish_posts',
										'read_private_posts'
									),
		'map_meta_cap' 			=> true,
		'hierarchical' 			=> false,
		'supports' 				=> array( 	
										'title',
										'editor',
										//'author',
										//'thumbnail',
										//'excerpt',
										//'trackbacks',
										//'custom-fields',
										//'comments' ,
										//'revisions',
										//'page-attributes',
										//'post-formats'
									),
		/* 
		'register_meta_box_cb' => 'add_custom_meta_box',
		 
		'taxonomies' 			=> array( 'category', 'tag'),*/
		'has_archive'			=> true,
		'permalink_epmask' 		=> EP_PERMALINK,
		'rewrite' 				=> array( 	
										'slug' 			=> 'team_member', 
										'with_front' 	=> false,
										'feeds' 		=> true,
										'pages' 		=> true,
										'ep_mask' 		=> EP_PERMALINK
									),
		'query_var' 			=> true,
		'can_export' 			=> true,
	);
	register_post_type( 'team_member', $args );
}
add_action( 'init', 'register_team_cpt' );


/* Profile Order Meta Box
===============================================================================*/
/*function team_member_profile_order_meta_box(){
	add_meta_box( 
		'team_member-info', 
		'Profile Order', 
		'team_member_ui_form', 
		'team_member', 
		'side', 
		'high'
	);
}
add_action( 'admin_init', 'team_member_profile_order_meta_box', 1 );

function team_member_ui_form( $post=false ){
	if( !$post )
		global $post;
	if ( !current_user_can( 'edit_posts', $post->ID ) ) {
		return false;
	}
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/team-member.form.php';
}

function team_member_change_title_text( $title ){
	global $post;
	if( 'team_member' != $post->post_type ) return $title;
	return 'Team Member Full Name';
}
add_filter( 'enter_title_here', 'team_member_change_title_text' );

function team_member_on_post_save( $post_id ) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
	$post = get_post( $post_id );
	if( 'team_member' != $post->post_type ) return $post_id;
	if ( !wp_verify_nonce(isset($_POST['wp_meta_box_nonce']), 'benefactor' ) ) {
		return $post_id;
	}
	if ( !current_user_can( 'edit_posts', $post->ID ) ) {
		return $post_id;
	}
	if( count( $_REQUEST ) > 0 ) {
  		$profile_order = $_REQUEST['profile_order'];
  		update_post_meta( $post_id, 'profile_order', $profile_order );
	}
}
add_action( 'save_post', 'team_member_on_post_save' );

function team_member_type_desc_heading(){
?>	
	<div class="custom-admin">
		<div class="postarea">
			<label for="content">Team Member Bio</label>
		</div>
	</div>
<?php	
}

function team_member_post_ui_cleanup(){
	remove_action( 'media_buttons', 'media_buttons' );
	remove_action('media_buttons', array('RGForms', 'add_form_button'), 20);
	add_action( 'media_buttons', 'team_member_type_desc_heading' );
}

function team_member_only_late_f(){
	add_action( 'admin_init', 		'team_member_post_ui_cleanup', 1999 );	
}

if( !empty($_REQUEST['post_type']) && 'team_member' == $_REQUEST['post_type'] ) {
	team_member_only_late_f();
} else {
	// editing a post
	if( !empty( $_REQUEST['post'] ) ){
		$the_post = get_post( $_REQUEST['post'] );
		if( 'team_member' == $the_post->post_type ){
			team_member_only_late_f();
		}
	}
}

function change_columns( $cols ) {
  $cols = array(
    'cb' => '<input type="checkbox">', 
    'profile_order' => 'Profile Order', 
    'title' => 'Title',
    'author' => 'Author',
    'date' => 'Date'
  );
  return $cols;
} 
add_filter( "manage_team_member_posts_columns", "change_columns" );

function custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case "profile_order":
      $p_order = (int)get_post_meta( $post_id, 'profile_order', true); 
      echo '<style>#profile_order{ width: 115px; }</style>';
      echo $p_order;
    break;
  }
}
add_action( "manage_posts_custom_column", "custom_columns", 10, 2 );

function sortable_columns() { 
  return array(
    'profile_order' => 'profile_order',
    'title'  => 'title', 
    'author' => 'author', 
    'date' => 'date'
  );
}
add_filter( "manage_edit-team_member_sortable_columns", "sortable_columns" );*/
?>