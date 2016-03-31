<?php /* Template name: No Sidebar */ ?>

<?php get_header(); ?>
<!-- no_sidebar_layout.php -->
<div class="mdl-grid">
    <div class="mdl-cell mdl-cell--12-col">
        <div <?php post_class('mdl-card mdl-shadow--2dp'); ?>>
            <?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text"><?php the_title(); ?></h2>
            </div>
            <div class="mdl-card__supporting-text">
                <?php the_content(); ?>
            </div>
            <?php endwhile; else: ?>
            <div class="mdl-card__supporting-text">
                Nessun contenuto trovato!
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>