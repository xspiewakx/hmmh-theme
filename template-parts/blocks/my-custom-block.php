<?php
/**
 * Case Studies Block Template.
 */

$case_studies = get_field('case_studies');

$all_categories = [];
if( $case_studies ) {
    foreach( $case_studies as $case_study ) {
        if( isset($case_study['kategoria_case_study']) && is_array($case_study['kategoria_case_study']) ) {
            $all_categories = array_merge($all_categories, $case_study['kategoria_case_study']);
        }
    }
    $unique_categories = array_unique($all_categories);
}

if( $case_studies ): ?>

   <div class="case-studies-block">

           <?php if( !empty($unique_categories) ): ?>
            <div class="case-studies-block__filters">
                <button class="case-studies-block__filter-btn is-active" data-filter="all">Wszystkie</button>
                <?php foreach( $unique_categories as $category ): ?>
                    <button class="case-studies-block__filter-btn" data-filter="<?php echo esc_attr(strtolower(str_replace(' ', '-', $category))); ?>">
                        <?php echo esc_html($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="case-studies-block__container">
            <?php foreach( $case_studies as $case_study ): 
                $featured_image = $case_study['zdjecie_wyrozniajace'];
                $categories     = $case_study['kategoria_case_study'];
                $title          = $case_study['tytul_case_study'];
                $link           = $case_study['link_do_case_study'];
                $txt_link           = $case_study['tekst_link_do_case_study'];

               
                $category_classes = [];
                if( $categories ) {
                    foreach( $categories as $category ) {
                        $category_classes[] = 'is-' . strtolower(str_replace(' ', '-', $category));
                    }
                }
            ?>
                <div class="case-studies-block__item  <?php echo implode(' ', $category_classes); ?>">
                    <?php if( $link ): ?>
                        <a href="<?php echo esc_url($link); ?>" class="case-studies-block__link">
                    <?php endif; ?>

                    <?php if( $featured_image ): ?>
                        <div class="case-studies-block__image-wrapper">
                            <img class="case-studies-block__image" src="<?php echo esc_url($featured_image['url']); ?>" alt="<?php echo esc_attr($featured_image['alt']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="case-studies-block__content">
                        <?php if( $categories ): ?>
                            <ul class="case-studies-block__categories-list">
                                <?php foreach( $categories as $category ): ?>
                                    <li class="case-studies-block__category"><?php echo esc_html($category); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if( $title ): ?>
                            <h3 class="case-studies-block__title"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>

                        <?php if( $txt_link && $link): ?>
                            <a href="<?php echo esc_html($link); ?>" class="case-studies-block__readmore"><?php echo esc_html($txt_link); ?></a>
                        <?php endif; ?>
                    </div>

                    <?php if( $link ): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>