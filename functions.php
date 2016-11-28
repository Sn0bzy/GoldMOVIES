<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/lib/back-compat.php';
}

if ( ! function_exists( 'goldmovies_setup' ) ) :

function goldmovies_setup() {

	load_theme_textdomain( 'goldmovies', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'goldmovies' ),
		'social'  => __( 'Social Links Menu', 'goldmovies' ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = goldmovies_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'goldmovies_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	add_editor_style( array( 'assets/css/editor-style.css', 'assets/fonts/genericons.css', goldmovies_fonts_url() ) );

		add_action( 'add_meta_boxes', 'vh_add_metabox' );
		add_action( 'save_post', 'movies_save_metabox', 10, 2 );
		// Register Taxonomy
		register_taxonomy( 'genre',
			array (
				0 => 'movies',
			),
			array( 
				'hierarchical' => true, 
				'label' => 'Movie Genres',
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array('slug' => ''),
				'singular_label' => 'Movie Genre'
			) 
		);
}
endif; // goldmovies_setup
add_action( 'after_setup_theme', 'goldmovies_setup' );

function vh_add_metabox() {

	add_meta_box(
		'movies_metabox',                                   // Unique ID
		esc_html__( 'Advanced event fields', 'vh' ),  // Title
		'movies_metabox_function',                          // Callback function
		'movies',                                           // Admin page (or post type)
		'normal',                                           // Context
		'high'                                              // Priority
	);

}

function movies_metabox_function( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'movies_nonce' ); ?>

	<p>
		<label for="movies_year"><?php _e( "Movies Year", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="movies_year" id="movies_year" value="<?php echo esc_attr( get_post_meta( $object->ID, 'movies_year', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="imdb_rating"><?php _e( "IMDB Rating", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="imdb_rating" id="imdb_rating" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdb_rating', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="directed_by"><?php _e( "Directed By", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="directed_by" id="directed_by" value="<?php echo esc_attr( get_post_meta( $object->ID, 'directed_by', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="actors"><?php _e( "Actors", 'vh' ); ?></label>
		<br />
		<input class="widefat" type="text" name="actors" id="actors" value="<?php echo esc_attr( get_post_meta( $object->ID, 'actors', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="movies_link"><strong><?php _e( "Movie Link (flv, mp4 and etc.)", 'vh' ); ?></strong></label>
		<br />
		<input class="widefat" type="text" name="movies_link" id="movies_link" value="<?php echo esc_attr( get_post_meta( $object->ID, 'movies_link', true ) ); ?>" size="30" />
	</p>

	<p>
		<label for="movie_iframe"><strong><?php _e( "Movie Iframe Link", 'vh' ); ?></strong></label>
		<br />
		<input class="widefat" type="text" name="movie_iframe" id="movie_iframe" value="<?php echo esc_attr( get_post_meta( $object->ID, 'movie_iframe', true ) ); ?>" size="30" />
	</p>

<?php }

function movies_save_metabox( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['movies_nonce'] ) || !wp_verify_nonce( $_POST['movies_nonce'], basename( __FILE__ ) ) )
	return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value   = ( isset( $_POST['movies_year'] ) ? sanitize_text_field( $_POST['movies_year'] ) : '' );
	$new_meta_value2  = ( isset( $_POST['imdb_rating'] ) ? sanitize_text_field( $_POST['imdb_rating'] ) : '' );
	$new_meta_value3  = ( isset( $_POST['directed_by'] ) ? sanitize_text_field( $_POST['directed_by'] ) : '' );
	$new_meta_value4  = ( isset( $_POST['actors'] ) ? sanitize_text_field( $_POST['actors'] ) : '' );
	$new_meta_value5  = ( isset( $_POST['movies_link'] ) ? sanitize_text_field( $_POST['movies_link'] ) : '' );
	$new_meta_value6  = ( isset( $_POST['movie_iframe'] ) ? sanitize_text_field( $_POST['movie_iframe'] ) : '' );

	/* Get the meta key. */
	$meta_key   = 'movies_year';
	$meta_key2  = 'imdb_rating';
	$meta_key3  = 'directed_by';
	$meta_key4  = 'actors';
	$meta_key5  = 'movies_link';
	$meta_key6  = 'movie_iframe';

	/* Get the meta value of the custom field key. */
	$meta_value   = get_post_meta( $post_id, $meta_key, true );
	$meta_value2  = get_post_meta( $post_id, $meta_key2, true );
	$meta_value3  = get_post_meta( $post_id, $meta_key3, true );
	$meta_value4  = get_post_meta( $post_id, $meta_key4, true );
	$meta_value5  = get_post_meta( $post_id, $meta_key5, true );
	$meta_value6  = get_post_meta( $post_id, $meta_key6, true );


	if ( $new_meta_value && '' == $meta_value )
	add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	elseif ( $new_meta_value && $new_meta_value != $meta_value )
	update_post_meta( $post_id, $meta_key, $new_meta_value );

	elseif ( '' == $new_meta_value && $meta_value )
	delete_post_meta( $post_id, $meta_key, $meta_value );

	if ( $new_meta_value2 && '' == $meta_value2 )
	add_post_meta( $post_id, $meta_key2, $new_meta_value2, true );

	elseif ( $new_meta_value2 && $new_meta_value2 != $meta_value2 )
	update_post_meta( $post_id, $meta_key2, $new_meta_value2 );

	elseif ( '' == $new_meta_value2 && $meta_value2 )
	delete_post_meta( $post_id, $meta_key2, $meta_value2 );

	if ( $new_meta_value3 && '' == $meta_value3 )
	add_post_meta( $post_id, $meta_key3, $new_meta_value3, true );

	elseif ( $new_meta_value3 && $new_meta_value3 != $meta_value3 )
	update_post_meta( $post_id, $meta_key3, $new_meta_value3 );

	elseif ( '' == $new_meta_value3 && $meta_value3 )
	delete_post_meta( $post_id, $meta_key3, $meta_value3 );

	if ( $new_meta_value4 && '' == $meta_value4 )
	add_post_meta( $post_id, $meta_key4, $new_meta_value4, true );

	elseif ( $new_meta_value4 && $new_meta_value4 != $meta_value4 )
	update_post_meta( $post_id, $meta_key4, $new_meta_value4 );

	elseif ( '' == $new_meta_value4 && $meta_value4 )
	delete_post_meta( $post_id, $meta_key4, $meta_value4 );

	if ( $new_meta_value5 && '' == $meta_value5 )
	add_post_meta( $post_id, $meta_key5, $new_meta_value5, true );

	elseif ( $new_meta_value5 && $new_meta_value5 != $meta_value5 )
	update_post_meta( $post_id, $meta_key5, $new_meta_value5 );

	elseif ( '' == $new_meta_value5 && $meta_value5 )
	delete_post_meta( $post_id, $meta_key5, $meta_value5 );

	if ( $new_meta_value6 && '' == $meta_value6 )
	add_post_meta( $post_id, $meta_key6, $new_meta_value6, true );

	elseif ( $new_meta_value6 && $new_meta_value6 != $meta_value6 )
	update_post_meta( $post_id, $meta_key6, $new_meta_value6 );

	elseif ( '' == $new_meta_value6 && $meta_value6 )
	delete_post_meta( $post_id, $meta_key6, $meta_value6 );

}

add_action( 'init', 'vh_create_post_type' );
function vh_create_post_type() {
	register_post_type( 'movies',
		array(
		'labels' => array(
			'name' => __( 'Movies', "vh" ),
			'singular_name' => __( 'Movie', "vh" )
		),
		'taxonomies' => array('genre'),
		'rewrite' => array('slug'=>'movies','with_front'=>false),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'category',
			'editor',
			'revisions',
			'thumbnail',
			'comments',
			'post-templates'
			)
		)
	);
}

function get_movie_genres() {
	$values = get_terms('genre');
	foreach ($values as $value) {
		$genres[] = array('name'=>$value->name,'slug'=>$value->slug);
	}

	$output = '';
	foreach ( $genres as $genre ) {
		$output .= '<li><a href="'.home_url().'/genre/'.$genre['slug'].'/'.'">'.$genre['name'].'</a></li>';
	}

	$output .= '</ul></div>';

	return $output;
}

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count;
}

function MOVIE_POSTID($postID, $arg){

    $count = get_post($postID);

    return $count->{$arg};
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); 

function goldmovies_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'goldmovies' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'goldmovies' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'goldmovies_widgets_init' );

if ( ! function_exists( 'goldmovies_fonts_url' ) ) :

function goldmovies_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'goldmovies' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'goldmovies' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	if ( 'off' !== _x( 'on', 'libonsolata font: on or off', 'goldmovies' ) ) {
		$fonts[] = 'libonsolata:400,700';
	}

	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'goldmovies' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

function goldmovies_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'goldmovies-fonts', goldmovies_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/assets/fonts/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'goldmovies-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'goldmovies-ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'goldmovies-style' ), '20141010' );
	wp_style_add_data( 'goldmovies-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'goldmovies-ie7', get_template_directory_uri() . '/assets/css/ie7.css', array( 'goldmovies-style' ), '20141010' );
	wp_style_add_data( 'goldmovies-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'goldmovies-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'goldmovies-keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'goldmovies-script', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'goldmovies-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'goldmovies' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'goldmovies' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'goldmovies_scripts' );


function goldmovies_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'goldmovies-style', $css );
}
add_action( 'wp_enqueue_scripts', 'goldmovies_post_nav_background' );

function goldmovies_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'goldmovies_nav_description', 10, 4 );

function goldmovies_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'goldmovies_search_form_modify' );

add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
require( trailingslashit( get_template_directory() ) . 'lib/option-tree/ot-loader.php' );

/**
 * Theme Options
 */
require( trailingslashit( get_template_directory() ) . 'lib/theme-options.php' );


function add_settings_page() {
	add_menu_page( __( 'Theme Options' ), __( 'Theme Options' ), 'manage_options', 'ot-theme-options', 'custom_theme_options');
}

add_action( 'admin_menu', 'add_settings_page' );

function custom_search_where($pieces) {

    // filter to select search query
    if (is_search() && !is_admin()) {

        global $wpdb;
        $custom_fields = array('movies_year','imdb_rating','directed_by','actors');
        $keywords = explode(' ', get_query_var('s'));
        $query = "";
        foreach ($custom_fields as $field) {
             foreach ($keywords as $word) {
                 $query .= "((mypm1.meta_key = '".$field."')";
                 $query .= " AND (mypm1.meta_value  LIKE '%{$word}%')) OR ";
             }
        }

        if (!empty($query)) {
            // add to where clause
            $pieces['where'] = str_replace("((({$wpdb->posts}.post_title LIKE '%", "( {$query} (({$wpdb->posts}.post_title LIKE '%", $pieces['where']);

            $pieces['join'] = $pieces['join'] . " INNER JOIN {$wpdb->postmeta} AS mypm1 ON ({$wpdb->posts}.ID = mypm1.post_id)";
            $pieces['groupby'] = "{$wpdb->posts}.ID";
        }
    }
    return ($pieces);
}
add_filter('posts_clauses', 'custom_search_where', 20, 1);

function change_pages_permalinks() {
	global $wp_rewrite;
	// Change the value of the author permalink base to whatever you want here
	$wp_rewrite->author_base = '';
	// Change the value of the page permalink base to whatever you want here
	$wp_rewrite->page_structure = 'page/%pagename%';
	$wp_rewrite->flush_rules();
}
add_action('init','change_pages_permalinks');

function change_post_permalinks() {
	global $wp_rewrite;
	// Change the value of the author permalink base to whatever you want here
	$wp_rewrite->author_base = '';
	// Change the value of the page permalink base to whatever you want here
	$wp_rewrite->post_structure = 'news/%postname%';
	$wp_rewrite->flush_rules();
}
add_action('init','change_post_permalinks');

function get_excerpt($count, $post){
  $permalink = get_permalink($post);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = $excerpt.' ... <!--<a href="'.$permalink.'">more</a>-->';
  return $excerpt;
}

function sort_by_title($query){
	if(isset($_GET['sort']) && $_GET['sort'] == 'title') {
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'order', 'ASC' );
		//Set the orderby
		$query->set( 'orderby', 'title' );
	}
}

function sort_by_imdb($query){
	if(isset($_GET['sort']) && $_GET['sort'] == 'rating') {
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'meta_key', 'imdb_rating' );	 
		$query->set( 'order', 'DESC' );
		$query->set( 'orderby', 'meta_value' );
	}
}

function sort_by_views($query){
	if(isset($_GET['sort']) && $_GET['sort'] == 'views') {
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'meta_key', 'post_views_count' );
		$query->set( 'order', 'DESC' );
		$query->set( 'orderby', 'meta_value' );
	}
}

function sort_by_year($query){
	if(isset($_GET['sort']) && $_GET['sort'] == 'year') {
		//If you wanted it for the archive of a custom post type use: is_post_type_archive( $post_type )
		//Set the order ASC or DESC
		$query->set( 'meta_key', 'movies_year' );
		$query->set( 'order', 'DESC' );
		$query->set( 'orderby', 'meta_value' );
	}
}

function my_post_queries( $query ) {
	// not an admin page and is the main query
	if ( $query->is_main_query() ) {
		// category and search pages
		if ( isset($_GET['sort']) && $_GET['sort'] == 'title' ) {
			add_action( 'pre_get_posts', 'sort_by_title'); 
		}
		if ( isset($_GET['sort']) && $_GET['sort'] == 'rating' ) {
			add_action( 'pre_get_posts', 'sort_by_imdb'); 
		}
		if ( isset($_GET['sort']) && $_GET['sort'] == 'views' ) {
			add_action( 'pre_get_posts', 'sort_by_views'); 
		}
		if ( isset($_GET['sort']) && $_GET['sort'] == 'year' ) {
			add_action( 'pre_get_posts', 'sort_by_year'); 
		}
	}
}
add_action( 'pre_get_posts', 'my_post_queries' );

register_post_type('news', array(
	'labels' => array(
		'name' => 'News',
		'singular_name' => 'news'
	),
	'rewrite' => array(
		'slug' => 'news'
    ),
    'public' => false,
));

function movies_on_homepage( $query ) {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'post_type', 'movies' );
        $query->set( 'posts_per_page', 18 );
        $query->set( 'paged', $paged );
    }
}
add_action( 'pre_get_posts', 'movies_on_homepage' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/lib/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/lib/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/lib/customizer.php';
