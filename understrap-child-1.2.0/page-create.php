<?php
/**
 * The template for creating random pokemon single posts
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">
    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
        <div class="row">
          
        </div><!-- .row -->
    </div><!-- #content -->
</div><!-- #single-wrapper -->

<?php 
get_footer(); 
