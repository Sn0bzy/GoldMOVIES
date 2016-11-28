<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# video: http://ogp.me/ns/video#">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php
		// Get favicon
		$favicon = ot_get_option('favicon');
		if($favicon == false) {
			$favicon = 'favicon.ico';
		}
	?>
	<link rel="icon" type="image/x-icon" href="<?php echo $favicon; ?>" >
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel='stylesheet' id='google-fonts-css'  href='http://fonts.googleapis.com/css?family=Fira+Sans%3A400%2C500%2C700%2C400italic%7CKhand%3A500%7COpen+Sans%3A400italic%2C400%2C600%2C700&#038;ver=4.2.2' type='text/css' media='all' />
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='<?php echo get_template_directory_uri() . '/assets/css/video-js.css'; ?>' rel='stylesheet' type='text/css'>
	<?php
		$logo_size_html = '';

		// Get home theme logo
		$home_logo = ot_get_option('home_logo');
		if($home_logo == false) {
			$home_logo = get_template_directory_uri() . '/assets/images/logo_home.png';
		}

		// Get theme logo
		$logo = ot_get_option('website_logo');
		if($logo == false) {
			$logo = get_template_directory_uri() . '/assets/images/logo.png';
		}
	?>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<?php if ( is_user_logged_in() ) { ?>
	<script type="text/javascript">
		var logged_in = '1';
	</script>
	<?php } ?>
	<?php if ( !is_user_logged_in() ) { ?>
	<script type="text/javascript">
		var logged_in = '0';
	</script>
	<?php } ?>
	<?php if(ot_get_option('custom_css') != '') { ?>
	<style>
		<?php echo ot_get_option('custom_css'); ?>
	</style>
	<?php } ?>
</head>

<body>

	<div id="Page" class="page-wrapper">
		<div class="overlay">
			<div class="loader"></div>
		</div>
	<?php if( is_front_page() && empty($_GET['sort']) ) : ?>
		<section id="featuresparallax" class="fullscreen white-section nopadding" <?php if ( is_user_logged_in() ) { echo "style='height: 644px;'"; } ?>>
			<aside id="homesidebar">
				<ul>
					<li><a href="<?php echo home_url(); ?>/" class="logo"><img src="<?php echo $home_logo; ?>"></a></li>
					<li><a href="<?php echo home_url(); ?><?php echo ot_get_option('news_category'); ?>" class="active"><i class="fa fa-globe"></i><span><?php echo __( 'News', 'goldmovies' ); ?></span></a></li>
					<li><a href="<?php echo home_url(); ?>/?sort=rating"><i class="fa fa-star"></i><span><?php echo __( 'POPULAR', 'goldmovies' ); ?></span></a></li>
					<?php
					$randoms = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '1', 'post_type' => 'movies' ) );
					// output the random post
					while ( $randoms->have_posts() ) : $randoms->the_post();
					?>
					<li><a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><i class="fa fa-toggle-right"></i><span><?php echo __( 'SUGGEST ME', 'goldmovies' ); ?></span></a></li>
					<?php
					endwhile;

					// Reset Post Data
					wp_reset_postdata();
					?>
				</ul>
			</aside>
			<content id="homecontent">
				<div class="homecontent-inner">
					<span class="homecontent-title"><?php echo __( 'News', 'goldmovies' ); ?></span>
					<div class="homecontent-search">
						<div class="search">
							<form method="GET" role="search" action="<?php echo home_url(); ?>/">
								<input type="image" src="<?php bloginfo('template_url'); ?>/assets/images/search.png">
								<input type="text" name="s" class="search" value="" placeholder="<?php echo __( 'Search', 'goldmovies' ); ?>">
							</form>
						</div>
					</div>
				</div>
				<?php $args = array( 'posts_per_page' => 1, 'offset'=> 0 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
				<div class="large-slide slide-poster">
					<div id="image_id_<?php echo $post->ID; ?>" class="image" style="background-image: url(<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), array('1920', '1080') )['0']; ?>);"></div>
					<h1><a href="<?php echo home_url(); ?>/news/<?php echo $post->post_name; ?>"><?php the_title(); ?></a></h1>
				</div>
				<?php endforeach; wp_reset_postdata(); ?>
				<?php $args = array( 'posts_per_page' => 5, 'offset'=> 1 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
				<div class="small-slide slide-poster">
					<style>
						#image_id_<?php echo $post->ID; ?> {
							background-image: url("<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), array('1920', '1080') )['0']; ?>");
						}
					</style>
				<?php $categories = get_the_category($post->ID); ?>
					<a href="<?php echo site_url(); ?>/category/<?php echo $categories['0']->slug; ?>" class="slide-category"><?php echo $categories['0']->cat_name;  ?></a>
					<div id="image_id_<?php echo $post->ID; ?>" class="image"></div>
					<h1><a href="<?php echo home_url(); ?>/news/<?php echo $post->post_name; ?>"><?php the_title(); ?></a></h1>
				</div>
				<?php endforeach; wp_reset_postdata(); ?>
				<?php $args = array( 'posts_per_page' => 2, 'offset'=> 6 );
				$myposts = get_posts( $args );
				foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
				<div class="normal-slide slide-poster">
					<style>
						#image_id_<?php echo $post->ID; ?> {
							background-image: url("<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), array('1920', '1080') )['0']; ?>");
						}
					</style>
					<div id="image_id_<?php echo $post->ID; ?>" class="image"></div>
					<h1><a href="<?php echo home_url(); ?>/news/<?php echo $post->post_name; ?>"><?php the_title(); ?></a></h1>
				</div>
				<?php endforeach; wp_reset_postdata(); ?>
			</content>
		</section>
	<?php endif;?>
		<section class="fullscreen white-section nopadding">

			<div class="page-container">

				<div class="mp-pusher" id="mp-pusher">
					<header id="header" role="banner" <?php if ( is_user_logged_in() ) { echo "style='top: 32px;'"; } ?>>
						<div class="full_wrap cf">
							<div style="padding-left: 30px; padding-right: 30px;">
								<a id="guest-logo" href="<?php echo home_url(); ?>">
									<img src="<?php echo $logo; ?>"<?php echo $logo_size_html ; ?> alt="<?php bloginfo('name'); ?>">
								</a>
								
								<div class="search">
									<form method="GET" role="search" action="<?php echo home_url(); ?>/">
										<input type="image" src="<?php bloginfo('template_url'); ?>/assets/images/search.png">
										<input type="text" name="s" class="search" value="" placeholder="<?php echo __( 'Search', 'goldmovies' ); ?>">
									</form>
								</div>
							</div>
						</div>


						<div id="sub-bar-container" class="sub-bar-sort" style="top: 0px;">
							<div id="sub-bar" class="headline-bar wrap cf">
								<div style="padding: 0px 30px; margin-bottom: 35px;">
									<div class="select-movie-genre" id="select-genre" style="left:30px; display:block">
										<div class="select-genre-title">
											<a><?php echo __( 'Choose Movies Genre', 'goldmovies' ); ?></a>
										</div>
										<div id="select-movie-genre" class="select-genre-categories" style="display: none;">
											<div class="select-genre-categories-inner">
												<ul>
												<?php
												echo get_movie_genres();
												?>
												</ul>
											</div>
										</div>
									
									<div id="sort-by">
										<div id="filter-by">
											<span>Filter By:</span>
											<a href="<?php echo home_url(); ?>/?sort=title" class="title-sort-btn" data-order="asc" title="<?php echo __( 'Title', 'goldmovies' ); ?>"><?php echo __( 'Title', 'goldmovies' ); ?></a> <span class="filter-line"></span>
											<a href="<?php echo home_url(); ?>/?sort=rating" class="rating-sort-btn" data-order="desc" title="<?php echo __( 'Rating', 'goldmovies' ); ?>"><?php echo __( 'Rating', 'goldmovies' ); ?></a> <span class="filter-line"></span>
											<a href="<?php echo home_url(); ?>/?sort=year" class="date-sort-btn" data-order="desc" title="<?php echo __( 'Year', 'goldmovies' ); ?>"><?php echo __( 'Year', 'goldmovies' ); ?></a> <span class="filter-line"></span>
											<a href="<?php echo home_url(); ?>/?sort=views" class="views-sort-btn" data-order="desc" title="<?php echo __( 'Views', 'goldmovies' ); ?>"><?php echo __( 'Views', 'goldmovies' ); ?></a> <span class="filter-line"></span>
											<div class="imdb-sort"><a href="<?php echo home_url(); ?>/?sort=rating" class="imdb"><i class="icon"></i>IMDB</a></div>
										</div>
									</div>
						        </div>
							</div>
						</div>
					</header>

					<aside class="sidebar" <?php if( is_user_logged_in() ) { echo "style='top: 30px;'"; } ?>>
						<div class="aside-header">
							<div class="aside">
								<h2 style="margin-left: 20px;">menu</h2>
								<a class="close-aside" id="close-aside" style="margin-right: 20px;">Close</a>
							</div>
						</div>
					
						<ul class="clearfix">
							<li><a href="<?php echo home_url(); ?>" class="icon-newest">HOME</a></li>
						<?php
							$mypages = get_pages( array( 'sort_order' => 'desc' ) );
							foreach( $mypages as $page ) {
						?>
							<li><a href="<?php echo get_page_link( $page->ID ); ?>" class="icon-newest"><?php echo $page->post_title; ?></a></li>
						<?php
							}
						?>
						</ul>
					</aside>
				</div>

