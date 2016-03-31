<?php get_header(); ?>  
<!-- single.php -->
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet">
        <div <?php post_class('mdl-card mdl-shadow--2dp single'); ?>>
            <?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>
            <?php if ( has_post_thumbnail() ) { ?>
            <?php //prendo l'url dell'immagine in evidenza per metterla come background-image
                $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <div class="mdl-card__title" style="background-image: url( <?php echo $url ?> ); height: 300px">
                <h2 class="mdl-card__title-text" style="color: white;"><?php the_title(); ?></h2>
            </div>
            <?php } else { ?>
            <div class="mdl-card__title" style="height: auto">
                <h2 class="mdl-card__title-text" style="color: #9e005d; text-shadow: none;"><?php the_title(); ?></h2>
            </div>
            <?php } ?>
            <div class="mdl-card__supporting-text">
                Scritto da: <?php the_author_posts_link(); ?> in <?php the_category(' | '); ?>
            </div>
            <?php if ( has_excerpt() ) { ?>
            <div class="mdl-card__supporting-text excerpt">
                <?php the_excerpt();?>
            </div>
            <?php } ?>
            <div class="mdl-card__supporting-text">
                <ul class="tag">
                    <?php the_tags('<li>',', ','</li>') ?>
                </ul>
            </div>
            <div class="mdl-card__supporting-text">
                <?php the_content(); ?>
            </div>
            <div class="mdl-card__supporting-text">
              <?php  if ( comments_open() || get_comments_number() ) {
						comments_template();
					} ?>
            </div>
            <div class="mdl-card__menu">
                <button id="menu-speed" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">share</i>
                </button>
            </div>
            <?php endwhile; else: ?>
            <div class="mdl-card__supporting-text">
                Nessun contenuto trovato!
            </div>
            <?php endif; ?>
            
            <div class="mdl-grid prevnext">
                <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?php previous_post_link(); ?></div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--4-col-tablet mdl-cell--2-col-phone"><?php next_post_link(); ?></div>
            </div>
            
        </div>
    </div>
    <?php get_sidebar('right'); ?>
</div>

<?php get_footer(); ?>