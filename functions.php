<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

    
////////////////////////////////////////////////////////////

/*** Load LESS ***/

function childtheme_scripts() {

wp_enqueue_style('less', get_stylesheet_directory_uri() .'/css/style.less');
add_filter('style_loader_tag', 'my_style_loader_tag_function');

wp_enqueue_script('less', get_stylesheet_directory_uri() .'/scripts/less.min.js', array('jquery'),'2.5.0');

}
add_action('wp_enqueue_scripts','childtheme_scripts', 150);

function my_style_loader_tag_function($tag){   
  return preg_replace("/='stylesheet' id='less-css'/", "='stylesheet/less' id='less-css'", $tag);
}

////////////////////////////////////////////////////////////

/*** Content Width ***/

if ( ! isset( $content_width ) )
    $content_width = 1000;

////////////////////////////////////////////////////////////

/* Remove Date from Yoast SEO */

add_filter( 'wpseo_show_date_in_snippet_preview', false);

////////////////////////////////////////////////////////////

add_shortcode( 'divider', 'shortcode_insert_divider' );
function shortcode_insert_divider( ) {
return '<div class="divider"></div>';
}

////////////////////////////////////////////////////////////

/* Remove Dates from SEO on Pages */

function wpd_remove_modified_date(){
    if( is_page() ){
        add_filter( 'the_time', '__return_false' );
        add_filter( 'the_modified_time', '__return_false' );
        add_filter( 'get_the_modified_time', '__return_false' );
        add_filter( 'the_date', '__return_false' );
        add_filter( 'the_modified_date', '__return_false' );
        add_filter( 'get_the_modified_date', '__return_false' );
    }
}
add_action( 'template_redirect', 'wpd_remove_modified_date' );

////////////////////////////////////////////////////////////

/* Defer Parsing of Java */

if (!(is_admin() )) {
  function defer_parsing_of_js ( $url ) {
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return "$url' defer ";
  }
  add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
}

////////////////////////////////////////////////////////////

/*function custom_quantity_field_archive() {
	$product = wc_get_product( get_the_ID() );
	if ( ! $product->is_sold_individually() && 'variable' != $product->product_type && $product->is_purchasable() ) {
		woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'custom_quantity_field_archive', 0, 9 );

function custom_add_to_cart_quantity_handler() {
	wc_enqueue_js( '
		jQuery( ".post-type-archive-product" ).on( "change input", ".quantity .qty", function() {
			var add_to_cart_button = jQuery( this ).parents( ".product" ).find( ".add_to_cart_button" );
			// For AJAX add-to-cart actions
			add_to_cart_button.attr( "data-quantity", jQuery( this ).val() );
			// For non-AJAX add-to-cart actions
			add_to_cart_button.attr( "href", "?add-to-cart=" + add_to_cart_button.attr( "data-product_id" ) + "&quantity=" + jQuery( this ).val() );
		});
	' );
}
add_action( 'init', 'custom_add_to_cart_quantity_handler' );

///////////////////////////////////////////////////

/* WooCommerce - Remove Checkout Fields 

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_first_name']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_city']);
    $fields['order']['order_comments']['placeholder'] = 'My new placeholder';
    $fields['order']['order_comments']['label'] = 'My new label';
    return $fields;
}*/

