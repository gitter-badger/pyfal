<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('mdl-cell mdl-cell--12-col'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title mdl-typography--headline">', '</h1>' );?>
	</header><!-- .entry-header -->
	<?php pyfal_entry_meta(); ?>
	<div class="entry-content mdl-typography--text-justify">
		<?php
			/* translators: %s: Name of current post */
			the_content();

			social_sharing_buttons();
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

</article><!-- #post-## -->
