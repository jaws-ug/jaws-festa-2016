<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package JAWSFESTA 2016
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'jawsfesta' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content hentry">
					<h2>Comming soon...</h2>
					<p>これから、Facebookページ <a href="https://www.facebook.com/JawsFesta/" target="_blank">/JAWS Festa</a> とTwitter: <a href="https://twitter.com/jawsug_toukaido" target="_blank">@jawsug_toukaido</a> で告知をしていきます。<br>
					是非、フォローをお願いします！！</p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
