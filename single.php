<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Pyfal
 * @since Pyfal 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area mdl-grid mdl-grid--no-spacing mdl-cell mdl-cell--12-col mdl-cell--8-col-desktop">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content' );
			
			// Previous/next post navigation.
			pyfal_post_nav();

			// Related Post by category
			pyfal_related_post();
			
		// End the loop.
		endwhile;
		
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			
		
		?>
	</div><!-- .content-area -->

<?php get_footer(); ?>
