<?php
/**
 * Landlord Data
 *
 */
if ( ! class_exists('Wp_rem_Landlord') ) {

    class Wp_rem_Landlord {

        /**
         * Start construct Functions
         */
        public function __construct() {

          add_action('wp_ajax_wp_rem_add_property_manager', array( $this, 'wp_rem_add_property_manager_callback' ), 11);
          add_action('wp_ajax_nopriv_wp_rem_add_property_manager', array( $this, 'wp_rem_add_property_manager_callback' ), 11);
          add_action('wp_ajax_wp_rem_landlord_flag', array( $this, 'wp_rem_landlord_flag_callback' ), 11);
          add_action('wp_ajax_nopriv_wp_rem_landlord_flag', array( $this, 'wp_rem_landlord_flag_callback' ), 11);
          add_action('wp_ajax_wp_rem_landlord_preferences', array( $this, 'wp_rem_landlord_preferences_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_preferences', array( $this, 'wp_rem_landlord_preferences_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_maintenance_requests', array( $this, 'wp_rem_landlord_maintenance_requests_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_maintenance_requests', array( $this, 'wp_rem_landlord_maintenance_requests_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_my_owners', array( $this, 'wp_rem_landlord_my_owners_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_my_owners', array( $this, 'wp_rem_landlord_my_owners_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_make_payment', array( $this, 'wp_rem_landlord_make_payment_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_make_payment', array( $this, 'wp_rem_landlord_make_payment_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_agents_following', array( $this, 'wp_rem_landlord_agents_following_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_agents_following', array( $this, 'wp_rem_landlord_agents_following_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_tenancy_requests', array( $this, 'wp_rem_landlord_tenancy_requests_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_tenancy_requests', array( $this, 'wp_rem_landlord_tenancy_requests_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_my_questions', array( $this, 'wp_rem_landlord_my_questions_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_my_questions', array( $this, 'wp_rem_landlord_my_questions_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_statistics', array( $this, 'wp_rem_landlord_statistics_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_statistics', array( $this, 'wp_rem_landlord_statistics_callback' ), 11,1);
          add_action('wp_ajax_wp_rem_landlord_tenant_list', array( $this, 'wp_rem_landlord_tenant_list_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_tenant_list', array( $this, 'wp_rem_landlord_tenant_list_callback' ), 11,1);

          add_action('wp_ajax_wp_rem_landlord_redeem_reward_points', array( $this, 'wp_rem_landlord_redeem_reward_points_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_redeem_reward_points', array( $this, 'wp_rem_landlord_redeem_reward_points_callback' ), 11,1);


          add_action('wp_ajax_wp_rem_landlord_posted_requirements', array( $this, 'wp_rem_landlord_posted_requirements_callback' ), 11,1);
          add_action('wp_ajax_nopriv_wp_rem_landlord_posted_requirements', array( $this, 'wp_rem_landlord_posted_requirements_callback' ), 11,1);


        add_action('wp_ajax_wp_rem_member_bank_information', array( $this, 'wp_rem_member_bank_information_callback' ), 11,1);
        add_action('wp_ajax_nopriv_wp_rem_member_bank_information', array( $this, 'wp_rem_member_bank_information_callback' ), 11,1);

        add_action('wp_ajax_wp_rem_member_role_choose', array( $this, 'wp_rem_member_role_choose_callback' ), 11,1);
        add_action('wp_ajax_nopriv_wp_rem_member_role_choose', array( $this, 'wp_rem_member_role_choose_callback' ), 11,1);



        }

        /**
         * Landlord flag
         */


        public function wp_rem_landlord_flag_callback($property_id = '') {
          $author_id = get_current_user_id();
          global $post, $wp_rem_html_fields, $wp_rem_form_fields;

           // $arg = array( 'post_type' => 'properties', 'author' => $author_id );
           // $get_author_post = get_posts( $arg );

           // echo "<pre>";
           //  print_r($get_author_post->ID);
           // echo "</pre>";


            $args = array(
                'post_type' => 'wp_rem_claims',
                'author' => $author_id
                );

            $the_query = new WP_Query( $args );
           // echo "<pre>";
           //  print_r($the_query);
           // echo "</pre>";
        ?>


          <div id="main">
                <div class="user-packages">
                    <div class="element-title">
                        <h4> My flag </h4>
                        <hr />
                    </div>
                  <table class="table" id="my_flag_table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Reasson</th>
                            <th>Date</th>
                    </thead>
                        <tbody>
                        </tr>
                        <?php if ( $the_query->have_posts() ) : ?>
                            <!-- pagination here -->
                            <!-- the loop -->
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <?php
                               $post_id = get_the_id();
                                $wp_rem_claimer_name              = get_post_meta( $post_id, 'wp_rem_claimer_name', true );
                                $wp_rem_flag_property_post_id     = get_post_meta( $post_id, 'wp_rem_flag_property_post_id', true );
                                $wp_rem_claimer_email             = get_post_meta( $post_id, 'wp_rem_claimer_email', true );
                                $wp_rem_claimer_reason            = get_post_meta( $post_id, 'wp_rem_claimer_reason', true );
                                $args = array (
                                    'post_type' => 'properties',
                                    'p'   => $wp_rem_flag_property_post_id
                                );
                                $get_post = get_posts($args);

                             ?>

                              <tr>
                                  <td>
                                    <?php
                                       foreach ($get_post as $postid) {
                                        ?>
                                            <a href="<?php echo get_permalink($postid->ID); ?>"><?php the_title(); ?></a>
                                        <?php
                                        }
                                    ?>
                                  </td>
                                  <td><?php echo $wp_rem_claimer_name; ?></td>
                                  <td><?php echo $wp_rem_claimer_email; ?></td>
                                  <td><?php echo $wp_rem_claimer_reason; ?></td>
                                  <td><?php echo get_the_date(); ?></td>
                              </tr>
                            <?php endwhile; ?>
                            <!-- end of the loop -->
                        </tbody>
                            <!-- pagination here -->

                            <?php wp_reset_postdata(); ?>



                        <?php endif; ?>
                    </table>
                </div>
          </div>
          <script type="text/javascript">
          $(document).ready( function () {
              $('#my_flag_table').DataTable({
              });
          } );
          </script>
          <?php
        }

        /**
         * Landlord preferences
         */
    public function wp_rem_landlord_preferences_callback($member_id = '1') {
      ?>
      <div id="main">
            <div class="user-packages">
                <div class="element-title">
                    <h4>Preferences </h4>
                    <hr />
                    [newsletter_form]
                    [newsletter_field name="email"]
                    [/newsletter_form]
                    <div class="row mt-2">
                      <div class="col-sm-12">
                      </div>
                    </div>

                </div>
            </div>
        </div>
      <?php
    }

    /**
     * Landlord Maintenance Requests
     */
     public function property_manager($property_id){
       global $wpdb;
       $user = wp_get_current_user()->ID;


     }
    public function wp_rem_landlord_maintenance_requests_callback($member_id = '') {
      // var_dump($_POST);
      extract($_POST);
      global $membertype;
      $userid = get_current_user_id();
      if (!empty($_POST)) {
        global $wpdb;
        $maintenance_requests = $wpdb->prefix.'maintenance_requests';
        extract($_POST);

        $assign_property = $wpdb->prefix.'assign_property';
        $property_manager = $wpdb->get_results( "SELECT * FROM $assign_property  WHERE property_id LIKE '%$property_id%'");
        $property_manager = $property_manager[0]->property_manager;
        $status = 0;//pending request
        $wpdb->insert(
          $maintenance_requests,
          array(
            'property_id' => $property_id,
            'tenant_id' => $tenant_id,
            'subject' => $subject,
            'message' => $message,
            'property_manager_id' =>$property_manager,
            'status' => $status
          ),
            array( '%s' )
         );
      }

      ?>
      <div id="main">
            <div class="user-packages">
                <div class="element-title">
                    <h4> Maintenance Requests</h4>
                    <?php if($membertype=="tenant"){ ?>
                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#request_maintenance" data-whatever="@mdo">Request Maintenance</button>
                    <?php } ?>
                    <div class="alert alert-success" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      <strong>Well done!</strong> Message Sent Successfully.
                    </div>

                      <div class="modal fade" id="request_maintenance" tabindex="-1" role="dialog" aria-labelledby="request_maintenanceLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="request_maintenanceLabel">Request For Maintenance</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form>

                                <div class="form-group">
                                    <label for="">Choose Property:</label>
                                    <select class="form-control"  name="property_id" id="property_id" style="height: 68px;" required="required">
                                        <option value="">--Select Property --</option>
                                        <?php
                                        global $wpdb;
                                        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}tenant_list WHERE tenant_id = $userid and status=1", OBJECT );
                                        if (!empty((array) $results)) {
                                          foreach ($results as $result ) {
                                            $requester= get_user_by('id', $result->tenant_id);
                                            $property = get_post( $result->property_id );?>
                                             <option value="<?php echo $property->ID; ?>"><?php echo $property->post_title; ?></option>
                                          <?php
                                            }
                                          }
                                         ?>

                                    </select>

                                </div>
                                <input type="hidden" id="membertype" value="<?php echo $membertype ?>" />
                                <input type="hidden" name="tenant" id="tenant_id"  value="<?php echo $results[0]->tenant_id;?>">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Subject:</label>
                                  <input type="text" class="form-control" id="subject">
                                </div>
                                <div class="form-group">
                                  <label for="message-text" class="col-form-label">Message:</label>
                                  <textarea class="form-control" id="message"></textarea>
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="maintenance_req_form" data-dismiss="modal" data-backdrop="false">Send message</button>
                            </div>
                          </div>
                        </div>
                      </div>



                    <table id="tenant_maintence_list" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Property</th>
                                <th>subject</th>
                                <th>Message</th>
                                <th>Schedule</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $userid = get_current_user_id();
                              global $wpdb;
                              $counter=0;
                              $statusHTML='';
                              $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}maintenance_requests WHERE tenant_id = $userid ORDER BY id DESC", OBJECT );
                              // var_dump($results);
                              if (!empty((array) $results)) {
                                foreach ($results as $result ) {
                                  $counter++;
                                  $property = get_post( $result->property_id );
                                  $property_post =get_post($property->ID);
                                  $meta = get_post_meta( $property->ID );
                                  $property_link = get_permalink( $result->property_id );
                                  if(0==$result->status){
                                    $statusHTML= '<div class="orders-status">
                                       <span class="orders-list" style="background-color: #ffba00;color:#fff;">Processing</span>
                                    </div>';
                                  }
                                  if(1==$result->status){
                                    $statusHTML= '<div class="orders-status">
                                       <span class="orders-list" style="background-color: green;color:#fff;">Solved</span>
                                    </div>';
                                  }
                                  if(2==$result->status){
                                    $statusHTML= '<div class="orders-status">
                                       <span class="orders-list" style="background-color: green;color:blue;">In progress</span>
                                    </div>';
                                  }
                                 $html="<tr><td>
                                 ".$counter."
                                 </td><td>
                                 <a href='$property_link' target='_blank'>" . $property->post_title . "</a>
                                 </td><td>
                                 ".$result->subject."
                                 </td><td>
                                 ".$result->message."
                                 </td><td>
                                 ".$result->schedule."
                                 </td><td>
                                 ".$statusHTML."
                                 </td>
                                 </tr>" ;
                                 echo $html;
                                }
                              }?>
                            </tbody>
                    </table>


                </div>
            </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function() {
            $("#property_id").select({
              maximumSelectionLength: 100,
              placeholder: "--Select a Property--",
            });
            $('#tenant_maintence_list').DataTable({
               scrollX: 1000
            });
          });
        </script>
      <?php
    }

    /**
     *  My Owners
     */
    public function wp_rem_landlord_my_owners_callback($member_id = '') {
      ?><style media="screen">
      hr {
        border: 2px solid black !important;
        border-radius: 5px!important;
        }
      </style>
      <div id="main">
            <div class="user-packages">
                <div class="element-title">
                    <h4> My Owners </h4>
                    <hr/>
                </div>

                <div class="row">

                  <table id="landlord_my_owners" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Owner Name</th>
                    <th>Property Title</th>
                    <th>Rent</th>
                    <th>Payment Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
              <?php
                $userid = get_current_user_id();
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}tenant_list WHERE tenant_id = $userid", OBJECT );

                if (!empty((array) $results)) {
                  foreach ($results as $result ) {

                    $requester= get_user_by('id', $result->tenant_id);
                    $property = get_post( $result->property_id );
                    $owner= get_user_by('id', $result->property_owner_id);
                    // var_dump($owner);
                    $property_post =get_post($property->ID);
                     $meta = get_post_meta( $property->ID );
                     $property_link = get_permalink( $result->property_id );
                     if($result->payment_status==0)
                     {
                      $payment_status = "Requested";
                     }
                     if($result->payment_status==1)
                     {
                      $payment_status = "Unpaid";
                     }
                     if($result->payment_status==2)
                     {
                      $payment_status = "Paid";
                     }
                     if($result->payment_status==3)
                     {
                       // var_dump($result->payment_status);
                      $payment_status = "Your Request Been Rejected";
                     }

                  if($result->payment_status==1)
                      $paypal_form= "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' target='_top'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='rehan.flyte@gmail.com'>
<input type='hidden' name='lc' value='US'>
<input type='hidden' name='item_name' value='Test Item'>
<input type='hidden' name='item_number' value='Test_1'>
<input type='hidden' name='amount' value='10.00'>
<input type='hidden' name='button_subtype' value='services'>
<input type='hidden' name='no_note' value='0'>
<input type='hidden' name='currency_code' value='USD'>
<input type='hidden' name='bn' value='PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest'>
<input type='submit' name='submit' value='Pay Now' alt='PayPal - The safer, easier way to pay online!'>
</form>
";
                   $html= "<tr><td>#".$result->id."</td><td>".$requester->data->display_name."</td><td><a href='$property_link' target='_blank'>" . $property->post_title . "</a></td><td>".$meta['wp_rem_property_price'][0]."</td><td>".$payment_status."</td><td>".$paypal_form."</td></tr>";

                   echo $html;
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
            $('#landlord_my_owners').DataTable({
            });
        } );
        </script>
      <?php
    }


    /**
     * make payment
     */
public function wp_rem_landlord_make_payment_callback($member_id = '') {
  ?>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Make payment </h4>
                <hr />
                <ul>
                  <li class="register-payment-gw-holder"<?php //echo ($is_updating === true ? ' style="display: none;"' : '') ?>>

                      <div class="dashboard-element-title">
                    <strong><?php echo wp_rem_plugin_text_srt('wp_rem_add_user_payment_info'); ?></strong>
                      </div>
                <?php
                ob_start();
                $_REQUEST['trans_id'] = 0;
                $_REQUEST['action'] = 'property-package';
                $_GET['trans_id'] = 0;
                $_GET['action'] = 'property-package';
                $trans_fields = array(
                    'trans_id' => 0,
                    'action' => 'property-package',
                    'back_button' => true,
                    'creating' => true,
                );
                do_action('wp_rem_payment_gateways', $trans_fields);
                $output = ob_get_clean();
                echo str_replace('col-lg-8 col-md-8', 'col-lg-12 col-md-12', $output);
                ?>
                        </li>
                      </ul>
                  </div>
              </div>
          </div>
        <?php
      }
      public function wp_rem_landlord_agents_following_callback($member_id = '') {
        ?><style media="screen">
        hr {
          border: 2px solid black !important;
          border-radius: 5px!important;
          }
        </style>
        <div id="main">
              <div class="user-packages">
                  <div class="element-title">
                      <h4>Following Agents </h4>
                      <hr/>
                      <div class="row">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Agent Name</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>#4896</td>
                          <td><a href="#"> Scott Pfaff</a></td>
                      </tr>
                      <tr>
                          <td>#4896</td>
                          <td><a href="#"> Scott Pfaff</a></td>
                      </tr>
                      <tr>
                          <td>#4896</td>
                          <td><a href="#"> Scott Pfaff</a></td>
                      </tr>


                  </tbody>
                  <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Agent Name</th>
                    </tr>
                  </tfoot>
              </table>

                      </div>

                  </div>
              </div>
          </div>
        <?php
      }

    public function wp_rem_landlord_tenancy_requests_callback($member_id = '') {

        if (!empty($_POST)) {
          global $wpdb;
          $tenancy_requests = $wpdb->prefix.'tenant_list';
          extract($_POST);
          if ($status==1) {
            $payment_status=1;//payment_status unpaid
            $wpdb->update(
              $tenancy_requests,
              array(
                'status' => $status,
                'payment_status'=>$payment_status
              ),
              array( 'ID' => $id ),
              array(
                '%s'
              ),
              array( '%s' )
            );
          }
          //if decline
          // if ($status==2) {
          //   // echo "string";
          //   $wpdb->delete( $wpdb->prefix.'tenant_list', array( 'ID' => $id ) );
          // }
          if($status==2){
            $payment_status=3;//payment status 3 for request reject
            $wpdb->update(
              $tenancy_requests,
              array(
                'status' => $status,
                'payment_status'=>$payment_status
              ),
              array( 'ID' => $id ),
              array(
                '%s'
              ),
              array( '%s' )
            );
          }

        }




      ?><style media="screen">
      hr {
        border: 2px solid black !important;
        border-radius: 5px!important;
        }
      </style>
      <div id="main">
            <div class="user-packages">
                <div class="element-title">
                    <h4>Tenancy Requests List</h4>
                </div>
                <div class="row">
                  <table id="tenancy_requests_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Property</th>
                    <th>Approve</th>
                </tr>
            </thead>


              <?php
                $userid = get_current_user_id();
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}tenant_list WHERE property_owner_id = $userid and status=0", OBJECT );
                if (!empty((array) $results)) {
                  foreach ($results as $result ) {
                    $requester= get_user_by('id', $result->tenant_id);
                    $property = get_post( $result->property_id );
                    $property_link = get_permalink( $result->property_id );
                    ?>

             <tbody>
                   <?php
                   $html= "<tr><td>#".$result->id."</td><td>".$requester->data->display_name."</td><td><a href='$property_link' target='_blank'>" . $property->post_title . "</a></td><td><a href='javascript:void(0);' data-req=".$result->id."  id='tenancy_approval'  class='btn-submit'>Approve</a><a href='javascript:void(0);'  id='tenancy_decline'  data-req=".$result->id."  class='btn-submit' style='background-color:red'>Decline</a></td></tr>";
                   echo $html;
                  }
                }
               ?>




            </tbody>
        </table>

                </div>
            </div>
        </div>

      <?php
      }


    public function wp_rem_landlord_my_questions_callback($member_id = '') {
      ?><style media="screen">
      hr {
        border: 2px solid black !important;
        border-radius: 5px!important;
        }
      </style>
      <div id="main">
            <div class="user-packages">
                <div class="element-title">
                    <h4>My Questions</h4>
                </div>
                <div class="row">

                    <form action="" method="POST" enctype="multipart/form-data">

                      <label for="area">Question</label>
                      <input type="text" id="area" name="areaname" placeholder="Question">


                      <a href="javascript:void(0);"  id="posted_requirements"  class="btn-submit"  type="submit"><?php echo 'Submit'; ?></a>


                    </form>
            </div>
        </div>
      <?php
      }



public function wp_rem_landlord_statistics_callback($member_id = '') {
  ?><style media="screen">
  hr {
    border: 2px solid black !important;
    border-radius: 5px!important;
    }
  </style>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Statistics</h4>
                <hr/>
            </div>
            <div class="popularpost">
                <?php
                $author = get_current_user_id();
                $args = array(
                    'post_type'     => 'properties',
                    'rating' => 1,
                    'author'        => $author
                );

                wpp_get_mostpopular( $args );
                ?>
            </div>
        </div>
    </div>
  <?php
  }

public function wp_rem_landlord_tenant_list_callback($member_id = '') {
  ?><style media="screen">
  hr {
    border: 2px solid black !important;
    border-radius: 5px!important;
    }
  </style>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Tenant List</h4>
                  <table id="landlord_tenant_list_table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tenent Name</th>
                                <th>Property Title</th>
                                <th>Rent</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $userid = get_current_user_id();
                            global $wpdb;
                            $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}tenant_list WHERE property_owner_id = $userid and status=1", OBJECT );

                            if (!empty((array) $results)) {
                              foreach ($results as $result ) {
                                $requester= get_user_by('id', $result->tenant_id);
                                $property = get_post( $result->property_id );
                                $property_post =get_post($property->ID);
                                $meta = get_post_meta( $property->ID );
                                $property_link = get_permalink( $result->property_id );
                               $html= "<tr><td>#".$result->id."</td><td>".$requester->data->display_name."</td><td><a href='$property_link' target='_blank'>" . $property->post_title . "</a></td><td>".$meta['wp_rem_property_price'][0]."</td></tr>";
                               echo $html;
                              }
                            }
                           ?>
                        </tbody>
                </table>
                <script type="text/javascript">
                $(document).ready( function () {
                    $('#landlord_tenant_list_table').DataTable({
                    });
                } );
                </script>
            </div>
        </div>
    </div>
  <?php
  }

public function wp_rem_landlord_posted_requirements_callback($member_id = '') {

  //js call back
//echo "Hello";
    if (!empty($_POST['area'])) {
      // var_dump($_POST);
      extract($_POST);
      if ( ! isset($member_id) || $member_id == '' ) {
          $member_id = get_current_user_id();
      }
          global $wpdb;
          // $charset_collate = $wpdb->get_charset_collate();

          $posted_requirements = $wpdb->prefix.'posted_requirements';
            // var_dump($posted_requirements);
         $wpdb->insert( $posted_requirements, array(
             'area' => $area,
             'subject' => $subject,
           ),
             array( '%s' )
          );

    }

    ?>
    <style media="screen">

    hr {
      border: 2px solid black !important;
      border-radius: 5px!important;
      }
    </style>
    <div id="main">
          <div class="user-packages">
              <div class="element-title">
                  <h4>Posted Requirement</h4>
                  <hr/>
              </div>
              <div class="row">

                  <form action="" method="POST" enctype="multipart/form-data">

                    <label for="area">Area</label>
                    <input type="text" id="area" name="areaname" placeholder="area name ..">

                    <label for="date">Posted Date</label>
                    <input type="date" id="posted_date" name="posted_date" placeholder="posted date">

                    <label for="subject">Subject</label>
                    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>


                    <a href="javascript:void(0);"  id="posted_requirements"  class="btn-submit"  type="submit"><?php echo 'Submit'; ?></a>


                  </form>
              </div>
          </div>
      </div>
    <?php
  }




public function wp_rem_landlord_redeem_reward_points_callback($member_id = '') {
  ?><style media="screen">
  hr {
    border: 2px solid black !important;
    border-radius: 5px!important;
    }
  </style>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Redeem Reward Points</h4>
                <hr/>
            </div>
            <div class="row">
              <div class="col-sm-12">
                Total pints: 1000pt<br />
                point Convertion rate : 100pt = $1
              </div>
              <table id="landlord_redeem_reward_points_table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Comments</th>
                <th>Points</th>
                <th> Expiry date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>
            <tr>
                <td>#4896</td>
                <td>Jonathon Luis</td>
                <td>Lorem ipsam Lorem ipsam</td>
                <td>61</td>
                <td>2011/04/25</td>
            </tr>

        </tbody>
    </table>

            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready( function () {
        $('#landlord_redeem_reward_points_table').DataTable({
        });
    } );
    </script>
  <?php
  }

public function wp_rem_add_property_manager_callback($member_id = '') {
    global $current_user, $wp_rem_plugin_options;
    $pagi_per_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard_pagination']) ? $wp_rem_plugin_options['wp_rem_member_dashboard_pagination'] : '';
    $member_id = wp_rem_company_id_form_user_id($current_user->ID);
    $posts_per_page = $pagi_per_page > 0 ? $pagi_per_page : 1;
    $posts_paged = isset($_REQUEST['page_id_all']) ? $_REQUEST['page_id_all'] : '';

    $args = array(
        'post_type' => 'properties',
        'posts_per_page' => $posts_per_page,
        'paged' => $posts_paged,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'wp_rem_property_member',
                'value' => $member_id,
                'compare' => '=',
            ),
            array(
                'key' => 'wp_rem_property_status',
                'value' => 'delete',
                'compare' => '!=',
            ),
        ),
    );

    $args = wp_rem_filters_query_args($args);
    $custom_query = new WP_Query($args);
    $total_posts = $custom_query->found_posts;
    $all_properties = $custom_query->posts;

    //var_dump($all_properties);

    $company_ID = get_user_meta(get_current_user_id(), 'wp_rem_company', true);
    $team_args = array(
        'role' => 'wp_rem_member',
        'meta_query' => array(
            array(
                'key' => 'wp_rem_company',
                'value' => $company_ID,
                'compare' => '='
            ),
            array(
                'relation' => 'AND',
                array(
                    'key' => 'wp_rem_user_type',
                    'compare' => '=',
                    'value' => 'property-member'
                ),
            ),
        ),
    );
    $team_members = get_users($team_args);


    if (!empty($_POST['property_id']) && !empty($_POST['property_manager_id'])) {
        $property_manager = $_POST['property_manager_id'];
        $property_id = $_POST['property_id'];
        $property_encode_id = json_encode($property_id);

        // Insert Assign Property row
        global $wpdb;
        $assign_property = $wpdb->prefix.'assign_property';
        $wpdb->insert(
            $assign_property,
            array(
                'property_owner' => $member_id,
                'property_manager' => $property_manager,
                'property_id' => $property_encode_id
            ),
            array(
                '%d',
                '%d',
                '%s'
            )
        );
    }


  ?>
  <style media="screen">

  hr {
    border: 2px solid black !important;
    border-radius: 5px!important;
    }
  </style>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Add Property Manager</h4>

            </div>
            <div class="row">
                <div class="alert alert-success" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  <strong>Well done!</strong> You successfully assign Property Manager.
                </div>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Property :</label>
                              <select name="property_id" id="property_id" class="js-example-basic-single form-control input-sm" multiple="multiple" style="height: 50%;" required="required">
                                <?php
                                    foreach ($all_properties as $key => $value) {
                                    ?>
                                        <option value="<?php echo $value->ID; ?>"><?php echo $value->post_title; ?></option>
                                    <?php
                                     }?>
                              </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Property Manager :</label>
                            <select class="form-control"  name="property_manager_id" id="property_manager_id" style="height: 68px;" required="required">
                                <option value="">--Select Property Manager--</option>
                                <?php foreach ($team_members as $key => $value) {
                                ?>
                                     <option value="<?php echo $value->ID; ?>"><?php echo $value->user_nicename; ?></option>
                                <?php
                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group pull-right">
                            <button onclick="javascript:void(0)" class="btn btn-primary btn-lg" id="assign_property_manager" type="submit" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".js-example-basic-single").select2({
        maximumSelectionLength: 100,
        placeholder: "--Select a Property--",
      });
    });
  </script>
<?php
}

public function wp_rem_member_bank_information_callback($member_id = ''){

  global $membertype;
  $userid = get_current_user_id();
  if (!empty($_POST)) {
    global $wpdb;
    $bank_info = $wpdb->prefix.'bank_info';
    extract($_POST);
    $cardNumber = hash('sha512', $cardNumber);
    $cvv = hash('sha512', $cvv);
    $wpdb->insert(
      $bank_info,
      array(
        'first_name' => $firstName,
        'last_name' => $lastName,
        'card_number' => $cardNumber,
        'expiry_date' => $expireDate,
        'cvv' =>$cvv
      ),
        array( '%s' )
     );
  }
?>
  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Bank Information</h4>
                <hr/>
            </div>
            <div class="row">
              <div class="alert alert-success" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <strong>Well done!</strong> Payment Information.
              </div>
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="col-md-6 col-12">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name ..">
                  </div>
                  <div class="col-md-6 col-12">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name ..">
                  </div>
                  <div class="col-12 col-md-12">
                    <label for="cardNumber">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter Card Number">
                  </div>
                  <div class="col-md-6 col-12">
                    <label for="expireDate">Expire Date</label>
                    <input type="text" id="expireDate" name="expireDate" placeholder="05/21">
                  </div>
                  <div class="col-md-6 col-12">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="CVV">
                  </div>


                  <a href="javascript:void(0);"  id="bankinfo"  class="btn-submit" style="margin-top:20px;"  type="submit"><?php echo 'Submit'; ?></a>


                </form>
            </div>
        </div>
    </div>
  <?php
}
public function wp_rem_member_role_choose_callback($member_id = ''){

  if (!empty($_POST['userrole'])){
  
      global $wp_rem_plugin_options;
      $user_details = wp_get_current_user();
      $user_company_id = get_user_meta($user_details->ID, 'wp_rem_company', true);
      $MembersType = get_post_meta($user_company_id, 'wp_rem_member_profile_type', true);

      // Update Profile Member for Individual *Facebook, Google Plus, Twitter, Linkdin*    
      $update_member = update_post_meta( $user_company_id, 'wp_rem_member_profile_type', $_POST['userrole'], $MembersType);
      echo '<script> window.location.href = "dashboard/?dashboard=suggested"; </script>';
  }

  ?>

  <div id="main">
        <div class="user-packages">
            <div class="element-title">
                <h4>Choose Your Role</h4>
                <hr/>
            </div>
            <div class="row">
              <div class="alert alert-success" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <strong>Well done!</strong> Your Role Created.
              </div>
                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="form-group col-md-6">
                    <label for="userrole">Select User Role</label>
                    <select class="form-control" id="userrole" required="required">
                      <option value="">-- Choose your Role --</option>
                      <option value="landlord">Landlord</option>
                      <option value="builder">Builder</option>
                      <option value="tenant">Tenant</option>
                      <option value="agency">Agent</option>
                    </select>
                  </div>


                  <a type="submit" href="javascript:void(0);"  id="user_role"  class="btn-submit" style="margin-top:27px;"><?php echo 'Submit'; ?></a>


                </form>
            </div>
        </div>
    </div>

  <?php
}
}
    global $wp_rem_landlord;
    $wp_rem_landlord = new Wp_rem_Landlord();
    return $wp_rem_landlord;
}
