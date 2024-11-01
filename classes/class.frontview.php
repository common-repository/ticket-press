<?php
	class TP_FRONTVIEW{

		private $tp_general_option;

		public $ticket_error;

		function __construct(){
			$this->tp_general_option = get_option('tp_general');
			$this->ticket_error = new WP_Error;

			add_shortcode('my_tickets', array($this,'my_tickets') );
			add_shortcode('new_ticket', array($this,'new_ticket') );
			add_action('init',array($this,'grab_new_ticket') );
			add_filter( 'single_template', array($this,'set_ticket_single_template') );
			add_filter( 'comments_template', array($this,'tp_comment_template') );
		}

		public function my_tickets(){
			if(is_user_logged_in()){
				$output = tp_load_template('my-tickets');
			}else{
				$redirect = isset($this->tp_general_option['my-tickets'])?get_permalink($this->tp_general_option['my-tickets']):site_url();
				$output = '<div class="tp-alert tp-alert-error"></p>'.__('Sorry, you need to <a href="'.wp_login_url( $redirect ).'">log in</a> before viewing your tickets','ticketpress').'</p></div>';
			}
			
			return $output;
		}

		public function new_ticket(){
			if(is_user_logged_in()){
				$output = tp_load_template('new-ticket');
			}else{
				$redirect = isset($this->tp_general_option['new-ticket'])?get_permalink($this->tp_general_option['new-ticket']):site_url();
				$output = '<div class="tp-alert tp-alert-error"></p>'.__('Sorry, you need to <a href="'.wp_login_url( $redirect ).'">log in</a> before you add a new ticket','ticketpress').'</p></div>';
			}
			return $output;
		}

		public function set_ticket_single_template($single_template) {
		    global $post;
		    if ($post->post_type == 'tp-tickets') {
		    		if( is_ticket_visible() ){
		    			if ( !$single_template = locate_template( 'ticketpress/single-ticket.php' ) ) {
						   $single_template =  TICKETPRESS_DIR . '/templates/single-ticket.php';
						}		
		    		}else{
		    			$output = tp_load_template('no-access');
		    			echo $output;
		    		}
		    }
		     
		    return $single_template;
		}

		public function tp_comment_template($theme_template){
			global $post;
		    if ($post->post_type == 'tp-tickets') {
		    	if ( !$theme_template = locate_template( 'ticketpress/ticket-comments.php' ) ) {
				   $theme_template =  TICKETPRESS_DIR . '/templates/ticket-comments.php';
				}	
		    }
			return $theme_template;
		}

		public function grab_new_ticket(){
			
			if(isset($_POST['btn_tp_submit'])){
				$post_title = $_POST['post_title'];
				$post_content = $_POST['post_content'];
				$post_scope = $_POST['post_scope'];

				if(!$post_title){
					$title_error = __('Title for the ticket is missing','ticketpress');
					$this->ticket_error->add( 'error_post_title', $title_error );
				}

				if(!$post_content){
					$content_error = __('Problem in your ticket is missing','ticketpress');
					$this->ticket_error->add( 'error_post_title', $content_error );
				}

				if(!$post_scope){
					$content_error = __('Problem scope is missing','ticketpress');
					$this->ticket_error->add( 'error_post_scope', $content_error );
				}

				if(!$post_title || !$post_content || !$post_scope){ return false; }

				$new_ticket = apply_filters('tp_new_ticket', 
					array(
					  'post_title'    => $post_title,
					  'post_content'  => strip_tags($post_content,'<p><a><em><strong><code>'),
					  'post_type'     => 'tp-tickets',
					  'post_status'   => 'tp_open',
					  'post_author'   => get_current_user_id()
					)
				);

				do_action('tp_before_ticket_added');

				$post_id = wp_insert_post( $new_ticket );
				
				wp_set_object_terms( $post_id, $post_scope,'tp-ticket-scope');
				$redirect_url = false;
				if(isset($this->tp_general_option['my-tickets'])){
					$redirect_url = get_permalink( $this->tp_general_option['my-tickets'] );
				}

				$redirect_to = apply_filters('tp_redirect_after_save_to',$redirect_url);
				
				do_action('tp_after_ticket_added',$post_id);

				if($redirect_to){
					wp_redirect($redirect_to);
					exit();
				}

				
			}
		}
}