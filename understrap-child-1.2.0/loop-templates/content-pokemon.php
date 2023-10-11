<?php
/**
 * Single Pokemon partial template
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->`

	</header><!-- .entry-header -->
    <?php echo get_stylesheet_directory_uri() . "/style.css"; ?>

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php
        // Get postmeta data
        $photo_url = get_the_post_thumbnail_url( $post->ID, 'large' );
        $pokemon_description = get_post_meta( $post->ID, 'pokemon_description', true );
        $primary_type = get_post_meta( $post->ID, 'primary_type', true );
        $secondary_type = get_post_meta( $post->ID, 'secondary_type', true );
        $pokemon_weight = get_post_meta( $post->ID, 'pokemon_weight', true );
        $pokedex_number_old = get_post_meta( $post->ID, 'pokedex_number_oldest', true );
        $pokedex_number_new = get_post_meta( $post->ID, 'pokedex_number_newest', true );
        $attacks = get_post_meta( $post->ID, 'pokemon_attacks', true );
        
        // Display the data
        ?>

        <div class="pokemon-description">
            <h2>Description</h2>
            <p><?php echo $pokemon_description; ?></p>
        </div>

        <div class="pokemon-type">
            <h2>Type</h2>
            <p><?php echo $primary_type; ?></p>
            <?php if ( $secondary_type ) { ?>
                <p><?php echo $secondary_type; ?></p>
            <?php } ?>
        </div>

        <div class="pokemon-weight">
            <h2>Weight</h2>
            <p><?php echo $pokemon_weight; ?></p>
        </div>

        <div class="pokemon-pokedex-number">
            <h2>Pokedex Number</h2>
            <p>Oldest Pokedex Number: <?php echo $pokedex_number_old; ?></p>
            <p>Newest Pokedex Number: <?php echo $pokedex_number_new; ?></p>
        </div>

        <div class="pokemon-attacks">
            <h2>Attacks</h2>
            <table>
                <tr>
                    <th>Attack Name</th>
                    <th>Attack description</th>
                </tr>

                <?php foreach ( $attacks as $attack ) { ?>
                    <tr>
                        <td><?php echo $attack["name"]; ?></td>
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
