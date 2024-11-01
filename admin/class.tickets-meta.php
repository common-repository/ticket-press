<?php
class TP_TICKETS_META {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function add_meta_box( $post_type ) {
		add_meta_box(
			'ticket_info',
			__( 'Ticket Info', 'ticketpress' ),
			array( $this, 'render_info_meta_box' ),
			'tp-tickets',
			'side',
			'high'
		);
	}

	public function render_info_meta_box( $post ) {
		wp_nonce_field( 'tp_render_info', 'tp_render_info_nonce' );

		$assigned_to = get_post_meta( $post->ID, 'assigned_to', true );
		$tp_ticket_visibility = get_post_meta( $post->ID, 'tp_ticket_visibility', true );
	?>
		<div class="operator-section operator-assign" >
			<label for="assigned-to"><?php _e('Assigned to','ticketpress'); ?>: 
				<select name="assigned_to" id="assigned-to" >
					<?php
						$ticket_operators = get_users( 'role=tp_operator' ); 
						if($ticket_operators){
							echo '<option value="">'.__('Select Ticket Operator','ticketpress').'</option>';
							foreach($ticket_operators as $operator){
								echo '<option value="'.$operator->ID.'" '.( ($operator->ID == $assigned_to)?'selected':'' ).'>'.esc_html($operator->display_name).'</option>';
							}
						}else{
							echo '<option>'.__('No operator found','ticketpress').'</option>';
						}
					?>
				</select>
			</label>			
		</div>

		<div class="ticket-section ticket-visibility" >
			<label for="ticket-visibility"><?php _e('Make it public','ticketpress'); ?>: 
				<input type="checkbox" id="ticket-visibility" name="tp_ticket_visibility" <?php echo ($tp_ticket_visibility)?'checked':''; ?> />
			</label>
		</div>
	<?php
	}

	public function save( $post_id ) {
		if ( ! isset( $_POST['tp_render_info_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tp_render_info_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'tp_render_info' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'tp-tickets' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		
		remove_action('save_post', array($this,'save') );
		if( ($_POST['post_status'] == 'publish') || ($_POST['hidden_post_status'] == 'publish') ){
			$post_status = 'tp_open';
		}else{
			$post_status = $_POST['post_status'] ;
		}

		$post_args = array(
			'ID' => $post_id,
			'post_status' => $post_status
		);

		wp_update_post( $post_args );

		add_action('save_post', array($this,'save') );

		update_post_meta( $post_id, 'assigned_to', $_POST['assigned_to'] );
		update_post_meta( $post_id, 'tp_ticket_visibility', $_POST['tp_ticket_visibility'] );
	}


}