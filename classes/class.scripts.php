<?php
	class TP_LOAD_SCRIPTS{
		private $tp_display;

		function __construct(){
			$this->tp_display = get_option( 'tp_display', array() );
			add_action('wp_enqueue_scripts',array($this,'load_front_script') );
		}

		public function load_front_script(){
			if(!isset($this->tp_display['not_use_design']) ){
				wp_register_style('tp-style', plugins_url( 'asset/css/style.css', dirname(__FILE__) ) );
				if( isset($this->tp_display['support_design']) && ($this->tp_display['support_design'] == 1) ){
					wp_enqueue_style('tp-style-1', plugins_url( 'asset/css/style-1.css', dirname(__FILE__) ),array('tp-style') );
				}else if( isset($this->tp_display['support_design']) && ($this->tp_display['support_design'] == 2) ){
					wp_enqueue_style('tp-style-2', plugins_url( 'asset/css/style-2.css', dirname(__FILE__) ),array('tp-style') );
				}else{
					wp_enqueue_style('tp-style');
				}
			}
		}
	}