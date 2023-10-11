// JS script to add/remove attack inputs from meta box
jQuery(document).ready(function($) {
    $('.add-attack').on('click', function() {
        console.log("ADD ATTACK");

        var size = $('#pokemon_attacks tbody tr').size();
        console.log(size);
        $('#attack-' + size).after('<tr id="attack-' + (size + 1) + '"><td><input type="text" name="pokemon_attacks[' + size + '][name]" id="pokemon_attacks[' + size + '][name]" class="regular-text"></td><td><input type="text" name="pokemon_attacks[' + size + '][description]" id="pokemon_attacks[' + size + '][description]" class="regular-text"></td><td><a class="button remove-attack" href="#">-</a></td></tr>');
        return false;
    });
    $('.remove-attack').live('click', function() {
        console.log("REMOVE ATTACK");

        var size = $('#pokemon_attacks tbody tr').size();
        if (size > 2) {
            $(this).parents('tr').remove();
        }
        return false;
    });
});

