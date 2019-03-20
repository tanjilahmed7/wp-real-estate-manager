<?php
if ( ! class_exists('Wp_rem_tenant_request') ) {
    class Wp_rem_tenant_request {
      public function __construct() {

        add_action('wp_ajax_tenant_request', array( $this, 'tenant_request_callback' ), 11,1);
        add_action('wp_ajax_nopriv_tenant_request', array( $this, 'tenant_requestcallback' ), 11,1);
      }
			function tenant_request_callback(){
        if (!empty($_POST)) {
       extract($_POST);
       global $wpdb;
         $tenancy_requests = $wpdb->prefix.'tenant_list';
          $wpdb->insert( $tenancy_requests, array(
              'tenant_id' => $tenant_request_id,
              'property_owner_id' => $property_owner_id,
              'status' => $status,
              'property_id'=>$property_id,
            ),
              array( '%s' )
           );


                }

			}
    }
		global $wp_rem_tenant_request;
		$wp_rem_tenant_request = new Wp_rem_tenant_request();
		return $wp_rem_tenant_request;
}
 ?>
