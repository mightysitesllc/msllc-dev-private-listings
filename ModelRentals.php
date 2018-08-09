<?php
class ModelRentals{

	public function __construct(){

		add_action( 'init', array($this, 'create_rentals_post_type') );
		add_action("save_post", array($this, "savePostsRentals"));
		add_shortcode('rental-properties', array($this, 'rentalPropertiesHandler'));
		add_filter( 'manage_edit-rental_columns',  array($this, 'rental_columns' )) ;
		add_action( 'manage_rental_posts_custom_column', array($this, 'rental_columns_content'), 10, 2 );
		add_action('wp_enqueue_scripts', array($this, 'modified_enqueue_style'));
		add_filter( 'enter_title_here', array($this, 'wpos_change_title_palceholder') );
		add_action( 'admin_enqueue_scripts', array($this, 'wpos_admin_style') );
	}

	/** enqueue style of rental css
	 * modified by WPOS
	*/
	function modified_enqueue_style(){
		$slug = 'rental';
		wp_register_style( $slug . '_styles', plugins_url( 'css/rentals.css', __FILE__ ) );
	}
	/**
	 * Create Rentals Post type to manage rental's property information
	*/
	public function create_rentals_post_type() {
		register_post_type( 'rental', 
			array(
				'labels' => array(
					'name' => __( 'Rentals' ),
					'singular_name' => __( 'Rental' )
				),
				'rewrite' => true,
				'menu_icon' => 'dashicons-admin-home',
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'hierarchical' => true,
				'supports' => array('title')

			)
		);
	}
	public function rental_columns_content($column, $post_id) {
		global $post;
		switch( $column ) {
			case 'address':
				$address = get_field_object('address', $post_id);
				if ( isset($address['value']) ) {
					echo $address['value'];
				} else {
					echo "No Address. id#: $post_id";
				}
				break;
			case 'shortcode':
				echo '[rental-properties prop='.$post_id.']';
				break;
		default :
			break;
		}
	}

	public function rental_columns($columns) {
		$columns = array( 
			'cb'	 	=> '<input type="checkbox" />',
			'title' 	=> 'Title',
			'address' => __( 'Address' ),
			'shortcode' =>  __( 'Shortcode' ),
			'date' => __( 'Date' )
		);
		return $columns;
	}

	/**
	 * Save post metadata when a post is saved.
	 *
	 * @param int $post_id The ID of the post.
	*/
	public function savePostsRentals($post_id){		
		
		/*
	     * In production code, $slug should be set only once in the plugin,
	     * preferably as a class property, rather than in each function that needs it.
	     */
	    $slug = 'rental';

	    // If this isn't a 'rental' post, don't update it.
	    if ( isset($_POST['post_type']) && $slug != $_POST['post_type'] ) {
	        return;
	    }
	    if ( ! wp_is_post_revision( $post_id ) ){

	    	$post_title = get_field('rental_agent_name');
	    	$post_name = strtolower($post_title);
	    	$post_name = str_replace(" ", "-", $post_name);
	    	$args = array();
            $args['ID'] = $post_id;
            //$args['post_title' ] = $post_title;
            $args['post_name' ] = $post_name;
            // unhook this function so it doesn't loop infinitely
            remove_action("save_post", array($this, "savePostsRentals"));
            // update the post, which calls save_post again
            wp_update_post( $args );
            // re-hook this function
            add_action("save_post", array($this, "savePostsRentals"));
	    }	    
	}
	/**
	 * Display shortcode data for rental-properties	 
	*/
	public function rentalPropertiesHandler( $atts ){
		$atts = shortcode_atts( array(
			'prop' => ''
		), $atts );
		$template = RENTALS_URL . "templates/default.php";
		ob_start();    
    	include_once($template);
    $output = ob_get_clean();
    return $output;
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @package WPOS Change place holder in post title
	 * @since 1.0.0
	 */

	function wpos_change_title_palceholder( $title ){
	    
	    $screen = get_current_screen();
	 
	    if  ( 'rental' == $screen->post_type ) {
	        $title = 'Enter property street number, street name and any prefixes, suffixes or directions';
	    }
 
    	return $title;
	}

	/**
	 * Enqueue admin styles
	 * 
	 * @package WPOS enqueue admin styles
	 * @since 1.0.0
	 */
	function wpos_admin_style( $hook ) {

		global $typenow;
		
		// If page is plugin setting page then enqueue script
		if( $typenow == 'rental' ) {
			
			// Registring admin script
			wp_register_style( 'wpos-admin-style', plugins_url( 'css/wpos-admin.css', __FILE__ ) );
			wp_enqueue_style( 'wpos-admin-style' );
		}
	}
}
new ModelRentals();
?>