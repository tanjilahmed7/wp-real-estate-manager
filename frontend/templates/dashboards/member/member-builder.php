<?php
/*
	Member Builder
*/

/**
 *
 */

if (!class_exists('Wp_rem_Bulider')) {
	class Wp_rem_Bulider
	{

		function __construct()
		{
			add_action('wp_ajax_wp_rem_report', array( $this, 'wp_rem_report_callback' ), 11);
      add_action('wp_ajax_nopriv_wp_rem_report_received', array( $this, 'wp_rem_report_received_callback' ), 11);

		}

		public function wp_rem_report_callback($member_id = ''){
			if(!empty($_POST['todate']) && !empty($_POST['fromdate'])){
				 $fromdate = $_POST['fromdate'];
				 $todate = $_POST['todate'];


            if ( ! isset($member_id) || $member_id == '' ) {
                $member_id = get_current_user_id();
            }

            $member_company_id = wp_rem_company_id_form_user_id($member_id);
            $args = array(
				'date_query' => array(
				       array(
				            'after'     => $fromdate,
				            'before'    => $todate,
				            'inclusive' => true,
				        ),
				),
                'post_type' => 'property_enquiries',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_enquiry_member',
                        'value' => $member_company_id,
                        'compare' => '=',
                    )
                ),
            );

            $enquiry_query = new WP_Query($args);
            //var_dump($enquiry_query);
        ?>
                <div class="element-title ">
                        <div class="report col-md-6">
                                <h4> My Report </h4>
                        </div>                           
                        <div class="all-enquires col-md-6">
                               <ul class="pull-right">
                                    <li class="user_dashboard_ajax" id="wp_rem_member_enquiries" data-queryvar="dashboard=enquiries"><a href="javascript:void(0);"><i class="icon-question_answer"></i>All Enquiries</a></li>
                               </ul>
                        </div>
                    <hr />
                </div>         
                    <div class="user-orders-list">                        
                        <ul class="orders-list enquiries-list" id="portfolio">                           
                            <?php if ( $enquiry_query->have_posts() ) : ?>

							<?php
						            while ( $enquiry_query->have_posts() ) : $enquiry_query->the_post();

						                $enquiry_property_id = get_post_meta(get_the_ID(), 'wp_rem_property_id', true);
						                $buyer_read_status = get_post_meta(get_the_ID(), 'buyer_read_status', true);
						                $seller_read_status = get_post_meta(get_the_ID(), 'seller_read_status', true);

						                if ( $type == 'my' ) {
						                    $member_name = get_post_meta(get_the_ID(), 'wp_rem_property_member', true);
						                    if ( $buyer_read_status == 1 ) {
						                        $read_unread = 'read';
						                    } else {
						                        $read_unread = 'unread';
						                    }
						                    $read_status = $buyer_read_status;
						                } else {
						                    $member_name = get_post_meta(get_the_ID(), 'wp_rem_enquiry_member', true);
						                    if ( $seller_read_status == 1 ) {
						                        $read_unread = 'read';
						                    } else {
						                        $read_unread = 'unread';
						                    }
						                    $read_status = $seller_read_status;
						                }
						                ?>

						                <li class="<?php echo esc_html($read_unread); ?>">
						                    <div class="img-holder">
						                        <figure>
						                            <?php
						                            if ( function_exists('property_gallery_first_image') ) {
						                                $gallery_image_args = array(
						                                    'property_id' => $enquiry_property_id,
						                                    'size' => 'thumbnail',
						                                    'class' => '',
						                                    'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
						                                );
						                                echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
						                            }
						                            ?>
						                        </figure>
						                    </div>
						                    <div class="orders-title">
						                        <h6 class="order-title"><a href="javascript:void(0);" onclick="javascript:wp_rem_enquiry_detail('<?php the_ID(); ?>', '<?php echo esc_html($type); ?>', '<?php echo esc_html($read_status); ?>');"><?php echo get_the_title($enquiry_property_id); ?></a><span>( #<?php echo get_the_ID(); ?> )</span></h6>
						                    </div>
						                    <div class="orders-date">
						                        <span><?php echo get_the_date('M, d Y'); ?></span>
						                    </div>
						                    <div class="orders-type">
						                        <span><a href="<?php echo get_the_permalink($member_name); ?>"><?php echo get_the_title($member_name); ?></a></span>
						                    </div>
						                </li>
						                <?php
						            endwhile;
						        ?>

                            <?php else: ?>
                                <li class="no-order-list-found">
                                    <?php
                                    if ( $type == 'received' ) {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_received_enquiry');
                                    } else {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_enquiry');
                                    }
                                    ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
		<?php
		die();
			}

		 ?>
          <div id="main">
                <div class="user-packages">
                    <div class="element-title">
                        	<div class="report">
                    				<h4> My Report </h4>
                        	</div>
                        <hr />
                    </div>

                    <div class="col-md-12">
						<div class="date_filter">
								<form action="" id="report-form" method="POST" enctype="multipart/form-data">

								  <div class="form-group col-md-6">
								    <label for="reportInput">From Date</label>
								    <input type="date" name="fromdate" class="form-control" id="reportInputFrom">
								  </div>

								  <div class="form-group col-md-6">
								    <label for="reportInput">To Date</label>
								    <input type="date" name="todate" class="form-control" id="reportInputTo">
								  </div>
								  <div class="from-group col-md-12">
								  	<br>
								  	<a href="javascript:void(0);"  id="myreport"  class="btn-submit"  type="submit"><?php echo 'Submit'; ?></a>
								  </div>


							</form>
						</div>
                    </div>


            	</div>
          </div>

		<?php
		}


		public function wp_rem_report_received_callback(){

		}
        public function render_view_enquiries($enquiry_query = '', $type = 'my') {
            $has_border = ' has-border';
            if ( $enquiry_query->have_posts() ) :
                $has_border = '';
            endif;

            $property_id = wp_rem_get_input('data_param', '');
            $property_title = '';
            if ( $property_id != '' ) {
                $property_title = get_the_title($property_id) . ' > ';
            }
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="element-title<?php echo wp_rem_allow_special_char($has_border); ?>">
                        <h4>
                            <?php
                            if ( $type == 'my' ) {
                                echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_recent');
                            } else {
                                echo $property_title . wp_rem_plugin_text_srt('wp_rem_member_enquiries_received_enquiries');
                            }
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="user-orders-list">
                        <ul class="orders-list enquiries-list" id="portfolio">
                            <?php if ( $enquiry_query->have_posts() ) : ?>
                                <?php echo force_balance_tags($this->render_list_item_view($enquiry_query, $type)); ?>
                            <?php else: ?>
                                <li class="no-order-list-found">
                                    <?php
                                    if ( $type == 'received' ) {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_received_enquiry');
                                    } else {
                                        echo wp_rem_plugin_text_srt('wp_rem_member_enquiries_not_enquiry');
                                    }
                                    ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
        }

	}

	global $wp_rem_bulider;
    $wp_rem_bulider = new Wp_rem_Bulider();
    return $wp_rem_bulider;
}

 ?>
