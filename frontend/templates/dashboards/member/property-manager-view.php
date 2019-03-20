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
                            <table class="table table-hover list_properties_assigned">
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
                            </table>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready( function () {
                    $('.list_properties_assigned').DataTable({
                       scrollY: 400
                    });
                } );
                </script>
<?php
    }
    public function wp_rem_member_view_maintenance_requests_callback($member_id=''){


      if (!empty($_POST)) {
        global $wpdb;
        // var_dump($_POST);
        $maintenance_requests = $wpdb->prefix.'maintenance_requests';
        extract($_POST);

          $wpdb->update(
            $maintenance_requests,
            array(
              'schedule' => $schedule,
              'status' => $status
            ),
            array( 'id' => $id ),
            array(
              '%s'
            ),
            array( '%s' )
          );



      }



      ?>
<div id="main">
    <div class="user-packages">
        <div class="element-title">
            <h4>View Maintenance Requests </h4>
        </div>
        <div class="alert alert-success" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          <strong>Well done!</strong> Message Sent Successfully.
        </div>
        <div class="row mt-2">
            <table class="table table-hover" id="list_maintenance_requests">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Property</th>
                        <th scope="col">Request By</th>
                        <th scope="col">subject</th>
                        <th scope="col">Message</th>
                        <th scope="col">Status</th>
                        <th scope="col">Schedule</th>
                        <th scope="col">confirm Schedule </th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $userid = get_current_user_id();
                    global $wp_rem_plugin_options;

                    global $wpdb;
                    $counter=0;
                    $statusHTML='';
                    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}maintenance_requests WHERE property_manager_id = $userid ORDER BY id DESC", OBJECT );
                    // var_dump($results);
                    if (!empty((array) $results)) {
                      foreach ($results as $result ) {
                        $counter++;
                        $property = get_post( $result->property_id );
                        $property_post =get_post($property->ID);
                        $meta = get_post_meta( $property->ID );
                        $property_link = get_permalink( $result->property_id );
                        $tenant= get_user_by('id', $result->tenant_id);;

                        $statusHTML='<div class="form-group">
                            <label for="">Choose Status:</label>
                            <select class="form-control" id="req_status-'.$counter.'" style="height:32px; width:105px;" >
                                <option value="0">Pending</option>
                                <option value="1">Active</option>
                                <option value="2">In progress</option>
                              </select>
                        </div>';
                       $html="<tr><td>
                       ".$counter."
                       </td><td>
                       <a href='$property_link' target='_blank'>" . $property->post_title . "</a>
                       </td><td>
                       ".$tenant->display_name."
                       </td><td>
                       ".$result->subject."
                       </td><td>
                       ".$result->message."
                       </td><td>
                       ".$statusHTML."
                       </td><td>
                        <textarea class='form-control' id='schedule-$counter'></textarea>
                       </td>
                       <td>
                       <input type='hidden' id='req_id-$counter' value='$result->id' />
                       <button type='button' class='btn btn-primary schedule_form_class' id='schedule_form-$counter'>Confirm Schedule</button>
                       </td>
                       </tr>" ;
                       echo $html;
                      }
                    }
                    else {
                      echo "<p>No Request Found</p>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready( function () {
    $('#list_maintenance_requests').DataTable({
       scrollX: 1000
    });
} );
</script>

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
