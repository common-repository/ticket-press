	<div class="tp-tickets-wrapper new-tickets" >
		<?php
			do_action('tp_form_start');
			get_title_field(array('placeholder'=>'Ticket Title'));
			get_scope_field();
			get_content_field();
			tp_submit_button();
			do_action('tp_form_end');
		?>
	</div>