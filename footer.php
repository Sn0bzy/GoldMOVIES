<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */
?>

	</div><!-- .site-content -->
	<div id="footer" style="margin-bottom: -25px; <?php if(ot_get_option('footer_columns') == 'off') { ?>height: 62px;<?php } ?>">
		<?php if(ot_get_option('footer_columns') == 'on') { ?>
			<ul>
				<li>
					<a href="<?php echo home_url(); ?>/"><p class="home"><?php echo __( 'HOME', 'goldmovies' ); ?></p></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>/?sort=rating"><p class="general"><?php echo __( 'POPULAR', 'goldmovies' ); ?></p></a>
				</li>
				<li>
					<a href="<?php echo home_url(); ?>/?sort=title"><p class="pages"><?php echo __( 'SORT BY ALPHABET', 'goldmovies' ); ?></p></a>
				</li>
				<li>
					<?php
					$randoms = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '1', 'post_type' => 'movies' ) );
					if($randoms->have_posts()) {
					// output the random post
					while ( $randoms->have_posts() ) : $randoms->the_post();
					?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><p class="users"><?php echo __( 'SUGGEST MOVIE', 'goldmovies' ); ?></p></a>
					<?php
					endwhile;
					} else { ?>
					<a href="<?php echo home_url(); ?>"><p class="users"><?php echo __( 'SUGGEST MOVIE', 'goldmovies' ); ?></p></a>
					<?php
					}
					?>
				</li>
			</ul>
		<?php } ?>
			<span class="powered_by"><?php echo ot_get_option('footer_copyright'); ?></span>
	</div>

</div><!-- .site -->
</section>
	</div>

<?php echo ot_get_option('tracking_code'); ?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
<?php if( is_user_logged_in() ) { ?><script>var detect_h = '32';</script><?php } else { ?><script>var detect_h = '0';</script><?php } ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/animate.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/video.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/gold.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/js/gold.min.js"></script>

<?php if(ot_get_option('custom_js') != '') { ?>
<script type="text/javascript">
	<?php echo ot_get_option('custom_js'); ?>
</script>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
