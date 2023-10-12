/* wp_send_json_success( array(
    'newest_pokedex_number' => $oldest_pokedex_number,
    'newest_pokedex_number_game' => $oldest_pokedex_number_game,
)); */

function ajaxCallback(button) {
    // Ajax request using jquery
    jQuery.ajax({
        url: pokemon_ajax_object.ajax_url,
        dataType: 'html',
        type: 'POST',
        data: {
            action: 'pokemon_display_oldest_number',
            nonce: pokemon_ajax_object.nonce,
            post_id: button.getAttribute('data-id')
        },
        success: function(response) {
            response = JSON.parse(response);
            let pokedexNumber = response.data['newest_pokedex_number'];
            let pokedexNumberGame = response.data['newest_pokedex_number_game'];
            button.outerHTML = '<p>Oldest (' + pokedexNumberGame + ') Pokedex Number: ' + pokedexNumber + '</p>' + button.outerHTML;
            button.removeEventListener('click', () => {ajaxCallback(button)});
        },
        error: function(error) {
            console.log(error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

    let button = document.querySelector('#show-oldest');
    button.addEventListener('click', () => {ajaxCallback(button)});
});

