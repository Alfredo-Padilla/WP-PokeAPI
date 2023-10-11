<?php
/**
 * Single Pokemon partial template
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get postmeta data
$primary_type = get_post_meta( $post->ID, 'primary_type', true );
$secondary_type = get_post_meta( $post->ID, 'secondary_type', true );
$photo_url = get_the_post_thumbnail_url( $post->ID, 'large' );
$pokemon_description = get_post_meta( $post->ID, 'pokemon_description', true );
$pokemon_weight = get_post_meta( $post->ID, 'pokemon_weight', true );
$pokedex_number_old = get_post_meta( $post->ID, 'pokedex_number_oldest', true );
$pokedex_number_new = get_post_meta( $post->ID, 'pokedex_number_newest', true );
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
                <div class="pokemon-type">
                    <a pokemon-type="<?php echo $primary_type; ?>" ><?php echo $primary_type; ?></a>
                    <?php if ( $secondary_type ) { ?>
                        <a pokemon-type="<?php echo $secondary_type; ?>"><?php echo $secondary_type; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
	</header><!-- .entry-header -->

	<div class="entry-content mt-5">
        <div class="pokemon-description">
            <h2>Pokemon Description</h2>
            <p><?php the_content(); ?></p>
        </div>

        <div class="pokemon-data">
            <h2>Pokemon Data</h2>
            <p>
                Weight: <?php echo $pokemon_weight; ?>kg<br />
                Oldest Pokedex Number: <?php echo $pokedex_number_old; ?><br />
                Newest Pokedex Number: <?php echo $pokedex_number_new; ?>
            </p>
        </div>

        <div class="pokemon-attacks">
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
