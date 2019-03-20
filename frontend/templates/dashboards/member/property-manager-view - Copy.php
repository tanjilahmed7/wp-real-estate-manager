<?php
    /**
     * propertymanager Data
     *
     */
    if ( ! class_exists('Wp_rem_PropertyManager') ) {
    
        class Wp_rem_PropertyManager {
    
            /**
             * Start construct Functions
             */
            public function __construct() {
              add_action('wp_ajax_wp_rem_member_view_properties_assigned', array( $this, 'wp_rem_member_view_properties_assigned_callback' ), 11,1);
              add_action('wp_ajax_nopriv_wp_rem_member_view_properties_assigned', array( $this, 'wp_rem_member_view_properties_assigned_callback' ), 11,1);
              add_action('wp_ajax_wp_rem_member_view_maintenance_requests', array( $this, 'wp_rem_member_view_maintenance_requests_callback' ), 11);
              add_action('wp_ajax_nopriv_wp_rem_member_view_maintenance_requests', array( $this, 'wp_rem_member_view_maintenance_requests_callback' ), 11);
              add_action('wp_ajax_wp_rem_member_manage_communications', array( $this, 'wp_rem_member_manage_communications_callback' ), 11);
              add_action('wp_ajax_nopriv_wp_rem_member_manage_communications', array( $this, 'wp_rem_member_manage_communications_callback' ), 11);
    
            }
    
            /**
             * peoperty manager flag
             */
            public function wp_rem_member_view_properties_assigned_callback($member_id = '') {
                global $wpdb;
                $user = wp_get_current_user()->ID;
 
                $assign_property = $wpdb->prefix.'assign_property';
                $tenant_list = $wpdb->prefix.'tenant_list';
                $assign_property_db = $wpdb->get_results( "SELECT * FROM $assign_property  WHERE property_manager = $user");

                ?>

                <div id="main">
                    <div class="user-packages">
                        <div class="element-title">
                            <h4>View Property Assaigned </h4>
                            <hr />
                        </div>
                        <div class="row mt-2">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Property</th>
                                        <th scope="col">Tenent</th>
                                        <th scope="col">Landlord</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php 
                                $counter = 0;
                                foreach ($assign_property_db as  $value) {
                                    $PropertyID = json_decode($value->property_id);
                                    foreach ($PropertyID as $id) {
                                       $posts = get_post( $id );
                                ?>
                                        <tr>
                                            <td><?php echo ++$counter; ?></td>
                                            <td><a href="<?php echo get_permalink($posts->ID); ?>"><?php echo $posts->post_title; ?></a></td>
                                            <td><?php echo $this->tenant($posts->ID); ?></td>
                                            <td><?php echo get_userdata($posts->post_author)->user_nicename; ?></td>
                                        </tr>

                                <?php
                                    }
                                }   
                            ?>                                 

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Property</th>
                                        <th scope="col">Tenent</th>
                                        <th scope="col">Landlord</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
<?php
    }
    public function wp_rem_member_view_maintenance_requests_callback($member_id='')
    {?>
<div id="main">
    <div class="user-packages">
        <div class="element-title">
            <h4>View Maintenance Requests </h4>
            <hr />
        </div>
        <div class="row mt-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Property</th>
                        <th scope="col">Message</th>
                        <th scope="col">Request By</th>
                        <th scope="col">Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">#6545</th>
                        <td> <img src="#" alt="property_image"> </td>
                        <td> <a href="#">Lorem Ipsam Lorem Ipsam</a> </td>
                        <td> <a href="#">Willoam</a> </td>
                        <td><input type="date" id="schedule"></td>
                    </tr>
                    <tr>
                        <th scope="row">#6545</th>
                        <td> <img src="#" alt="property_image"> </td>
                        <td> <a href="#">Lorem Ipsam Lorem Ipsam</a> </td>
                        <td> <a href="#">Willoam</a> </td>
                        <td><input type="date" id="schedule"></td>
                    </tr>
                    <tr>
                        <th scope="row">#6545</th>
                        <td> <img src="#" alt="property_image"> </td>
                        <td> <a href="#">Lorem Ipsam Lorem Ipsam</a> </td>
                        <td> <a href="#">Willoam</a> </td>
                        <td><input type="date" id="schedule"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Property</th>
                        <th scope="col">Message</th>
                        <th scope="col">Request By</th>
                        <th scope="col">Schedule</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php
}
public function tenant($id){
    global $wpdb;
    $tenant_list = $wpdb->prefix.'tenant_list';
    $tenant_list_db = $wpdb->get_results( "SELECT * FROM $tenant_list  WHERE property_id = $id");
    $TID = ($tenant_list_db[0]->tenant_id);
    $rr = get_userdata($TID);
    return $rr->user_nicename;
}
}
global $wp_rem_propertymanager;
$wp_rem_propertymanager = new Wp_rem_PropertyManager();
return $wp_rem_propertymanager;
}