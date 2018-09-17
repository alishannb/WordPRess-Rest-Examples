<?php 
	/**
	 * Plugin Name
	 *
	 * @package     PluginPackage
	 * @author      Ali Shan
	 * @copyright   2017 © CompanyName - All rights are reserved
	 * @license     GPL-2.0+
	 *
	 * @wordpress-plugin
	 * Plugin Name: WP Rest
	 * Plugin URI:  http://company.com
	 * Description: Description of the plugin.
	 * Version:     1.0.0
	 * Author:      Ali Shan
	 * Author URI:  http://company.com
	 * Text Domain: asb
	 * License:     GPL-2.0+
	 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
	 */
	
	
	
	// REF: https://torquemag.io/2015/06/adding-custom-routes-wordpress-rest-api/
	
	add_action('rest_api_init', function () {
	
		// demowp.com/wp-json/wp-rest/v1/testing
		register_rest_route('wp-rest/v1', 'testing',  array(
			'methods' => 'GET',
			'callback' => 'my_awesome_func',
		));
		
		
		//http://wptest.test/wp-json/wp-rest/v1/get_users
		register_rest_route('wp-rest/v1', 'get_users',  array(
			'methods' => 'GET',
			'callback' => 'namespace_return_users',
		));
		
		
		
		register_rest_route('wp-rest/v1', 'get_users_with_params/(?P<id>\d+)',  array(
			'methods' => WP_REST_Server::READABLE,
			'callback' => 'namespace_abc',
		));
		
		/*
		 *
		 *
		 register_rest_route( "{$root}/{$version}", '/products' . '/(?P<id>\d+)/(?P<number>[a-zA-Z0-9-]+', array(
      		array(
					 'methods'        		=> \WP_REST_Server::READABLE,
					 'callback'        		=> array( $cb_class, 'get_item' ),
					 'args'            		=> array(),
					 'permission_callback' 	=> array( $this, 'permissions_check' )
				  ),
			   )
			);
		 *
		 * */
		
	
	});
	
	function my_awesome_func(WP_REST_Request $request){
		
		$params = $request->get_params();
		
		
		return new WP_Error( 'rest_forbidden', esc_html__( 'This is my testing function. Throwing custom error.', 'my-text-domain' ), array( 'status' => 401 ) );
  
	}
	
	function namespace_return_users(WP_REST_Request $request){
		
		$record = get_users();
		
		return $record;
	}
	
	function namespace_abc(WP_REST_Request $request){
		
		$id = $request->get_param('id');
		
		if (! $id)
			$record = get_users();
		else
			$record = get_user_by('ID', $id);
		
		return $record;
	}