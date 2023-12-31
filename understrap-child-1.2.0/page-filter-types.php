<?php
/**
 * The template for displaying random pokemon posts
 *
 */

 $ALL = 'all';

// Get types from url
if ( isset($_GET['types']) ) {
    $types = [$_GET['types']];
} else {
    $url = get_site_url() . '/filter-types/?types=' . $ALL;
    wp_redirect($url);
}

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );

// Get data
$posts_per_page = 6;
$total_posts = wp_count_posts('pokemon')->publish;

if ( $types[0] ==  $ALL ) {
    $pokemon = get_posts(array(
        'post_type' => 'pokemon',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    ));
} else {
    $pokemon = get_posts(array(
        'post_type' => 'pokemon',
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date',
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        'tax_query' => array(
            array(
                'taxonomy' => 'pokemon_type',
                'field' => 'slug',
                'terms' => $types,
                'operator' => 'IN'
            )
        )
    ));
    $total_posts = count($pokemon);
}
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
                $class = "pokemon-type-filter me-2 ";
                $class .= in_array($pokemon_type->name, $types) || $types[0] ==  $ALL? "enabled":"";
                echo '<a href="#" class="' . $class . '" pokemon-type="' . $pokemon_type->slug . '">' . $pokemon_type->name . '</a>';
            }
            echo '</div>';
            ?>
        </div>

        <div class="row mt-3">
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

            <div class="col-md-12 mt-5  d-flex justify-content-center">
                <?php
                $total = $total_posts  / $posts_per_page;
                if ( $total > 1 ) {
                    echo paginate_links(array(
                        'total' => ceil($total),
                    ));
                }
                ?>
            </div>
        </div><!-- .row -->
    </div><!-- #content -->
</div><!-- #single-wrapper -->

<?php 
get_footer(); 
