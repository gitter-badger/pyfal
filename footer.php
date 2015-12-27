<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 */
 
get_sidebar(); ?>
	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer mdl-mini-footer" role="contentinfo">
		<div class="site-info mdl-mini-footer__left-section">
    		<div class="mdl-logo"><?php bloginfo( 'name' ); ?></div>
    		<ul class="mdl-mini-footer__link-list">
      			<li><a href="#">Help</a></li>
      			<li><a href="#">Privacy & Terms</a></li>
    		</ul>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->
	
</main>
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
