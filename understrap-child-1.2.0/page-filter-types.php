<?php
/**
 * The template for displaying random pokemon posts
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

// This page shows every pokemon with pagination every 6 posts
// Get data
$posts_per_page = 6;
$total_posts = wp_count_posts('pokemon')->publish;
$pokemon = get_posts(array(
    'post_type' => 'pokemon',
    'posts_per_page' => $posts_per_page,
    'orderby' => 'date',
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
));
?>


<div class="wrapper" id="type-filter-wrapper">
    <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
        <div class="row">
            <?php
            // Get all pokemon types
            $pokemon_types = get_terms(array(
                'taxonomy' => 'pokemon_type',
                'hide_empty' => false
            ));

            echo '<div class="d-flex">';
            // Display pokemon types
            foreach ($pokemon_types as $pokemon_type) {
                echo '<a href="#" class="pokemon-type-filter me-2" pokemon-type="' . $pokemon_type->slug . '">' . $pokemon_type->name . '</a>';
            }
            echo '</div>';
            ?>
        </div>

        <div class="row mt-3">
            <!-- Display data -->
            <?php foreach ($pokemon as $post) : setup_postdata($post); ?>
                <div class="col-md-4">
                    <div class="card mb-2">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h2><?php the_title(); ?></h2>
                            <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
                        </div>

                        <div class="card-body">
                            <?php the_content(); ?>
                        </div>

                        <div class="card-footer p-0">
                            <a href="<?php the_permalink(); ?>" pokemon-type="<?php echo get_the_terms($post->ID, "pokemon_type")[0]->name; ?>" class="btn btn-primary w-100 fw-bold text-uppercase">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Display pagination -->
            <div class="col-md-12 mt-5  d-flex justify-content-center">
                <?php
                echo paginate_links(array(
                    'total' => ceil($total_posts / $posts_per_page),
                ));
                ?>
            </div>



        </div><!-- .row -->
    </div><!-- #content -->
</div><!-- #single-wrapper -->

<?php 
get_footer(); 
