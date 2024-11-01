<?php
	class TP_ADMIN_FIELDS{
		private $tp_general;
		private $tp_display;
		private $page_array;

		function __construct(){
			$this->tp_general = get_option( 'tp_general', array() );
			$this->tp_display = get_option( 'tp_display', array() );

			$args = array(
				'post_type'        => 'page',
				'post_status'      => 'publish',
			);
			$this->page_array = get_posts( $args );
		}
		
		public function my_tickets(){ ?>
			<select id="tp_my_tickets" name="tp_general[my-tickets]" >
				<option value=""><?php _e('Select Page','ticketpress'); ?></option>
				<?php
					foreach ($this->page_array as $page){
						echo '<option value="'.$page->ID.'" '.( ( isset( $this->tp_general['my-tickets'] ) && ( $this->tp_general['my-tickets'] == $page->ID ) )?'selected':'' ).' >'.$page->post_title.'</option>';
					}
				?>
			</select>			
		<?php }

		public function new_ticket(){?>
			<select id="tp_new_ticket" name="tp_general[new-ticket]" >
				<option value=""><?php _e('Select Page','ticketpress'); ?></option>
				<?php
					foreach ($this->page_array as $page){
						echo '<option value="'.$page->ID.'" '.( ( isset( $this->tp_general['new-ticket'] ) && ( $this->tp_general['new-ticket'] == $page->ID ) )?'selected':'' ).' >'.$page->post_title.'</option>';
					}
				?>
			</select>
		<?php
		}

		public function use_design(){
			echo '<input type="checkbox" id="tp_use_design" name="tp_display[not_use_design]" '.( isset($this->tp_display['not_use_design'] )?'checked':'' ).' />';
		}



		public function select_design(){ ?>
			<select id="tp_support_design" name="tp_display[support_design]" >
				<option value=""><?php _e('Select Style','ticketpress'); ?></option>
				<option value="1" <?php if( isset($this->tp_display['support_design']) && ($this->tp_display['support_design'] == 1) ){ echo 'selected'; } ?> ><?php _e('Style 1','ticketpress'); ?></option>
				<option value="2" <?php if( isset($this->tp_display['support_design']) && ($this->tp_display['support_design'] == 2) ){ echo 'selected'; } ?>><?php _e('Style 2','ticketpress'); ?></option>
			</select>
		<?php }
	}