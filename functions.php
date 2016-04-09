<?php
if ( ! isset( $content_width ) ) {
    $content_width = 900;
}

//navwalker per aggiungere le classi MDL al menu
require_once('nav-walker.php');

//personalizzazione del tema
function temaSetup(){
    //aggiungere  RSS feed links in testata
	add_theme_support( 'automatic-feed-links' );

    //nome del blog
    add_theme_support( 'title-tag' );

    //immagine in evidenza
    add_theme_support( 'post-thumbnails' );

    //immagine header personalizzata
    add_theme_support( 'custom-header', array(
        'default-image' => get_template_directory_uri() . '/bg.jpg',
        'uploads' => true

    ) );

    //switch dei commenti in html
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ) );

    /*da abilitare i formati nel tema
    add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
  */
}
add_action('after_setup_theme', 'mfood_Setup');

function creaMenu(){
    register_nav_menus( array(
        'menu_principale' => 'Menu Principale',
        'menu_secondario' => 'Menu Secondario'
    ) );
}
add_action('init','creaMenu');

function areaWidget(){
    //Sidebar Destra
    register_sidebar( array(
        "name" => "Sidebar Destra",
        "description" => "I widget sulla destra",
        "id" => "sidebar-1",
        "before_widget" => '<div class="mdl-card__supporting-text">',
        "after_widget" => '</div>',
        "before_title" => '<div class="mdl-card__title"><h4 class="mdl-card__title-text">',
        "after_title" => '</h4></div>'
    ) );
    //Sidebar Sinistra
    register_sidebar( array(
        "name" => "Sidebar Sinistra",
        "description" => "I widget sulla sinistra",
        "id" => "sidebar-2",
        "before_widget" => '<div class="mdl-card__supporting-text">',
        "after_widget" => '</div>',
        "before_title" => '<div class="mdl-card__title"><h4 class="mdl-card__title-text">',
        "after_title" => '</h4></div>'
    ) );
    //Footer
    register_sidebar( array(
        "name" => "Footer",
        "description" => "I widget nel footer",
        "id" => "sidebar-3",
        "before_widget" => '<div class="mdl-mega-footer__drop-down-section">',
        "after_widget" => '</div>',
        "before_title" => '<h1 class="mdl-mega-footer__heading">',
        "after_title" => '</h1>'
    ) );

    //Post category home
    register_sidebars(4, array(
        'name' => 'Home post %d',
        'description' => 'Scegli il widget "Ultimi Post Categorizzati" e seleziona una categoria di post da mostrare',
        "before_widget" => '<div class="mdl-card__supporting-text">',
        "after_widget" => '</div>',
        "before_title" => '<div class="mdl-card__title"><h2 class="mdl-card__title-text">',
        "after_title" => '</h2></div>'
    ) );
}
add_action("widgets_init","areaWidget");

function caricaScript(){
    //Dimentica la versione attualmente registrata di Jquery
    wp_deregister_script("jquery");
    //definisco Jquery
    wp_register_script(
        'jquery',
        get_template_directory_uri() . '/js/jquery-2.1.4.js',
        false,
        '2.1.4',
        true
    );
    //definisco material.js
    wp_register_script(
        'materialJS',
        get_template_directory_uri() . '/mdl/material.min.js',
        array('jquery'),
        '2.0.0',
        true
    );
    //definisco lightbox js
    wp_register_script(
        'lightboxJS',
        get_template_directory_uri() . '/js/lightbox.js',
        array('jquery','materialJS'),
        '2.0.0',
        true
    );
    //definisco il mio script
    wp_register_script(
        'mioJS',
        get_template_directory_uri() . '/js/mioscript.js',
        array('jquery','materialJS'),
        '1.0.0',
        true
    );

    //definisco material.css
    wp_register_style(
        'materialCSS',
        get_template_directory_uri() . '/mdl/material.min.css',
        false,
        '2.0.0',
        'all'
    );
    //definisco lightbox.css
    wp_register_style(
        'lightboxCSS',
        get_template_directory_uri() . '/css/lightbox.css',
        array('materialCSS'),
        '2.0.0',
        'all'
    );

    //caricamento degli script e degli style
    wp_enqueue_script('jquery');
    wp_enqueue_script('materialJS');
    wp_enqueue_script('lightboxJS');
    wp_enqueue_script('mioJS');
    wp_enqueue_style('materialCSS');
    wp_enqueue_style('lightboxCSS');
    wp_enqueue_style('style',get_stylesheet_uri());
}
add_action('wp_enqueue_scripts','caricaScript');

//aggiungere categorie alle immagini
function aggiungiCategorieImmagini() {
      register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'aggiungiCategorieImmagini' );

//lunghezza excerpt
function new_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');

//commenti
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
}

//WIDGET per ultimi post scegliendo la categoria
class UltimiPostCategorizzati extends WP_Widget
{
    //funzione per definire le impostazioni del widget
    public function __construct()
    {
        //costruttore di classe
        //parametri: il nome unico del widget, il titolo, array associativo con altre opzioni
        parent::__construct('cat-posts', __('Ultimi Post Categorizzati','catposts'), array('classname' => 'cat-post-widget', 'description' => __('Post pi&#249; recenti divisi per categoria','catposts')));
    }

    //funzione per definire come visualizzare il form nella configurazione del widget da backend
    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array(
            'title'          => '',
            'num'            => 3,
            'cat'            => '',
            'hide_if_empty'  => ''
        ) );

        $title          = $instance['title'];
        $num            = $instance['num'];
        $cat            = $instance['cat'];
        $hide_if_empty  = $instance['hide_if-empty'];
        ?>

        <!-- codice html del form -->
        <!-- input text per il titolo -->
        <p>
            <label for="<?php echo $this->get_field_id("title"); ?>">
                <?php _e( 'Titolo','catposts' ); ?>:
                <input class="widefat" style="width:80%;" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
            </label>
        </p>
        <!-- select per scegliere la categoria di post -->
        <p>
            <label>
                <?php _e( 'Categoria','catposts' ); ?>:
                <?php wp_dropdown_categories( array( 'hide_empty'=> 0, 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
            </label>
        </p>
        <!-- checkbox "hide if empty", quando selezionato se la categoria scelta non contiene post, il widget viene nascosto -->
        <p>
            <label for="<?php echo $this->get_field_id("hide_if_empty"); ?>">
                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("hide_if_empty"); ?>" name="<?php echo $this->get_field_name("hide_if_empty"); ?>"<?php checked( (bool) $instance["hide_if_empty"], true ); ?> />
                <?php _e( 'Nascondi se la categoria non ha post','catposts' ); ?>
            </label>
        </p>
        <!-- input nascosto per il numero di post da mostrare -->
        <p style="display:none;">
            <label for="<?php echo $this->get_field_id("num"); ?>">
                <?php _e('Number of posts to show','catposts'); ?>:
                <input style="text-align: center; width: 30%;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="number" min="0" value="<?php echo absint($instance["num"]); ?>" />
            </label>
        </p>
        <?php
    }

    //elaborazione del widget e output html (nel frontend)
    public function widget( $args,$instance )
    {
        extract( $args );

		// Se non viene definito un titolo usa il nome della categoria
		if( !$instance["title"] ) {
			$category_info = get_category($instance["cat"]);
			$instance["title"] = $category_info->name;
		}

        // array delle info del post
		$args = array(
            'showposts' => $instance["num"],
			'cat' => $instance["cat"],
		);

        $cat_posts = new WP_Query( $args );
        if ( !isset ( $instance["hide_if_empty"] ) || $cat_posts->have_posts() ) {

            //filtro per la lunghezza dell'excerpt
			$new_excerpt_length = create_function('$length', "return " . $instance["excerpt_length"] . ";");
			if ( $instance["excerpt_length"] > 0 )
				add_filter('excerpt_length', $new_excerpt_length);

            echo $before_widget;

			//titolo del widget
			if( !isset ( $instance["hide_title"] ) ) {
				echo $before_title;
				if( isset ( $instance["title_link"] ) ) {
					echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>';
				} else {
					echo $instance["title"];
				}
				echo $after_title;
			}

            //Elenco dei post
            echo "<ul>\n";
            while ( $cat_posts->have_posts() )
            {
                $cat_posts->the_post(); ?>
                <li <?php echo "class=\"cat-post-item";
				          if ( is_single(get_the_title() ) ) { echo " cat-post-current"; }
						  echo "\""; ?> >
                    <h4 class="post_title"><a <?php echo " cat-post-title"; ?> href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                    <ul class="tag">
                        <?php the_tags('<li>',', ','</li>') ?>
                    </ul>
                    <?php the_excerpt(20); ?>
                </li>
           <?php }
            echo "</ul>\n";

            echo $after_widget;

            remove_filter('excerpt_length', $new_excerpt_length);

            // Reimpostazione della variabile global $post
            wp_reset_postdata();
        } //END if
    }// END function

    //aggiornamento delle opzioni del widget quando mostrate nel pannello
    public function update( $new_instance, $old_instance )
    {
        return $new_instance;
    }
}
//registrazione del widget per mostrarlo nel pannello widget
function registraWidget(){
    register_widget('UltimiPostCategorizzati');
}
add_action('widgets_init','registraWidget');

//Custom logo
function mfood_theme_customizer( $wp_customize ) {
   $wp_customize->add_section( 'mfood_logo_section' , array(
    'title'       => __( 'Logo', 'mfood' ),
    'priority'    => 30,
    'description' => '
   Caricamento di un logo, in sostituzione del nome sito / descrizione in testata',
) );

    $wp_customize->add_setting( 'mfood_logo' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mfood_logo', array(
    'label'    => __( 'Logo', 'mfood' ),
    'section'  => 'mfood_logo_section',
    'settings' => 'mfood_logo',
    'sanitize_callback' => 'esc_url_raw',
  	'type' => 'theme_mod',
)));

}
add_action( 'customize_register', 'mfood_theme_customizer' );

/*
function add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function = '' ) {
    return add_submenu_page( 'themes.php', $page_title, $menu_title, $capability, $menu_slug, $function );
}

*/

//Social share
function social_share_menu_item()
{
  add_submenu_page("options-general.php", "Social Share", "Social Share", "manage_options", "social-share", "social_share_page");
}
function social_share_page()
{
   ?>
      <div class="wrap">
         <h1>Opzioni Condivisione Social</h1>

         <form method="post" action="options.php">
            <?php
               settings_fields("social_share_config_section");

               do_settings_sections("social-share");

               submit_button();
            ?>
         </form>
      </div>
   <?php
}
function social_share_settings()
{
    add_settings_section("social_share_config_section", "", null, "social-share");

    add_settings_field("social-share-facebook", "Attivare pulsante condivisione Facebook?", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-twitter", "Attivare pulsante condivisione Twitter?", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-linkedin", "Attivare pulsante condivisione LinkedIn?", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-pinterest", "Attivare pulsante condivisione Pinterest?", "social_share_pinterest_checkbox", "social-share", "social_share_config_section");
    add_settings_field("social-share-googleplus", "Attivare pulsante condivisione Google+?", "social_share_googleplus_checkbox", "social-share", "social_share_config_section");

    register_setting("social_share_config_section", "social-share-facebook");
    register_setting("social_share_config_section", "social-share-twitter");
    register_setting("social_share_config_section", "social-share-linkedin");
    register_setting("social_share_config_section", "social-share-pinterest");
    register_setting("social_share_config_section", "social-share-googleplus");
}

function social_share_facebook_checkbox()
{
   ?>
        <input type="checkbox" name="social-share-facebook" value="1" <?php checked(1, get_option('social-share-facebook'), true); ?> /> Attiva
   <?php
}
function social_share_twitter_checkbox()
{
   ?>
        <input type="checkbox" name="social-share-twitter" value="1" <?php checked(1, get_option('social-share-twitter'), true); ?> /> Attiva
   <?php
}
function social_share_linkedin_checkbox()
{
   ?>
        <input type="checkbox" name="social-share-linkedin" value="1" <?php checked(1, get_option('social-share-linkedin'), true); ?> /> Attiva
   <?php
}
function social_share_pinterest_checkbox()
{
   ?>
        <input type="checkbox" name="social-share-pinterest" value="1" <?php checked(1, get_option('social-share-pinterest'), true); ?> /> Attiva
   <?php
}
function social_share_googleplus_checkbox()
{
   ?>
        <input type="checkbox" name="social-share-googleplus" value="1" <?php checked(1, get_option('social-share-googleplus'), true); ?> /> Check for Yes
   <?php
}

add_action("admin_init", "social_share_settings");
add_action("admin_menu", "social_share_menu_item");
function add_social_share_icons($content)
{
    $html = "<ul class='mdl-menu mdl-js-menu mdl-menu--bottom-right' for='menu-speed'>";
    global $post;
    $url = get_permalink($post->ID);
    $url = esc_url($url);
    $media = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    $title = get_the_title($post->ID);


    if(get_option("social-share-facebook") == 1)
    {
        $html = $html . "<li class='mdl-menu__item facebook'><a target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "'>Facebook</a></li>";
    }
    if(get_option("social-share-twitter") == 1)
    {
        $html = $html . "<li class='mdl-menu__item twitter'><a target='_blank' href='https://twitter.com/share?url=" . $url . "'>Twitter</a></li>";
    }
    if(get_option("social-share-linkedin") == 1)
    {
        $html = $html . "<li class='mdl-menu__item linkedin'><a target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $url . "'>LinkedIn</a></li>";
    }

    if(get_option("social-share-pinterest") == 1)
    {
        $html = $html . "<li class='mdl-menu__item pinterest'><a target='_blank' href='http://pinterest.com/pin/create/button/?url=" . $url . "&media=".$media."&description=".$title."'>Pinterest</a></li>";
    }

    if(get_option("social-share-googleplus") == 1)
    {
        $html = $html . "<li class='mdl-menu__item googleplus'><a target='_blank' href='https://plus.google.com/share?url=" . $url . "' onclick='javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;'>Google+</a></li>";
    }
    $html = $html."</ul>";
    return $content = $content.$html;
}
add_filter("the_content", "add_social_share_icons");

?>
