function test() {
    console.log('test');
}

function addListenersToFilters() {
    const filters = document.querySelectorAll('.pokemon-type-filter[pokemon-type]');
    
    // URL params
    const urlParams = new URLSearchParams(window.location.search);
    let type:string = urlParams.get('types') || 'all';
    console.log(type);

    // Add listeners
    filters.forEach((filter) => {
        filter.addEventListener('click', () => {
            const type = filter.getAttribute('pokemon-type');
            const url = new URL(window.location.href);
            url.searchParams.set('types', type);
            window.location.href = url.toString();
        });
    });
    
}

function pokemonMetaBoxes() {
    /* jQuery(document).ready(function($) {
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
    }); */
    // Should work like the coment above, but in TypeScript
    const addAttack = document.querySelector('.add-attack');
    const removeAttack = document.querySelector('.remove-attack');
    const attacks = document.querySelector('#pokemon_attacks');
    if (addAttack) {
        addAttack.addEventListener('click', () => {
            console.log("ADD ATTACK");
    
            const attacks = document.querySelectorAll('tbody tr');
            if (attacks !== null) {
                return false;
            }
            const size = attacks.querySelectorAll('tbody tr').length;
            console.log(size);
            
            const newAttack = document.createElement('tr');
            newAttack.setAttribute('id', 'attack-' + (size + 1));
            newAttack.innerHTML = '<td><input type="text" name="pokemon_attacks[' + size + '][name]" id="pokemon_attacks[' + size + '][name]" class="regular-text"></td><td><input type="text" name="pokemon_attacks[' + size + '][description]" id="pokemon_attacks[' + size + '][description]" class="regular-text"></td><td><a class="button remove-attack" href="#">-</a></td>';
            const tbody = document.querySelector('#pokemon_attacks tbody');
            if (!tbody) {
                return false;
            }
            console.log(newAttack);
            
            tbody.appendChild(newAttack);
            return false;
        });
    }
    if (removeAttack) {
        removeAttack.addEventListener('click', () => {
            console.log("REMOVE ATTACK");
    
            const attacks = document.querySelector('#pokemon_attacks');
            if (!attacks) {
                return false;
            }
            
            const size = attacks.querySelectorAll('tbody tr').length || 0;
            if (size > 2) {
                attacks.querySelector('tbody tr:last-child').remove();
            }
            return false;
        });
    }

}

document.addEventListener('DOMContentLoaded', () => {
    test();
    addListenersToFilters();
});