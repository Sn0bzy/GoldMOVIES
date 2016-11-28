<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */

get_header();
?>

<div id="waterfall-container" class="waterfall-container" style="margin: 114px auto 0;">
	<div class="wrap cf"><div id="feed" class="wrap cf">
		<style>.full_wrap{width:100%; } #loading-indicator { width: 590px; }</style>
		<div class="full_wrap cf"><div style="float: left; width: 100%;">

		<div id="advert"><?php if(ot_get_option('center_advert') != '') { echo ot_get_option('center_advert'); } ?></div>

		<div id="container" style="visibility: visible;">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'goldmovies' ),
				'next_text'          => __( 'Next page', 'goldmovies' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'goldmovies' ) . ' </span>',
			) );

			wp_reset_postdata();
		?>
		<?php endif; ?>

		</div>
		<div id="advert"><?php if(ot_get_option('advert2_advert') != '') { echo ot_get_option('advert2_advert'); } ?></div>
		</div></div>
	</div>
</div>

<?php get_footer(); ?>
