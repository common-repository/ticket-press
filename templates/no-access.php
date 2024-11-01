<?php get_header(); ?>
	<div id="primary" class="content-area tp-tickets-wrapper">
		<main id="main" class="site-main tp-ticket-inner" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<header class="entry-header">
					<h2 class="entry-title" ><?php _e('The ticket is classified','ticketpress'); ?></h2>
				</header>
				<div class="entry-content">
					<div class="tp-alert">
						<p><?php _e('Sorry! User do not want to show this post','ticketpress'); ?></p>
					</div>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
		</main>
	</div>

<?php get_footer(); ?>

