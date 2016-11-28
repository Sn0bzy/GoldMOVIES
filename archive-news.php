<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area width-100">
		<main id="main" class="site-main" role="main" style="display: inline-block;">

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			$movies_query = new WP_Query( array(
			  'post_type' => 'post',
			  'posts_per_page' => 12
			) );
			if ( $movies_query->have_posts() ):
			?>

				<?php if ( is_home() && ! is_front_page() ) : ?>
					<header>
						<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php endif; ?>

				<?php
				// Start the loop.
				while ( $movies_query->have_posts() ) : $movies_query->the_post();

					get_template_part( 'content', get_post_format() );

				// End the loop.
				endwhile; wp_reset_postdata();

				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'goldmovies' ),
					'next_text'          => __( 'Next page', 'goldmovies' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'goldmovies' ) . ' </span>',
				) );
			?>
			<?php endif; ?>



		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
