<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	//Show thumbnails as background
	 if ( has_post_thumbnail() ) :
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id,'medium', true);
		echo '<div class="post-thumbnail" style="background:url('.$thumb_url[0].') center / cover"></div>';
		else: ?>
		<div class="post-thumbnail mdl-color--indigo-50"></div>
	<?php endif; ?>
	<div class="entry-content">
	<header class="entry-header"">
		<?php the_title( sprintf( '<h2 class="entry-title  mdl-typography--headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );?>
		<?php pyfal_entry_meta(); ?>
	</header><!-- .entry-header -->
		<?php the_excerpt();?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
