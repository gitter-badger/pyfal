<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Pyfal
 * @since Pyfal 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class('pyfal'); ?>>
<div id="page" class="hfeed site mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<header id="masthead" class="site-header mdl-layout__header mdl-layout__header--waterfall" role="banner">
			<div class="site-branding mdl-layout__header-row">
				
							
<?php if ( get_theme_mod( 'pyfal_logo' ) ) : ?>
    			<div class='site-logo'>
        			<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'pyfal_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
    			</div>
<?php else : 
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title mdl-layout-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title mdl-layout-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description visuallyhidden"><?php echo $description; ?></p>
					<?php endif;
 endif;?>
				<div class="mdl-layout-spacer"></div>
				
				<form class="search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width" role="search" method="get"  action="<?php echo home_url( '/' ); ?>">
					<label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
						<i class="material-icons">search</i>
					</label>
					<div class="mdl-textfield__expandable-holder">
						<input placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" class="mdl-textfield__input" type="search" name="sample" id="search-field" />
					</div>
				</form><!-- .search-box-->
				
				<div class="navigation-container mdl-layout--large-screen-only">
				<nav class="navigation mdl-navigation">
					<?php
					//Custom display nav menu for applying mdl
					//https://css-tricks.com/snippets/wordpress/remove-li-elements-from-output-of-wp_nav_menu/ 
 					if ( has_nav_menu( 'primary' ) ) :
 						$menuprimary = array(
						'theme_location'  => 'primary',
						'container'       => false,
  						'echo'            => false,
  						'items_wrap'      => '%3$s',
  						'depth'           => 0,
					);
						// Primary navigation menu.
						echo strip_tags(wp_nav_menu($menuprimary), '<a>' );
					endif; ?>
				</nav>
				</div>
				
			</div><!-- .site-branding -->
		</header><!-- .site-header -->
		<div class="mdl-layout__drawer mdl-layout--small-screen-only">
			<span class="mdl-layout-title"><?php bloginfo( 'name' ); ?></span>
			<nav class="mdl-navigation">
				<?php
					//Custom display nav menu for applying mdl
					//https://css-tricks.com/snippets/wordpress/remove-li-elements-from-output-of-wp_nav_menu/ 
 					if ( has_nav_menu( 'drawer' ) ) :
 						$menudrawer = array(
							'theme_location'  => 'drawer',
							'container'       => false,
  							'echo'            => false,
  							'items_wrap'      => '%3$s',
  							'depth'           => 0,
						);
					// Primary navigation menu.
					echo strip_tags(wp_nav_menu($menudrawer), '<a>' );
 				endif; ?>
			</nav>
		</div>
  	<main class="mdl-layout__content">
		<div id="content" class="site-content mdl-grid">
