<?php get_header(); ?>
	<div id="primary" class="content-area tp-tickets-wrapper">
		<main id="main" class="site-main tp-ticket-inner" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h2 class="entry-title" ><?php echo get_the_title(); ?></h2>
					<div class="ticket-status">
						<span><?php echo __('Assigned to','ticketpress').': '.get_operator_name(); ?></span>
						<span><?php echo __('Status','ticketpress').': '.get_ticket_status(); ?></span>
						<span><?php echo __('Scope','ticketpress').': '.get_scope_name(); ?></span>
					</div>
				</header>
				<div class="entry-content">
					<?php echo get_the_content(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->
			<?php 
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
		endwhile;
		?>
		</main>
	</div>

<?php get_footer(); ?>
