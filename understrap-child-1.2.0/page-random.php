<?php
/**
 * The template for displaying random pokemon posts
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Clear post data
wp_reset_postdata();

// Get random pokemon post
$args = array(
    'post_type' => 'pokemon',
    'orderby' => 'rand',
    'posts_per_page' => 1
);

// Redirect
$random_pokemon = new WP_Query( $args );
if ( $random_pokemon->have_posts() ) {
    while ( $random_pokemon->have_posts() ) {
        $random_pokemon->the_post();
        $post_id = get_the_ID();
        $post_url = get_permalink( $post_id );
        wp_redirect( $post_url );
        exit;
    }
} else {
    echo 'No pokemon found';
}

?>

