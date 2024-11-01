<?php
	function tp_gather_up(){
		remove_role('sp_operator');
		add_role( 'tp_operator', 'Ticket Operator', array( 'read' => true, 'level_1' => true ) );
		add_role( 'tp_customer', 'Customer', array( 'read' => true, 'level_1' => true ) );
		$pages = tp_install_pages();
		
		if($pages){
			$settings = array(
				'page' => $pages,
				'styles' => array(
					'not_use_design' => 0
				)
			);
			tp_update_settings($settings);
		}
		
		tickets_page();
		flush_rewrite_rules();
	}

	function tp_install_pages(){
		$pages = array();
		$current_pages = get_option( 'tp_general');
		
		if( !$current_pages['my-tickets'] ){
			$my_tickets = array(
				'post_title'    => 'My Tickets',
				'post_content'  => '[my_tickets]',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id()
			);

			$pages['my-tickets'] = wp_insert_post( $my_tickets );
		}


		if( !$current_pages['new-ticket'] ){
			$new_ticket = array(
				'post_title'    => 'New Ticket',
				'post_content'  => '[new_ticket]',
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id()
			);

			$pages['new-ticket'] = wp_insert_post( $new_ticket );
		}

		return $pages;
	}

	function tp_update_settings($settings){
		update_option( 'tp_general', $settings['page'] );
		update_option( 'tp_display', $settings['styles'] );
	}


	function tickets_page(){
		$labels = array(
			'name'                  => _x( 'Tickets', 'Post Type General Name', 'tickets_page' ),
			'singular_name'         => _x( 'Ticket', 'Post Type Singular Name', 'tickets_page' ),
			'menu_name'             => __( 'Tickets', 'tickets_page' ),
			'name_admin_bar'        => __( 'Post Type', 'tickets_page' ),
			'parent_item_colon'     => __( 'Parent Ticket:', 'tickets_page' ),
			'all_items'             => __( 'Tickets', 'tickets_page' ),
			'add_new_item'          => __( 'Add New Ticket', 'tickets_page' ),
			'add_new'               => __( 'Add New', 'tickets_page' ),
			'new_item'              => __( 'New Ticket', 'tickets_page' ),
			'edit_item'             => __( 'Edit Ticket', 'tickets_page' ),
			'update_item'           => __( 'Update Ticket', 'tickets_page' ),
			'view_item'             => __( 'View Ticket', 'tickets_page' ),
			'search_items'          => __( 'Search Ticket', 'tickets_page' ),
			'not_found'             => __( 'Not found', 'tickets_page' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'tickets_page' ),
			'items_list'            => __( 'tickets list', 'tickets_page' ),
			'items_list_navigation' => __( 'ticket list navigation', 'tickets_page' ),
			'filter_items_list'     => __( 'Filter tickets list', 'tickets_page' ),
		);
		
		$rewrite = array(
			'slug'                  => 'tickets',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
			
		$args = array(
			'label'                 => __( 'Ticket', 'tickets_page' ),
			'description'           => __( 'ticketpress Tickets', 'tickets_page' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'comments', ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'menu_position'			=> 82,
			'rewrite'               => $rewrite,
		);

		register_post_type( 'tp-tickets', $args );
	}