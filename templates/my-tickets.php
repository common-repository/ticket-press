<div class="tp-tickets-wrapper my-tickets" >
	<?php
		$args = get_ticket_arguments();
		$tp_tickets_query = new WP_Query( $args );
		if ( $tp_tickets_query->have_posts() ) { ?>
			<table class="tp-table" >
				<thead>
					<tr>
						<th><?php _e('Ticket #','ticketpress'); ?></th>
						<th><?php _e('Ticket Name','ticketpress'); ?></th>
						<th><?php _e('Scope','ticketpress'); ?></th>
						<th><?php _e('Status','ticketpress'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						while ( $tp_tickets_query->have_posts() ) {
							$tp_tickets_query->the_post();
					?>
							<tr>
								<td># <?php echo get_the_ID(); ?></td>
								<td><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></td>
								<td><?php echo get_scope_name(); ?></td>
								<td><?php echo get_ticket_status(); ?>
								</td>
							</tr>
					<?php
						}
					?>
				</tbody>
			</table>
	<?php
		} else {
			echo '<div class="tp-alert tp-alert-error"><p>'.tp_get_error_message().'</p></div>';
		}
		wp_reset_postdata();
	?>
</div>