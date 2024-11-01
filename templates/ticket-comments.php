<div id="comments" class="comments-area tp-ticket-comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One reply on &ldquo;%2$s&rdquo;', '%1$s replies on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'ticketpress' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h2>
		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
			?>
		</ol>
	<?php endif;?>
	<?php comment_form(); ?>
</div>
