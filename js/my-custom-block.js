jQuery(document).ready(function($) {
    // Pamiętaj, aby opakować kod w funkcję anonimową,
    // aby uniknąć konfliktów z innymi bibliotekami.
    
    $('.case-studies-block').each(function() {
        const $block = $(this);
        const $filters = $block.find('.case-studies-block__filter-btn');
        const $items = $block.find('.case-studies-block__item');

        $filters.on('click', function() {
            // Usuń klasę 'is-active' ze wszystkich przycisków
            $filters.removeClass('is-active');
            
            // Dodaj klasę 'is-active' do klikniętego przycisku
            $(this).addClass('is-active');

            const filterValue = $(this).data('filter');

            // Pokaż/ukryj elementy
            if (filterValue === 'all') {
                $items.show();
            } else {
                $items.hide();
                $items.filter(`.is-${filterValue}`).show();
            }
        });
    });
});