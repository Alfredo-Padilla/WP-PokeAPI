<?php
/**
 * Single Pokemon partial template
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get primary and secondary types from post taxonomy
$types = get_the_terms( $post->ID, 'pokemon_type' );
if ( isset($types[0]) ) {
    $primary_type = $types[0]->name;
}
if ( isset($types[1]) ) {
    $secondary_type = $types[1]->name;
}

// Get postmeta data
$photo_url = get_the_post_thumbnail_url( $post->ID, 'large' );
$pokemon_description = get_post_meta( $post->ID, 'pokemon_description', true );
$pokemon_weight = get_post_meta( $post->ID, 'pokemon_weight', true );

$pokedex_number_old = get_post_meta( $post->ID, 'pokedex_number_oldest', true );
$pokedex_number_old_game = get_post_meta( $post->ID, 'pokedex_number_oldest_game', true );

if ( $pokedex_number_old == null ) {
    $pokedex_number_old = get_post_meta( $post->ID, 'pokemon_api_id', true );
    $pokedex_number_old_game = "Unknown Game";
}

$pokedex_number_new = get_post_meta( $post->ID, 'pokedex_number_newest', true );
$pokedex_number_new_game = get_post_meta( $post->ID, 'pokedex_number_newest_game', true );

$attacks = get_post_meta( $post->ID, 'pokemon_attacks', true );              
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="entry-header" pokemon-type="<?php echo $primary_type; ?>">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="row">
            <div class="col-12 col-md-2  d-flex justify-content-center">
                <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
            </div>

            <div class="col-12 col-md  d-flex align-items-center">
                <div class="pokemon-type d-flex">
                    <a pokemon-type="<?php echo $primary_type; ?>" class="pokemon-type-filter me-2"><?php echo $primary_type; ?></a>
                    <?php if (isset ($secondary_type) ) { ?>
                        <a pokemon-type="<?php echo $secondary_type; ?>" class="pokemon-type-filter"><?php echo $secondary_type; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content">
        <?php 
        $content = get_the_content();
        if ( $content != null ) : ?>
            <div class="pokemon-description mt-5">
                <h2>Pokemon Description</h2>
                <p><?php echo $content; ?></p>
            </div>
        <?php endif; ?>

        <div class="pokemon-data mt-5">
            <h2>Pokemon Data</h2>
            <p>
                Weight: <?php echo $pokemon_weight; ?>kg<br />
                Newest (<?php echo $pokedex_number_old_game; ?>) Pokedex Number: <?php echo $pokedex_number_old; ?><br />
                Oldest (<?php echo $pokedex_number_new_game; ?>) Pokedex Number: <?php echo $pokedex_number_new; ?>
            </p>
        </div>

        <div class="pokemon-attacks mt-5">
            <table class="attacks-table">
                <tr>
                    <th>Attack Name</th>
                    <th>Attack description</th>
                </tr>

                <?php foreach ( $attacks as $attack ) { ?>
                    <tr>
                        <td><?php echo ucwords($attack["name"]); ?></td>
                        <td><?php echo $attack["description"]; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
