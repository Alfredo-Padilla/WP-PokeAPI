<?php
/**
 * The template for creating random pokemon single posts
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( current_user_can( 'publish_posts' ) ) {
    $new_url = download_random_pokemon_data();
    wp_redirect($new_url);
} else {
    get_header();
    $container = get_theme_mod( 'understrap_container_type' );
    ?>
    <div class="wrapper" id="create-wrapper">
        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
            <div class="row">
                <h1>You don't have enough user permissions...</h1>
                <p>
                    You need to be logged in as an administrator to create a new pokemon.
                </p>
            </div><!-- .row -->
        </div><!-- #content -->
    </div><!-- #single-wrapper -->
    <?php
    get_footer(); 
}
