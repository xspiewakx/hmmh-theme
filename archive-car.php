<?php
/**
 * Szablon archiwum dla niestandardowego typu postów 'cars'.
 */
get_header(); 
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php if ( have_posts() ) : ?>

        <header class="page-header">
            <h1 class="page-title">Nasza flota samochodów</h1>
        </header><?php
        
        while ( have_posts() ) : the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header><div class="entry-content">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'medium' );  ?>
                    </div>
                <?php endif; ?>

                <?php 
                $terms = get_the_terms( get_the_ID(), 'car_brand' );
                //var_dump($terms);
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
                    $term_list = array();
                    foreach ( $terms as $term ) {
                        $term_list[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
                    }
                    echo '<p><strong>Marka:</strong> ' . implode( ', ', $term_list ) . '</p>';
                endif; 
                ?>

                <?php
                $mechanics = get_field('assigned_mechanics');
                //var_dump($mechanics);
                if( $mechanics ):
                    echo '<p><strong>Przypisani mechanicy:</strong> ';
                    $mechanics_list = array();
                    foreach( $mechanics as $mechanic ):
                        
                        $mechanics_list[] = esc_html( $mechanic['display_name'] );
                    endforeach;
                    echo implode( ', ', $mechanics_list ) . '</p>';
                endif;
                ?>
            </div></article><?php endwhile; ?>

        <?php the_posts_pagination();  ?>

    <?php else : ?>

        <p>Brak samochodów do wyświetlenia.</p>

    <?php endif; ?>

    </main></div><?php
get_sidebar(); 
get_footer();  