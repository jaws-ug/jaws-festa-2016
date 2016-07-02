<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package JAWSFESTA 2016
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses jawsfesta_header_style()
 * @uses jawsfesta_admin_header_style()
 * @uses jawsfesta_admin_header_image()
 */
function jawsfesta_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'jawsfesta_custom_header_args', array(
		'default-image'          => get_template_directory_uri() . '/images/default-image.png',
		'default-text-color'     => 'ffffff',
		'width'                  => 878,
		'height'                 => 400,
		'flex-height'            => true,
		'wp-head-callback'       => 'jawsfesta_header_style',
		'admin-head-callback'    => 'jawsfesta_admin_header_style',
		'admin-preview-callback' => 'jawsfesta_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'jawsfesta_custom_header_setup' );

if ( ! function_exists( 'jawsfesta_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see jawsfesta_custom_header_setup().
 */
function jawsfesta_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( HEADER_TEXTCOLOR === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // jawsfesta_header_style

if ( ! function_exists( 'jawsfesta_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see jawsfesta_custom_header_setup().
 */
function jawsfesta_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // jawsfesta_admin_header_style

if ( ! function_exists( 'jawsfesta_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see jawsfesta_custom_header_setup().
 */
function jawsfesta_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // jawsfesta_admin_header_image