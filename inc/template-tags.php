<?php
/**
 * Custom template tags for Pyfal
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 */

if ( ! function_exists( 'pyfal_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Pyfal 1.0
 */
function pyfal_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation mdl-grid mdl-grid--no-spacing mdl-cell mdl-cell--12-col" role="navigation">
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'pyfal' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'pyfal' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'pyfal_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Pyfal 1.0
 */
function pyfal_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		printf( '<span class="sticky-post">%s</span>', __( 'Featured', 'pyfal' ) );
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'pyfal' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment','code' ) ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time id="time-%5$s" class="entry-date published" datetime="%1$s">%2$s</time><span class="mdl-tooltip" for="time-%5$s"><time class="updated" datetime="%3$s">%4$s</time></span>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago',
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date(),
			get_the_ID() 
		);

		printf( '<small class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></small>',
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'code' ) ) ) {
		if ( is_singular() || is_multi_author() ) {
			printf( '<small class="byline"><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></small>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
			_x( 'Full size', 'Used before full size attachment link.', 'pyfal' ),
			esc_url( wp_get_attachment_url() ),
			$metadata['width'],
			$metadata['height']
		);
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<small class="comments-link">';
		/* translators: %s: post title */
		comments_popup_link( sprintf( __( 'Add Comment', 'pyfal' )) );
		echo '</small>';
	}
}
endif;


if ( ! function_exists( 'pyfal_sidebar_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Pyfal 1.0
 */
function pyfal_sidebar_meta() {
		if ( in_array( get_post_type(), array( 'post', 'code' ) ) ) {
			if ( is_singular() ) {
					$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'pyfal' ) );
				if ( $categories_list && pyfal_categorized_blog() ) {
					printf( '<small class="cat-links">%1$s</small>',
						$categories_list
					);
				}

				$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'pyfal' ) );
				if ( $tags_list ) {
					printf( '<small class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</small>',
						_x( 'Tags', 'Used before tag names.', 'pyfal' ),
						$tags_list
					);
				}
			}
		}
}
endif;


/**
 * Determine whether blog/site has more than one category.
 *
 * @since Pyfal 1.0
 *
 * @return bool True of there is more than one category, false otherwise.
 */
function pyfal_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'pyfal_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pyfal_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so pyfal_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pyfal_categorized_blog should return false.
		return false;
	}
}

if ( ! function_exists( 'pyfal_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Pyfal 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function pyfal_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '<span class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">arrow_backward</i></span> Previous', 'pyfal' ),
		'next_text' => __( 'Next <span class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">arrow_forward</i></span>', 'pyfal' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation mdl-grid mdl-grid--no-spacing mdl-cell mdl-cell--12-col" role="navigation">
		<div class="pagination loop-pagination mdl-cell mdl-cell--12-col">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'pyfal_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @since Pyfal 1.0
 */
function pyfal_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation mdl-cell mdl-cell--12-col" role="navigation">
		<div class="nav-links">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'pyfal' ) );
			else :
				previous_post_link( '%link', __( '<span class="meta-nav"><span class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">arrow_backward</i></span>Previous Post</span>', 'pyfal' ) );
				next_post_link( '%link', __( '<span class="meta-nav">Next Post<span class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">arrow_forward</i></span></span>', 'pyfal' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Flush out the transients used in {@see pyfal_categorized_blog()}.
 *
 * @since Pyfal 1.0
 */
function pyfal_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'pyfal_categories' );
}
add_action( 'edit_category', 'pyfal_category_transient_flusher' );
add_action( 'save_post',     'pyfal_category_transient_flusher' );


if ( ! function_exists( 'pyfal_get_link_url' ) ) :
/**
 * Return the post URL.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Pyfal 1.0
 *
 * @see get_url_in_content()
 *
 * @return string The Link format URL.
 */
function pyfal_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
endif;

//Remove emoji script on head 
//https://wordpress.org/support/topic/removing-emoji-code-from-header
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

//remove meta generator on head
//https://wordpress.org/support/topic/removing-meta-generator-wordpress
remove_action('wp_head', 'wp_generator');

/**
* Auto Thumbnail
*/
! defined( 'ABSPATH' ) and exit;
if ( ! function_exists( 'featured_image' ) ) {
	add_action( 'save_post', 'featured_image' );
	function featured_image() {
		if ( ! isset( $GLOBALS['post']->ID ) )
			return NULL;
		if ( has_post_thumbnail( get_the_ID() ) )
			return NULL;
		$args = array(
				'numberposts' => 1,
				'order' => 'ASC', // DESC for the last image
				'post_mime_type' => 'image',
				'post_parent' => get_the_ID(),
				'post_status' => NULL,
				'post_type' => 'attachment'
		);
		$attached_image = get_children( $args );
		if ( $attached_image ) {
			foreach ( $attached_image as $attachment_id => $attachment )
			set_post_thumbnail( get_the_ID(), $attachment_id );
		}
	}
}

/**
 * Custom Excerpt length and Remove […] string using Filters
 */
function new_excerpt_more( $more ) {
	return ' ';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length ) {
	return 26;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


//Apply CSS class to anchors 
function add_menuclass($ulclass) {
return preg_replace('/<a/', '<a class="menu-item mdl-navigation__link"', $ulclass, -1);
}
add_filter('wp_nav_menu','add_menuclass');

function comment_form_submit_button($button) {
	$button =
		'<button name="submit" type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="submit"><i class="material-icons" role="presentation">check</i></button>';
	return $button;
}
add_filter('comment_form_submit_button', 'comment_form_submit_button');

if ( ! function_exists( 'pyfal_related_post' ) ) :
/**
 * Display Related post by category.
 * http://www.wphats.com/get-related-post-category-wordpress-without-plugin/
 *
 * @since Pyfal 1.0
 */
	function pyfal_related_post(){
		echo '<div class="related-post mdl-cell mdl-cell--12-col">';
		global $post;
		$catArgs = array(
			'category__in'	=> wp_get_post_categories($post->ID),
			'showposts'	=> 4,//display number of posts
			'orderby'	=>'rand',//display random posts
			'post__not_in'	=> array($post->ID)
 		);

		$cat_post_query = new WP_Query($catArgs); 

		if( $cat_post_query->have_posts() ) { 
			while ($cat_post_query->have_posts()) : $cat_post_query->the_post();?>

		<div class="related-item"><a href="<?php the_permalink() ?>"> 

			<?php if ( has_post_thumbnail() ) :
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id,'medium', true);
		echo '<div class="post-thumbnail" style="background:url('.$thumb_url[0].') center / cover"></div>';
		else: 
		echo '<div class="post-thumbnail mdl-color--indigo-50"></div>';
		endif;?>
		 		 <?php the_title(); ?></a></div>
			<?php endwhile; 

		wp_reset_query(); }
		echo '</div>';
	}
endif;


//http://crunchify.com/how-to-create-social-sharing-button-without-any-plugin-and-script-loading-wordpress-speed-optimization-goal/
function social_sharing_buttons() {
	if(is_singular() || is_home()){
	
		// Get current page URL 
		$post_URL = get_permalink();
 
		// Get current page title
		$post_Title = str_replace( ' ', '%20', get_the_title());
		
		// Get Post Thumbnail for pinterest
		$post_Thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
 
		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$post_Title.'&amp;url='.$post_URL.'&amp;via=pyfal';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$post_URL;
		$googleURL = 'https://plus.google.com/share?url='.$post_URL;
		$bufferURL = 'https://bufferapp.com/add?url='.$post_URL.'&amp;text='.$post_Title;
		
		// Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$post_URL.'&amp;media='.$post_Thumbnail[0].'&amp;description='.$post_Title;
 
		// Add sharing button at the end of page/page content
		$var .= '<div class="social-sharer">';
		$var .= '<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect twitter mdl-color--blue-300" href="'.$twitterURL.'" target="_blank">Twitter</a>';
		$var .= '<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect facebook mdl-color--indigo-900" href="'.$facebookURL.'" target="_blank">Facebook</a>';
		$var .= '<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect googleplus mdl-color--orange-900" href="'.$googleURL.'" target="_blank">Google+</a>';
		$var .= '<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect buffer mdl-color--grey-900" href="'.$bufferURL.'" target="_blank">Buffer</a>';
		$var .= '<a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect pinterest mdl-color--red-900" href="'.$pinterestURL.'" target="_blank">Pin It</a>';
		$var .= '</div>';
		
		echo $var;
	}
}

/**
 * Custom header Logo
 */
function pyfal_customizer( $wp_customize ) {
    $wp_customize->add_section( 'pyfal_logo_section' , array(
    'title'       => __( 'Header Logo', 'pyfal' ),
    'priority'    => 30,
    'description' => __( 'Recomended : Use Transparen Background image and max-width image 64px or it will be cropped ', 'pyfal' ),
) );
$wp_customize->add_setting( 'pyfal_logo' );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pyfal_logo', array(
    'label'    => __( 'Logo', 'pyfal' ),
    'section'  => 'pyfal_logo_section',
    'settings' => 'pyfal_logo',
) ) );
}
add_action( 'customize_register', 'pyfal_customizer' );

/**
 * Widget Dashboard
 */
add_action( 'wp_dashboard_setup', 'pyfal_add_dashboard_widget' );
// call function to create our dashboard widget function prowp_add_dashboard_widget() {
function pyfal_add_dashboard_widget(){
    wp_add_dashboard_widget( 'pyfal_dashboard_widget',
	         'Pyfal Widget', 'pyfal_create_dashboard_widget' );
}
// function to display our dashboard widget content function prowp_create_dashboard_widget() {
function pyfal_create_dashboard_widget(){
    echo '<p>Hello World! This is my Dashboard Widget</p>';
}