<?php
	global $tp_error;

	function tp_load_template($template_name){
		$output = '';
			
		if ( !$file = locate_template( 'ticketpress/'.$template_name.'.php' ) ) {
		   $file =  TICKETPRESS_DIR . '/templates/'.$template_name.'.php';
		}	
		ob_start();
			load_template( $file );
			$output = ob_get_clean();
		ob_flush();

		return $output;
	}

	function get_operator_name(){
		$user_id = get_post_meta( get_the_ID(), 'assigned_to', true );
		$name = '';
		if($user_id){
			$user = get_userdata( $user_id );
			if($user){
				$name = $user->display_name;
			}else{
				$name = 'N/A';
			}
		}
		else{
			$name = 'N/A';
		}
		return $name;
	}

	function get_ticket_status(){
		global $post;
		$post_status_key = $post->post_status;
		if($post_status_key){
			$status = tp_get_nice_status($post_status_key);
		}else{
			$status = 'N/A';
		}
		return $status;
	}


	function tp_get_nice_status($key){
		$tp_labels = array(
			'tp_open' => __('Open','ticketpress'),
			'tp_closed' => __('Closed','ticketpress'),
			'tp_awaiting_reply' => __('Awaiting Reply','ticketpress'),
			'tp_resolved' => __('Resolved','ticketpress'),
		);
		return isset($tp_labels[$key])?$tp_labels[$key]:'N/A';
	}

	function get_ticket_error(){
		$errors = $GLOBALS['tp_frontview']->ticket_error;
		$error_messages = $errors->get_error_messages();
		return $error_messages;
	}


	function get_scope_name(){
		$scopes = wp_get_object_terms( get_the_ID(), 'tp-ticket-scope', array('fields' => 'names') );
		if($scopes){
			$scope = $scopes[0];
		}else{
			$scope = __('N/A','ticketpress');
		}
		return $scope;
	}


	function get_ticket_arguments(){
		global $tp_error;
		$user = wp_get_current_user();
		$role = array_pop($user->roles);
		
		$args = array (
			'post_type'              => 'tp-tickets'
		);

		if( $role == 'tp_operator' || $role == 'administrator' ){
                 /* Do nothing */
		}else{
			$args['author'] = get_current_user_id();
		}

		return $args;		
	}

	function tp_get_error_message(){
		global $tp_error;
		return $tp_error;
	}

	function is_ticket_visible(){
		global $post;
		$user = wp_get_current_user();
		$role = array_pop($user->roles);
		if(is_user_logged_in()){
			$visibility = get_post_meta( $post->ID, 'tp_ticket_visibility', true );
			if( $role == 'tp_operator' || $role == 'administrator' || ( get_current_user_id() == $post->post_author ) || $visibility ){
				return true;
			}
		}
		return false;
	}

	function tp_show_quicktags( $qtInit ) {
		$qtInit['buttons'] = 'link,strong,code,em,ul,li,olblock';
	 	return $qtInit;
	}
	add_filter('quicktags_settings', 'tp_show_quicktags');