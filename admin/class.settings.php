<?php
	class TP_ADMIN_SETTINGS{
		function __construct(){
			add_action('admin_init', array($this,'tp_page_init') );
		}

		public function admin_board(){  
			$active_tab = 'general-settings';
			if( isset( $_GET[ 'tab' ] ) ) {
                $active_tab = $_GET[ 'tab' ];
            }
	    ?>
			<div class="wrap">
				<h2><i class="dashicons-before dashicons-tickets"></i> <?php _e('Support Press','ticketpress'); ?></h2>
				<?php settings_errors(); ?>
			</div>
			<h2 class="nav-tab-wrapper">
	            <a href="?page=ticket-press&tab=general-settings" class="nav-tab <?php echo $active_tab == 'general-settings' ? 'nav-tab-active' : ''; ?>"><?php _e('General Settings','ticketpress'); ?></a>
	            <a href="?page=ticket-press&tab=display-settings" class="nav-tab <?php echo $active_tab == 'display-settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Display Settings','ticketpress'); ?></a>
	        </h2>
	        <form method="post" enctype="multipart/form-data" action="options.php">
		        <?php
		            if( $active_tab == 'display-settings' ) {
		            	settings_fields( 'tp-displayOpt' );   
		            	do_settings_sections( 'tp-display' );
		            }else{
		            	settings_fields( 'tp-generalOpt' );   
		            	do_settings_sections( 'tp-general' );
		            }
		          	submit_button(); 
		        ?>
	        </form>
		<?php	}

		public function tp_page_init(){
			$this->tp_general_settings();
			$this->tp_display_settings();
		}

		function tp_validate_general_fields($input){ 
			add_settings_error(
		        'ticketpress-error',
		        esc_attr( 'settings_updated' ),
		        __( 'Settings successfully updated', 'ticketpress' ),
		        'updated'
		    );
			return $input;
		}

		function tp_validate_display_fields($input){ 
			add_settings_error(
		        'ticketpress-error',
		        esc_attr( 'settings_updated' ),
		        __( 'Settings successfully updated', 'ticketpress' ),
		        'updated'
		    );
			return $input;
		}

		function tp_general_settings(){
			register_setting(
		        'tp-generalOpt',
		        'tp_general',
		        array($this,'tp_validate_general_fields')
		    );
			
			add_settings_section(
		        'tp-general-section',
		        null,
		        null,
		        'tp-general'
		    );
		    
		    add_settings_field(
			    'tp_my_tickets',
			    '<label for="tp_my_tickets">'.__('My Tickets','ticketpress').'</label>',
			    array($GLOBALS['tp_admin_fields'],'my_tickets'),
			    'tp-general',
			    'tp-general-section' 
			);

			add_settings_field(
			    'tp_new_ticket',
			    '<label for="tp_new_ticket">'.__('New Ticket','ticketpress').'</label>',
			    array($GLOBALS['tp_admin_fields'],'new_ticket'),
			    'tp-general',
			    'tp-general-section' 
			);
		}

		function tp_display_settings(){
			register_setting(
		        'tp-displayOpt',
		        'tp_display',
		        array($this,'tp_validate_display_fields')
		    );

		    add_settings_section(
		        'tp-display-section',
		        null,
		       	null,
		        'tp-display'
		    );

			add_settings_field(
			    'tp_use_design',
			    '<label for="tp_use_design">'.__('I don\'t want to use your design','ticketpress').'</label>',
			    array($GLOBALS['tp_admin_fields'],'use_design'),
			    'tp-display',
			    'tp-display-section' 
			);

			add_settings_field(
			    'tp_design',
			    '<label for="tp_support_design">'.__('Select Design','ticketpress').'</label>',
			    array($GLOBALS['tp_admin_fields'],'select_design'),
			    'tp-display',
			    'tp-display-section' 
			);
		}

	}