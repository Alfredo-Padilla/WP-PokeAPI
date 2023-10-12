<?php
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );




##############################
# FUNCTIONS FOR POKEMON SITE #
##############################
/**
 * Enqueue build script
 */
function pokemon_enqueue_scripts() {
	$args = include( get_stylesheet_directory() . '/public/scripts.asset.php' );
	wp_enqueue_script( 'pokemon', get_stylesheet_directory_uri() . '/public/scripts.js', $args['dependencies'], $args['version'], true );
}
add_action( 'wp_enqueue_scripts', 'pokemon_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'pokemon_enqueue_scripts' );



/**
 * Pokemon type taxonomy
 */
function pokemon_type_taxonomy() {
	$labels = array(
		'name' => __( 'Pokemon Types', 'understrap-child' ),
		'singular_name' => __( 'Pokemon Type', 'understrap-child' ),
		'search_items' => __( 'Search Pokemon Types', 'understrap-child' ),
		'all_items' => __( 'All Pokemon Types', 'understrap-child' ),
		'parent_item' => __( 'Parent Pokemon Type', 'understrap-child' ),
		'parent_item_colon' => __( 'Parent Pokemon Type:', 'understrap-child' ),
		'edit_item' => __( 'Edit Pokemon Type', 'understrap-child' ),
		'update_item' => __( 'Update Pokemon Type', 'understrap-child' ),
		'add_new_item' => __( 'Add New Pokemon Type', 'understrap-child' ),
		'new_item_name' => __( 'New Pokemon Type Name', 'understrap-child' ),
		'menu_name' => __( 'Pokemon Types', 'understrap-child' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'pokemon_type' ),
	);

	register_taxonomy( 'pokemon_type', array( 'pokemon' ), $args );
}
add_action( 'init', 'pokemon_type_taxonomy' );

/**
 * Custom Pokemon post type
 */
function pokemon_post_type() {
	$labels = array(
		'name' => __( 'Pokemon', 'understrap-child' ),
		'singular_name' => __( 'Pokemon', 'understrap-child' ),
		'add_new' => __( 'Add New', 'understrap-child' ),
		'add_new_item' => __( 'Add New Pokemon', 'understrap-child' ),
		'edit_item' => __( 'Edit Pokemon', 'understrap-child' ),
		'new_item' => __( 'New Pokemon', 'understrap-child' ),
		'view_item' => __( 'View Pokemon', 'understrap-child' ),
		'search_items' => __( 'Search Pokemon', 'understrap-child' ),
		'not_found' => __( 'No Pokemon found', 'understrap-child' ),
		'not_found_in_trash' => __( 'No Pokemon found in Trash', 'understrap-child' ),
		'parent_item_colon' => __( 'Parent Pokemon:', 'understrap-child' ),
		'menu_name' => __( 'Pokemon', 'understrap-child' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => __( 'Pokemon', 'understrap-child' ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies' => array( 'pokemon_type' ),
		'public' => true,
		'show_ui' => true,
		'show_in_rest' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-admin-site',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'rewrite' => array( 'slug' => 'pokemon', 'with_front' => false ),
		'has_archive' => 'pokemon',
		'query_var' => true,
		'can_export' => true,
		'delete_with_user' => false,
	);

	register_post_type( 'pokemon', $args );
}
add_action( 'init', 'pokemon_post_type' );

/**
 * Add fields in editor to Custom Pokemon post type
 */
function pokemon_add_custom_meta_boxes() {
	add_meta_box(
		'pokemon_meta_box', // $id
		'Pokemon Data', // $title
		'pokemon_show_custom_meta_box', // $callback
		'pokemon', // $screen
		'normal', // $context
		'high' // $priority
	);
}
add_action( 'add_meta_boxes', 'pokemon_add_custom_meta_boxes' );




/**
 * Show fields in editor for Custom Pokemon post type
 */
function pokemon_show_custom_meta_box() {
	// Weight
	pokemon_weight_meta_box();

	// Pokedex IDs
	pokemon_pokedex_ids_meta_box();
	
	// Attacks
	pokemon_attacks_meta_box();

	// API ID
	pokemon_api_id_meta_box();

	// Save button
	?>
	<input type="hidden" name="pokemon_meta_box_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>">
	<?php
}

/**
 * Weight meta box
 */
function pokemon_weight_meta_box() {
	global $post;
	$weight = get_post_meta( $post->ID, 'pokemon_weight', true );

	wp_nonce_field( basename( __FILE__ ), 'pokemon_weight_nonce' );

	?>
	<table id="pokemon_weight" class="table">
		<thead>
			<tr>
				<th>Weight</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>(Use hectograms)</td>
			</tr>
			<tr>
				<td><input type="text" name="pokemon_weight" id="pokemon_weight" class="regular-text" value="<?php echo $weight; ?>"></td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * Pokedex IDs meta box
 */
function pokemon_pokedex_ids_meta_box() {
	global $post;
	$oldest_pokedex_id = get_post_meta( $post->ID, 'pokedex_number_oldest', true );
	$newest_pokedex_id = get_post_meta( $post->ID, 'pokedex_number_newest', true );

	wp_nonce_field( basename( __FILE__ ), 'pokemon_types_nonce' );

	?>
	<table id="pokedex_ids" class="table">
		<thead>
			<tr>
				<th>Oldest Pokedex ID</th>
				<th>Newest Pokedex ID</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>(Use Pokedex number)</td>
				<td>(Use Pokedex number)</td>
			</tr>
			<tr>
				<td><input type="text" name="pokemon_pokedex_ids[oldest_pokedex_id]" id="pokemon_pokedex_ids[oldest_pokedex_id]" class="regular-text" value="<?php echo $oldest_pokedex_id; ?>"></td>
				<td><input type="text" name="pokemon_pokedex_ids[newest_pokedex_id]" id="pokemon_pokedex_ids[newest_pokedex_id]" class="regular-text" value="<?php echo $newest_pokedex_id; ?>"></td>
			</tr>
			<tr>
				<td>Game</td>
				<td>Game</td>
			</tr>
			<tr>
				<td><input type="text" name="pokemon_pokedex_ids[oldest_pokedex_id_game]" id="pokemon_pokedex_ids[oldest_pokedex_id_game]" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'pokedex_number_oldest_game', true ); ?>"></td>
				<td><input type="text" name="pokemon_pokedex_ids[newest_pokedex_id_game]" id="pokemon_pokedex_ids[newest_pokedex_id_game]" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'pokedex_number_newest_game', true ); ?>"></td>
			</tr>
		</tbody>
	</table>
	<?php
}
/**
 * Attacks meta box
 */

function pokemon_attacks_meta_box() {
	global $post;
	$meta = get_post_meta( $post->ID, 'pokemon_attacks', true );
	$attacks = $meta ? $meta : array();

	wp_nonce_field( basename( __FILE__ ), 'pokemon_attacks_nonce' );
	?>

	<table id="pokemon_attacks" class="table">
		<thead>
			<tr>
				<th>Attack Name</th>
				<th>Attack Description</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $attacks as $index => $attack ) { ?>
				<tr>
					<td><input type="text" name="pokemon_attacks[<?php echo $index; ?>][name]" id="pokemon_attacks[<?php echo $index; ?>][name]" class="regular-text" value="<?php echo $attack['name']; ?>"></td>
					<td><input type="text" name="pokemon_attacks[<?php echo $index; ?>][description]" id="pokemon_attacks[<?php echo $index; ?>][description]" class="regular-text" value="<?php echo $attack['description']; ?>"></td>
					<td><button type="button" class="button button-secondary remove-attack">Remove</button></td>
				</tr>
			<?php } ?>
			<tr>
				<td><input type="text" name="pokemon_attacks[<?php echo count($attacks); ?>][name]" id="pokemon_attacks[<?php echo count($attacks); ?>][name]" class="regular-text" value=""></td>
				<td><input type="text" name="pokemon_attacks[<?php echo count($attacks); ?>][description]" id="pokemon_attacks[<?php echo count($attacks); ?>][description]" class="regular-text" value=""></td>
				<td><button type="button" class="button button-secondary remove-attack">Remove</button></td>
			</tr>
		</tbody>
	</table>
	<button type="button" class="button button-secondary add-attack">Add Attack</button>

	
	<?php
}

/**
 * API ID meta box
 */
function pokemon_api_id_meta_box() {
	global $post;
	$api_id = get_post_meta( $post->ID, 'pokemon_api_id', true );

	wp_nonce_field( basename( __FILE__ ), 'pokemon_api_id_nonce' );

	?>
	<table id="pokemon_api_id" class="table">
		<thead>
			<tr>
				<th>API ID</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="pokemon_api_id" id="pokemon_api_id" class="regular-text" value="<?php echo $api_id; ?>"></td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * Save the custom fields
 */
function pokemon_save_custom_meta_box( $post_id ) {
	if ( isset( $_POST['pokemon_types_nonce'] ) ) {
		$types_nonce = $_POST['pokemon_types_nonce'];
	}

	if ( ! isset( $types_nonce ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $types_nonce, basename( __FILE__ ) ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$weight = $_POST['pokemon_weight'];
	update_post_meta( $post_id, 'pokemon_weight', $weight );

	$pokedex_ids = $_POST['pokemon_pokedex_ids'];
	update_post_meta( $post_id, 'pokedex_number_oldest', $pokedex_ids['oldest_pokedex_id'] );
	update_post_meta( $post_id, 'pokedex_number_newest', $pokedex_ids['newest_pokedex_id'] );
	update_post_meta( $post_id, 'pokedex_number_oldest_game', $pokedex_ids['oldest_pokedex_id_game'] );
	update_post_meta( $post_id, 'pokedex_number_newest_game', $pokedex_ids['newest_pokedex_id_game'] );

	// Attacks
	$attacks = $_POST['pokemon_attacks'];
	update_post_meta( $post_id, 'pokemon_attacks', $attacks );


	$api_id = $_POST['pokemon_api_id'];
	update_post_meta( $post_id, 'pokemon_api_id', $api_id );
}
add_action( 'save_post', 'pokemon_save_custom_meta_box' );



/**
 * Download Pokemon data frokm PokeAPI
 */
function download_random_pokemon_data() {
	// Get the Pokemon data from the API
	$api_url = 'https://pokeapi.co/api/v2/pokemon/';
	$api_response = wp_remote_get( $api_url );
	$api_body = wp_remote_retrieve_body( $api_response );
	$api_data = json_decode( $api_body );
	
	// Get the pokemon meta ID of every saved pokemon
	$args = array(
		'post_type' => 'pokemon',
		'posts_per_page' => -1,
	);
	$pokemon = new WP_Query( $args );

	$pokemon_meta_ids = array();
	while ( $pokemon->have_posts() ) {
		$pokemon->the_post();
		$pokemon_meta_ids[] = get_post_meta( get_the_ID(), 'pokemon_api_id', true );
	}

	// Generate a random ID not currently in the database
	$random_pokemon_id = rand( 1, $api_data->count );
	while ( in_array( $random_pokemon_id, $pokemon_meta_ids ) ) {
		$random_pokemon_id = rand( 1, $api_data->count );
	}

	// Get pokemon data
	$api_url = 'https://pokeapi.co/api/v2/pokemon/' . $random_pokemon_id;
	$api_response = wp_remote_get( $api_url );
	$api_body = wp_remote_retrieve_body( $api_response );
	$api_data = json_decode( $api_body );

	// Save to post meta and return post URL
	return get_permalink( save_pokemon_data( $api_data ) );
}



/**
 * Function to save each individual pokemon data
 */
function save_pokemon_data( $api_data ) {
	// Create a new post for each Pokemon
	$post_id = wp_insert_post(
		array(
			'post_title' => ucwords($api_data->name),
			'post_type' => 'pokemon',
			'post_status' => 'publish',
		)
	);

	// Save the Pokemon data to the post meta
	// Photo of the pokemon
	$photo_url = $api_data->sprites->front_default;
	$photo_id = media_sideload_image( $photo_url, $post_id, $api_data->name, 'id' );
	set_post_thumbnail( $post_id, $photo_id );

	// Pokemon description
	$description_url = $api_data->species->url;
	$description_response = wp_remote_get( $description_url );
	$description_body = wp_remote_retrieve_body( $description_response );
	$description_data = json_decode( $description_body );

	// Find description with language en
	foreach ( $description_data->flavor_text_entries as $description ) {
		if ( $description->language->name == 'en' ) {
			$pokemon_description = $description->flavor_text;
			break;
		}
	}
	$my_post = array(
		'ID' => $post_id,
		'post_content' => $pokemon_description,
	);
	wp_update_post( $my_post );

	// Primary and secondary type of pokemon as taxonomy
	$primary_type = $api_data->types[0]->type->name;
	wp_set_object_terms( $post_id, $primary_type, 'pokemon_type', true );

	if ( isset( $api_data->types[1] ) ) {
		$secondary_type = $api_data->types[1]->type->name;
	}
	wp_set_object_terms( $post_id, $secondary_type, 'pokemon_type', true );

	// Pokemon weight is saved in hectograms: https://github.com/PokeAPI/pokeapi.co/pull/20
	// We convert to kilograms
	$pokemon_weight = $api_data->weight / 10;
	update_post_meta( $post_id, 'pokemon_weight', $pokemon_weight );


	// Pokedex number in older and newest version of the game
	if ( count($api_data->game_indices) > 0 ) {
		$pokedex_number_old = $api_data->game_indices[0]->game_index;
		$pokedex_number_old_game = $api_data->game_indices[0]->version->name;
		update_post_meta( $post_id, 'pokedex_number_oldest', $pokedex_number_old );
		update_post_meta( $post_id, 'pokedex_number_oldest_game', $pokedex_number_old_game );
	
		$last = count($api_data->game_indices) - 1;
		$pokedex_number_new = $api_data->game_indices[$last]->game_index;
		$pokedex_number_new_game = $api_data->game_indices[$last]->version->name;
		update_post_meta( $post_id, 'pokedex_number_newest', $pokedex_number_new );
		update_post_meta( $post_id, 'pokedex_number_newest_game', $pokedex_number_new_game );
	} else {
		update_post_meta( $post_id, 'pokedex_number_oldest', $api_data->id);
		update_post_meta( $post_id, 'pokedex_number_oldest_game', 'Unknown');
		update_post_meta( $post_id, 'pokedex_number_newest', $api_data->id);
		update_post_meta( $post_id, 'pokedex_number_newest_game', 'Unknown');
	}

	// The attacks of said pokémon with its short description
	$attacks = $api_data->moves;
	$attacks_final = array();
	foreach ( $attacks as $attack ) {
		$attack_url = $attack->move->url;
		$attack_response = wp_remote_get( $attack_url );
		$attack_body = wp_remote_retrieve_body( $attack_response );
		$attack_data = json_decode( $attack_body );

		$attack_name = $attack_data->name;
		// Finde description with language en
		foreach ( $attack_data->effect_entries as $description ) {
			if ( $description->language->name == 'en' ) {
				$attack_description = $description->short_effect;
				break;
			}
		}

		$attacks_final[] = array(
			'name' => $attack_name,
			'description' => $attack_description,
		);
	}
	update_post_meta( $post_id, 'pokemon_attacks', $attacks_final );


	// API ID
	update_post_meta( $post_id, 'pokemon_api_id', $api_data->id );

	return $post_id;
}



/**
 * Function to create a new API endpint that returns the pokemon list
 */
function pokemon_api_endpoints() {
	register_rest_route( 'pokemon/v1', '/list', array(
		'methods' => 'GET',
		'callback' => 'pokemon_api_list',
	) );
}
add_action( 'rest_api_init', 'pokemon_api_endpoints' );

/**
 * Function to return list of pokemon
 */
function pokemon_api_list() {
	$args = array(
		'post_type' => 'pokemon',
		'posts_per_page' => -1,
	);
	$pokemon = new WP_Query( $args );
	
	$pokemon_list = array();
	while ( $pokemon->have_posts() ) {
		$pokemon->the_post();
		$pokemon_list[] = array(
			'name' => get_the_title(),
			'api id' => get_post_meta( get_the_ID(), 'pokemon_api_id', true ),
		);
	}

	$response = new WP_REST_Response( $pokemon_list );
	$response->set_status( 200 );

	return $response;
}

/**
 * Function to create a new API endpint that returns the full JSON of a pokemon
 */
function pokemon_api_endpoints_full() {
	register_rest_route( 'pokemon/v1', '/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'pokemon_api_full',
	) );
}
add_action( 'rest_api_init', 'pokemon_api_endpoints_full' );

/**
 * Function to return full JSON of a pokemon
 */
function pokemon_api_full( $data ) {
	$args = array(
		'post_type' => 'pokemon',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'pokedex_number_newest',
				'value' => $data['id'],
				'compare' => '=',
			),
		),
	);
	$pokemon = new WP_Query( $args );

	$pokemon_list = array();
	while ( $pokemon->have_posts() ) {
		$pokemon->the_post();
		$pokemon_list[] = array(
			'name' => get_the_title(),
			'description' => get_the_content(),
			'newest pokedex id' => get_post_meta( get_the_ID(), 'pokedex_number_newest', true ),
			'oldest pokedex id' => get_post_meta( get_the_ID(), 'pokedex_number_oldest', true ),
			'oldest pokedex id game' => get_post_meta( get_the_ID(), 'pokedex_number_oldest_game', true ),
			'newest pokedex id game' => get_post_meta( get_the_ID(), 'pokedex_number_newest_game', true ),
			'primary type' => get_the_terms( get_the_ID(), 'pokemon_type' )[0]->name,
			'secondary type' => get_the_terms( get_the_ID(), 'pokemon_type' )[1]->name,
			'weight' => get_post_meta( get_the_ID(), 'pokemon_weight', true ),
			'attacks' => get_post_meta( get_the_ID(), 'pokemon_attacks', true ),
			'api id' => get_post_meta( get_the_ID(), 'pokemon_api_id', true ),

		);
	}

	return $pokemon_list;
}



/**
 * Funtion to handle AJAX displaying the oldest pokedex number
*/
function pokemon_display_oldest_number() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'pokemon-switch-pokedex-number' ) ) {
		wp_send_json_error( 'Invalid nonce' );
	}

	$post_id = $_POST['post_id'];
	$oldest_pokedex_number = get_post_meta( $post_id, 'pokedex_number_oldest', true );
	$oldest_pokedex_number_game = get_post_meta( $post_id, 'pokedex_number_oldest_game', true );

	// Return the new pokedex numbers
	wp_send_json_success( array(
		'post_id' => $post_id,
		'newest_pokedex_number' => $oldest_pokedex_number,
		'newest_pokedex_number_game' => $oldest_pokedex_number_game,
	));
}
add_action( 'wp_ajax_pokemon_display_oldest_number', 'pokemon_display_oldest_number' );
add_action( 'wp_ajax_nopriv_pokemon_display_oldest_number', 'pokemon_display_oldest_number' );

/**
 * Funtion to enqueue AJAX js
*/
function pokemon_ajax_scripts() {
	wp_enqueue_script( 'pokemon-ajax', get_stylesheet_directory_uri() . '/js/ajax.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'pokemon-ajax', 'pokemon_ajax_object', array( 
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'pokemon-switch-pokedex-number' ),
	));
}
add_action( 'wp_enqueue_scripts', 'pokemon_ajax_scripts' );


flush_rewrite_rules( false );