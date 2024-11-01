<?php
	add_action('tp_form_start','add_error_message');
	add_action('tp_form_start','tp_form_start');
	
	function add_error_message(){
		$errors = get_ticket_error();
		if($errors){
			echo '<div class="tp-alert-error"><ul>';
			foreach($errors as $error){
				echo '<li>'.$error.'</li>';
			}
			echo '</ul></div>';
		}
	}


	function tp_form_start(){
		echo '<form method="post" name="tp_ticket_form" >';
		wp_nonce_field( 'post_nonce', 'post_nonce_field' );
	}

	add_action('tp_form_end','tp_form_end');
	function tp_form_end(){
		echo '</form>';
	}

	function get_title_field($args=array()){
		$element ="";
		$defaults = array(
			'container' => false,
			  'container_class' => '',
			  'container_id' => '',
			  'element_class' => '',
			  'element_id' => '',
			  'placeholder' => '',
			  'content'	=> '',
			  'attr' => ''
		);
		$args = wp_parse_args( $args, $defaults );
		$container = '';
		if($args['container']){
			$container= '<div '.(($args['container_class'])?'class="'.$args['container_class'].'"':'').' '.(($args['container_id'])?'id="'.$args['container_id'].'"':'').' >';
		}
		$element .= '<input type="text" name="post_title" class="tp-ticket-title'.$args['element_class'].'" '.(($args['element_id'])?'id="'.$args['element_id'].'"':'').' '.(($args['placeholder'])?'placeholder="'.$args['placeholder'].'"':'').' '.(($args['content'])?'value="'.$args['content'].'"':'');
		$element .=' '.$args['attr'];
		$element .='/>';

		$container .= $element;

		if($args['container']){
			$container .= '</div>';
		}
		echo $container;
	}


	function get_content_field($args=array()){
		$defaults = array(
			'element_class' => '',
		  	'content'	=> '',
		);
		$args = wp_parse_args( $args, $defaults );

		wp_editor(
			$args['content'],
			'post_content',
			array(
				'media_buttons' => false,
				'editor_class'	=> $args['element_class'],
				'tinymce'		=> false
			)
		);
	}

	function get_scope_field($args=array()){
		$defaults = array(
			'container' => false,
			'container_class' => '',
			'container_id' => '',
			'element_class' => '',
			'element_id' => '',
			'placeholder' => '',
			'content'	=> '',
			'attr' => ''
		);
		$args = wp_parse_args( $args, $defaults );
		$element = '';
		$container = '';
		if( isset($args['container']) && $args['container'] ){
			$container= '<div '.(($args['container_class'])?'class="'.$args['container_class'].'"':'').' '.(($args['container_id'])?'id="'.$args['container_id'].'"':'').' >';
		}

		$element .= '<select name="post_scope" class="tp-ticket-scope'.$args['element_class'].'" '.(($args['element_id'])?'id="'.$args['element_id'].'"':'');
		$element .=' '.$args['attr'];
		$element .=' >';
		$element .='<option value="">'.__('Select Scope','ticketpress').'</option>';

		$args = array(
		    'hide_empty'        => false, 
		    'fields'            => 'all'
		);
		
		$terms = get_terms('tp-ticket-scope', $args);

		if($terms){
			foreach ($terms as $term){
				$element .='<option value="'.$term->slug.'">'.$term->name.'</option>';
			}
		}

		$element .='</select>';
		$container .= $element;

		if( isset($args['container']) && $args['container'] ){
			$container .= '</div>';
		}
		echo $container;
	}

	function tp_submit_button($args=array()){
		$defaults = array(
		  'container' => false,
		  'container_class' => '',
		  'container_id' => '',
		  'element_class' => '',
		  'element_id' => '',
		  'attr' => '',
		  'label' => __('Submit','ticketpress')
		);
		$args = wp_parse_args( $args, $defaults );
		$container = '';
		$element = '';
		if($args['container']){
			$container= '<div '.(($args['container_class'])?'class="'.$args['container_class'].'"':'').' '.(($args['container_id'])?'id="'.$args['container_id'].'"':'').' >';
		}

		$element .= '<button type="submit" name="btn_tp_submit" class="tp-submit-btn'.$args['element_class'].'" '.(isset($args['element_id'])?'id="'.$args['element_id'].'"':'').' '.(isset($args['placeholder'])?'placeholder="'.$args['placeholder'].'"':'');
		$element .=' '.$args['attr'];
		$element .='>';
		$element .= $args['label'];
		$element .= '</button>';

		$container .= $element;

		if($args['container']){
			$container .= '</div>';
		}
		echo $container;
	}

