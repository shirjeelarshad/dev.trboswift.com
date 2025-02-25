<?php

/*

FUNCTION LIST
1. user_posts()

*/
use Hybridauth\Hybridauth;


class framework_user extends framework_addlisting
{



	function handle_membership_expire()
	{

		global $wpdb;


		$args = array(
			'posts_per_page' => 100,
			'post_type' => 'listing_type',
			'orderby' => 'rand',
			'order' => 'asc',
			'fields' => 'ID',
			'meta_query' => array(
				array(
					'key' => 'ppt_subscription',
					'compare' => '!=',
					'value' => "",
				),
			)
		);


		$wp_custom_query = new WP_User_Query($args);

		if (count($wp_custom_query->results) > 0) {
			$tt = $wpdb->get_results($wp_custom_query->request, OBJECT);
			foreach ($tt as $u) {

				// CHECK IF EXPIRED
				// EXPIRED EMAIL ATTACHED
				$this->USER("membership_active", $u->ID);

			}
		}

	}




	function USER($action = 'add', $order_data)
	{

		global $userdata, $wpdb, $CORE;

		switch ($action) {



			case "set_offline_listings": {

				if (in_array(THEME_KEY, array("mj"))) {


					$SQL = "SELECT ID FROM " . $wpdb->base_prefix . "posts WHERE post_author = '" . $order_data . "' AND post_type = 'listing_type' AND post_status = 'publish'  LIMIT 100";

					$ores = $wpdb->get_results($SQL);
					if (!empty($ores)) {
						foreach ($ores as $row) {

							delete_post_meta($row->ID, "online");

						}
					}
				}

			}
				break;


			case "set_online_listings": {

				if (in_array(THEME_KEY, array("mj"))) {


					$SQL = "SELECT ID FROM " . $wpdb->base_prefix . "posts WHERE post_author = '" . $order_data . "' AND post_type = 'listing_type' AND post_status = 'publish'  LIMIT 100";
					$ores = $wpdb->get_results($SQL);
					if (!empty($ores)) {
						foreach ($ores as $row) {

							update_post_meta($row->ID, "online", date('Y-m-d H:i:s'));

						}
					}
				}

			}
				break;


			case "smiles": {

				return array("angel", "angry", "cap", "clown", "confused", "cool", "crying", "cyber", "depression", "dislike", "eyeglass", "gay", "geek", "happy", "humor", "kiss", "laughing", "like", "love", "money", "mustache", "punk", "robot", "security", "sleepi", "smarth", "smile", "star", "sunglass", "sunglass_2", "sunglass_3", "suprise", "tounge", "wink");

			}
				break;


			case "get_account_type": {

				$data = array("name" => "");


				if (in_array(THEME_KEY, array("es", "jb", "mj", "ll")) && $userdata->ID) {

					$mtype = get_user_meta($userdata->ID, 'user_type', true);

					if (THEME_KEY == "mj") {
						global $CORE_MICROJOBS;
						$accountTypes = $CORE_MICROJOBS->_user_types();
					} elseif (THEME_KEY == "es") {
						global $CORE_ESCORTTHEME;
						$accountTypes = $CORE_ESCORTTHEME->_escort_types();
					} elseif (THEME_KEY == "jb") {
						global $CORE_JOBS;
						$accountTypes = $CORE_JOBS->_user_types();
					} elseif (THEME_KEY == "ll") {
						global $CORE_LEARNING;
						$accountTypes = $CORE_LEARNING->_user_types();
					}

					foreach ($accountTypes as $key => $val) {

						if ($mtype == $key) {
							return array("name" => $val['name']);
						}

					}


				}



				return $data;

			}
				break;

			case "get_message_link": {


				if ($userdata->ID) {

					if (!$CORE->USER("membership_hasaccess", "msg_send")) {

						return 'href="javascript:void(0);" onclick="processUpgrade();"';

					} else {

						if (isset($GLOBALS['flag-singlepage'])) {
							global $post;

							return 'href="javascript:void(0);" onclick="processMessageSingle(' . $order_data . ',' . $post->ID . ');"';

						} else {

							return 'href="javascript:void(0);" onclick="processMessage(' . $order_data . ');"';

						}


					}

				} else {

					return 'href="javascript:void(0);" onclick="processLogin();"';

				}

			}
				break;

			case "get_membership_continue_button": {

				$k = $order_data;


				if ($userdata->ID) {

					$btn = $CORE->order_encode(array(
						"uid" => $userdata->ID,
						"amount" => _ppt('mem' . $k . '_price'),
						"order_id" => "SUBS-mem" . $k . "-" . $userdata->ID . "-" . rand(),
						"description" => _ppt('mem' . $k . '_name'),
						"recurring" => _ppt('mem' . $k . '_r'),
						"recurring_days" => _ppt('mem' . $k . '_duration'),
						"couponcode" => "",

					));

					$button = 'href="javascript:void(0);" onclick="processPayment(\'' . $btn . '\',\'' . _ppt('mem' . $k . '_price') . '\'); "';

				} else {

					$button = 'href="javascript:void(0)" onclick="processLogin(0, \'mem' . $k . '\');"';

				}


				return $button;

			}
				break;


			case "get_user_count_likes": {

				$total = 0;

				$SQL = "SELECT ID FROM " . $wpdb->base_prefix . "posts WHERE post_author = '" . $order_data . "' AND post_type = 'listing_type' AND post_status = 'publish'  LIMIT 100";
				$ores = $wpdb->get_results($SQL);
				if (!empty($ores)) {
					foreach ($ores as $row) {

						$total = $total + $CORE->USER("get_likes_count", $row->ID);

					}

				}

				return $total;


			}
				break;

			case "get_user_count_hits": {


				$total = 0;

				$SQL = "SELECT ID FROM " . $wpdb->base_prefix . "posts WHERE post_author = '" . $order_data . "' AND post_type = 'listing_type' AND post_status = 'publish'  LIMIT 100";
				$ores = $wpdb->get_results($SQL);
				if (!empty($ores)) {
					foreach ($ores as $row) {

						$hits = get_post_meta($row->ID, "hits", true);
						if (!is_numeric($hits)) {
							$hits = 0;
						}

						$total = $total + $hits;

					}

				}

				return $total;


			}
				break;



			case "update_user_free_membership_addon": {

				// MAKE SURE ITS EANBELD
				if (_ppt(array('mem', 'enable')) != 1) {
					return;
				}


				// LISTINGS
				if ($order_data[0] == "listings" && $CORE->USER("membership_hasaccess", "listings")) {

					$c = get_user_meta($order_data[1], "free_listings_count", true);

					if (is_numeric($c)) {

						update_user_meta($order_data[1], "free_listings_count", ($c - 1));
					}

				} elseif ($order_data[0] == "listings_max" && $CORE->USER("membership_hasaccess", "listings_max")) {

					$c = get_user_meta($order_data[1], "free_listings_max_count", true);

					if (is_numeric($c)) {

						update_user_meta($order_data[1], "free_listings_max_count", ($c - 1));
					}

				} elseif ($order_data[0] == "max_msg" && $CORE->USER("membership_hasaccess", "max_msg")) {

					$c = get_user_meta($order_data[1], "max_msg_count", true);

					if (is_numeric($c)) {

						update_user_meta($order_data[1], "max_msg_count", ($c - 1));
					}

					if (($c - 1) < 1) {
						return false;
					}

				} elseif ($order_data[0] == "downloads") {


					// CHECK IF DOWNLOAD HAS BEEN DONE BEFORE
					$order_key_id = $this->ORDER("check_exists", "FREE-" . $order_data[2]);
					if (!is_numeric($order_key_id)) {

						// 3. ADD NEW ORDER/INVOICE
						$ex = $CORE->ORDER("add", array(
							"order_id" => "FREE-" . $order_data[2],
							"order_status" => 1, // pending
							"order_total" => 0,
							"order_userid" => $order_data[1],
							"order_postid" => $order_data[2],
							"order_description" => __("Free credit download", "premiumpress"),

						));

						$c = get_user_meta($order_data[1], "free_downloads_count", true);
						if (is_numeric($c)) {

							update_user_meta($order_data[1], "free_downloads_count", ($c - 1));
						}

					}


				}

				return true;


			}
				break;

			case "get_user_free_membership_addon": {

				if (!isset($order_data[1])) {
					return 0;
				}

				$c = 0;

				// GET CURRENT MEMBERSHIP
				$mymmem = $this->USER("get_user_membership", $order_data[1]);

				if ($order_data[0] == "listings") {

					// GET COUNT FROM USER PROFILE
					$c = get_user_meta($order_data[1], "free_listings_count", true);


					// ASSUME SICEN NOTHING WAS FOUND
					// THAT THEY DIDNT GET ADDED
					if (!is_numeric($c) || $c < 0) {

						$c = _ppt('mem' . $mymmem['key'] . '_listings_count');
						if (!is_numeric($c)) {
							$c = 0;
						}

						update_user_meta($order_data[1], "free_listings_count", $c);

					}

					return $c;


				} elseif ($order_data[0] == "listings_max") {

					// GET COUNT FROM USER PROFILE
					$c = get_user_meta($order_data[1], "free_listings_max_count", true);

					// ASSUME SICEN NOTHING WAS FOUND
					// THAT THEY DIDNT GET ADDED
					if (!is_numeric($c)) {

						$c = _ppt('mem' . $mymmem['key'] . '_listings_max_count');
						if (!is_numeric($c)) {
							$c = 0;
						}

						update_user_meta($order_data[1], "free_listings_max_count", $c);

					}

					return $c;

				} elseif ($order_data[0] == "max_msg") {

					// GET COUNT FROM USER PROFILE
					$c = get_user_meta($order_data[1], "max_msg_count", true);

					// ASSUME SICEN NOTHING WAS FOUND
					// THAT THEY DIDNT GET ADDED
					if (!is_numeric($c)) {

						$c = _ppt('mem' . $mymmem['key'] . '_max_msg_count');
						if (!is_numeric($c)) {
							$c = 0;
						}

						update_user_meta($order_data[1], "max_msg_count", $c);

					}

					if ($c < 1) {
						$c = 0;
					}

					return $c;

				} elseif ($order_data[0] == "downloads") {

					// GET COUNT FROM USER PROFILE
					$c = get_user_meta($order_data[1], "free_downloads_count", true);

					// ASSUME SICEN NOTHING WAS FOUND
					// THAT THEY DIDNT GET ADDED
					if (!is_numeric($c)) {

						$c = _ppt('mem' . $mymmem['key'] . '_downloads_count');
						if (!is_numeric($c)) {
							$c = 0;
						}

						update_user_meta($order_data[1], "free_downloads_count", $c);

					}

					return $c;

				}


			}
				break;



			case "check_identifier_exists": {


				if ($order_data == "") {
					return false;
				}

				// FIND OUT WHICH USERS HAVE ADDED ME TO THEIR LIST
				$my_list = array();

				$SQL = "SELECT user_id FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'sociallogin_identifier' AND meta_value LIKE '%\"" . $order_data . "\"%'  LIMIT 1 ";
				$result = $wpdb->get_results($SQL);
				if (empty($result)) {

					return false;
				}

				return array(

					"user_id" => $result[0]->ID,
					"user_email" => $CORE->USER("get_email", $result[0]->ID),

				);

			}
				break;

			case "get_this_membership": {


				$all_memberships = $CORE->USER("get_memberships", array());


				foreach ($all_memberships as $key => $m) {

					if ($m['key'] == $order_data || "mem" . $m['key'] == $order_data) {
						return $m;
					}

				}

				return array();

			}
				break;

			case "get_memberships": {

				// CHECK FOR CURRENT PLAN
				$dontshowkey = "";
				/*
							if($userdata->ID && !isset($GLOBALS['SHOWALLMEMS'])){		
							 
								$cm			= get_user_meta($userdata->ID,'ppt_subscription'); 
								if(is_array($cm) && isset($cm[0]) && _ppt($cm[0]['key'].'_repurchase') == "0" && !is_admin() ){
								 
								 $dontshowkey = $cm[0]['key'];					 
								 
								}					
							
							}*/



				// 0 = free
				// 1 = featured
				// 2 = sponsored

				$namesarray = array(
					0 => __("Basic", "premiumpress"),
					1 => __("Featured", "premiumpress"),
					2 => __("Sponsored", "premiumpress"),
				);

				$i = 1;
				$list = array();
				while ($i < 11) {

					// ENABLED
					if (_ppt('mem' . $i . '_enable') == 0) {
						$i++;
						continue;
					}

					// NAME
					if (_ppt('mem' . $i . '_name') == "" && $i < 3) {
						$name = $namesarray[$i];
					} elseif (_ppt('mem' . $i . '_name') == "" && $i > 4) {
						$i++;
						continue;
					} else {
						$name = _ppt('mem' . $i . '_name');
					}

					// PRICE
					if (_ppt('mem' . $i . '_price') == "") {
						$price = 0;
					} else {
						$price = _ppt('mem' . $i . '_price');

						// CONVERT TO LOCAL PRICE AMOUNT
						$price = hook_price(array($price, 0));

					}

					// DURATION
					if (_ppt('mem' . $i . '_duration') == "") {
						$duration = 0;
					} else {
						$duration = _ppt('mem' . $i . '_duration');
					}

					// RECURRING
					if (_ppt('mem' . $i . '_r') == 1) {
						$recurring = 1;
					} else {
						$recurring = 0;
					}

					// WORK OUR PRICE
					if (_ppt('mem' . $i . '_price') == 0) {
						$price_txt = __("FREE", "premiumpress");
					} else {
						$price_txt = hook_price(_ppt('mem' . $i . '_price'));
					}

					// DAY TEXT
					$daytext = "";
					switch ($duration) {
						case "1": {
							$daytext = "24 " . __("Hours Access", "premiumpress");
						}
							break;
						case "2": {
							$daytext = "48 " . __("Hours Access", "premiumpress");
						}
							break;
						case "7": {
							$daytext = "1 " . __("Week Access", "premiumpress");
						}
							break;
						case "30": {
							$daytext = "1 " . __("Month Access", "premiumpress");
						}
							break;
						case "365": {
							$daytext = "1 " . __("Year Access", "premiumpress");
						}
							break;
						default: {
							if (is_numeric($duration) && $duration > 0) {
								$daytext = $duration . " " . __("Days Access", "premiumpress");
							} else {
								$daytext = "";
							}
						}
					}

					// KEY 
					$key = _ppt('mem' . $i . '_key');
					if (!is_numeric($key)) {
						$key = $i;
					}



					// DESC
					$desc = _ppt('mem' . $i . '_desc');


					// BUILD					
					$list[$i] = array(
						"key" => $key,
						"name" => trim(stripslashes($name)),
						"desc" => trim(stripslashes($desc)),
						"price" => trim($price),
						"price_text" => $price_txt,
						"duration" => trim($duration),
						"duration_text" => $daytext,
						"recurring" => $recurring,

					);

					$i++;
				}

				return $list;


			}
				break;

			case "membership_features": {

				$features = array();


				$features = array(


					15 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "1"), __("View %s Page", "premiumpress")),
						"key" => "view_listing",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to access the %s page.", "premiumpress")),
						"order" => 1,
						"default" => 1,
						"hide_default" => 0,
					),


					4 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "1"), __("Read %s Descriptions", "premiumpress")),
						"key" => "view_profile",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to view %s page descriptions.", "premiumpress")),
						"order" => 2,
						"default" => 1,
						"hide_default" => 0,
					),



					3 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "1"), __("View %s Photos", "premiumpress")),
						"key" => "view_photos",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to view %s photos.", "premiumpress")),
						"order" => 3,
						"default" => 1,
						"hide_default" => 0,
					),



					9 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "2"), __("Multiple %s", "premiumpress")),
						"key" => "listings_multiple",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "2")), __("Allow users to create multiple %s.", "premiumpress")),
						"order" => 4,
						"default" => 0,
						"hide_default" => 1,
					),




					8 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "1"), __("Free %s Credit", "premiumpress")),
						"key" => "listings",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "2")), __("This is the number of free credits they receive when they signup or renew this membership enabling them to add %s for free.", "premiumpress")),
						"order" => 5,
						"default" => 0,
						"hide_default" => 1,
					),


					16 => array(
						"name" => str_replace("%s", $CORE->LAYOUT("captions", "1"), __("Max %s Credit", "premiumpress")),
						"key" => "listings_max",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "2")), __("Set the maximum number of %s a user can create. This will increase each time their membership renews.", "premiumpress")),
						"order" => 6,
						"default" => 0,
						"hide_default" => 1,
					),



					5 => array(
						"name" => __("Send Gifts", "premiumpress"),
						"key" => "gifts",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to send gifts.", "premiumpress")),
						"order" => 9,
						"default" => 1,
						"hide_default" => 0,
					),

					6 => array(
						"name" => __("Access Chatroom", "premiumpress"),
						"key" => "view_chatroom",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to access the chatroom page.", "premiumpress")),
						"order" => 9,
						"default" => 1,
						"hide_default" => 0,
					),

					7 => array(
						"name" => __("Downloads", "premiumpress"),
						"key" => "downloads",
						"desc" => __("This is the number of downloads they receive when they signup or renew this membership.", "premiumpress"),
						"order" => 9,
						"default" => 0,
						"hide_default" => 0,
					),





					10 => array(
						"name" => __("No Third-party Ads", "premiumpress"),
						"key" => "adfree",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Disable the display of the built-in advertising system.", "premiumpress")),
						"order" => 9,
						"default" => 0,
						"hide_default" => 0,
					),

					11 => array(
						"name" => __("See Who Liked My Profile", "premiumpress"),
						"key" => "liked",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to see who's liked their %s.", "premiumpress")),
						"order" => 9,
						"default" => 1,
						"hide_default" => 0,
					),

					/*12 => array(
										  "name" => __("View Member Videos","premiumpress"), 
										  "key" => "view_videos"
									  ),
									  */
					13 => array(
						"name" => __("Visitor Charts", "premiumpress"),
						"key" => "visitor_chart",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to see who's visiited their %s.", "premiumpress")),
						"order" => 9,
						"default" => 1,
						"hide_default" => 0,
					),

					14 => array(
						"name" => __("View Phone Number", "premiumpress"),
						"key" => "phone",
						"desc" => str_replace("%s", strtolower($CORE->LAYOUT("captions", "1")), __("Enable users to view the phone number.", "premiumpress")),
						"order" => 9,
						"default" => 1,
						"hide_default" => 0,
					),


					1 => array(
						"name" => __("Send Messages", "premiumpress"),
						"key" => "msg_send",
						"desc" => __("Enable users to send messages.", "premiumpress"),
						"order" => 10,
						"default" => 1,
						"hide_default" => 0,
					),

					17 => array(
						"name" => __("Send Message Limit", "premiumpress"),
						"key" => "max_msg",
						"desc" => __("Limit how many messages this user can send. Will update when their membership renews.", "premiumpress"),
						"order" => 11,
						"default" => 0,
						"hide_default" => 0,
					),

					2 => array(
						"name" => __("Read Messages", "premiumpress"),
						"key" => "msg_read",
						"desc" => __("Enable users to read messages.", "premiumpress"),
						"order" => 12,
						"default" => 1,
						"hide_default" => 0,
					),



				);

				// REMOVE MULTIPLE
				if (_ppt(array('lst', 'onelistingonly')) == "0") {
					unset($features[9]);
				}
				if (_ppt(array('lst', 'websitepackages')) == "0") {
					unset($features[9]);
					unset($features[13]);
				}

				if (_ppt(array('user', 'account_messages')) == "0") {
					unset($features[1]);
					unset($features[2]);
				}

				// downloads
				if (THEME_KEY != "so") {
					unset($features[7]);
				}

				// view Phone Number
				if (THEME_KEY != "es") {
					unset($features[14]);
				}


				if (in_array(THEME_KEY, array("da", "ex", "es"))) {

					unset($features[8]);

					if (in_array(THEME_KEY, array("es"))) {

						unset($features[5]);
						unset($features[6]);
						unset($features[11]);
						unset($features[12]);
					}

				} else {

					unset($features[5]);
					unset($features[6]);
					unset($features[11]);
					unset($features[12]);
				}


				// GIFTS
				if (THEME_KEY == "da" && !in_array(_ppt(array('design', 'display_gifts')), array("", "1"))) {
					unset($features[5]);
				} else {
					unset($features[5]);
				}




				// REORDER
				usort($features, 'compare_order');

				return $features;

			}
				break;


			case "membership_hasaccess_page": {


				// MEMBERSHIPS TURNED OFF
				if (_ppt(array('mem', 'enable')) == "0") {
					return 1;
				}


				// GET VIDEO ACCESS
				$value = get_post_meta($order_data, 'pageaccess', true);
				if (!is_array($value) || is_array($value) && empty($value)) {
					return 1;
				}

				// QUICK CHECKS
				if ($value[0] == "") {
					return 1;
				}

				// BUILD USERS ACCESS
				$myaccess = array();

				// MEMBER IS LOGGED IN ACCESS
				if (is_array($value)) {
					foreach ($value as $h) {
						if ($h == "loggedin" && !$userdata->ID) {

							return 0;

						} elseif ($h == "loggedin" && $userdata->ID) {

							return 1;
						}

					}
				}

				// MEMBER HAS VALID SUBSCRIPTION
				if ($userdata->ID) {

					$mymem = $CORE->USER("get_user_membership", $userdata->ID);

					if (isset($mymem['expired']) && $mymem['expired'] == 0 && in_array("subs", $value)) {

						return 1;
					}

					if (is_array($value)) {
						foreach ($value as $h) {

							if (in_array($mymem['key'], $value)) {

								return 1;

							}
						}
					}
				}



				return 0;

			}
				break;

			case "membership_hasaccess": {

				// RETURN 1 IF MEMBERSHIPS NOT ENABLED
				if (!$CORE->LAYOUT("captions", "memberships")) {
					return 1;
				}

				if (_ppt(array('mem', 'enable')) == "0" && $order_data == "listings_multiple") {
					return 0;
				}

				if (_ppt(array('mem', 'enable')) == "0") {
					return 1;
				}


				// CHECK WE HAVE THIS OPTION ENABLED
				$ff = $this->USER("membership_features", $userdata->ID);

				if (is_array($ff)) {

					$checkky = array();
					foreach ($ff as $ffk) {
						$checkky[$ffk['key']] = $ffk['key'];
					}

					if (!in_array($order_data, $checkky)) {
						return 1;
					}

				}


				global $post;

				// MY OWN POSTS
				if ($order_data != "liked" && isset($post->post_author) && ($userdata->ID == $post->post_author && $post->post_type == "listing_type") && isset($GLOBALS['flag-singlepage'])) {
					return 1;
				}

				$usermeme = "";
				if (is_array($order_data) && $userdata->ID) { // CHECK USER AGAINST				

					$g = $order_data; // MUST BE ARRAY

					$usermeme = $this->USER("get_user_membership", $g[0]);

					// PENDING APPROVAL
					if ($usermeme['user_approved'] == "0") {
						return 0;
					}

					if (is_array($usermeme)) {

						if (_ppt($usermeme['key'] . '_' . $g[1]) == 1) {
							return 1;
						}
					}

				} elseif ($userdata->ID) {

					$usermeme = $this->USER("get_user_membership", $userdata->ID);

					// PENDING APPROVAL
					if ($usermeme['user_approved'] == "0") {
						return 0;
					}


					if (is_array($usermeme)) {

						if (_ppt($usermeme['key'] . '_' . $order_data) == 1 || _ppt("mem" . $usermeme['key'] . '_' . $order_data) == 1) {
							return 1;
						}
					}

				}


				// CHECK AGAINST NO MEMBERSHIP
				if (!is_array($usermeme) && _ppt('mem0_' . $order_data) == 1) {
					return 1;
				}


				return 0;

			}
				break;

			case "membership_active": {


				$m = $this->USER("get_user_membership", $order_data);

				if (is_array($m)) {

					$da = $CORE->date_timediff($m['date_expires'], '');
					if ($da['expired'] == 0) {

						return 1;

					} elseif ($da['expired'] == 1) {

						// SEND EMAIL							
						$CORE->FUNC(
							"add_log",
							array(
								"type" => "membership_expired",
								"to" => $order_data,
								"from" => 0,
								"alert_uid1" => $order_data,
							)
						);
						// DELETE KEY
						delete_user_meta($order_data, 'ppt_subscription');

					}

				}

				return 0;

			}
				break;


			case "get_user_membership": {

				// NOT LOGGED IN
				if ($order_data == 0 || $order_data == "") {
					return 0;
				}


				$cm = get_user_meta($order_data, 'ppt_subscription');


				if (is_array($cm)) {
					$i = 1;
					$mymeme = array();

					if (isset($cm[0]) && isset($cm[0]['key'])) {
						$mymeme = $cm[0];
					}

					// APPROVAL SYSTEM
					if (!isset($mymeme['approved'])) {
						$user_approved = 1;
					} else {
						$user_approved = $mymeme['approved'];
					}


					if (!isset($mymeme['key']) || isset($mymeme['key']) && $mymeme['key'] == "") {

						// CLEAN UP
						delete_user_meta($order_data, 'ppt_subscription');
						delete_user_meta($order_data, 'ppt_subscription_key');


					} else {

						$GLOBALS['SHOWALLMEMS'] = 1;
						$sd = $CORE->USER("get_this_membership", $mymeme['key']);
						unset($GLOBALS['SHOWALLMEMS']);
						if (is_array($sd)) {

							if (!isset($sd['name'])) {
								return 0;
							}

							$da = $CORE->date_timediff($mymeme['date_expires'], '');

							update_user_meta($order_data, 'ppt_subscription_key', $sd['key']);

							return array(
								"key" => $sd['key'],
								"name" => $sd['name'],
								"date_start" => $mymeme['date_start'],
								"date_expires" => $mymeme['date_expires'],
								"expired" => $da['expired'],
								"user_approved" => $user_approved,




							);

						}


					}


				} else {
					// CLEAN UP	
					delete_user_meta($order_data, 'ppt_subscription');

				}


				return 0;

			}
				break;


			case "update_rating_likes": {

				$UID = $order_data;

				// HITS ARRAy
				$data = get_post_meta($UID, 'likes_array', true);
				if (!is_array($data)) {
					$data = array();
				}

				// GET DATE		  
				$date_now = date('Y-m-d');

				// update
				if (isset($data[$date_now]) && isset($data[$date_now])) {
					$data[$date_now] = array("date" => $date_now, "hits" => $data[$date_now]['hits'] + 1, "last_visit" => date('Y-m-d H:i:s'), "userid" => $userdata->ID);
				} else {
					$data[$date_now] = array("date" => $date_now, "hits" => 1, "userid" => $userdata->ID);
				}

				// SAVE
				update_post_meta($UID, 'likes_array', $data);

			}
				break;

			case "get_likes_count": {


				$c = get_post_meta($order_data, 'ratingup', true);
				if (is_numeric($c) && $c > 0) {
					return $c;
				}

				return 0;


			}
				break;

			case "get_rating_likes": {

				$count = 0;

				// LOOP ALL USER POSTS
				$args = array(
					'post_type' => 'listing_type',
					'posts_per_page' => 100,
					'post_status' => "publish",
					'author' => $order_data[0],
					'meta_query' => array(

						'log_userid2' => array(
							'key' => 'likes_array',
							'type' => 'NUMERIC',
						),
					),
				);
				$found_logs = new WP_Query($args);
				$logs = $wpdb->get_results($found_logs->request, OBJECT);
				foreach ($logs as $log) {

					$data = get_post_meta($log->ID, 'likes_array', true);
					if (!is_array($data)) {
						$data = array();
					}

					switch ($order_data[1]) {

						case "all": {
							foreach ($data as $h) {
								$count = $count + $h['hits'];
							}
						}
							break;
						default: {
							if (isset($data[$order_data[1]])) {
								$count = $count + $data[$order_data[1]]['hits'];
							}
						}
							break;
					}
				}// end foreach			

				return $count;


			}
				break;

			case "get_subscribers_count": {

				return number_format(count($this->USER("get_subscribers", $order_data)));


			}
				break;

			case "get_subscribers": {

				// GETS MY SUBSCRIBERS			 
				$extn = "_list";
				$type = "subscribe";
				if (defined('WP_ALLOW_MULTISITE')) {
					$extn .= get_current_blog_id();
				}

				$my_list = get_user_meta($order_data, $type . $extn . "_followers", true);

				if (!is_array($my_list)) {
					$my_list = array();
				}

				return $my_list;


			}
				break;

			case "get_subscribers_followers_count": {

				$gg = $CORE->USER("get_subscribers_followers", $order_data);

				if (!is_array($gg)) {
					$gg = array();
				}

				return count($gg);


			}
				break;

			case "get_subscribers_followingme": {


				// FIND OUT WHICH USERS HAVE ADDED ME TO THEIR LIST
				$my_list = array();
				$SQL = "SELECT user_id FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'subscribe_list' AND meta_value LIKE '%\"" . $order_data . "\"%' AND user_id != '" . $order_data . "'  LIMIT 50 ";


				$ores = $wpdb->get_results($SQL);
				if (!empty($ores)) {
					foreach ($ores as $row) {

						$my_list[$row->user_id] = $row->user_id;
					}

				}

				return $my_list;


			}
				break;

			case "get_subscribers_followers": {


				$extn = "_list";
				$type = "subscribe";
				if (defined('WP_ALLOW_MULTISITE')) {
					$extn .= get_current_blog_id();
				}

				$my_list = get_user_meta($order_data, $type . $extn, true);

				if (!is_array($my_list)) {
					$my_list = array();
				}

				return $my_list;




			}
				break;

			case "get_views": {

				$g = $order_data;

				$count = 0;

				$data = get_user_meta($g[0], 'views_array', true);
				if (!is_array($data)) {
					$data = array();
				}

				switch ($g[1]) {

					case "all": {

						foreach ($data as $h) {

							$count = $count + $h['hits'];
						}

					}
						break;

					default: {

						if (isset($data[$g[1]])) {

							$count = $data[$g[1]]['hits'];

						}

					}
						break;

				}

				return $count;


			}
				break;

			case "update_views": {

				$UID = $order_data;

				// HITS ARRAy
				$data = get_user_meta($UID, 'views_array', true);
				if (!is_array($data)) {
					$data = array();
				}

				// GET DATE		  
				$date_now = date('Y-m-d');

				// update
				if (isset($data[$date_now]) && isset($data[$date_now])) {
					$data[$date_now] = array("date" => $date_now, "hits" => $data[$date_now]['hits'] + 1, "last_visit" => date('Y-m-d H:i:s'));
				} else {
					$data[$date_now] = array("date" => $date_now, "hits" => 1);
				}

				// SAVE
				update_user_meta($UID, 'views_array', $data);

			}
				break;


			case "set_online": {

				update_user_meta($order_data, 'online', date("Y-m-d H:i:s"));

			}
				break;

			case "get_online_users": {

				// CHECK EXISTS
				$SQL = "SELECT * FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'online' ";
				$user = array();
				$last_posts = (array) $wpdb->get_results($SQL);
				foreach ($last_posts as $value) {
					$user[$value->user_id] = $value->user_id;
				}

				return $user;

			}
				break;

			case "get_online_status": {

				// CHECK EXISTS
				$SQL = "SELECT count(*) as total FROM " . $wpdb->base_prefix . "usermeta WHERE meta_key = 'online' AND user_id ='" . $order_data . "'  LIMIT 1 ";

				$ores = $wpdb->get_results($SQL);
				if (isset($ores[0]) && $ores[0]->total == 1) {
					return 1;
				}

				return 0;

			}
				break;


			case "get_online_badge": {

				if ($order_data) {

					return '<span class="onlinebadge online text-dark badge border px-2 bg-white"><i class="fa fa-circle text-success"></i> ' . __("Online", "premiumpress") . '</span>';

				}

				return '<span class="onlinebadge offline text-dark badge border px-2 bg-white"><i class="fa fa-circle text-dark"></i> ' . __("Offline", "premiumpress") . '</span>';


			}
				break;

			case "get_avatar": {



				// PROFILE IMAGE FROM PROFILE
				if (in_array(THEME_KEY, array("da", "es"))) {


					$SQL = "SELECT DISTINCT " . $wpdb->posts . ".ID FROM " . $wpdb->posts . " WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('" . $order_data . "') LIMIT 1";
					$query = $wpdb->get_results($SQL, OBJECT);
					if (!empty($query)) {

						return do_shortcode("[IMAGE pathonly=1 pid='" . $query[0]->ID . "']");

					}


				}


				$currentimg = get_user_meta($order_data, "userphoto", true);
				if (is_array($currentimg) && isset($currentimg['img'])) {
					return $currentimg['img'];
				}

				$img = get_user_meta($order_data, 'myavatar', true);
				if ($img != "") {
					return get_template_directory_uri() . "/framework/images/avatar/" . $img . ".png";
				}

				return get_template_directory_uri() . "/framework/images/avatar/none.png";

			}
				break;


			case "get_photo": {

				$img = $this->USER("get_avatar", $order_data);

				// USER PHOTO
				return '<img src="' . $img . '" class="userphoto img-fluid rounded-circle">';


			}
				break;


			case "bar_reputation": {

				$data = $CORE->USER("feedback_score", $order_data);

				$l = $CORE->USER("get_level", $order_data);

				ob_start();

				?>
					<div class="repuationbox">

						<div class="rating-box">
							<input type="hidden" class="rating" data-filled="fa fa-star" data-empty="fal fa-star" data-fractions="2"
								data-readonly value="<?php echo $data['stars']; ?>" />

							<div class="rating-votes tiny text-center"><?php echo $data['votes']; ?>
							<?php echo __("reviews", "premiumpress"); ?></div>

						</div>
					</div>
					<?php

					return ob_get_clean();

			}
				break;

			case "favs_count": {

				if (!$userdata->ID) {
					return 0;
				}

				$extn = "_list";
				if (defined('WP_ALLOW_MULTISITE')) {
					$extn .= get_current_blog_id();
				}

				$my_list = get_user_meta($userdata->ID, 'favorite' . $extn, true);
				if (!is_array($my_list)) {
					$my_list = array();
				}
				foreach ($my_list as $hk => $hh) {
					if ($hh == 0 || $hh == "") {
						unset($my_list[$hk]);
					}
				}

				if (empty($my_list)) {
					return 0;
				}

				return count($my_list);

			}
				break;



			case "get_country": {

				$country = get_user_meta($order_data, 'country', true);

				if (isset($GLOBALS['core_country_list'][$country])) {
					return $GLOBALS['core_country_list'][$country];
				}

				return $country;

			}
				break;

			case "get_country_flag": {

				$country = get_user_meta($order_data, 'country', true);


				if (isset($GLOBALS['core_country_list'][$country])) {
					return '<span class="flag flag-' . strtolower($country) . ' ppt_locationflag"></span>';
				}

				return $country;

			}
				break;

			case "get_city": {

				$country = get_user_meta($order_data, 'city', true);

				return $country;

			}
				break;

			case "get_user_profile_link": {

				if (!is_numeric($order_data)) {
					return "#";
				}

				if (in_array(THEME_KEY, array("da", "ex", "es"))) {

					$SQL = "SELECT DISTINCT " . $wpdb->posts . ".ID FROM " . $wpdb->posts . " WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('" . $order_data . "') LIMIT 1";
					$query = $wpdb->get_results($SQL, OBJECT);
					if (!empty($query)) {

						return get_permalink($query[0]->ID);

					} else {

						return 0;

					}

				}



				return get_author_posts_url($order_data);

			}

			case "get_userid_from_postid": {

				return get_post_field('post_author', $order_data);

			}
				break;

			case "get_username": {

				if (!is_numeric($order_data)) {
					return "invalid user id";
				}

				// BUILD DISPLAY NAME
				$name = get_the_author_meta('user_login', $order_data);

				return $name;

			}
				break;

			case "get_name": {

				if (!is_numeric($order_data)) {
					return "anonymous";
				}

				// BUILD DISPLAY NAME
				$name = get_the_author_meta('first_name', $order_data) . " " . get_the_author_meta('last_name', $order_data);

				// FALLBACK
				if ($name == " ") {
					$name = get_the_author_meta('display_name', $order_data);
				}

				return $name;

			}
				break;


			case "get_first_name": {

				if (!is_numeric($order_data)) {
					return "anonymous";
				}

				// BUILD DISPLAY NAME
				$name = get_the_author_meta('first_name', $order_data);

				return $name;

			}
				break;


			case "get_last_name": {

				if (!is_numeric($order_data)) {
					return "anonymous";
				}

				// BUILD DISPLAY NAME
				$name = get_the_author_meta('last_name', $order_data);

				return $name;

			}
				break;

			case "get_address": {

				if (!is_numeric($order_data)) {
					return "invalid user id";
				}

				$name = "";

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('address1', $order_data, true)) > 1) {
					$name .= get_the_author_meta('address1', $order_data, true) . "<br>";
				}

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('address2', $order_data, true)) > 1) {
					$name .= get_the_author_meta('address2', $order_data, true) . "<br>";
				}

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('town', $order_data, true)) > 1) {
					$name .= get_the_author_meta('town', $order_data, true) . "<br>";
				}

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('city', $order_data, true)) > 1) {
					$name .= get_the_author_meta('city', $order_data, true) . "<br>";
				}

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('country', $order_data, true)) > 1) {
					$country = get_the_author_meta('country', $order_data, true);
					if (isset($GLOBALS['core_country_list'][$country])) {
						$name .= $GLOBALS['core_country_list'][$country] . "<br>";
					} else {
						$name .= $country . "<br>";
					}

				}

				// BUILD DISPLAY NAME
				if (strlen(get_the_author_meta('zip', $order_data, true)) > 1) {
					$name .= get_the_author_meta('zip', $order_data, true) . "<br>";
				}


				return $name;

			}
				break;
			case "get_address_part": {

				$val = get_user_meta($order_data[1], $order_data[0], true);

				if (THEME_KEY == "sp" && $val == "") {
					switch ($order_data[0]) {
						case "address1": {
							$val = get_user_meta($order_data[1], 'billing_address', true);
						}
							break;
						case "country": {
							$val = get_user_meta($order_data[1], 'billing_country', true);
						}
							break;
						case "city": {
							$val = get_user_meta($order_data[1], 'billing_city', true);
						}
							break;
						case "town": {
							$val = get_user_meta($order_data[1], 'billing_city', true);
						}
							break;
						case "state": {
							$val = get_user_meta($order_data[1], 'billing_state', true);
						}
							break;
						case "zip": {
							$val = get_user_meta($order_data[1], 'billing_zip', true);
						}
							break;
						case "phone": {
							$val = get_user_meta($order_data[1], 'billing_phone', true);
						}
							break;

					}
				}

				return $val;

			}
				break;

			case "update_address_part": {
				$user_id = $order_data[1];
				$meta_key = $order_data[0];
				$meta_value = isset($_POST[$meta_key]) ? sanitize_text_field($_POST[$meta_key]) : '';

				// Update user meta data
				update_user_meta($user_id, $meta_key, $meta_value);

				// If it's one of the address parts, update corresponding address meta
				if (in_array($meta_key, ['address1', 'city', 'country', 'zip'])) {
					$address_meta_key = 'billing_' . $meta_key;
					update_user_meta($user_id, $address_meta_key, $meta_value);
				}

				// If it's map related, update map meta
				if (in_array($meta_key, ['map-location', 'map-lat', 'map-log'])) {
					update_user_meta($user_id, $meta_key, $meta_value);
				}

				return $meta_value;
			}
				break;

			case "get_phone": {

				if (!is_numeric($order_data)) {
					return "invalid user id";
				}

				// BUILD DISPLAY NAME
				return get_user_meta('phone', $order_data, true);


			}
				break;

			case "get_verified": {

				if (!is_numeric($order_data)) {
					return "invalid user id";
				}

				// BUILD DISPLAY NAME				
				if (get_user_meta($order_data, 'ppt_verified', true) == 1) {
					return 1;
				} else {
					return 0;
				}


			}
				break;

			case "get_email": {

				$user_info = get_userdata($order_data);

				if (!isset($user_info->user_email)) {
					return "";
				}

				return $user_info->user_email;

			}
				break;
			case "get_desc": {

				if (!is_numeric($order_data)) {
					return;
				}

				$user_info = get_userdata($order_data);

				if (strlen($user_info->description) < 2) {
					return "Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.";
				}

				return stripslashes($user_info->description);

			}
				break;
			case "get_joined": {

				if (!is_numeric($order_data)) {
					return;
				}

				$user_info = get_userdata($order_data);
				if (!isset($user_info->user_registered)) {
					return "";
				}

				return hook_date_only($user_info->user_registered);

			}
				break;

			case "get_role": {

				$user_info = get_userdata($order_data);

				if (!isset($user_info->roles)) {
					return "";
				}

				return $user_info->roles[0];

			}
				break;

			case "get_lastlogin": {

				$date = get_user_meta($order_data, 'login_lastdate', true);

				if ($date == "") {
					return "-";
				}

				$xp = $CORE->date_timediff($date);

				if (!isset($xp['date_array'][__("days", "premiumpress")])) {

					$xp['date_array'][__("days", "premiumpress")] = 0;
				}

				if (isset($xp['date_array'][__("months", "premiumpress")]) && $xp['date_array'][__("months", "premiumpress")] == "0" && $xp['date_array'][__("days", "premiumpress")] == 0) {

					return __("today", "premiumpress");

				}

				return ($xp['date_array'][__("days", "premiumpress")] + ($xp['date_array'][__("months", "premiumpress")] * 30)) . " " . __("days ago", "premiumpress");

			}
				break;


			case "get_credit": {

				$credit = get_user_meta($order_data, 'ppt_usercredit', true);

				if ($credit == "") {
					$credit = 0;
				}

				return $credit;

			}
				break;


			case "get_ordertotal": {

				$args = array(
					'post_type' => 'ppt_orders',

					'meta_query' => array(
						'user_id' => array(
							'key' => 'order_userid',
							'type' => 'NUMERIC',
							'value' => $order_data,
							'compare' => '=',
						),
					),


				);
				$wp_query1 = new WP_Query($args);
				return $wp_query1->found_posts;

			}
				break;



			case "get_cashout_total": {

				$args = array(
					'post_type' => 'ppt_cashout',

					'meta_query' => array(
						'user_id' => array(
							'key' => 'cashout_userid',
							'type' => 'NUMERIC',
							'value' => $userdata->ID,
							'compare' => '=',
						),
					),


				);
				$wp_query1 = new WP_Query($args);

				return $wp_query1->found_posts;

			}
				break;

			case "get_cashout_pending": {

				$args = array(
					'post_type' => 'ppt_cashout',

					'meta_query' => array(

						'relation' => "AND",

						'user_id' => array(
							'key' => 'cashout_userid',
							'type' => 'NUMERIC',
							'value' => $userdata->ID,
							'compare' => '=',
						),

						'cashout_status' => array(
							'key' => 'cashout_status',
							'type' => 'NUMERIC',
							'value' => 0,
							'compare' => '=',
						),
					),

				);
				$wp_query1 = new WP_Query($args);

				return $wp_query1->found_posts;

			}
				break;


			case "get_unread_logs": {


				// GET ALL LOGS
				$args = array(
					'post_type' => 'ppt_logs',
					'posts_per_page' => 1, // WE ONLY NEED 1

					'meta_query' => array(

						'log_read' => array(
							'key' => 'log_read' . $order_data,
							'value' => "unread",
							'compare' => '=',
						),

					),

				);

				$data = array();
				$found_logs = new WP_Query($args);
				$logs = $wpdb->get_results($found_logs->request, OBJECT);

				foreach ($logs as $log) {

					$data[] = array(
						"logid" => $log->ID,
						"date" => get_the_date("Y-m-d", $log->ID),
					);

				}

				return $data;

			}
				break;

			case "get_public_logs": {


				// GET ALL LOGS
				$args = array(
					'post_type' => 'ppt_logs',
					'posts_per_page' => 20,

					'meta_query' => array(
						'relation' => 'OR',
						'log_to' => array(
							'key' => 'log_public',
							'type' => 'NUMERIC',
							'value' => 1,
							'compare' => '=',
						),
						'log_from' => array(
							'key' => 'log_public',
							'type' => 'NUMERIC',
							'value' => 1,
							'compare' => '=',
						),
					),


				);
				$found_logs = new WP_Query($args);
				$logs = $wpdb->get_results($found_logs->request, OBJECT);

				if (!empty($logs)) {

					$outputarray = array();

					foreach ($logs as $log) {

						$d = $CORE->FUNC("format_logtype", $log->ID);

						// TIME SINCE
						$vv = $CORE->date_timediff($d['date']);
						$d['time'] = $vv['string-small'] . " " . __("ago", "premiumpress");

						$outputarray[] = $d;
					}

					return $outputarray;

				} else {

					return array();
				}


			}
				break;


			case "get_logs": {


				// GET ALL LOGS
				$args = array(
					'post_type' => 'ppt_logs',
					'posts_per_page' => 20,

					'meta_query' => array(


						'relation' => 'AND',
						array(

							'relation' => 'OR',
							array(
								'log_to' => array(
									'key' => 'log_to',
									'type' => 'NUMERIC',
									'value' => $order_data,
									'compare' => '=',
								),
								'log_from' => array(
									'key' => 'log_from',
									'type' => 'NUMERIC',
									'value' => $order_data,
									'compare' => '=',
								),
							),

							array(
								//'relation'    => 'and',	
								array(
									'log_public' => array(
										'key' => 'log_public',
										'type' => 'NUMERIC',
										'value' => 0,
										'compare' => '=',
									),


								),
							),
						),
					),

				);

				$found_logs = new WP_Query($args);
				$logs = $wpdb->get_results($found_logs->request, OBJECT);

				if (!empty($logs)) {

					$output = '<ol class="activity-feed">';
					foreach ($logs as $log) {

						if (get_post_meta($log->ID, "log_public", true) == 1) {
							continue;
						}

						$d = $CORE->FUNC("format_logtype", $log->ID);
						// TIME SINCE
						$vv = $CORE->date_timediff($d['date']);
						ob_start();
						?>
							<li class="feed-item">

								<span class="text"><i class="<?php echo $d['icon']; ?>"></i> <?php echo $d['name']; ?></span>
								<span class="desc"><?php echo $d['desc']; ?> - <em
										class="date"><?php echo $vv['string-small']; ?><?php echo __("ago", "premiumpress"); ?></em> </span>

							</li>
							<?php
							$output .= ob_get_clean();
					}

					$output .= '</ol>';
					return $output;

				} else {

					return '<div class="small text-muted">' . __("no recent activity.", "premiumpress") . "</div>";
				}


			}
				break;

			case "check_offer_exists_by_orderid": {

				if (!$userdata->ID) {
					return 0;
				}

				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
					INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 					 				
					WHERE 1=1 
					AND ( mt1.meta_key = 'order_id' AND mt1.meta_value = ('" . $order_data . "')   )				 
					AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID LIMIT 1 ";

				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return $result[0]->ID;

			}
				break;
			case "get_offer": {

				if (!$userdata->ID) {
					return 0;
				}

				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
					INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
					INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 					
					WHERE 1=1 
					AND ( mt1.meta_key = 'seller_id' AND mt1.meta_value = ('" . $userdata->ID . "') OR mt1.meta_key = 'buyer_id' AND mt1.meta_value = ('" . $userdata->ID . "')  )
					AND ( mt2.meta_key = 'post_id' AND mt2.meta_value = ('" . $order_data . "') )
					AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer'  GROUP BY ID LIMIT 1 ";

				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return $result[0]->ID;

			}
				break;

			case "get_offer_status": {

				$g = $this->USER("get_offer", $order_data);
				if (is_numeric($g) && $g > 0) {

					$status = get_post_meta($g, "offer_status", true);
					return $status;

				}

				return 0;

			}
				break;

			case "count_offers": {

				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
							 
						WHERE 1=1 
							
						AND ( mt1.meta_key = 'seller_id' AND mt1.meta_value = ('" . $order_data . "') OR mt1.meta_key = 'buyer_id' AND mt1.meta_value = ('" . $order_data . "') )
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID ";

				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return count($result);


			}
				break;


			case "count_offers_pending_by_postid": {

				if (!is_array($order_data)) {
					return 0;
				}

				$d1 = $order_data[0]; // POST ID
				$d2 = $order_data[1]; // USER ID


				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 
						
						WHERE 1=1 
							
						AND ( mt1.meta_key = 'post_id' AND mt1.meta_value = ('" . $d1 . "')  )						 				
						AND ( mt2.meta_key = 'buyer_id' AND mt2.meta_value = ('" . $d2 . "')  )						 				
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID ";


				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return count($result);


			}
				break;


			case "get_offers_pending_by_postid": {

				if (!is_array($order_data)) {
					return 0;
				}

				$d1 = $order_data[0]; // POST ID
				$d2 = $order_data[1]; // USER ID


				$SQL = "SELECT ID FROM " . $wpdb->prefix . "posts 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 
						
						WHERE 1=1 
							
						AND ( mt1.meta_key = 'post_id' AND mt1.meta_value = ('" . $d1 . "')  )						 				
						AND ( mt2.meta_key = 'buyer_id' AND mt2.meta_value = ('" . $d2 . "')  )						 				
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID ";


				$result = $wpdb->get_results($SQL);

				if (isset($result[0])) {
					return $result[0]->ID;

				} else {
					return 0;
				}


			}
				break;


			case "count_offers_pending": {



				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 
							 
						WHERE 1=1 
							
						AND ( mt1.meta_key = 'seller_id' AND mt1.meta_value = ('" . $order_data . "') OR mt1.meta_key = 'buyer_id' AND mt1.meta_value = ('" . $order_data . "') )
						
						AND ( mt2.meta_key = 'offer_status' AND mt2.meta_value = '1'  )						
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID ";


				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return count($result);


			}
				break;


			case "count_offers_pending_post": {

				if (!is_array($order_data)) {
					return 0;
				}

				$d1 = $order_data[0]; // POST ID
				$d2 = $order_data[1]; // USER ID

				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
				
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
						
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 
						
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt3 ON (" . $wpdb->prefix . "posts.ID = mt3.post_id) 
						
						 
						WHERE 1=1 
							
						AND ( 
						
							mt1.meta_key = 'post_id' 
							
							AND mt1.meta_value = ('" . $d1 . "') 
							
							AND mt2.meta_key = 'seller_id' 
							
							AND mt2.meta_value = ('" . $d2 . "') 
							
							AND mt3.meta_key = 'offer_status' 
							
							AND ( mt3.meta_value = '1'  OR mt3.meta_value = '2'  )
						
						)						 				
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID ";

				//echo $SQL;


				$result = $wpdb->get_results($SQL);

				if (empty($result)) {
					return 0;
				}

				return count($result);


			}
				break;


			case "count_offers_complete": {

				$SQL = "SELECT * FROM " . $wpdb->prefix . "posts 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id) 
						INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id) 
							 
						WHERE 1=1 
							
						AND ( mt1.meta_key = 'seller_id' AND mt1.meta_value = ('" . $order_data . "') )
						
						AND ( mt2.meta_key = 'offer_status' AND mt2.meta_value = '3'  )						
							 
						AND " . $wpdb->prefix . "posts.post_status = 'publish' AND " . $wpdb->prefix . "posts.post_type='ppt_offer' GROUP BY ID "; // OR mt1.meta_key = 'buyer_id' AND mt1.meta_value = ('".$order_data."')

				$result = $wpdb->get_results($SQL);


				if (empty($result)) {
					return 0;
				}

				return count($result);


			}
				break;

			case "count_listings": {

				$SQL = "SELECT count(*) AS total FROM " . $wpdb->prefix . "posts 
				WHERE " . $wpdb->prefix . "posts.post_author = ('" . $order_data . "') 
				AND " . $wpdb->prefix . "posts.post_status = 'publish' 
				AND " . $wpdb->prefix . "posts.post_type='listing_type'";

				$result = $wpdb->get_results($SQL);

				return $result[0]->total;

			}
				break;

			case "count_profile_views": {

				$j = get_user_meta($order_data, 'views', true);
				if ($j == "") {
					return 0;
				}
				return number_format($j);

			}
				break;


			case "count_messages": {

				// MSSAGES BETWEEN USER
				$SQL = "SELECT count(*) as total FROM " . $wpdb->prefix . "posts 
			INNER JOIN " . $wpdb->prefix . "postmeta AS mt1 ON (" . $wpdb->prefix . "posts.ID = mt1.post_id AND  mt1.meta_key = 'msg_stick' 
			AND ( mt1.meta_value LIKE '%[" . $userdata->ID . "]%' OR  mt1.meta_value LIKE '%[" . $userdata->ID . "]%' ) )  
			WHERE  1= 1
			AND " . $wpdb->prefix . "posts.post_status = 'publish' 
			AND " . $wpdb->prefix . "posts.post_type = 'ppt_message' ORDER BY " . $wpdb->prefix . "posts.post_date ASC";


				$result = $wpdb->get_results($SQL);
				return $result[0]->total;


			}
				break;


			case "count_messages_unread": {

				// MSSAGES BETWEEN USER
				$SQL = "SELECT count(*) as total FROM " . $wpdb->prefix . "posts 
			 
			INNER JOIN " . $wpdb->prefix . "postmeta AS mt2 ON (" . $wpdb->prefix . "posts.ID = mt2.post_id AND  mt2.meta_key = 'msg_status' AND mt2.meta_value = 'unread_" . $order_data . "') 
			
			WHERE  1= 1
			AND " . $wpdb->prefix . "posts.post_status = 'publish' 
			AND " . $wpdb->prefix . "posts.post_type = 'ppt_message' ORDER BY " . $wpdb->prefix . "posts.post_date ASC";

				echo $SQL;

				$result = $wpdb->get_results($SQL);

				return $result[0]->total;


			}
				break;

			case "user_comment_score": {


				if (is_array($order_data)) {

					$userid = $order_data[0];
					$postid = $order_data[1];

				} else {

					$userid = $order_data;
				}

				$total_score = 0;
				$total_found = 0;
				$feedback_value = array();

				$args = array(

					'posts_per_page' => '150',
					'meta_query' => array(

						array(
							'key' => 'postauthor',
							'value' => $userid,
							'compare' => '=',
						),

					),

				);
				// GET USER FEEDBACK
				$c = new WP_Comment_Query($args);


				$feedback = $c->comments;
				if (!empty($feedback)) {

					$total_found = count($feedback);

					foreach ($feedback as $this_feedback) {

						if (isset($postid) && is_numeric($postid)) {
							$pid = get_comment_meta($this_feedback->comment_ID, 'ratingpid', true);
							if ($pid != $postid) {
								continue;
							}
						}

						$score = get_comment_meta($this_feedback->comment_ID, 'ratingtotal', true);

						if ($score == "") {
							$score = 5;
						}
						$total_score = $total_score + $score;

						if (isset($feedback_value[substr($score, 0, 1)])) {
							$feedback_value[substr($score, 0, 1)] = $feedback_value[substr($score, 0, 1)] + 1;
						} else {
							$feedback_value[substr($score, 0, 1)] = 1;
						}

					}
				}



				// PERCENTAGE
				$percentage = 0;
				if ($total_found > 0 && $total_score > 0) {
					$percentage = number_format(($total_found / $total_score) * 100 * 5, 0);
				}

				// DEFAULT 5 SCORE
				if ($total_found > 0) {
					$score = round(($total_score / $total_found), 2);
				} else {
					$score = 5;
				}

				// DEFAULTS
				if ($percentage == 0) {
					$percentage = 100;
					$score = 5;
				}

				return array(
					"score" => $score,
					"votes" => $total_found,
					"stars" => $score,
					"percentage" => $percentage, //<-- not used now
					"data" => $feedback_value,
				);


			}
				break;


			case "feedback_score": {


				if (is_array($order_data)) {

					$userid = $order_data[0];
					$postid = $order_data[1];

				} else {

					$userid = $order_data;
				}

				$total_score = 0;
				$total_found = 0;
				$feedback_value = array();

				$args = array(

					'posts_per_page' => '150',
					'meta_query' => array(

						array(
							'key' => 'feedback_for',
							'value' => $userid,
							'compare' => '=',
						),
						array(
							'key' => 'feedback',
							'value' => 1,
							'compare' => '=',
						),

					),

				);
				// GET USER FEEDBACK
				$c = new WP_Comment_Query($args);


				$feedback = $c->comments;
				if (!empty($feedback)) {

					$total_found = count($feedback);

					foreach ($feedback as $this_feedback) {

						if (isset($postid) && is_numeric($postid)) {
							$pid = get_comment_meta($this_feedback->comment_ID, 'ratingpid', true);
							if ($pid != $postid) {
								continue;
							}
						}

						$score = get_comment_meta($this_feedback->comment_ID, 'ratingtotal', true);

						if ($score == "") {
							$score = 5;
						}
						$total_score = $total_score + $score;

						if (isset($feedback_value[substr($score, 0, 1)])) {
							$feedback_value[substr($score, 0, 1)] = $feedback_value[substr($score, 0, 1)] + 1;
						} else {
							$feedback_value[substr($score, 0, 1)] = 1;
						}

					}
				}



				// PERCENTAGE
				$percentage = 0;
				if ($total_found > 0 && $total_score > 0) {
					$percentage = number_format(($total_found / $total_score) * 100 * 5, 0);
				}

				// DEFAULT 5 SCORE
				if ($total_found > 0) {
					$score = round(($total_score / $total_found), 2);
				} else {
					$score = 5;
				}

				// DEFAULTS
				if ($percentage == 0) {
					$percentage = 100;
					$score = 5;
				}

				if ($total_found == 0) {
					$percentage = 0;
					$score = 0;
				}

				return array(
					"score" => $score,
					"votes" => $total_found,
					"stars" => $score,
					"percentage" => $percentage, //<-- not used now
					"data" => $feedback_value,
				);


			}
				break;

			case "get_level": {

				$g = $this->USER("get_levels", $order_data);

				foreach ($g as $k => $h) {

					if (isset($h['current']) && $h['current']) {
						return $k;
					}

				}

				return 1;

			}
				break;

			case "get_levels": {

				$user_levels = array(

					1 => array(
						"name" => __("Level 1", "premiumpress"),
						"desc" => __("Joined within the last 30 days.", "premiumpress"),
					),
					2 => array(
						"name" => __("Level 2", "premiumpress"),
						"desc" => "Has been a member for more than 90 days.",
					),
					3 => array(
						"name" => __("Level 3", "premiumpress"),
						"desc" => "Has been a member for than 180 days.",
					),
					4 => array(
						"name" => __("Level 4", "premiumpress"),
						"desc" => "Has been a member for more than 300 days.",
					),
					5 => array(
						"name" => __("Level 5", "premiumpress"),
						"desc" => "Has been a member for more than a year.",
					),

				);


				// ADMIN AUTO GETS LEVEL 5
				if (user_can($order_data, 'administrator') || user_can($order_data, 'contributor')) {

					$user_levels[1]['active'] = 1;
					$user_levels[2]['active'] = 1;
					$user_levels[3]['active'] = 1;
					$user_levels[4]['active'] = 1;
					$user_levels[5]['active'] = 1;
					$user_levels[5]['current'] = 1;

					return $user_levels;
				}


				if (is_numeric($order_data)) {

					// GET JOINED DATE
					$g = $CORE->USER("get_joined", $order_data);

					// WORK OUT DAYS
					$your_date = strtotime($g);
					$datediff = time() - $your_date;
					$totaldays = round($datediff / (60 * 60 * 24));
					//$totaldays = 100;

					if ($totaldays >= 301) {

						$user_levels[1]['active'] = 1;
						$user_levels[2]['active'] = 1;
						$user_levels[3]['active'] = 1;
						$user_levels[4]['active'] = 1;
						$user_levels[5]['active'] = 1;
						$user_levels[5]['current'] = 1;

					} elseif ($totaldays > 181 && $totaldays < 300) {

						$user_levels[1]['active'] = 1;
						$user_levels[2]['active'] = 1;
						$user_levels[3]['active'] = 1;
						$user_levels[4]['active'] = 1;
						$user_levels[4]['current'] = 1;

					} elseif ($totaldays > 91 && $totaldays < 180) {

						$user_levels[1]['active'] = 1;
						$user_levels[2]['active'] = 1;
						$user_levels[3]['active'] = 1;
						$user_levels[3]['current'] = 1;


					} elseif ($totaldays > 31 && $totaldays < 90) {

						$user_levels[1]['active'] = 1;
						$user_levels[2]['active'] = 1;
						$user_levels[2]['current'] = 1;

					} else {

						$user_levels[1]['active'] = 1;
						$user_levels[1]['current'] = 1;

					}

					return $user_levels;

				} else {

					return $user_levels;

				}

			}
				break;
			case "get_awards": {


				$user_awards = array(

					1 => array(
						"name" => "Complete Profile",
						"desc" => "Sold more than $1 across the market.",
						"active" => false,
					),
					2 => array(
						"name" => "Favorites",
						"desc" => "Has more than 1 ad on their favorites list.",
						"active" => false,
					),
					3 => array(
						"name" => "Active",
						"desc" => "Active within the last 48 hours.",
						"active" => false,
					),
					4 => array(
						"name" => "Verified",
						"desc" => "Account has been verified by an admin.",
						"active" => false,
					),
					5 => array(
						"name" => "Photo",
						"desc" => "Has uploaded a custom profile photo.",
						"active" => false,
					),

					6 => array(
						"name" => "Celeberity",
						"desc" => "Has more than 100 profile views.",
						"active" => false,
					),
					7 => array(
						"name" => "Power Seller",
						"desc" => "Has more than 10 ads.",
						"active" => false,
					),
					8 => array(
						"name" => "Feedback",
						"desc" => "Has receieved more than 1 feedback.",
						"active" => false,
					),
					9 => array(
						"name" => "Diamond Author",
						"desc" => "Has receieved more than 10 feedback.",
						"active" => false,
					),
					10 => array(
						"name" => "Emerald Author",
						"desc" => "Has receieved more than 20 feedback.",
						"active" => false,
					),
					11 => array(
						"name" => "Diamond Author",
						"desc" => "Has receieved more than 10 feedback.",
						"active" => false,
					),
					12 => array(
						"name" => "Emerald Author",
						"desc" => "Has receieved more than 20 feedback.",
						"active" => false,
					),
					13 => array(
						"name" => "Emerald Author",
						"desc" => "Has receieved more than 20 feedback.",
						"active" => false,
					),
					14 => array(
						"name" => "Diamond Author",
						"desc" => "Has receieved more than 10 feedback.",
						"active" => false,
					),
					15 => array(
						"name" => "Emerald Author",
						"desc" => "Has receieved more than 20 feedback.",
						"active" => false,
					),


				);


				if (is_numeric($order_data)) {

					// 1. USER PROFILE
					$ud = get_the_author_meta("description", $order_data);
					if (strlen($ud) > 100) {

						$user_awards[1]['active'] = 1;
					}

					//2 . FAVS
					if ($CORE->USER("favs_count", $order_data) > 0) {

						$user_awards[2]['active'] = 1;
					}

					//3 .
					if (1 == 1) {

						$user_awards[3]['active'] = 1;
					}

					//4 .
					if (1 == 1) {

						$user_awards[4]['active'] = 1;
					}

					//5 .
					if (1 == 1) {

						$user_awards[5]['active'] = 1;
					}

					//6 .
					if (1 == 1) {

						$user_awards[6]['active'] = 1;
					}

					//7 .
					if (1 == 1) {

						$user_awards[7]['active'] = 1;
					}

					//8 .
					if (1 == 1) {

						$user_awards[8]['active'] = 1;
					}

					//9 .
					if (1 == 1) {

						$user_awards[9]['active'] = 1;
					}




					return $user_awards;

				} else {

					return $user_awards;

				}

			}
				break;

			case "get_account_links": {



				// BUILD ACCOUNT PAGE ITEMS
				$accountitems = array(

					"dashboard" => array(

						"name" => __("DASHBOARD", "premiumpress"),
						"desc" => __("This is the overview page of your account area.", "premiumpress"),
						"link" => _ppt(array('links', 'account')),
						"icon" => "fa-tachometer-alt-slow",
						"path" => 'dashboard',

					),

					"downloads" => array(

						"name" => __("MY DOWNLOADS", "premiumpress"),
						"desc" => __("Here you can manage your downloads.", "premiumpress"),
						"link" => "",
						"icon" => "fa-file",
						"path" => 'downloads',

					),

					"details" => array(
						"name" => __("MY SETTINGS", "premiumpress"),
						"desc" => __("This is where you can edit your profile details.", "premiumpress"),
						"path" => 'details',
						"icon" => "fa-user",
						"link" => "",

					),

					/*
								   "photo" => array(
								   
									   "name" => __("Change Photo","premiumpress"),
									   "desc" => __("Here you can change your account display photo.","premiumpress"),
									   "link" => "",
									   "icon" => "fa-camera",
									   "path" => 'photo',	
										
								   ),*/

					/*
								   "offers" => array(
								   
									   "name" => __("MY BIDS","premiumpress"),
									   "desc" => __("Here you can manage your website","premiumpress")." ".$CORE->LAYOUT("captions","offers"),
									   "link" => "",
									   "icon" => "fa-globe",
									   "path" => 'offers',	
										
								   
								   ),*/

					/*
								   "listings" => array(
								   
									   "name" => __(" INVENTORY","premiumpress"),
									   "desc" => __("Here you can manage your website","premiumpress")." ".$CORE->LAYOUT("captions","2"),
									   "link" => "",
									   "icon" => $CORE->LAYOUT("captions","icon"),
									   "path" => 'listings',	
										
								   
								   ),*/

					// "escrow" => array(

					// 	"name" => __("Escrow","premiumpress"),
					// 	"desc" => __("Here you can view escrow transactions.","premiumpress"),
					// 	"link" => "",
					// 	"icon" => "fa-sack",
					// 	"path" => 'escrow',
					// ),

					"financing" => array(

						"name" => __("Financing", "premiumpress"),
						"desc" => __("Here you can view all financing.", "premiumpress"),
						"link" => "",
						"icon" => "fa-sync",
						"path" => 'financing',
					),
					"transport" => array(

						"name" => __("Transport", "premiumpress"),
						"desc" => __("Here you can view all transport.", "premiumpress"),
						"link" => "",
						"icon" => "fa-truck",
						"path" => 'transport',
					),

					"messages" => array(

						"name" => __("Message", "premiumpress"),
						"desc" => __("Here you can view and send messages to other users.", "premiumpress"),
						"link" => "",
						"icon" => "fa-envelope",
						"path" => 'messages',
					),

					"cashback" => array(

						"name" => __("CASHBACK", "premiumpress"),
						"desc" => __("Here you can manage your cashback requests..", "premiumpress"),
						"link" => "",
						"icon" => "fa-sync",
						"path" => 'cashback',
						//"amount" => .

					),



					"likes" => array(

						"name" => __("FOLLOWERS", "premiumpress"),
						"desc" => __("Here you can see which users have liked your profile.", "premiumpress"),
						"link" => "",
						"icon" => "fa-heart",
						"path" => 'likes',

					),


					"friends" => array(

						"name" => __("MY FRIENDS", "premiumpress"),
						"desc" => __("Here you can manage your friends and friend requests.", "premiumpress"),
						"link" => "",
						"icon" => "fa-user-circle",
						"path" => 'friends',
						//"amount" => .

					),



					"membership" => array(

						"name" => __("MY MEMBERSHIP", "premiumpress"),
						"desc" => __("Here you can view your membership details.", "premiumpress"),
						"link" => "",
						"icon" => "fa-bullhorn",
						"path" => 'mymembership',

					),

					/*
								   "orders" => array(
								   
									   "name" => __("INVOICES","premiumpress"),
									   "desc" => __("Here you can view orders and download invoices.","premiumpress"),
									   "link" => "",
									   "icon" => "fa-credit-card",
									   "path" => 'orders',
								   
								   ),*/

					/*
								   "favs" => array(
								   
									   "name" => __("My Favorites","premiumpress"),
									   "desc" => __("This is the overview page of your account area.","premiumpress"),
									   "link" => home_url()."/?s=&favs=1",
									   "icon" => "fa-heart",					
								   ),*/


					"cashout" => array(

						"name" => __("MY BALANCE", "premiumpress"),
						"desc" => __("Here you can request to cashout some of your balance.", "premiumpress"),
						"link" => "",
						"icon" => "fa-sack",
						"path" => 'cashout',
						//"amount" => .

					),





					/*
								   "awards" => array(
								   
									   "name" => __("My Rewards","premiumpress"),
									   "desc" => __("Here you can request to cashout some of your balance.","premiumpress"),
									   "link" => "",
									   "icon" => "fa-badge",
									   "path" => 'awards',
								   
								   ),
								   */

					"sellspace" => array(

						"name" => __("ADVARTIZING", "premiumpress"),
						"desc" => __("Here you can request to cashout some of your balance.", "premiumpress"),
						"link" => "",
						"icon" => "fa-bullhorn",
						"path" => 'sellspace',

					),







				);

				if (THEME_KEY != "so") {
					unset($accountitems['downloads']);
				}

				if (THEME_KEY != "da") {
					unset($accountitems['likes']);
				}

				if (THEME_KEY == "da" && !in_array(_ppt(array('user', 'likes')), array("", "1"))) {
					unset($accountitems['likes']);
				}


				if (THEME_KEY != "cp") {
					unset($accountitems['cashback']);
				} else {


					if (_ppt(array('lst', 'cpcashback')) == '1') {
					} else {
						unset($accountitems['cashback']);
					}
				}


				// LISTINGS
				if ($CORE->LAYOUT("captions", "listings")) {

				} else {
					unset($accountitems['listings']);
				}



				// ADIN ONLY
				if (THEME_KEY == "at" && _ppt(array('lst', 'adminonly')) == 1) {

					unset($accountitems['listings']);

				} elseif (_ppt(array('lst', 'adminonly')) == 1) {

					unset($accountitems['listings']);
					//unset($accountitems['offers']);

				} elseif (_ppt(array('lst', 'websitepackages')) == "0") {

					unset($accountitems['listings']);
					unset($accountitems['offers']);

				}


				// ONLY ONE LISTING					 
				if (_ppt(array('lst', 'onelistingonly')) == "1" && !$CORE->USER("membership_hasaccess", "listings_multiple") && (THEME_KEY != "es" && get_user_meta($userdata->ID, "user_type", true) != 3)) {
					unset($accountitems['listings']);
				}



				if (in_array(THEME_KEY, array("jb", "mj")) && get_user_meta($userdata->ID, "user_type", true) == "user_fr") {
					unset($accountitems['listings']);
				}



				// MEMBERSHIPS					
				if ($CORE->LAYOUT("captions", "memberships")) {
					if (_ppt(array('mem', 'enable')) != 1) {
						unset($accountitems['membership']);
					}
				} else {
					unset($accountitems['membership']);
				}

				// MESSAGES
				if (_ppt(array('user', 'account_messages')) != 1) {
					unset($accountitems['messages']);
				}

				// FRIENDS
				if (_ppt(array('user', 'friends')) != 1 || in_array(THEME_KEY, array("dt", "sp", "cm", "cp", "vt", "jb", "rt", "so", "cp", "ph", "es"))) {
					unset($accountitems['friends']);
				}

				// FAVS
				if (_ppt(array('user', 'favs')) != 1) {
					unset($accountitems['favs']);
				}

				// INVOICES
				if (_ppt(array('user', 'orders')) != 1) {
					unset($accountitems['orders']);
				}

				// ADVERTISING
				if (_ppt(array('sellspace', 'enable')) != 1) {
					unset($accountitems['sellspace']);
				}

				// CASHOUT	
				if (_ppt(array('user', 'cashout')) != 1 && get_user_meta($userdata->ID, 'ppt_usercredit', true) < 1) {
					unset($accountitems['cashout']);
				}


				if (THEME_KEY == "sp") {

					unset($accountitems['offers']);
					unset($accountitems['listings']);
					unset($accountitems['membership']);

				}
				$user_roles = wp_get_current_user()->roles;
				if (in_array('subscriber', $user_roles) || in_array('customer', $user_roles)) {
					unset($accountitems['listings']);
				}

				if (in_array(THEME_KEY, array("vt", "cm")) || $CORE->LAYOUT("captions", "offers") == "") {

					unset($accountitems['offers']);

				}


				// EXTRAS
				if (THEME_KEY == "jb" && in_array(get_user_meta($userdata->ID, 'user_type', true), array("", "user_fr"))) {

					$accountitems['resumes'] = array(
						"name" => __("My Resumes", "premiumpress"),
						"desc" => __("Here you can upload and manage your resumes", "premiumpress"),
						"link" => "",
						"icon" => "fa-file",
						"path" => 'resume',
					);
				}

				// HIDE INTERVIEWS/ SINGLE OFFER
				if (_ppt(array('design', 'single-offers')) == "0") {
					unset($accountitems['offers']);
				}

				//$accountitems = hook_v9_account_options($accountitems);


				return $accountitems;


			}
				break;



		}
	}


	function image_avatar($avatar, $id_or_email, $size, $default)
	{
		global $wpdb;

		// GET USERID
		if (is_object($id_or_email)) {
			if (isset($id_or_email->ID))
				$id_or_email = $id_or_email->ID;
			//Comment
			else if ($id_or_email->user_id)
				$id_or_email = $id_or_email->user_id;
			else if ($id_or_email->comment_author_email)
				$id_or_email = $id_or_email->comment_author_email;
		}

		$userid = false;
		if (is_numeric($id_or_email))
			$userid = (int) $id_or_email;
		else if (is_string($id_or_email))
			$userid = (int) $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '" . esc_sql($id_or_email) . "'");

		// FALLBACK IF NOT AVATAR
		if (!$userid) {
			return $avatar;
		}

		// CHECK IF ISSET
		$userphoto = get_user_meta($userid, 'userphoto', true);

		if (is_array($userphoto) && isset($userphoto['path'])) {
			return "<img src='" . $userphoto['img'] . "' class='avatar img-fluid userphoto' alt='image' />";

		} elseif (get_user_meta($userid, 'myavatar', true) != "") {

			return "<img src='" . get_template_directory_uri() . "/framework/images/avatar/" . get_user_meta($userid, 'myavatar', true) . ".png' class='userphoto useravatar img-fluid'>";
		} else {
			return str_replace('avatar ', 'avatar img-fluid userphoto img-fluid ', $avatar);
		}
	}




	/* =============================================================================
	  Membership functions
	  ========================================================================== */

	function get_subscription($uid)
	{

		$f = get_user_meta($uid, 'ppt_subscription', true);

		return $f;

	}




	/* =============================================================================
		SOCIAL LOGIN
		========================================================================= */


	function sociallogin()
	{
		global $CORE;

		if (isset($_GET['sociallogin']) && $_GET['sociallogin'] && in_array($_GET['sociallogin'], array("Facebook", "Twitter", "LinkedIn", "Google", "Apple"))) {


			$pp = trim($_GET['sociallogin']);

			// LOAD DEFAULT
			$core_admin_values = get_option("core_admin_values");

			// CHECK TO MAKE SURE ITS ENABLED
			if (_ppt(array('register', 'sociallogin')) != 1) {
				die('social login disabled');
			}

			require_once(get_template_directory() . "/framework/Hybridauth/autoload.php");

			//First step is to build a configuration array to pass to `Hybridauth\Hybridauth`
			$config = [
				//Location where to redirect users once they authenticate with a provider
				'callback' => home_url() . '/wp-login.php?sociallogin=' . $_GET['sociallogin'],

				//Providers specifics
				'providers' => [
					'Twitter' => [
						'enabled' => true,     //Optional: indicates whether to enable or disable Twitter adapter. Defaults to false
						'keys' => [
							'key' => _ppt('social_twitter_key1'), //Required: your Twitter consumer key
							'secret' => _ppt('social_twitter_key2')  //Required: your Twitter consumer secret
						]
					],

					'Google' => [
						'enabled' => true,
						'keys' => [
							'id' => _ppt('social_google_key1'),
							'secret' => _ppt('social_google_key2'),
						]
					],

					'Facebook' => [
						'enabled' => true,
						'keys' => [
							'id' => _ppt('social_facebook_key1'),
							'secret' => _ppt('social_facebook_key2'),
						]
					],

					'Linkedin' => [
						'enabled' => true,
						'keys' => [
							'id' => _ppt('social_linkedin_key1'),
							'secret' => _ppt('social_linkedin_key2'),
						]
					],

					'Apple' => [
						'enabled' => true,
						'keys' => [
							'id' => _ppt('social_apple_key1'),
							'secret' => _ppt('social_apple_key2'),
						]
					],

				]
			];

			if ($pp == "Twitter") {
				$config['callback'] = home_url() . "/wp-login.php"; //.'?sociallogin='.$_GET['sociallogin'];
			}

			try {
				//Feed configuration array to Hybridauth
				$hybridauth = new Hybridauth($config);

				//Attempt to authenticate users with a provider by name
				$adapter = $hybridauth->authenticate($_GET['sociallogin']);

				//Returns a boolean of whether the user is connected with Twitter
				$isConnected = $adapter->isConnected();

				//Retrieve the user's profile
				$userProfile = $adapter->getUserProfile();

				if (empty($userProfile)) {
					header("location: " . wp_login_url() . "&social_error=1");
					exit();
				}

				// GET EMAIL
				$email = $userProfile->email;

				// GET IDENTIFIER
				$identifier = $userProfile->identifier;

				// CHECK IF WERE ALREADY LOGGED IN							
				$founddata = $CORE->USER("check_identifier_exists", $identifier);

				if ((is_array($founddata) && !empty($founddata)) || ($email != "" && email_exists($email))) {


					if (is_array($founddata) && !empty($founddata)) {
						$huser = get_user_by('email', $founddata['user_email']);
					} else {
						$huser = get_user_by('email', $email);
					}

					// CREATE NEW PASSWORD
					$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);

					// UPDATE ACCOUNT WITH NEW PASS
					$data = array();
					$data['user_pass'] = $random_password;
					$data['ID'] = $huser->data->ID;
					wp_update_user($data);

					// UPDATE IDENTIFIER
					update_user_meta($huser->data->ID, 'sociallogin_identifier', $identifier);

					// LOGIN						 
					$ff = $this->USER_LOGIN($huser->data->user_login, $random_password);

					// REDIRECT
					header("location: " . _ppt(array('links', 'myaccount')));
					exit();

				}


				//Disconnect the adapter 
				$adapter->disconnect();

				$fname = $userProfile->firstName;
				$lname = $userProfile->lastName;
				$dname = $userProfile->displayName;

				$photo = $userProfile->photoURL;

				if ($email == "") {
					die("Could not get your email address. Please register using the standard registration form.");
				}

				// DISPLAY NAME
				if ($dname == "") {
					$gg = explode("@", $email);
					$newusername = $gg[0] . date('s');
				} else {
					$newusername = $dname;
				}

				// CHECK IF USERNAME EXISTS
				if (username_exists($newusername)) {
					$newusername = $newusername . "1";
				}

				$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
				$_POST['password'] = $random_password;

				// CREATE NEW USER
				$errors = $CORE->USER_REGISTER($newusername, $random_password, $email, 1, 0, 0);

				// IF HAS ERRORS					 
				if (is_wp_error($errors)) {
					echo '<h4>' . $errors->get_error_message() . '</h4>';
					die();
				}

				// SET USER ONLINE			
				$this->USER("set_online", $errors->data->ID);

				// UPDATE USER DATA
				if (strlen($photo) > 1) {
					update_user_meta($errors->data->ID, 'ppt_userphoto', $photo);
				}

				// SETUP DEFAULT MEMBERSHIP
				if ($CORE->LAYOUT("captions", "memberships")) {

					$sd = $CORE->USER("get_this_membership", _ppt(array('mem', 'regmembership')));
					if (is_array($sd)) {
						update_user_meta(
							$errors->data->ID,
							'ppt_subscription',
							array(
								"key" => _ppt(array('mem', 'regmembership')),
								"date_start" => date("Y-m-d H:i:s"),
								"date_expires" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + " . $sd['days'] . " days")),

							)
						);
					}
				}

				// EXTRA
				$data['ID'] = $errors->data->ID;
				$data['first_name'] = strip_tags($fname);
				$data['last_name'] = strip_tags($lname);
				wp_update_user($data);

				// ADD ON IDENIFIA
				update_user_meta($errors->data->ID, 'sociallogin_identifier', $identifier);

				// LOGIN LANGUAGE
				if (_ppt(array('lang', 'switch')) == "1" && is_array(_ppt('languages')) && !empty(_ppt('languages'))) {

					$u_lang = get_user_meta($errors->data->ID, 'language', true);
					if ($u_lang != "") {
						$u_lang = "?l=" . $u_lang;
					}

				}

				// REDIRECT
				header("location: " . _ppt(array('links', 'myaccount')) . $u_lang);
				exit();



			} catch (\Exception $e) {
				echo '<h4>' . $e->getMessage() . '</h4>';
				print_r($config);
				die();
			}



		}

	}


	/*
		this function displays the 
		registration fields for users
	*/
	function user_fields($userid = "")
	{
		$taborder = 10;
		$string = "";

		$regfields = get_option("regfields");

		if (is_array($regfields) && !empty($regfields)) {

			$i = 0;
			if (!is_array($regfields['name'])) {
				return;
			}
			foreach ($regfields['name'] as $data) {

				if (isset($regfields['name'][$i]) && strlen($regfields['name'][$i]) > 2) {

					// IF IS USER GET VALUE
					$value = "";
					if (is_numeric($userid) && (isset($GLOBALS['flag-account']) || is_admin())) {
						$value = get_user_meta($userid, $regfields['key'][$i], true);
					}


					// COL BREASK
					$col0 = "col-xs-12 col-md-12 form-group";
					$col1 = "col-md-12";
					$col2 = "col-md-12";

					if (isset($GLOBALS['flag-account'])) {
						$col0 = "col-md-6 form-group";
						$col1 = "";
						$col2 = "";
					}

					// REQUIRED
					if (!isset($regfields['required'][$i])) {
						$regfields['required'][$i] = 0;
					}

					// SWITCH FOR TAXONOMY
					if ($regfields['type'][$i] == "tax") {
						$regfields['values'][$i] = $regfields['tax_name'][$i];

					} elseif ($regfields['type'][$i] == "post_type") {
						$regfields['values'][$i] = $regfields['posttype_name'][$i];
					}



					if (isset($GLOBALS['flag-register']) && isset($regfields['signup'][$i]) && $regfields['signup'][$i] == 0) {



					} else {

						ob_start();
						?>
						<div class="<?php echo $col0; ?> ">

							<?php if (!isset($GLOBALS['flag-account'])) { ?>
								<div class="row"><?php } ?>


								<?php if (!isset($GLOBALS['flag-register'])) { ?>

									<div class="<?php echo $col1; ?>">

										<label class="col-form-label">

											<?php echo stripslashes($regfields['name'][$i]); ?>

											<?php if ($regfields['required'][$i] == 1) { ?>
												<span class="text-danger">*</span>
											<?php } ?>

										</label>

									</div>

								<?php } ?>

								<div class="<?php echo $col2; ?>">

									<?php if (!isset($regfields['values'][$i])) {
										$regfields['values'][$i] = "";
									} ?>

									<?php echo $this->fieldtype($regfields['type'][$i], $regfields['key'][$i], $regfields['values'][$i], $taborder, $value, $regfields['required'][$i], $regfields['name'][$i]); ?>

								</div>

								<?php if (!isset($GLOBALS['flag-account'])) { ?>
								</div><?php } ?>

						</div>
						<?php
						$string .= ob_get_clean();
					}



					$taborder++;


				} // is blank name			
				$i++;
			} // end foreach

		} // end is array	

		return $string;

	}

	function fieldtype($type, $key, $value = "", $taborder = 1, $user_value = "", $required = 0, $label = "")
	{
		global $wpdb, $userdata;

		// IF REQUIRED ADD ON EXTRA CLASS
		$eclass = "";

		if ($required != 0 && ($required == 1 || $required == "yes")) {
			$eclass = "required";
		}

		// DEFAULT VALUE
		if ($user_value == "" && $value != "") { // && !isset($_GET['eid']) 
			$user_value = $value;
		}

		ob_start();
		switch ($type) {


			case "time": {
				if ($user_value == "") {
					$user_value = date('Y-m-d H:i:s');
				}
				$db = explode(" ", $user_value);

				?>


					<script>
						jQuery(document).ready(function () { jQuery('#field-<?php echo $key; ?>-date').datetimepicker({ format: 'yyyy-mm-dd hh:ii:ss', fontAwesome: 1, todayBtn: true, pickerPosition: "bottom-right" }); });
					</script>

					<div class="row">
						<div class="col-md-12">
							<div class="input-group date" id="field-<?php echo $key; ?>-date">

								<input type="text" name="custom[<?php echo $key; ?>]" tabindex="<?php echo $taborder; ?>"
									value="<?php echo esc_attr($user_value); ?>" class="form-control rounded-0 <?php echo $eclass; ?>">

								<span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;">
									<span class="fal fa-calendar"></span>
								</span>
							</div>

						</div>
					</div>

			<?php
			}
				break;


			case "date": {
				if ($user_value == "") {
					$user_value = date('Y-m-d H:i:s');
				}
				$db = explode(" ", $user_value);

				?>


					<script>
						jQuery(document).ready(function () { jQuery('#field-<?php echo $key; ?>-date1').datetimepicker({ format: 'yyyy-mm-dd hh:ii:ss', fontAwesome: 1 }); });
					</script>



					<div class="row" <?php if (is_admin()) { ?>style="margin:-5px;" <?php } ?>>
						<div class="col-md-12">
							<div class="input-group  date" id="field-<?php echo $key; ?>-date1">



								<input type="text" name="custom[<?php echo $key; ?>]" tabindex="<?php echo $taborder; ?>"
									value="<?php echo esc_attr($user_value); ?>"
									class="form-control <?php if (is_admin()) { ?>hasaddon<?php } else { ?>rounded-0 <?php echo $eclass; ?> <?php } ?>">

								<span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;">
									<span class="fal fa-calendar"></span>
								</span>
							</div>
						</div>
					</div>

			<?php
			}
				break;

			case "post_type": {


				$SQL = "SELECT DISTINCT ID, post_title 
		   FROM " . $wpdb->prefix . "posts
		   WHERE " . $wpdb->prefix . "posts.post_status = 'publish' 
		   AND " . $wpdb->prefix . "posts.post_type = '" . $value . "'
		   ORDER BY " . $wpdb->prefix . "posts.post_title ASC
		   LIMIT 100";

				$results = $wpdb->get_results($SQL);

				if (count($results) > 0 && !empty($results)) {
					?>
						<select class="form-control rounded-0 <?php echo $eclass; ?>" name="custom[<?php echo $key; ?>]"
							tabindex="<?php echo $taborder; ?>">
							<option></option>
						<?php foreach ($results as $val) {

							// SETUP SELECTED VALUE
							if ($user_value == $val->ID) {
								$b = "selected=selected";
							} else {
								$b = "";
							}

							?>
								<option value="<?php echo $val->ID; ?>" <?php echo $b; ?>><?php echo $val->post_title; ?></option>
						<?php } ?>

						</select>

				<?php } ?>


			<?php
			}
				break;

			case "tax": {


				$terms = get_terms($value, 'hide_empty=0&parent=0');
				$selec = (isset($_GET['pr'])) ? $_GET['pr'] : '';


				if (!isset($terms->errors) && count($terms) > 2) {
					?>

						<select class="form-control rounded-0 <?php echo $eclass; ?>" name="custom[<?php echo $key; ?>]"
							tabindex="<?php echo $taborder; ?>">
							<option></option>
						<?php
						foreach ($terms as $term_inn) {

							// SETUP SELECTED VALUE
							if ($user_value == $term_inn->term_id) {
								$b = "selected=selected";
							} else {
								$b = "";
							}

							echo "<option value='" . $term_inn->term_id . "' " . $b . "> " . $term_inn->name . " (" . $term_inn->count . ") </option>";

						}
						?>

						</select>

				<?php } ?>

			<?php

			}
				break;

			case "percentage": {


				?>

					<div class="row">
						<div class="col-md-12">
							<div class="input-group">
								<span class="input-group-prepend"><span class="input-group-text bg-white">%</span></span>
								<input type="text" name="custom[<?php echo $key; ?>]" maxlength="255"
									class="form-control rounded-0 val-numeric <?php echo $eclass; ?>" tabindex="<?php echo $taborder; ?>"
									value="<?php echo esc_attr($user_value); ?>" id="field-<?php echo $key; ?>" />
							</div>
						</div>
					</div>

					<script>
						jQuery("#field-<?php echo $key; ?>").change(function () {
							jQuery("#field-<?php echo $key; ?>").val(jQuery("#field-<?php echo $key; ?>").val().replace(',', ''));
						});
					</script>

			<?php
			}
				break;

			case "price": {


				?>

					<div class="row">
						<div class="col-md-12">
							<div class="input-group">
								<span class="input-group-prepend"><span
										class="input-group-text bg-white"><?php echo hook_currency_symbol(''); ?></span></span>
								<input type="text" name="custom[<?php echo $key; ?>]" maxlength="255"
									class="form-control rounded-0 val-numeric <?php echo $eclass; ?>" tabindex="<?php echo $taborder; ?>"
									value="<?php echo esc_attr($user_value); ?>" id="field-<?php echo $key; ?>" />
							</div>
						</div>
					</div>

					<script>
						jQuery("#field-<?php echo $key; ?>").change(function () {
							jQuery("#field-<?php echo $key; ?>").val(jQuery("#field-<?php echo $key; ?>").val().replace(',', ''));
						});
					</script>

			<?php
			}
				break;

			case "input": {


				// CLEAR VALUE ON REGISTER PAGE
				if (!isset($GLOBALS['flag-account']) && !is_admin() && !isset($GLOBALS['flag-add'])) {
					$user_value = "";
					$value = "";
				}
				?>


					<input type="input" <?php if (isset($GLOBALS['flag-register'])) { ?>placeholder="<?php echo $label; ?>" <?php } ?>
						name="custom[<?php echo $key; ?>]" class="form-control rounded-0 <?php echo $eclass; ?>"
						tabindex="<?php echo $taborder; ?>" value="<?php echo esc_attr($user_value); ?>" id="field-<?php echo $key; ?>" />


				<?php
			}
				break;

			case "textarea": {
				?>
					<textarea <?php if (isset($GLOBALS['flag-register'])) { ?>placeholder="<?php echo $label; ?>" <?php } ?>
						name="custom[<?php echo $key; ?>]" rows="10" class="form-control rounded-0 <?php echo $eclass; ?> height:100px"
						style=" height:100px !important;" tabindex="<?php echo $taborder; ?>"
						id="field-<?php echo $key; ?>"><?php echo esc_textarea($user_value); ?></textarea>
				<?php
			}
				break;

			case "select": {

				if (is_array($value)) {
					$options = $value;
				} else {
					$options = explode(PHP_EOL, $value);
				}

				?>



				<?php if (isset($GLOBALS['flag-register'])) { ?>
						<div class="mb-2 small"><?php echo $label; ?></div><?php } ?>
					<select name="custom[<?php echo $key; ?>]" class="form-control rounded-0" tabindex="<?php echo $taborder; ?>"
						id="field-<?php echo $key; ?>">


					<?php if (is_array($options)) {
						foreach ($options as $key => $val) {

							$val = trim($val);

							if ($user_value == $key) { ?>
									<option value="<?php echo $key; ?>" selected=selected><?php echo $val; ?></option>
							<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php
							}
						}
					}// end foreach
					?>
					</select>


			<?php
			}
				break;
			case "checkbox":
			case "radio": {

				if (is_array($value)) {
					$options = $value;
				} else {
					$options = explode(PHP_EOL, $value);
				}

				?>
					<div class="form-check pl-0">
						<div class="container pl-0">
							<div class="row">


								<?php
								if (is_array($options)) {
									foreach ($options as $k => $val) { ?>

										<div class="col-md-6 col-xl-4">

											<?php

											$val = trim($val);


											if ($k != "" && !is_numeric($k)) {

												if (is_array($user_value) && in_array($k, $user_value)) { ?>


													<label class="<?php echo $type; ?> custom-control custom-checkbox">
														<input type="<?php echo $type; ?>" class="form-control custom-control-input"
															data-toggle="<?php echo $type; ?>" name="custom[<?php echo $key; ?>][]"
															value="<?php echo $k; ?>" checked=checked>
														<span class="custom-control-label"></span>
													<?php echo $val; ?>
													</label>
											<?php } else { ?>
													<label class="<?php echo $type; ?> custom-control custom-checkbox">
														<input type="<?php echo $type; ?>" class="form-control custom-control-input"
															data-toggle="<?php echo $type; ?>" name="custom[<?php echo $key; ?>][]"
															value="<?php echo $k; ?>">
														<span class="custom-control-label"></span>
													<?php echo $val; ?>
													</label>
												<?php
												}


											} else {

												if (is_array($user_value) && in_array($val, $user_value)) { ?>
													<label class="<?php echo $type; ?> custom-control custom-checkbox">
														<input type="<?php echo $type; ?>" class="form-control custom-control-input"
															data-toggle="<?php echo $type; ?>" name="custom[<?php echo $key; ?>][]"
															value="<?php echo $val; ?>" checked=checked>
														<span class="custom-control-label"></span>
													<?php echo $val; ?>
													</label>
											<?php } else { ?>
													<label class="<?php echo $type; ?> custom-control custom-checkbox">
														<input type="<?php echo $type; ?>" class="form-control custom-control-input"
															data-toggle="<?php echo $type; ?>" name="custom[<?php echo $key; ?>][]"
															value="<?php echo $val; ?>">
														<span class="custom-control-label"></span>
													<?php echo $val; ?>
													</label>
												<?php
												}

											}

											?>
										</div><!-- end col 6 -->
								<?php


									}
								}// end foreach
								?>
							</div>
						</div>
					</div>
				<?php
			}
				break;

		}
		return ob_get_clean();
	}




	/*
		   this function gets the users
		   feedback rating and vote count
	   */



	/*
	   this function counts the users
	   posts with/without membership
	   */
	function count_user_posts_by_type($userid, $post_type = 'post', $EXTRA = "", $include_membershipdate = true)
	{
		global $wpdb, $userdata;

		$where = get_posts_by_author_sql($post_type, true, $userid);

		// CHECK IF USER IS ASSIGNED TO A MEMBERSHIP AND SO ONLY COUNT LISTINGS AFTER THEIR MEMBERSHIP WAS ASSIGNED
		if ($userid == $userdata->ID && $include_membershipdate) {

			$mem_startdate = get_user_meta($userid, 'ppt_membership_started', true);
			if (strlen($mem_startdate) > 1) {
				$where .= " AND post_date > '" . $mem_startdate . "'";
			}

		}

		// ADD IN PENDING LISTINGS TOO

		$where = str_replace("post_status = 'publish'", "post_status = 'publish' OR post_status = 'pending'", $where);

		$count = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->prefix . "posts $where $EXTRA");


		return apply_filters('get_usernumposts', $count, $userid);
	}





	// NEEDS REDOING
	function user_feedback_exists($postid, $userid)
	{
		global $wpdb;

		if (!is_numeric($postid)) {
			return false;
		}

		// CHECK IF WE HAVE ALREADY LEFT FEEDBACK FOR THIS USER + ITEM
		$SQL = "SELECT " . $wpdb->postmeta . ".post_id, " . $wpdb->posts . ".post_author, " . $wpdb->postmeta . ".meta_value FROM " . $wpdb->postmeta . " 
					INNER JOIN " . $wpdb->posts . " ON ( " . $wpdb->postmeta . ".post_id = " . $wpdb->posts . ".ID  AND " . $wpdb->posts . ".post_author='" . $userid . "' )
					WHERE " . $wpdb->postmeta . ".meta_key = 'pid' AND " . $wpdb->postmeta . ".meta_value= ('" . $postid . "') AND " . $wpdb->posts . ".post_type = 'ppt_feedback' LIMIT 0,100";

		$result = $wpdb->get_results($SQL);

		if (empty($result)) {
			return false;
		} else {
			return true;
		}

	}


	/*
		   This function gets the users membership
		   name for the icon
	   
	   */
	function user_membership_name($userid)
	{
		global $userdata;


		$cm = get_user_meta($userid, 'ppt_subscription', true);

		if (is_array($cm) && !empty($cm['key'])) {

			return $this->get_subscription_name($userid) . " " . __("membership", "premiumpress");

		} else {
			return __("Member", "premiumpress");
		}

	}
	/*
		   This function gets the users favorties list
		   data
	   
	   */
	function user_favs($userid = "")
	{
		global $CORE, $userdata, $wpdb;

		$extn = "_list";
		if (defined('WP_ALLOW_MULTISITE')) {
			$extn .= get_current_blog_id();
		}
		$my_list = get_user_meta($userid, 'favorite' . $extn, true);
		if (!is_array($my_list)) {
			$my_list = array();
		}
		return $my_list;


	}



	/*
		   This function gets a list of recently viewed posts
		   and updated the users recently viewed list
	   
	   */
	function user_recentlyviewed($userid = "", $postid = "", $get = false)
	{
		global $post, $userdata, $wpdb;

		if (isset($GLOBALS['done_recentlyviewed'])) {
			return;
		}
		$GLOBALS['done_recentlyviewed'] = true;

		$recent = get_user_meta($userid, "recentlyviewed", true);

		if (!is_array($recent)) {
			$recent = array();
		}

		// REMOVE DUPLICATES
		$recent = array_unique($recent);

		if ($get) {

			return $recent;

		} else {

			// RESET
			if (count($recent) > 20) {
				update_user_meta($userid, "recentlyviewed", "");
			}

			$recent[$post->ID] = $post->ID;

			update_user_meta($userid, "recentlyviewed", $recent);
		}

	}

	/*
		   This function gets a list of posts
		   by a single user.	
	   */
	function user_posts($userid = "1", $limit = 100, $status = "publish")
	{
		global $wpdb;


		if (!is_numeric($userid)) {
			return false;
		}

		$SQL = "SELECT " . $wpdb->posts . ".* FROM " . $wpdb->posts . " 
		WHERE " . $wpdb->posts . ".post_author='" . $userid . "' 
		AND " . $wpdb->posts . ".post_type = 'listing_type' 
		AND " . $wpdb->posts . ".post_status = '" . $status . "' 
		ORDER BY " . $wpdb->posts . ".post_date 
		DESC LIMIT " . $limit;

		$result = $wpdb->get_results($SQL);


		if (empty($result)) {
			return false;
		} else {
			return $result;
		}

	}






	/* =============================================================================
		 PAGE ACCESS
		  ========================================================================== */

	function Authorize()
	{

		global $wpdb, $post;

		$user = wp_get_current_user();
		if ($user->ID == 0) {
			nocache_headers();

			if (_ppt(array('links', 'login')) != "") {
				wp_redirect(_ppt(array('links', 'login')) . '?noaccess=1&redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
			} else {
				wp_redirect(get_option('siteurl') . '/wp-login.php?noaccess=1&redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
			}

			exit();
		}
	}


	/* =============================================================================
			 LOGIN FUNCTION 
		   ========================================================================== */

	function LOGIN()
	{
		global $pagenow;


		// FIX FOR ELEMENTOR STYLES NOT SHOWING
		if (defined('ELEMENTOR_VERSION') && _ppt(array('pageassign', 'header')) != "") {

			if (substr(_ppt(array('pageassign', 'header')), 0, 9) == "elementor") {

				//wp_register_style( 'e1', home_url().'/wp-content/uploads/elementor/css/global.css');	 
				//wp_enqueue_style( 'e1' );

				if (defined('ELEMENTOR_PRO_VERSION')) {
					wp_register_style('e2', home_url() . '/wp-content/plugins/elementor-pro/assets/css/frontend.min.css');
					wp_enqueue_style('e2');
				}

			}
		}

		if (!isset($_GET["action"])) {
			$_GET["action"] = "";
		}

		switch ($_GET["action"]) {
			case 'lostpassword':
			case 'retrievepassword':
				$GLOBALS['flag-password'] = true;
				$this->_show_password();
				break;
			case 'register': {
				$GLOBALS['flag-register'] = true;
				$this->_show_register();
			}
				break;
			case 'resetpass':
			case 'rp': {
				$GLOBALS['flag-resetpassword'] = true;
				$this->_show_resetpass();
			}
				break;

			case 'login':
			default: {
				$GLOBALS['flag-login'] = true;
				$this->_show_login();
			}
				break;


		}
		die();
	} // END LOGIN	



	function _show_resetpass()
	{

		global $CORE, $wp_error;
		$string = "";

		/*	
			  // CHECK FOR RESET
			  if(isset($_GET['key']) && isset($_GET['login']) ){
			  
				  $user = check_password_reset_key($_GET['key'], $_GET['login']); 		
				
				  if ( is_wp_error($user) ) {
					  wp_redirect( site_url('wp-login.php?action=lostpassword&error=invalidkey') );
					  exit;
				  }
			  
				  $errors = new WP_Error();
			  
				  if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
					  $errors->add( 'password_reset_mismatch', 'The passwords do not match.'  );
			  
				  do_action( 'validate_password_reset', $errors, $user );
			  
				  if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
					  reset_password($user, $_POST['pass1']);
					  wp_redirect( site_url('wp-login.php?action=login') );
					  exit;
				  }
			  
				  wp_enqueue_script('utils');
				  wp_enqueue_script('user-profile');
				  
				  // CHECK FOR ERRORS		
				  if(isset($_POST['pass1'])){
				  $string .= $this->_show_errors($errors);
				  } 
			  
			  }// end check
			  
			  // LOAD IN PAGE TEMPLATE
			  _ppt_template( 'page', 'reset' );
			  
			  */

	}

	function _show_password()
	{
		global $CORE, $errortext, $wpdb;

		if (isset($_POST['user_login']) && $_POST['user_login']) {

			$errors = new WP_Error();

			if (!function_exists('retrieve_password')) {
				//include(str_replace("wp-content","",WP_CONTENT_DIR)."/wp-includes/user.php");
				$errors = $this->retrieve_password1();
			} else {
				$errors = retrieve_password();
			}


			// ADD LOG ENTRY AND REDIRECT USER
			if (!is_wp_error($errors)) {

				// CONFIRM
				wp_redirect('wp-login.php?checkemail=confirm');
				exit();
			} else {

				$errortext = $this->_show_errors($errors);

			}

			do_action('lostpassword_post');

		}

		// CHECK FOR ERRORS
		if (isset($_GET['error']) && $_GET['error'] == 'invalidkey') {
			$errors = new WP_Error();

			$errors->add('invalidkey', __("Sorry, that key does not appear to be valid.", "premiumpress"), 'cp');
			$errors->add('registermsg', __("Please enter your username or e-mail address. You will receive a new password via e-mail.", "premiumpress"), 'message');


		}

		if (!isset($_POST['user_login'])) {
			$_POST['user_login'] = "";
		}

		if (!isset($errors)) {
			$errors = "";
		}

		if (isset($_POST['user_login'])) {
			$errortext = $this->_show_errors($errors);
		}

		// LOAD IN PAGE TEMPLATE
		_ppt_template('page', 'forgottenpassword');

	}


	function retrieve_password1()
	{

		$errors = new WP_Error();

		if (empty($_POST['user_login']) || !is_string($_POST['user_login'])) {

			$errors->add('empty_username', __('Enter a username or email address.', 'premiumpress'));

		} elseif (strpos($_POST['user_login'], '@')) {

			$user_data = get_user_by('email', trim(wp_unslash($_POST['user_login'])));


			if (empty($user_data)) {

				$errors->add('invalid_email', __('There is no account with that username or email address.', 'premiumpress'));
			}


		} else {
			$login = trim($_POST['user_login']);
			$user_data = get_user_by('login', $login);
		}


		do_action('lostpassword_post', $errors);

		if ($errors->has_errors()) {

			return $errors;
		}

		if (!$user_data) {


			$errors->add('invalidcombo', __('There is no account with that username or email address.', 'premiumpress'));
			return $errors;
		}

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key = get_password_reset_key($user_data);

		if (is_wp_error($key)) {


			return $key;
		}

		if (is_multisite()) {
			$site_name = get_network()->site_name;
		} else {
			/*
			 * The blogname option is escaped with esc_html on the way into the database
			 * in sanitize_option we want to reverse this for the plain text arena of emails.
			 */
			$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		}

		$message = __('Chúng tôi xác nhận rằng mật khẩu của tài khoản Autocoin của bạn đã được đặt lại thành công.
Nếu bạn là người khởi tạo việc thay đổi mật khẩu này, không cần thêm bất kỳ hành động nào từ phía bạn.
Nếu bạn không yêu cầu việc thay đổi này hoặc nghi ngờ về việc truy cập tài khoản của mình mà không được ủy quyền, vui lòng liên hệ ngay lập tức với đội ngũ hỗ trợ của chúng tôi tại  Admin@autocoin.vn để được hỗ trợ thêm.
Cảm ơn bạn đã lựa chọn Autocoin. An toàn cho tài khoản của bạn là ưu tiên của chúng tôi.', 'premiumpress') . "\r\n\r\n";
		/* translators: %s: site name */
		$message .= sprintf(__('Site Name: %s', 'premiumpress'), $site_name) . "\r\n\r\n";
		/* translators: %s: user login */
		$message .= sprintf(__('Username: %s', 'premiumpress'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'premiumpress') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:', 'premiumpress') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

		/* translators: Password reset email subject. %s: Site name */
		$title = sprintf(__('Xác Nhận Thay Đổi Mật Khẩu Cho Tài Khoản [%s] Của Bạn', 'premiumpress'), $site_name);

		/**
		 * Filters the subject of the password reset email.
		 *
		 * @since 2.8.0
		 * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters('retrieve_password_title', $title, $user_login, $user_data);

		/**
		 * Filters the message body of the password reset mail.
		 *
		 * If the filtered message is empty, the password reset email will not be sent.
		 *
		 * @since 2.8.0
		 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters('retrieve_password_message', $message, $key, $user_login, $user_data);

		if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message)) {
			wp_die(__('The email could not be sent.', 'premiumpress') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.', 'premiumpress'));
		}

		return true;
	}

	function USER_LOGIN($username, $pass, $return = 0)
	{
		global $user, $CORE, $errortext;

		$creds = array();
		$creds['user_login'] = $username;
		$creds['user_password'] = $pass;
		$creds['remember'] = true;

		// CHECK FOR SEEL BUT ALSO CHECK USER SETUP
		if (strpos(get_option('siteurl'), "https") == false) {	 //if ( is_ssl() && !force_ssl_admin() ){		
			$secure_cookie = '';
		} else {
			$secure_cookie = true;
		}

		// CHECK FOR EMAIL LOGIN
		if (strpos($creds['user_login'], "@") !== false) {

			$e = get_user_by('email', $creds['user_login']);
			if (is_object($e) && isset($e->data->user_login)) {
				$creds['user_login'] = $e->data->user_login;
			}
		}

		// FIX FOR SHOPPING CART DROPPING SESSIONS DURING LOGIN
		if (isset($_SESSION['ppt_cart']) && is_array($_SESSION['ppt_cart'])) {
			$cd = $_SESSION['ppt_cart'];
		}

		$user = wp_signon($creds, $secure_cookie);

		// RESET 
		if (isset($cd)) {
			$CORE->start_session();
			$_SESSION['ppt_cart'] = $cd;
		}



		// SEE IF LOGIN WAS SUCCESSFULL			
		if (is_wp_error($user)) {

			$err_codes = $user->get_error_codes();

			// Invalid username.
			// Default: '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?'
			if (in_array('invalid_username', $err_codes)) {
				return __("The login credentials you entered were incorrect.", "premiumpress");
			}

			if (in_array('incorrect_password', $err_codes)) {
				return __("The login credentials you entered were incorrect.", "premiumpress");
			}

			if (in_array('invalid_email', $err_codes)) {
				return __("Unknown email address. Check again or try your username.", "premiumpress");
			}



			return $user->get_error_message();

		} elseif (!is_wp_error($user)) {


			//CHECK FOR USER MEMBERSHIP DATA, IF ITS EXPIRED ASK THEM TO PAY AGAIN
			$membership_payment_due = get_user_meta($user->ID, 'ppt_membership_due', true);

			if (is_numeric($membership_payment_due) && $membership_payment_due > 0) {

				// LOG USER OUT
				wp_logout();

				// REDIRECT TO PAYMENT
				if ($return) {

					return home_url() . "/wp-login.php?action=membership&uid=" . $user->ID;

				} else {

					header("location: " . home_url() . "/wp-login.php?action=membership&uid=" . $user->ID);
					exit();

				}

			}


			// UPDATE LAST LOGINS				 					
			update_user_meta($user->ID, 'login_lastdate', current_time('mysql'));

			// LOGIN IP
			update_user_meta($user->ID, 'login_ip', $this->get_client_ip());

			// UPDATE LOGIN COUNT
			$ll = get_user_meta($user->ID, 'login_count', true);
			if (!is_numeric($ll)) {
				$ll = 0;
			}
			$ll++;
			update_user_meta($user->ID, 'login_count', $ll);

			// SET USER ONLINE
			$this->USER("set_online", $user->ID);

			// CLEAN-UP FAVS LIST
			$extn = "_list";
			if (defined('WP_ALLOW_MULTISITE')) {
				$extn .= get_current_blog_id();
			}
			$my_list = get_user_meta($user->ID, 'favorite' . $extn, true);

			if (!is_array($my_list)) {
				$my_list = array();
			}
			foreach ($my_list as $hk => $hh) {
				if ($hh == 0 || $hh == "") {
					unset($my_list[$hk]);
				} elseif (get_post_status($hh) != 'publish' && get_post_type($hh) != THEME_TAXONOMY . "_type") {
					unset($my_list[$hk]);
				}
			}
			update_user_meta($user->ID, 'favorite' . $extn, $my_list);

			// ADMIN LINK
			$admin_link = admin_url();

			// CHECK FOR EMAIL				
			$data = array(
				"username" => $CORE->USER("get_name", $user->ID),
			);
			$this->email_system($user->ID, 'login', $data);


			// SET ALL USER LISITNGS TO ONLINE
			$CORE->USER("set_online_listings", $user->ID);

			// SEND EMAIL
			$data1 = array(
				"user_id" => $user->ID,
				"username" => $CORE->USER("get_username", $user->ID),
				"first_name" => $CORE->USER("get_first_name", $user->ID),
				"last_name" => $CORE->USER("get_last_name", $user->ID),
				"email" => $CORE->USER("get_email", $user->ID),
			);
			$CORE->email_system("admin", "admin_user_login", $data1);


			// REDIRECT USER TO ACCOUNT PAGE
			if (isset($_POST['redirect_to']) && strlen($_POST['redirect_to']) > 1) {

				$redirect_to = $_POST['redirect_to'];

			} elseif (user_can($user->ID, 'administrator') || user_can($user->ID, 'contributor')) {

				//if(user_can($user->ID, 'administrator')){
				$redirect_to = $admin_link . "admin.php?page=premiumpress";
				//}else{
				//$redirect_to = $admin_link."";
				//}


			} else {

				// LOGIN LANGUAGE
				$u_lang = get_user_meta($user->ID, 'language', true);
				if ($u_lang != "") {
					$u_lang = "?l=" . $u_lang;
				}

				$redirect_to = _ppt(array('links', 'myaccount')) . $u_lang;
			}

			if ($redirect_to == "") {
				$redirect_to = get_home_url();
			}

			// ADD LOG
			$CORE->FUNC(
				"add_log",
				array(
					"type" => "user_login",
					"userid" => $user->data->ID,
				)
			);


			if ($return) {
				return $redirect_to;
			} else {
				header("location: " . $redirect_to);
				exit();
			}

		}

	}


	function USER_REGISTER($user, $pass, $email, $savedata = array(), $return = 0)
	{

		global $CORE, $wpdb;

		// REGISTER THE NEW USER			 
		$errors = wp_create_user($user, $pass, $email);

		// CHECK FOR ERRORS	 
		if (is_wp_error($errors)) {

			return $errors->get_error_message();

		} else {

			// ADD-ON FIRST / LAST NAME	
			$fname = "";
			if (isset($savedata["first_name"]) && $savedata["first_name"] != "") {
				$data = array();
				$data['ID'] = $errors;
				$data['first_name'] = esc_html(strip_tags($savedata["first_name"]));
				wp_update_user($data);
				$fname = $savedata["first_name"];
			}

			$lname = "";
			if (isset($savedata["last_name"]) && $savedata["last_name"] != "") {
				$data = array();
				$data['ID'] = $errors;
				$data['last_name'] = esc_html(strip_tags($savedata["last_name"]));
				wp_update_user($data);
				$lname = $savedata["last_name"];
			}

			// CUSTOM FIELDS
			if (isset($savedata['custom']) && is_array($savedata['custom']) && !empty($savedata['custom'])) {

				foreach ($savedata['custom'] as $kk => $vv) {
					if ($vv != "") {
						update_user_meta($errors, $kk, $vv);
					}
				}
			}

			// SETUP DEFAULT MEMBERSHIP
			if (_ppt(array('mem', 'regmembership')) != "" & strlen(_ppt(array('mem', 'regmembership'))) > 1) {

				$sd = $CORE->USER("get_this_membership", _ppt(array('mem', 'regmembership')));

				if (is_array($sd) && isset($sd['duration'])) {
					update_user_meta(
						$errors,
						'ppt_subscription',
						array(
							"key" => _ppt(array('mem', 'regmembership')),
							"date_start" => date("Y-m-d H:i:s"),
							"date_expires" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + " . $sd['duration'] . " days")),
							"listings" => 0,
							"flistings" => 0,
						)
					);
				}


			} else {

				if (is_numeric(_ppt('mem0_listings_count')) && _ppt('mem0_listings_count') > 0) { // DEFAULT FOR NON-MMEBERS

					update_user_meta($errors, "free_listings_count", _ppt('mem0_listings_count'));

				}


				if (is_numeric(_ppt('mem0_listings_max_count')) && _ppt('mem0_listings_max_count') > 0) { // DEFAULT FOR NON-MMEBERS					 

					update_user_meta($errors, "free_listings_max_count", _ppt('mem0_listings_max_count'));

				}

				if (is_numeric(_ppt('mem0_max_msg_count')) && _ppt('mem0_max_msg_count') > 0) { // DEFAULT MAX MESSAGES					 

					update_user_meta($errors, "max_msg_count", _ppt('mem0_max_msg_count'));

				}


			}




			// SETUP DEFAULT MEMBERSHIP FOR DATING THEME
			if (THEME_KEY == "da" && isset($savedata['custom']['da-seek1']) && is_numeric($savedata['custom']['da-seek1'])) {

				$cats = get_terms('dagender', array('hide_empty' => 0, 'parent' => 0));
				if (!empty($cats)) {
					foreach ($cats as $cat) {
						if ($cat->parent != 0) {
							continue;
						}


						if ($savedata['custom']['da-seek1'] == $cat->term_id && _ppt(array('mem', 'regmembership_' . $cat->term_id)) != "") {


							$sd = $CORE->USER("get_this_membership", _ppt(array('mem', 'regmembership_' . $cat->term_id)));

							if (is_array($sd) && isset($sd['duration'])) {
								update_user_meta(
									$errors,
									'ppt_subscription',
									array(
										"key" => _ppt(array('mem', 'regmembership_' . $cat->term_id)),
										"date_start" => date("Y-m-d H:i:s"),
										"date_expires" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + " . $sd['duration'] . " days")),
										"listings" => 0,
										"flistings" => 0,
									)
								);
							}

						}

					}
				}

			}

			// CUSTOM TYPE MEMBERSHIP			
			if (in_array(THEME_KEY, array("es", "jb", "mj", "ll")) && isset($savedata['custom']['user_type']) && _ppt(array('usertype', $savedata['custom']['user_type'] . '_mem')) != "") {

				$sd = $CORE->USER("get_this_membership", _ppt(array('usertype', $savedata['custom']['user_type'] . '_mem')));


				if (is_array($sd) && isset($sd['duration'])) {
					update_user_meta(
						$errors,
						'ppt_subscription',
						array(
							"key" => _ppt(array('usertype', $savedata['custom']['user_type'] . '_mem')),
							"date_start" => date("Y-m-d H:i:s"),
							"date_expires" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " + " . $sd['duration'] . " days")),
							"listings" => 0,
							"flistings" => 0,
						)
					);
				}

			}



			// ADD LOG					
			$CORE->FUNC(
				"add_log",
				array(
					"type" => "user_registered",
					"userid" => $errors,
					"email_data" => array(
						"user_id" => $errors,
						"username" => $user,
						"first_name" => $fname,
						"last_name" => $lname,
						"password" => $pass,
						"email" => $email
					)
				)
			);

			// ADD LOG					
			$CORE->FUNC(
				"add_log",
				array(
					"type" => "user_verify",
					"userid" => $errors,
					"email_data" => array(
						"user_id" => $errors,
						"username" => $user,
						"first_name" => $fname,
						"last_name" => $lname,
						"password" => $pass,
						"email" => $email
					)
				)
			);


			// WELCOME INBOX MESSAGE				
			$welcomemsg = stripslashes(get_option('ppt_email_inboxwelcome'));
			if (strlen($welcomemsg) > 3) {

				$my_post = array();
				$my_post['post_title'] = "new conversation";
				$my_post['post_content'] = strip_tags(strip_tags($welcomemsg));
				$my_post['post_excerpt'] = "";
				$my_post['post_status'] = "publish";
				$my_post['post_type'] = "ppt_message";
				$my_post['post_author'] = 1;
				$POSTID = wp_insert_post($my_post);

				add_post_meta($POSTID, "sender_id", 1);
				add_post_meta($POSTID, "reciever_id", $errors);

				// EASY TO FIND CUSTOM FIELD
				add_post_meta($POSTID, "msg_stick", "[" . $errors . "][1]");
				add_post_meta($POSTID, "msg_status", "unread_" . $errors);
			}




			// DA - AUTO CREATE USER LISTING

			if (_ppt(array('register', 'da_autocreate')) == 1) {
				$canBuild = 1;
			}

			if (in_array(THEME_KEY, array("es")) && isset($savedata['custom']['user_type']) && in_array($savedata['custom']['user_type'], array(2, 3, 4, 5, 6))) {
				$canBuild = 1;
			}

			if (in_array(THEME_KEY, array("da", "ex", "es")) && $canBuild) {

				$my_post = array(
					'post_type' => 'listing_type',
					'post_title' => $user,
					'post_modified' => current_time('mysql'),
					'post_excerpt' => ' ',
					'post_content' => ' ',
					'post_author' => $errors,
				);

				if (_ppt(array('lst', 'default_listing_status')) == "pending") {
					$my_post['post_status'] = "pending_approval";
				} else {
					$my_post['post_status'] = "publish";
				}

				$POSTID = wp_insert_post($my_post);

			}



			// SEND EMAIL
			$data1 = array(
				"user_id" => $errors,
				"username" => $user,
				"first_name" => $fname,
				"last_name" => $lname,
				"password" => $pass,
				"email" => $email,
			);
			$CORE->email_system("admin", "admin_user_new", $data1);


			// AUTO LOGIN NEW USER IF THEY SETUP A PASSWORD				
			$creds = array();
			$creds['user_login'] = $user;
			$creds['user_password'] = $pass;
			$creds['remember'] = true;
			$user = wp_signon($creds, false);

			// GET REDIRECT LINK				
			if (isset($savedata['redirect_to'])) {
				$redirect_to = $savedata['redirect_to'];
			} else {
				$redirect_to = _ppt(array('links', 'myaccount'));
			}

			// REDIRECT USER TO ACCOUNT PAGE	
			if ($return) {
				return $redirect_to;
			} else {
				header("location: " . $redirect_to);
				exit();
			}


		}// no errors


	}

	function _show_register()
	{

		global $CORE, $errortext, $errorStyle;
		$user_login = '';
		$user_email = '';

		$errorStyle = "alert-danger";


		// CHECK IF REGISTRATION IS ENABLED
		if (!get_option('users_can_register') && !defined('WLT_DEMOMODE')) {
			wp_redirect(esc_url(site_url()) . '/wp-login.php?registration=disabled');
			exit();
		}

		// LOAD IN ERRORS
		$errors = new WP_Error();

		// PERFORM ACTION AFTER USER SUBMISSION
		if (isset($_POST['ppt_spam_hash']) && isset($_POST['user_login']) && strlen($_POST['user_login']) > 2 && empty($errors->errors)) {

			// CLEAN UP USER INPUT
			$sanitized_user_login = sanitize_user($_POST['user_login']);
			$user_email = apply_filters('user_registration_email', $_POST['user_email']);


			// BASIC FORM VALIDATION			
			if (_ppt(array('captcha', 'enable')) == 1 && _ppt(array('captcha', 'sitekey')) != "") {
				$canContinue = google_validate_recaptcha();
				if (!$canContinue) {
					$errors->add('registered', __("The security question answer is incorrect.", "premiumpress"), 'error');
				}
			}

			if (_ppt('register_mobilenum') == 1 && strlen($_POST['custom']['mobile-num']) < 8) {

				$errors->add('registered', __("Please enter a valid mobile number.", "premiumpress"), 'error');
			}

			if (isset($_POST['first_name']) && $_POST['first_name'] == $_POST['last_name']) {
				$errors->add('registered', __("Your first &amp; last names cannot be the same.", "premiumpress"), 'error');
			}


			if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
				$errors->add('registered', __("The email address provided is invalid.", "premiumpress"), 'error');
			}

			if (_ppt(array('register', 'password')) == 1 && (isset($_POST['pass1']) && $_POST['pass1'] == "") || (isset($_POST['pass1']) && strlen($_POST['pass1']) < 5)) {

				$errors->add('registered', __("The password cannot be blank or less than 5 characters.", "premiumpress"), 'error');
			}


			if (_ppt(array('register', 'password')) == 1 && ($_POST['pass1'] != $_POST['pass2'])) {
				$errors->add('registered', __("The passwords don't match.", "premiumpress"), 'error');
			}


			// CHECK FOR PLUGIN ERRORS
			$errors = apply_filters('registration_errors', $errors, $sanitized_user_login, $user_email);

			// CONTINUE ONTO STEP 1
			if ($errors->get_error_code()) {

			} else {

				// GENERATE PASSWORD
				if (_ppt(array('register', 'password')) == '1' && $_POST['pass2'] != "") {
					$_POST['password'] = strip_tags($_POST['pass2']);
				} else {
					$random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
					$_POST['password'] = $random_password;
				}

				// CREATE NEW USER
				$errors = $this->USER_REGISTER($sanitized_user_login, $_POST['password'], $user_email, _ppt(array('register', 'password')));

				// USER NEEDS TO LOGIN
				if (is_string($errors)) {

					$errors = new WP_Error();

					$errors->add('loggedout', __("The login details have been sent to your email.", "premiumpress"), 'message');


				}

			} // END ERROR CHECK 1	


		}// END PERFORM ACTION

		// CHECK FOR ERRORS 
		if (isset($sanitized_user_login)) {
			$errortext = $this->_show_errors($errors);
		}

		// LOAD IN PAGE TEMPLATE
		_ppt_template('page', 'register');

	}
	function _show_login()
	{

		global $CORE, $errortext, $errorStyle;
		$errors = new WP_Error();

		$errorStyle = "alert-danger";

		if (isset($_GET['fr']) && _ppt(array('register', 'password')) == '1') {

			$errors->add('loggedout', __("Registration complete, you can now login.", "premiumpress"), 'message');
			$errorStyle = "alert-success";

		} elseif (isset($_GET['fr'])) {

			$errors->add('loggedout', __("The login details have been sent to your email.", "premiumpress"), 'message');

			$errorStyle = "alert-info";
		}

		// PERFORM LOGIN CHECKS // ACCESS DETAILS
		if (isset($_GET['noaccess'])) {

			$errors->add('loggedout', __("Please login to access this page.", "premiumpress"), 'message');

		} elseif (isset($_GET['socialloginerror'])) {

			$errors->add('loggedout', __("Not enough information from your social profile could be found. Please use the register page to create a new profile on our website.", "premiumpress"), 'message');

		} elseif (isset($_GET['loggedout']) && TRUE == $_GET['loggedout']) {

			$errors->add('loggedout', __("You are now logged out.", "premiumpress"), 'message');
			$errorStyle = "alert-info";

		} elseif (isset($_GET['registration']) && 'disabled' == $_GET['registration']) {

			$errors->add('registerdisabled', "" . __("User registration is currently not allowed.", "premiumpress"));

		} elseif (isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail']) {

			$errors->add('confirm', __("The login details have been sent to your email.", "premiumpress"), 'message');
			$errorStyle = "alert-info";

		} elseif (isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail']) {

			$errors->add('newpass', __("Check your e-mail for your new password.", "premiumpress"), 'message');
			$errorStyle = "alert-info";

		} elseif (isset($_GET['checkemail']) && 'registered' == $_GET['checkemail']) {

			$errors->add('registered', __("Registration complete.", "premiumpress"), 'message');
			$errorStyle = "alert-success";
		}

		// CHECK FOR PLUGIN ERRORS 
		if (isset($_POST['log']) && strlen($_POST['log']) > 1) {
			$plugin_error = apply_filters('login_errors', '');
			if (strlen($plugin_error) > 5) {
				$errors->add('registered', $plugin_error, 'error');
			}
		}

		// CHECK FOR BASIC ERRORS AND THAT THE FORUM HAS BEEN PRESSED
		if (empty($errors->errors) && isset($_POST['log'])) {

			// CHECK FOR SECURE LOGINS
			if (is_ssl() && !force_ssl_admin()) {
				$secure_cookie = false;
			} else {
				$secure_cookie = '';
			}

			// LOGIN USER
			$errors = $this->USER_LOGIN($_POST['log'], $_POST['pwd']);


		} // end basic validation		

		// CHECK FOR ERRORS	
		$errortext = $this->_show_errors($errors);

		// LOAD IN REGISTER PAGE TEMPLATE
		_ppt_template('page', 'login');

	}
	function _show_errors($wp_error)
	{

		global $error, $CORE;

		if (!empty($error)) {
			$wp_error->add('error', $error);
			unset($error);
		}

		if (!empty($wp_error)) {


			if (is_object($wp_error) && $wp_error->get_error_code()) {

				$errors = '';
				$messages = '';

				foreach ($wp_error->get_error_codes() as $code) {

					$severity = $wp_error->get_error_data($code);

					if ($code == "invalidcombo") {

						return __('There is no account with that username or email address.', 'premiumpress');

					} elseif ($code == "incorrect_password" || $code == "invalid_username") {

						return __("The login credentials you entered were incorrect.", "premiumpress");

					} else {
						// disable default WP error message
						foreach ($wp_error->get_error_messages($code) as $error) {
							if ('message' == $severity)

								$messages .= $error;
							else
								$errors .= $error;
						}
					}
				}
				if (!empty($errors))
					//echo $COREDesign->GL_ALERT( $errors ,"error");
					return $errors;
				if (!empty($messages))
					//echo $COREDesign->GL_ALERT( $messages ,"success");
					return $messages;
			}
		}
	}


}

?>