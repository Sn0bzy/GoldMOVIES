<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */

get_header(); ?>


<div id="waterfall-container" class="waterfall-container" style="margin: 114px auto 0;">
	<div id="primary" class="content-area">
		<main id="main" class="error-page" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'goldmovies' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content" id="error-page">
					<h2><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'goldmovies' ); ?></h2>
					
					<div class="widget_search">
						<?php get_search_form(); ?>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->



<?php get_footer(); ?>
