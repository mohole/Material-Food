<?php get_header(); ?>
<!-- home.php -->
<div class="mdl-grid">
    <div class=" mdl-cell mdl-cell--8-col mdl-cell--5-col-tablet mdl-cell--4-col-phone">
        <?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>
        <div <?php post_class('mdl-card mdl-shadow--2dp tag-post'); ?>>
            <?php if ( has_post_thumbnail() ) { ?>
            <?php //prendo l'url dell'immagine in evidenza per metterla come background-image
                $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <div class="mdl-card__title" style="background-image: url( <?php echo $url ?> ); height: 300px">
                <h2 class="mdl-card__title-text" style="color: white;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </div>
            <?php } else { ?>
            <div class="mdl-card__title" style="height: auto">
                <h2 class="mdl-card__title-text"><a href="<?php the_permalink(); ?>" style="color: #9e005d; text-shadow: none;"><?php the_title(); ?></a></h2>
            </div>
            <?php } ?>
            <div class="mdl-card__supporting-text">
                <ul class="tag">
                    <?php the_tags('<li>',', ','</li>') ?>
                </ul>
            </div>
            <?php if ( has_excerpt() ) { ?>
            <div class="mdl-card__supporting-text excerpt">
                <?php the_excerpt();?>
            </div>
            <?php } ?>
            <div class="mdl-card__actions mdl-card--border">
                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php the_permalink(); ?>">
                Continua a leggere
                </a>
            </div>
        </div>

        <?php endwhile; else: ?>
        <div class="mdl-card mdl-shadow--2dp home-post">
            <div class="mdl-card__supporting-text">
                Nessun contenuto trovato!
            </div>
        </div>
        <?php endif; ?>
        <?php the_posts_pagination(array(
            "prev_text" => "&laquo;",
            "next_text" => "&raquo;"
        )); ?>
    </div>
    <?php get_sidebar('right'); ?>
</div>
<?php get_footer(); ?>