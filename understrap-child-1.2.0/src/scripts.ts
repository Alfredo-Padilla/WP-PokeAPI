function test() {
    console.log('test');
}

// Functions for page filters
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


// Functions for pokemon meta box
function addAttackCallback() {
    console.log("ADD ATTACK");
    
    const attacks = document.querySelectorAll('tbody tr');
    if (!attacks) {
        return false;
    }
    const size = attacks.length;
    
    const newAttack = document.createElement('tr');
    const tbody = document.querySelector('#pokemon_attacks tbody');
    if (!tbody || !newAttack) {
        return false;
    }
    newAttack.setAttribute('id', 'attack-' + (size + 1));
    newAttack.innerHTML = '<td><input type="text" name="pokemon_attacks[' + size + '][name]" id="pokemon_attacks[' + size + '][name]" class="regular-text"></td><td><input type="text" name="pokemon_attacks[' + size + '][description]" id="pokemon_attacks[' + size + '][description]" class="regular-text"></td><td><a class="button remove-attack" href="#">Remove</a></td>';
    newAttack.querySelector('.remove-attack').addEventListener('click', () => {removeAttackCallback(newAttack)});
    tbody.appendChild(newAttack);
    return false;
}

function removeAttackCallback(attack: Element) {
    console.log("REMOVE ATTACK");

    const attacks = document.querySelector('#pokemon_attacks');
    if (!attacks) {
        return false;
    }
    
    const size = attacks.querySelectorAll('tbody tr').length || 0;
    if (size > 2) {
        attacks.querySelectorAll('tbody tr')[size - 1].remove();
    }
    return false;
}

function pokemonMetaBoxes() {
    const addAttack = document.querySelector('.add-attack');
    const removeAttack = document.querySelectorAll('.remove-attack');
    if (addAttack) {
        addAttack.addEventListener('click', () => {addAttackCallback()});
    }
    if (removeAttack) {
        for (let i = 0; i < removeAttack.length; i++) {            
            removeAttack[i].addEventListener('click', () => {removeAttackCallback(removeAttack[i])});
        }
    }

}

document.addEventListener('DOMContentLoaded', () => {
    test();

    // Check for url
    if (window.location.href.includes('/filter-types/')) {
        addListenersToFilters();
    }
    if (window.location.href.includes('&action=edit') || window.location.href.includes('post-new.php?')) {
        console.log('edit');
        pokemonMetaBoxes();
    }
});