<?php
/**
 * Gold MOVIES is simple and awesome movies template for Wordpress.
 *
 * @package WordPress
 * @subpackage Gold_MOVIES
 * @since Gold MOVIES 1.0
 */
?>
<?php if ( get_post_meta( get_the_ID(), 'movies_year', true ) != '' ) { ?>
<div class="movie-element movie-element-size-1" data-id="<?php the_ID(); ?>">
	<a href="<?php echo get_permalink(); ?>" class="movie-image" style="background-image: url(<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), 'large' )[0]; ?>);">
		<div class="movie-overlay clearfix">
			<?php the_title( '<div class="movie-overlay-title">', '</div>' ); ?>
		</div>
	</a>
</div>
<?php } else { ?>
<style>
.content-area { width: 100%; }

.site-main article {
    width: calc(33% - 25px);
    float: left;
    margin-right: 10px;
}
.site-main article .wrap_normal {
	margin-bottom: 8px;
	height: 195px;
}
@media(max-width: 1249px) {
	.site-main article {
	    width: calc(50% - 45px);
	    float: left;
	    margin-right: 10px;
	}
}
@media(max-width: 998px) {
	.site-main article {
	    width: calc(100% - 75px);
	    float: left;
	    margin-right: 10px;
	}
	.site-main article .wrap_normal {
		margin-bottom: 8px;
		height: 100%;
	}
}
@media(max-width: 500px) {
	.site-main article {
	    width: calc(100% - 0px);
	    float: left;
	    margin-right: 10px;
	}
	.site-main article .wrap_normal {
		margin-bottom: 8px;
		height: 100%;
	}
	.site-main article .wrap_normal .movie_container .movie_image {
		width: auto;
	}
	.site-main article .wrap_normal .movie_container .movie_information  {
		width: auto;
	}
	.movie_title {
    	max-height: 100%;
   		display: inline-block;
	}
}
</style>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="wrap_normal">

		<div class="post_description">

				<div class="movie_container">
					<div id="movie_title"><a href="<?php echo home_url(); ?>/news/<?php echo $post->post_name; ?>" class="movie_title"><?php the_title( '', '' ); ?></a></div>
					<?php if(wp_get_attachment_image_src( get_post_thumbnail_id( ), 'large' )[0] != '') { ?>
					<a href="<?php echo home_url(); ?>/news/<?php echo $post->post_name; ?>" class="movie_image" style="height: 125px!important; overflow: hidden;">
						<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( ), 'large' )[0]; ?>" alt="<?php the_title( '', '' ); ?>" title="<?php the_title( '', '' ); ?>" class="image">
					</a>
					<?php } ?>
					<div class="movie_information <?php if(wp_get_attachment_image_src( get_post_thumbnail_id( ), 'large' )[0] == '') { ?>width-100<?php } ?>">
						<div class="movie_description">
							<?php
										$categories        = wp_get_post_terms( get_the_ID(), 'genre', array("fields" => "all") );
										$categories_count  = count($categories);
										$categories_val    = 1;
										$categories_string = '';
										foreach ($categories as $value) {
											if ( $categories_val == $categories_count ) {
												$categories_string .= '<a href="'.home_url().'/genre/'.$value->slug.'/">'.$value->name.'</a>';
											} else {
												$categories_string .= '<a href="'.home_url().'/genre/'.$value->slug.'/">'.$value->name.'</a>, ';
											}
											$categories_val++;
										}
										$directed_by = get_post_meta(get_the_ID(), 'directed_by', true);
										$directed = explode(", ", $directed_by);
										foreach($directed as &$rejisori) {
											$rejisori = "<a href='".home_url()."/?s=".$rejisori."'>".str_replace(".", "", $rejisori)."</a>";
										}
										$rejisorebi = implode(", ", $directed);
										
										$casts_by = get_post_meta(get_the_ID(), 'actors', true);
										$casts_explode = explode(", ", $casts_by);
										foreach($casts_explode as &$casts_to) {
											$casts_to = "<a href='".home_url()."/?s=".$casts_to."'>".str_replace(".", "", $casts_to)."</a>";
										}
										$casts = implode(", ", $casts_explode);
							?>
							<?php if ( get_post_meta( get_the_ID(), 'movies_year', true ) != '' ) { ?>
							<div class="movie_desc_row"><div class="movie_desc_title"><?php echo __( 'Year:', 'goldmovies' ); ?></div><div class="movie_desc_content"><a href="<?php echo home_url(); ?>/?s=<?php echo get_post_meta(get_the_ID(), 'movies_year', true); ?>"><?php echo get_post_meta(get_the_ID(), 'movies_year', true); ?></a></div></div>
							<?php } ?>
							<?php if ( $categories_string != '' ) { ?>
							<div class="movie_desc_row">
								<div class="movie_desc_title"><?php echo __( 'Genre:', 'goldmovies' ); ?>:</div>
								<div class="movie_desc_content">
									<?php
										echo $categories_string;
									?>
								</div>
							</div>
							<?php } ?>
							<?php if ( get_post_meta( get_the_ID(), 'directed_by', true ) != '' ) { ?>
							<div class="movie_desc_row"><div class="movie_desc_title"><?php echo __( 'Producer:', 'goldmovies' ); ?></div><div class="movie_desc_content"><?php echo $rejisorebi; ?></div></div>
							<?php } ?>
							<?php if ( get_post_meta( get_the_ID(), 'actors', true ) != '' ) { ?>
							<div class="movie_desc_row">
								<div class="movie_desc_title"><?php echo __( 'Actors:', 'goldmovies' ); ?></div>
								<span class="movie_desc_content float-none desc-actors">
									<?php echo $casts; ?>
								</span>
							</div>
							<?php } ?>
							<div class="movie_desc_row desc-info">
								<div class="movie_desc_title"><?php echo __( 'Description:', 'goldmovies' ); ?></div>
								<div class="movie_desc_content float-none description-of-movie"><?php echo mb_substr(strip_tags($post->post_content), 0, 250); ?> ...</div>
							</div>
							<?php if(get_post_meta(get_the_ID(), 'imdb_rating', true) != '') { ?>
							<div class="imdb-badge arrow"><span><?php echo get_post_meta(get_the_ID(), 'imdb_rating', true); ?></span></div>
							<?php } ?>
						</div>
					</div>
				</div>

		</div>
	</div>

</article><!-- #post-## -->
<?php } ?>