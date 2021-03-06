<?php

/**
 *
 * Plugin Bootstrap Class.
 *
 * @package SPTP
 * @since   0.1.0
 *
 */
namespace SPTP;

class Bootstrap {


	/** @var Option */
	private $option;

	/** @var Rewrite */
	private $rewrite;

	/** @var Admin */
	private $admin;

	/** @var Permalink */
	private $permalink;

	public function __construct() {

		$this->setup();

		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'wp_loaded', array( $this, 'flush_rewrite_rules' ), 999 );

	}

	/**
	 *
	 * for activate and uninstall hooks.
	 *
	 */
	private function setup() {
		register_activation_hook( SPTP_FILE, array( $this, 'queue_flush_rewrite_rules' ) );
		register_deactivation_hook( SPTP_FILE, array( $this, 'deactivation' ) );
		register_uninstall_hook( SPTP_FILE, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 *
	 * Delete SPTP options.
	 *
	 */
	public static function uninstall() {
		delete_option( 'sptp_queue_flush_rewrite_rules' );
		delete_option( 'sptp_options' );
	}

	/**
	 *
	 * initialize.
	 *
	 */
	public function plugins_loaded() {

		load_plugin_textdomain( 'sptp', false, dirname( plugin_basename( SPTP_FILE ) ) . SPTP_LANG_DIR );

		$this->load_modules();

	}


	/**
	 *
	 * Load Plugin modules.
	 *
	 */
	private function load_modules() {

		do_action( 'sptp_before_load_modules' );

		$this->option    = apply_filters( 'sptp_module_option', new Option(), $this );
		$this->admin     = apply_filters( 'sptp_module_admin', new Admin( $this->option ), $this );
		$this->rewrite   = apply_filters( 'sptp_module_rewrite', new Rewrite( $this->option ), $this );
		$this->permalink = apply_filters( 'sptp_module_permalink', new Permalink( $this->option ), $this );

		$this->option->add_hooks();
		$this->admin->add_hooks();
		$this->rewrite->add_hooks();
		$this->permalink->add_hooks();

		do_action( 'sptp_after_load_modules' );

		do_action( 'sptp_modules_loaded' );
	}

	/**
	 *
	 * queue reset rewrite rules for next request.
	 *
	 */
	public function queue_flush_rewrite_rules() {
		update_option( 'sptp_queue_flush_rewrite_rules', 1 );
	}

	/**
	 *
	 *  Re-Create Rewrite Rules.
	 *
	 */
	public function flush_rewrite_rules() {
		if ( get_option( 'sptp_queue_flush_rewrite_rules' ) ) {
			flush_rewrite_rules();
			update_option( 'sptp_queue_flush_rewrite_rules', 0 );
		}
	}

	/**
	 *
	 *  Reset rules.
	 *
	 */
	public function deactivation() {
		$this->rewrite->reset_rewrite_rules();
		flush_rewrite_rules();
	}
}