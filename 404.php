<?php get_header(); ?>
    <!-- 404.php -->    
    <div class="mdl-grid error-page">
        <div class="mdl-cell mdl-cell--8-col">
            <div class="demo-card-wide mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title errore" style="background-image: url(<?php echo esc_url( get_template_directory_uri() ) ?>/apple.jpg);">
                    <h2 class="mdl-card__title-text">whoooooops... page not found </h2>
                </div>
                <div class="mdl-card__supporting-text">
                    We're sorry but the link to the page you are looking is as rotten as this apple!
                </div>
            </div>
        </div>
        <?php get_sidebar('right'); ?>
    </div>
<?php get_footer(); ?>