<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Pyfal
 * @since Pyfal 1.0
 */
 if ( is_active_sidebar( 'sidebar' ) ) : ?>

	<div id="secondary" class="secondary mdl-cell mdl-cell--12-col mdl-cell--4-col-desktop">
			<div id="widget-area" class="widget-area mdl-grid mdl-grid--no-spacing" role="complementary">
				<?php dynamic_sidebar( 'sidebar' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>

	</div><!-- .secondary -->

