<?php
	
	class TP_ADMIN_MANAGEMENT{
		function __construct(){
			add_action( 'admin_menu', array($this, 'register_ticketpress_menu') );
			add_action( 'init', array($this, 'tickets_page') );
			add_action( 'init', array($this,'register_ticket_status') );
			add_action( 'init', array($this,'register_ticket_scope') );
			add_action('admin_footer',array($this,'register_status_into_inline_edit') );
		}

		public function register_ticketpress_menu(){
			add_menu_page( 'ticketpress', 'TicketPress', 'manage_options', 'ticket-press', array($this,'tp_admin_settings'), 'dashicons-tickets',81 );
		}

		public function tickets_page(){
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
		
		public function register_ticket_status(){
			register_post_status( 'tp_open', array(
				'label'                     => _x( 'Open', 'ticketpress' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Open <span class="count">(%s)</span>', 'Open <span class="count">(%s)</span>' ),
			) );

			register_post_status( 'tp_resolved', array(
				'label'                     => _x( 'Resolved', 'ticketpress' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Resolved <span class="count">(%s)</span>', 'Resolved <span class="count">(%s)</span>' ),
			) );

			register_post_status( 'tp_awaiting_reply', array(
				'label'                     => _x( 'Awaiting Reply', 'ticketpress' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Awaiting Reply <span class="count">(%s)</span>', 'Awaiting Reply <span class="count">(%s)</span>' ),
			) );

			register_post_status( 'tp_closed', array(
				'label'                     => _x( 'Closed', 'ticketpress' ),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Closed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>' ),
			) );
		}

		public function register_ticket_scope() {
			$labels = array(
				'name'                       => _x( 'Scopes', 'Taxonomy General Name', 'ticketpress' ),
				'singular_name'              => _x( 'Scope', 'Taxonomy Singular Name', 'ticketpress' ),
				'menu_name'                  => __( 'Scope', 'ticketpress' ),
				'all_items'                  => __( 'All Scopes', 'ticketpress' ),
				'parent_item'                => __( 'Parent Scope', 'ticketpress' ),
				'parent_item_colon'          => __( 'Parent Scope:', 'ticketpress' ),
				'new_item_name'              => __( 'New Scope Name', 'ticketpress' ),
				'add_new_item'               => __( 'Add New Scope', 'ticketpress' ),
				'edit_item'                  => __( 'Edit Scope', 'ticketpress' ),
				'update_item'                => __( 'Update Scope', 'ticketpress' ),
				'view_item'                  => __( 'View Scope', 'ticketpress' ),
				'separate_items_with_commas' => __( 'Separate scopes with commas', 'ticketpress' ),
				'add_or_remove_items'        => __( 'Add or remove scopes', 'ticketpress' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'ticketpress' ),
				'popular_items'              => __( 'Popular Scopes', 'ticketpress' ),
				'search_items'               => __( 'Search Scopes', 'ticketpress' ),
				'not_found'                  => __( 'Not Found', 'ticketpress' ),
				'items_list'                 => __( 'Scopes list', 'ticketpress' ),
				'items_list_navigation'      => __( 'Scopes list navigation', 'ticketpress' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_in_menu'				 => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
				'show_in_quick_edit'		 => true
			);
			register_taxonomy( 'tp-ticket-scope', array( 'tp-tickets' ), $args );
		}

		public function register_status_into_inline_edit() {
			global $post;
			if( isset($post) && $post->post_type == 'tp-tickets'){					
					$open = ($post->post_status == 'tp_open' )?'selected':'';
					$closed = ($post->post_status == 'tp_closed' )?'selected':'';
					$awaiting = ($post->post_status == 'tp_awaiting_reply' )?'selected':'';
					$resolved = ($post->post_status == 'tp_resolved' )?'selected':'';
	
					$label = '<span id="post-status-display">'.tp_get_nice_status($post->post_status).'</span>';
					echo "<script>
					jQuery(document).ready( function() {
						jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"tp_open\" ".$open.">".__('Open','ticketpress')."</option>' );
						jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"tp_resolved\" ".$resolved." >".__('Resolved','ticketpress')."</option>' );
						jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"tp_awaiting_reply\" ".$awaiting." >".__('Awaiting Reply','ticketpress')."</option>' );
						jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"tp_closed\" ".$closed." >".__('Closed','ticketpress')."</option>' );
						jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"tp_open\" ".$open.">".__('Open','ticketpress')."</option>' );
						jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"tp_resolved\" ".$resolved." >".__('Resolved','ticketpress')."</option>' );
						jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"tp_awaiting_reply\" ".$awaiting." >".__('Awaiting Reply','ticketpress')."</option>' );
						jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"tp_closed\" ".$closed." >".__('Closed','ticketpress')."</option>' );";
					
					if( $post->post_status == 'tp_open' || $post->post_status == 'tp_closed' || $post->post_status == 'tp_resolved' || $post->post_status == 'tp_awaiting_reply' ){
						echo "jQuery('.misc-pub-section label').append(' ".$label."');";
					}
					echo "
					});
					</script>";
			}
		}

		public function tp_admin_settings() {
			$GLOBALS['tp_admin_settings']->admin_board();
		}

		
	}