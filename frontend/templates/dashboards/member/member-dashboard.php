	<?php

	/**
	* The template for displaying member dashboard
	*
	*/
	function cs_member_popup_style() {
	wp_enqueue_style('custom-member-style-inline', plugins_url('../../../../assets/frontend/css/custom_script.css', __FILE__));
	$cs_plugin_options = get_option('cs_plugin_options');
	$cs_custom_css = '#id_confrmdiv
	{
	display: none;
	background-color: #eee;
	border-radius: 5px;
	border: 1px solid #aaa;
	position: fixed;
	width: 300px;
	left: 50%;
	margin-left: -150px;
	padding: 6px 8px 8px;
	box-sizing: border-box;
	text-align: center;
	}
	#id_confrmdiv .button {
	background-color: #ccc;
	display: inline-block;
	border-radius: 3px;
	border: 1px solid #aaa;
	padding: 2px;
	text-align: center;
	width: 80px;
	cursor: pointer;
	}
	#id_confrmdiv .button:hover
	{
	background-color: #ddd;
	}
	#confirmBox .message
	{
	text-align: left;
	margin-bottom: 8px;
	}';
	wp_add_inline_style('custom-member-style-inline', $cs_custom_css);
	}

	add_action('wp_enqueue_scripts', 'cs_member_popup_style', 5);
	get_header();
	//editor
	wp_enqueue_style('jquery-te');
	wp_enqueue_script('jquery-te');

	//iconpicker
	wp_enqueue_style('fonticonpicker');
	wp_enqueue_script('fonticonpicker');
	wp_enqueue_script('wp-rem-reservation-functions');
	wp_enqueue_script('wp-rem-validation-script');
	wp_enqueue_script('wp-rem-members-script');
	wp_enqueue_script('wp-rem-google-map-api');
	wp_enqueue_script('jquery-latlon-picker');
	wp_enqueue_script('jquery-branches-latlon-picker');
	$post_id = get_the_ID();
	$user_details = wp_get_current_user();
	$display_name =$user_details->display_name;
	$LoginName = explode('@', $display_name);


	global $wp_rem_plugin_options;
	$user_company_id = get_user_meta($user_details->ID, 'wp_rem_company', true);
	$fullName = isset($user_company_id) && $user_company_id != '' ? get_the_title($user_company_id) : '';
	/* if ( is_super_admin() ) {
	$fullName = $userdata->display_name;
	} */
	$profile_image_id = $wp_rem_member_profile->member_get_profile_image($user_details->ID);
	$member_profile_type = get_user_meta($user_details->ID, 'wp_rem_member_profile_type', true);

	$user_type = get_user_meta($user_details->ID, 'wp_rem_user_type', true);
	$profile_description = $user_details->description;

	$MembersType = get_post_meta($user_company_id, 'wp_rem_member_profile_type', true);


	?>
	<div id="main">
	<div class="page-section account-header">
	<div class="container">
	    <?php
	    $member_profile_status = get_post_meta($user_company_id, 'wp_rem_user_status', true);
	    if ( $member_profile_status != 'active' ) {
	        ?>
	        <div class="user-message alert" style="background-color:#ff6767">
	            <p><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_profile_not_active'); ?></p>
	        </div>
	        <?php
	    }
	    ?>
	    <div class="row">
	        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 dashboard-sidebar-panel">
				<div class="dashboard-nav-panel">
					<button class="dashboard-nav-btn"><i class="icon-dashboard"></i></button>
					<div class="user-account-holder">
						<div class="user-info user-info-sidebar">
							<?php
							if ( isset($profile_image_id) && $profile_image_id !== '' ) {
								if ( is_numeric($profile_image_id) ) {
									$profile_image_id = wp_get_attachment_url($profile_image_id);
								}
							}
							if ( $profile_image_id == '' ) {
								$profile_image_id = wp_rem::plugin_url() . '/assets/frontend/images/member-no-image.jpg';
							}
							echo '
							<div class="img-holder">
								<figure><img src="' . esc_url($profile_image_id) . '" alt=""></figure>
							</div>';
							?>
							<div class="text-holder">
								<?php
								
								echo '<h3 class="user-full-name" style="letter-spacing:0px!important;" >' . $LoginName[0] . '</h3>';
								
								?>
								<p><?php echo force_balance_tags($profile_description); ?></p>
								<?php
								$change_pass_text = wp_rem_plugin_text_srt('wp_rem_member_dashboard_change_pass');
								if ( $user_type == 'team-member' ) {
									$change_pass_text = wp_rem_plugin_text_srt('wp_rem_member_dashboard_my_profile');
								}
								?>
								<div class="user_dashboard_ajax" id="wp_rem_member_change_password" data-queryvar="dashboard=change_pass"><a class="btn-change-password" href="javascript:void(0)"><?php echo esc_html($change_pass_text); ?></a></div>

							</div>
						</div>
					</div>
					<div class="user-account-nav user-account-sidebar">
						<div class="user-account-holder">
							<?php
							$active_tab = ''; // default tab
							$child_tab = '';
							$wp_rem_dashboard_page = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
							$wp_rem_dashboard_link = $wp_rem_dashboard_page != '' ? wp_rem_wpml_lang_page_permalink( $wp_rem_dashboard_page, 'page' ) : '';

							if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'account' ) { // for account settings active tab
								$active_tab = 'wp_rem_member_accounts';
							}
							?>
							<ul class="dashboard-nav">
								<?php
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'suggested' ) {
									$active_tab = 'wp_rem_member_suggested';
								}
								wp_enqueue_script('wp-rem-favourites-script');
								?>
								<li class="user_dashboard_ajax active" id="wp_rem_member_suggested" data-queryvar="dashboard=suggested"><a href="javascript:void(0);"><i class="icon-dashboard"></i>Suggested Ads</a></li>


								<?php
								$current_user = wp_get_current_user();
								$wp_rem_user_type = get_user_meta($current_user->ID, 'wp_rem_user_type', true);
								$member_id = wp_rem_company_id_form_user_id($current_user->ID);
								$member_profile_type = '';
								if ( $member_id != '' ) {
									$member_profile_type = get_post_meta($member_id, 'wp_rem_member_profile_type', true);
								}
								$args = array(
									'posts_per_page' => "1",
									'post_type' => 'properties',
									'post_status' => 'publish',
									'fields' => 'ids',
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
								$custom_query = new WP_Query($args);
								$total_properties = $custom_query->found_posts;
								wp_reset_postdata();



								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin'OR $member_profile_type == ' property_manager' &&
                                    $wp_rem_user_type == 'team-member' OR $member_profile_type == 'property_manager' && $wp_rem_user_type == 'supper-admin') {

									if (true === Wp_rem_Member_Permissions::check_permissions('properties') ) {

										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'properties' ) {
											$active_tab = 'wp_rem_member_properties';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_properties" data-queryvar="dashboard=properties"><a href="javascript:void(0);"><i class="icon-megaphone2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_my_prop'); ?></a></li>
										<?php
									}

								}

								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'tenant') {
									if (  true === Wp_rem_Member_Permissions::check_permissions('favourites') ) {
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'favourites' ) {
											$active_tab = 'wp_rem_member_favourites';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_favourites" data-queryvar="dashboard=favourites"><a href="javascript:void(0);"><i class="icon-heart5"></i><?php echo "Favorite Properties"; ?></a></li>
										<?php
									}
								}


								if ( $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR  $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin' OR  $member_profile_type == 'agency' && $wp_rem_user_type == 'team-member'){
									if (  true === Wp_rem_Member_Permissions::check_permissions('wp_rem_member_manage_properties') ) {
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'manage_properties' ) {
											$active_tab = 'wp_rem_member_manage_properties';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_manage_properties" data-queryvar="dashboard=wp_rem_member_manage_properties"><a href="ad-new-property/"><i class="icon-home"></i><?php echo "Create Properties"; ?></a></li>
										<?php
									 }
									}


								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member'OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'team-member'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('enquiries') ) {
										$args = array(
											'post_type' => 'property_enquiries',
											'post_status' => 'publish',
											'posts_per_page' => '1',
											'fields' => 'ids',
											'meta_query' => array(
												'relation' => 'AND',
												array(
													'key' => 'wp_rem_enquiry_member',
													'value' => $member_id,
													'compare' => '=',
												),
												array(
													'key' => 'buyer_read_status',
													'value' => 0,
													'compare' => '=',
												)
											),
										);

										$enquiry_query = new WP_Query($args);
										$total_enquiries = $enquiry_query->found_posts;
										wp_reset_postdata();
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'enquiries' ) {
											$active_tab = 'wp_rem_member_enquiries';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_enquiries" data-queryvar="dashboard=enquiries"><a href="javascript:void(0);"><i class="icon-question_answer"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_enquires'); ?></a><b class="label count-enquiries"><?php echo absint($total_enquiries); ?></b></li>

										<?php
									}
								}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'enquiries_received' ) {
										$data_param = isset($_REQUEST['data_param']) && $_REQUEST['data_param'] != '' ? $_REQUEST['data_param'] : '';
										$active_tab = 'wp_rem_member_received_enquiries';
										if ( $data_param != '' ) {
											$active_tab = 'wp_rem_member_received_enquiries_' . $data_param;
										}
										echo '<li class="user_dashboard_ajax" id="' . $active_tab . '" data-param="' . $data_param . '" data-queryvar="dashboard=enquiries_received" style="display: none;"><a href="javascript:void(0);"><i class="icon-enquiries"></i>' . wp_rem_plugin_text_srt('wp_rem_member_enquiries_received_enquiries') . '</a></li>';
									}
								}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('arrange_viewings') ) {
										$args = array(
											'post_type' => 'property_viewings',
											'post_status' => 'publish',
											'posts_per_page' => '1',
											'fields' => 'ids',
											'meta_query' => array(
												'relation' => 'AND',
												array(
													'key' => 'wp_rem_viewing_member',
													'value' => $member_id,
													'compare' => '=',
												),
												array(
													'key' => 'buyer_read_status',
													'value' => 0,
													'compare' => '=',
												)
											),
										);

										$order_query = new WP_Query($args);
										$total_inquiries = $order_query->found_posts;
										wp_reset_postdata();
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'viewings' ) {
											$active_tab = 'wp_rem_member_viewings';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_viewings" data-queryvar="dashboard=viewings"><a href="javascript:void(0);"><i class="icon-layers3"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_register_requested_viewings'); ?></a><b class="label count-viewings"><?php echo absint($total_inquiries); ?></b></li>
										<?php
									}
								}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'viewings_received' ) {
										$data_param = isset($_REQUEST['data_param']) && $_REQUEST['data_param'] != '' ? $_REQUEST['data_param'] : '';
										$active_tab = 'wp_rem_member_received_viewings';
										if ( $data_param != '' ) {
											$active_tab = 'wp_rem_member_received_viewings_' . $data_param;
										}
										echo '<li class="user_dashboard_ajax" id="' . $active_tab . '" data-param="' . $data_param . '" data-queryvar="dashboard=viewings_received" style="display: none;"><a href="javascript:void(0);"><i class="icon-layers3"></i>' . wp_rem_plugin_text_srt('wp_rem_member_viewings_received_viewings') . '</a></li>';
									}
								}

								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( true === Wp_rem_Member_Permissions::check_permissions( 'reviews' ) ) {
										if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'reviews' ) {
											$active_tab = 'wp_rem_publisher_reviews';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_publisher_reviews" data-queryvar="dashboard=reviews"><a href="javascript:void(0);"><i class="icon-star3"></i><?php echo wp_rem_plugin_text_srt('wp_rem_reviews_all_reviews_heading') ?></a></li>
										<?php
									}
								}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'tenant') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('alerts') ) {
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'alerts' ) {
											$active_tab = 'wp_rem_member_propertyalerts';
										}
										echo do_action('wp_rem_top_menu_member_dashboard', wp_rem_plugin_text_srt('wp_rem_member_dashboard_alerts_searches'), '<i class="icon-save"></i>');
									}
								}



								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'prop_notes' ) {
									$active_tab = 'wp_rem_member_prop_notes';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'hidden_properties' ) {
									$active_tab = 'wp_rem_member_hidden_properties';
								}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('property_notes') ) {
									?>
										<li class="user_dashboard_ajax" id="wp_rem_member_prop_notes" data-queryvar="dashboard=prop_notes"><a href="javascript:void(0);"><i class="icon-book2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_prop_notes_notes') ?></a></li>
									<?php }}
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('hidden_properties') ) {
								?>
								<li class="user_dashboard_ajax" id="wp_rem_member_hidden_properties" data-queryvar="dashboard=hidden_properties"><a href="javascript:void(0);"><i class="icon-block"></i><?php echo wp_rem_plugin_text_srt('wp_rem_hidden_properties') ?></a></li>
								<?php
									}
								}

								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin') {
									if ( true === Wp_rem_Member_Permissions::check_permissions('packages') ) {
										if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'packages' ) {
											$active_tab = 'wp_rem_member_packages';
										}
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_packages" data-queryvar="dashboard=packages"><a href="javascript:void(0);"><i class="icon-dropbox2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_packages'); ?></a></li>

										<?php
									}
								}

								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'packages' ) {
										?>
										<li class="user_dashboard_ajax" id="wp_rem_member_packages" data-queryvar="dashboard=packages"><a href="ad-new-property/"><i class="icon-home"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_create_properties'); ?></a></li>

										<?php
									}
								}




								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'packages' ) {
									$active_tab = 'wp_rem_member_packages';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'change_pass' ) {

									$active_tab = 'wp_rem_member_change_password';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'location' ) {
									$child_tab = 'wp_rem_member_change_locations';
									$active_tab = 'wp_rem_member_accounts';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'opening-hours' ) {
									$child_tab = 'wp_rem_member_opening_hours';
									$active_tab = 'wp_rem_member_accounts';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'team_members' ) {
									$active_tab = 'wp_rem_member_company';
								}

								?>

								<?php
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'tenant') {
								if ( true === Wp_rem_Member_Permissions::check_permissions('company_profile') ) {
									?><li class="user_dashboard_ajax" id="wp_rem_member_accounts" data-queryvar="dashboard=account"><a href="javascript:void(0);"><i class="icon-tools2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_account_stng'); ?></a></li>
								<?php } }?>

								<?php if ( $member_profile_type == 'landlord' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin'   ) {
									?><li class="user_dashboard_ajax" id="wp_rem_member_company" data-queryvar="dashboard=team_members"><a href="javascript:void(0);"><i class="icon-group"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_team_members'); ?></a></li>
										<?php } ?>

								<?php
								if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
								if ( true === Wp_rem_Member_Permissions::check_permissions('redeem_reward_points') ) {
									?><?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'redeem_reward_points' ) {
										$active_tab = 'wp_rem_landlord_redeem_reward_points';
									}
								 ?>
									<!-- <li class="user_dashboard_ajax " id="wp_rem_landlord_redeem_reward_points" data-queryvar="dashboard=redeem_reward_points"><a href="javascript:void(0);"><i class="icon-dashboard"></i><?php //echo wp_rem_plugin_text_srt('redeem_reward_points'); ?></a></li> -->
								<?php } }?>

                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('posted_requirements') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'posted_requirements' ) {
																			$active_tab = 'wp_rem_landlord_posted_requirements';
																		}
																	 ?>

                                    <li class="user_dashboard_ajax" id="wp_rem_landlord_posted_requirements" data-queryvar="dashboard=posted_requirements"><a href="javascript:void(0);"><i class="icon-mail"></i><?php echo 'Posted Requirements'; ?></a></li>
                                <?php } }?>


                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('tenant_list') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'tenant_list' ) {
																			$active_tab = 'wp_rem_landlord_tenant_list';
																		}
																	 ?>
                                     <li class="user_dashboard_ajax " id="wp_rem_landlord_tenant_list" data-queryvar="dashboard=tenant_list"><a href="javascript:void(0);"><i class="icon-list2"></i><?php echo 'Tenant List'; ?></a></li>
                                <?php } }?>




                                <?php

                                if ($member_profile_type == 'landlord' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'tenant' ) {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('statistics') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'statistics' ) {
																			$active_tab = 'wp_rem_landlord_statistics';
																		}
																	 ?>
                                     <li class="user_dashboard_ajax " id="wp_rem_landlord_statistics" data-queryvar="dashboard=statistics"><a href="javascript:void(0);"><i class="icon-eye2"></i><?php echo 'Statistics'; ?></a></li>
                                <?php } }?>


                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('my_questions') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'my_questions' ) {
																			$active_tab = 'wp_rem_landlord_my_questions';
																		}
																	 ?>
                                     <!-- <li class="user_dashboard_ajax " id="wp_rem_landlord_my_questions" data-queryvar="dashboard=my_questions"><a href="javascript:void(0);"><i class="icon-new-message"></i><?php echo 'My Questions'; ?></a></li> -->
                                <?php } }?>


                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('tenancy_requests') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'tenancy_requests' ) {
																			$active_tab = 'wp_rem_landlord_tenancy_requests';
																		}
																	 ?>
                                     <li class="user_dashboard_ajax " id="wp_rem_landlord_tenancy_requests" data-queryvar="dashboard=tenancy_requests"><a href="javascript:void(0);"><i class="icon-home"></i><?php echo 'Tenancy Requests'; ?></a></li>
                                <?php } }?>


                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('agents_following') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'agents_following' ) {
																			$active_tab = 'wp_rem_landlord_agents_following';
																		}
																	 ?>
                                      <!-- <li class="user_dashboard_ajax " id="wp_rem_landlord_agents_following" data-queryvar="dashboard=agents_following"><a href="javascript:void(0);"><i class="icon-list"></i><?php //echo 'Agents I’m following'; ?></a></li> -->
                                <?php } }?>


                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member' OR $member_profile_type == 'tenant') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('make_payment') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'make_payment' ) {
																			$active_tab = 'wp_rem_landlord_make_payment';
																		}
																	 ?>
                              <!--          <li class="user_dashboard_ajax " id="wp_rem_landlord_make_payment" data-queryvar="dashboard=make_payment"><a href="javascript:void(0);"><i class="icon-attach_money"></i><?php //echo 'Make Payment'; ?></a></li> -->
                                <?php } }?>




                                <?php
                                if ($member_profile_type == 'tenant' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('my_owners') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'my_owners' ) {
																			$active_tab = 'wp_rem_landlord_my_owners';
																		}
																	 ?>
                                       <li class="user_dashboard_ajax " id="wp_rem_landlord_my_owners" data-queryvar="dashboard=my_owners"><a href="javascript:void(0);"><i class="icon-user"></i><?php echo 'My Owners'; ?></a></li>
                                <?php } }?>

                                <?php
                                if ($member_profile_type == 'tenant' OR $member_profile_type == 'landlord'  OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('property_maintenance_requests') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'property_maintenance_requests' ) {
																			$active_tab = 'wp_rem_landlord_maintenance_requests';
																		}
																	 ?>
                                       <li class="user_dashboard_ajax " id="wp_rem_landlord_maintenance_requests" data-membertype="<?php echo $member_profile_type ?>" data-queryvar="dashboard=property_maintenance_requests"><a href="javascript:void(0);"><i class="icon-business_center"></i><?php echo 'Property Maintenance Requests'; ?></a></li>
                                <?php } }?>



                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('preferences') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'preferences' ) {
																			$active_tab = 'wp_rem_landlord_preferences';
																		}
																	 ?>
                                       <!-- <li class="user_dashboard_ajax " id="wp_rem_landlord_preferences" data-queryvar="dashboard=preferences"><a href="javascript:void(0);"><i class="icon-address-book"></i><?php //echo 'Preferences'; ?></a></li> -->
                                <?php } }?>




                                <?php
                                if ($member_profile_type == 'landlord' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member'OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin') {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('my_flags') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'my_flags' ) {
																			$active_tab = 'wp_rem_landlord_flag';
																		}
																	 ?>
                                       <li class="user_dashboard_ajax " id="wp_rem_landlord_flag" data-queryvar="dashboard=my_flags"><a href="javascript:void(0);"><i class="icon-minus"></i><?php echo 'My Flag'; ?></a></li>
                                <?php } }
								 ?>
								 <?php
								 if ($member_profile_type == 'landlord' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin') {
 										if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'add_property_manager' ) {
											$active_tab = 'wp_rem_add_property_manager';
										}
								?>
									<li class="user_dashboard_ajax " id="wp_rem_add_property_manager" data-queryvar="dashboard=add_property_manager"><a href="javascript:void(0);"><i class="icon-plus"></i>Add Property Manager</a></li>
								 <?php
									}
								?>

								<?php
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'properties' ) {
									$active_tab = 'wp_rem_member_properties';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'view_properties_assigned' ) {
									$active_tab = 'wp_rem_member_view_properties_assigned';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'view_maintenance_requests' ) {
									$active_tab = 'wp_rem_member_view_maintenance_requests';
								}
								if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'manage_communications' ) {
									$active_tab = 'wp_rem_member_manage_communications';
								}


								if ($user_type == 'property-member') {?>


										<li class="user_dashboard_ajax" id="wp_rem_member_view_properties_assigned" data-queryvar="dashboard=view_properties_assigned"><a href="javascript:void(0);"><i class="icon-list"></i> View properties assigned</a></li>
										<li class="user_dashboard_ajax" id="wp_rem_member_view_maintenance_requests" data-queryvar="dashboard=view_maintenance_requests"><a href="javascript:void(0);"><i class="icon-eye"></i>View Maintenance requests</a></li>
										<li class="user_dashboard_ajax" id="wp_rem_member_manage_communications" data-queryvar="dashboard=manage_communications"><a href="javascript:void(0);"><i class="icon-new-message"></i>Manage communications</a></li>
										<?php
									}?>
									<?php
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'bank_information' ) {
										$active_tab = 'wp_rem_member_bank_information';
									}
									if($member_profile_type=='landlord' && $wp_rem_user_type == 'supper-admin' || $member_profile_type=='tenant' && $wp_rem_user_type == 'supper-admin' || $member_profile_type=='builder' && $wp_rem_user_type == 'supper-admin' || $member_profile_type=='agency' && $wp_rem_user_type == 'supper-admin'){?>
										<li class="user_dashboard_ajax" id="wp_rem_member_bank_information" data-queryvar="dashboard=bank_information"><a href="javascript:void(0);"><i class="icon-list"></i> Bank Information</a></li>
									<?php
										}
									?>
									<?php
									if ( isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == 'role_choose' ) {
										$active_tab = 'wp_rem_member_role_choose';
									}
									if($member_profile_type == 'individual' ){?>
										<li class="user_dashboard_ajax" id="wp_rem_member_role_choose" data-queryvar="dashboard=role_choose"><a href="javascript:void(0);"><i class="icon-list"></i> Choose Your Role</a></li>
									<?php
										}
									?>

                                <?php
                                if ( $member_profile_type == 'builder' && $wp_rem_user_type == 'team-member'OR $member_profile_type == 'builder' && $wp_rem_user_type == 'supper-admin' OR $member_profile_type == 'agency' && $wp_rem_user_type == 'team-member'OR $member_profile_type == 'agency' && $wp_rem_user_type == 'supper-admin' ) {
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('report') ) {
                                    ?>
																		<?php  if ( isset( $_REQUEST['dashboard'] ) && $_REQUEST['dashboard'] == 'report' ) {
																			$active_tab = 'wp_rem_report';
																		}
																	 ?>
                                       <li class="user_dashboard_ajax " id="wp_rem_report" data-queryvar="dashboard=report"><a href="javascript:void(0);"><i class="icon-tools2"></i><?php echo 'Report'; ?></a></li>
                                <?php } }?>



								<li><a href="<?php echo esc_url(wp_logout_url(wp_rem_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-log-out"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_signout'); ?></a></li>
							</ul>
						</div>
					</div>
				</div>
	        </div>
	        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

	            <div class="user-account-holder loader-holder">
	                <div class="user-holder">
	                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                        <?php
	                        if ( ! isset($_REQUEST['dashboard']) || $_REQUEST['dashboard'] == '' ) {
	                            ?>
	                            <script>jQuery(document).ready(function (e) {
	                                    jQuery('#wp_rem_member_suggested>').trigger('click');
																		});
	                            </script>
	                        <?php } ?>
	                    </div>
	                    <?php ?>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	</div>

	<div class="page-section">
	<div class="container">
	    <div class="row">
	        <!-- warning popup -->
	        <div id="id_confrmdiv">
	            <div class="cs-confirm-container">
	                <i class="icon-sad"></i>
	                <div class="message"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_want_to_profile'); ?></div>
	                <a href="javascript:void(0);" id="id_truebtn"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_delete_yes'); ?></a>
	                <a href="javascript:void(0);" id="id_falsebtn"><?php echo wp_rem_plugin_text_srt('wp_rem_member_dashboard_delete_no'); ?></a>
	            </div>
	        </div>
	        <!-- end warning popup -->
	    </div>
	</div>
	</div>
	</div>
	<?php if ( $active_tab != '' ) {
	if(defined('ICL_LANGUAGE_CODE')){
	$lang_code = ICL_LANGUAGE_CODE;
	if( isset($_GET['wpml_lang']) && $_GET['wpml_lang'] != '' ){
		$lang_code = $_GET['wpml_lang'];
	}
	}

	?>
	<script type="text/javascript">
	var page_id_all = <?php echo isset($_REQUEST['page_id_all']) && $_REQUEST['page_id_all'] != '' ? $_REQUEST['page_id_all'] : '1' ?>;
	var lang_code = "<?php echo isset($lang_code) && $lang_code != '' ? $lang_code : '' ?>";
	jQuery(document).ready(function (e) {
		jQuery('#<?php echo esc_html($active_tab); ?>').trigger('click');
	    //window.setTimeout( show_child(), 1000 );
	});
	var count = 0;
	jQuery(document).ajaxComplete(function (event, request, settings) {
	    if (count == 2) {
	        jQuery('#<?php echo esc_html($child_tab); ?>').trigger('click');
	    }
	    count++;
	});

	function show_child() {
	    jQuery('#<?php echo esc_html($child_tab); ?>').trigger('click');
	}
	</script>
	<?php
	}

	get_footer();
