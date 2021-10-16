<?php

/* REST endpoints */
add_action('rest_api_init', function () {
	$namespace = 'clx/v1';

	register_rest_route($namespace, '/send_feedback', [
		'methods'             => 'POST',
		'callback'            => 'send_feedback',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/register', [
		'methods'             => 'POST',
		'callback'            => 'register',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/google_register', [
		'methods'             => 'POST',
		'callback'            => 'google_register',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/authorize', [
		'methods'             => 'POST',
		'callback'            => 'authorize',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/update_user', [
		'methods'             => 'POST',
		'callback'            => 'update_user',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/send_mail', [
		'methods'             => 'POST',
		'callback'            => 'send_mail',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/change_signature', [
		'methods'             => 'POST',
		'callback'            => 'change_signature',
		'permission_callback' => '__return_true'
	]);

	// Songs
	register_rest_route($namespace, '/songs', [
		'methods'             => 'GET',
		'callback'            => 'get_songs',
		'permission_callback' => '__return_true',
		'args' => [
			'id' => [
				'type' => 'integer'
			],
			'limit' => [
				'type' => 'integer',
				'default' => 10
			],
			'offset' => [
				'type' => 'integer'
			],
		]
	]);
	register_rest_route($namespace, '/songs', [
		'methods'             => 'POST',
		'callback'            => 'create_song',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/songs', [
		'methods'             => 'DELETE',
		'callback'            => 'delete_song',
		'permission_callback' => '__return_true',
		'args' => [
			'id' => [
				'type' => 'integer',
				'required' => true
			]
		]
	]);

	// Albums
	register_rest_route($namespace, '/albums', [
		'methods'             => 'GET',
		'callback'            => 'get_albums',
		'permission_callback' => '__return_true',
		'args' => [
			'id' => [
				'type' => 'integer',
			],
			'limit' => [
				'type' => 'integer',
				'default' => 10
			],
			'offset' => [
				'type' => 'integer'
			],
		]
	]);
	register_rest_route($namespace, '/albums', [
		'methods'             => 'POST',
		'callback'            => 'create_album',
		'permission_callback' => '__return_true'
	]);
	register_rest_route($namespace, '/albums', [
		'methods'             => 'DELETE',
		'callback'            => 'delete_album',
		'permission_callback' => '__return_true',
		'args' => [
			'id' => [
				'type' => 'integer',
				'required' => true
			]
		]
	]);
});

/* REST callbacks */
function send_feedback(WP_REST_Request $request)
{
	$params = $request->get_params();
	$resp = ['success' => false];
	$msg_body = '';
	$admin_email = get_field('mail_address', 'option'); // TODO: change to acf field
	$headers = [
		'from' => $admin_email,
		'content-type' => 'text/html'
	];

	// Email validation
	if (!preg_match('/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9|\-])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $params['email'])) {
		$resp['fields'][] = 'email';
		return json_encode($resp);
	}

	foreach ($params as $key => $value) {
		if (!$value) continue;
		$msg_body .= ucwords($key) . ": $value \r\n";
	}

	$resp['success'] = true;
	$resp['message'] = $msg_body;
	wp_mail($admin_email, 'Jewishmusic contact form', $msg_body, $headers);
	return json_encode($resp);
}


/* REST callbacks sign up */
function register(WP_REST_Request $request)
{
	$params = $request->get_params();
	$resp = ['success' => false];

	// Phone validation
	if (!preg_match('/(^\+?[0-9]{10,15}$)/', $params['phone'])) {
		$resp['fields'][] = 'phone';
	}

	// Email validation
	if (!preg_match('/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9|\-])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $params['email'])) {
		$resp['fields'][] = 'email';
	}

	//Password validator
	if (($params['password'] !== $params['confirm_password'])) {
		$resp['fields'][] = 'password';
		$resp['fields'][] = 'confirm_password';
	}

	if (isset($resp['fields'])) {
		return json_encode($resp);
	}

	$user_email = $params['email'];
	$pattern = '/@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
	$replacement = '';
	$user_login = preg_replace($pattern, $replacement, $params['email']);

	$userdata = array(
		'user_pass'       => wp_hash_password($params['password']),
		'user_login'      => $user_login,
		'user_email'      => $user_email,
		'user_pass'       => $params['password'],
		'first_name'      => $params['first_name'],
		'last_name'       => $params['last_name'],
		'description'     => $params['phone'],
		'show_admin_bar_front' => 'false',
	);

	$id = wp_insert_user($userdata);
	wp_signon([
		'user_login'    => $user_login,
		'user_password' => $params['password'],
		'remember'      => true,
	]);

	if (is_wp_error($id)) {
		$resp['error_message'] =  $id->get_error_message();
		return json_encode($resp);
	}

	update_user_meta($id, 'user_avatar', get_template_directory_uri() . '/assets/images/user-logo.svg');

	$resp['redirect'] = '/account';
	$resp['success'] = true;
	return json_encode($resp);
}

/* REST callbacks sign in */
function authorize(WP_REST_Request $request)
{
	$params = $request->get_params();
	$resp = ['success' => false];

	// Email validation
	if (!preg_match('/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9|\-])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $params['email'])) {
		$resp['fields'][] = 'email';
		return json_encode($resp);
	}

	$creds = [
		'user_login' => $params['email'],
		'user_password' => $params['password'],
		'remember' => $params['check']
	];

	$user = wp_signon($creds);

	if (is_wp_error($user)) {
		$resp['error_string'] = $user->get_error_message();
		return json_encode($resp);
	}

	$resp['success'] = true;
	$resp['redirect'] = '/account';
	return json_encode($resp);
}

/* REST callbacks account page */
function update_user(WP_REST_Request $request)
{
	$params = $request->get_params();
	$user_id = $params['user_id'];
	$resp = ['success' => false];

	// Email validation
	if (isset($params['account_mail']) && !preg_match('/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9|\-])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $params['account_mail'])) {
		$resp['fields'][] = 'account_mail';
	}

	//Password validator
	if (($params['account_password'] !== '') && ($params['account_password'] !== $params['account_confirm'])) {
		$resp['fields'][] = 'account_password';
		$resp['fields'][] = 'account_confirm';
	}

	// Stop execution if errors
	if (isset($resp['fields'])) {
		return json_encode($resp);
	}

	// Start data updating
	$userdata = [
		'ID' => $user_id
	];

	if ( isset( $params['account_password'] ) && !empty( $params['account_password'] ) ) {
		$userdata['user_pass'] = $params['account_password'];
	}

	if ( isset( $params['account_mail'] ) ) {
		$userdata['user_email'] = $params['account_mail'];
	}

	if ( isset( $params['account_name'] ) ) {
		$userdata['display_name'] = $params['account_name'];
	}

	wp_update_user($userdata);

	if (isset($_FILES['user_avatar'])) {
		$img_upload = media_handle_upload('user_avatar', 0);
		$img_url = wp_get_attachment_url($img_upload);
		update_user_meta($user_id, 'user_avatar', $img_url);
	}

	if ( isset( $params['user_signature'] ) ) {
		$image = save_base64($params['user_signature'], "{$user_id}_signature");
		update_user_meta($user_id, 'user_signature', $image['url']);
	}

	$resp['success'] = true;
	return json_encode($resp);
}

/* Songs */
function create_song(WP_REST_Request $request) {
	$params = $request->get_params();
	$user_id = $params['user_id'];
	$response = ['success' => false];
	unset($params['user_id']);

	$user_info = get_userdata($user_id);
	$user_name = $user_info->display_name;
	$admin_email = get_field('mail_for_upload', 'option'); // TODO: change to acf field
	$headers = ["From: $admin_email", 'Content-Type: text/html; charset=UTF-8'];

	$post_id = isset($params['post_id'])
		? $params['post_id']
		: wp_insert_post([
			'post_title'    => wp_strip_all_tags($_POST['song_name']),
			'post_status'   => 'publish',
			'post_type'     => 'song',
			'post_author'   => $user_id,
			'post_category' => array(8, 39),
		]);
	$is_new = !isset($params['post_id']);
	unset( $params['post_id'] );

	if (is_wp_error($post_id)) {
		$response['error'] = [
			'message' => $post_id->get_error_message()
		];
		wp_send_json( $response );
	}

	foreach ($params as $key => $value) {
		$normal_key = str_replace('_', ' ', $key);

		if ( $key == 'genre' ) {
			$genre_info = implode(", ", $value);
			update_field('genre', $genre_info, $post_id);
			continue;
		}
		update_field($key, $value, $post_id);
	}

	if ( $_FILES['song_cover']['error'] === 0 ) {
		$img_id = media_handle_upload('song_cover', $post_id);
		set_post_thumbnail($post_id, $img_id);
	}

	if ( $_FILES['song_artist_photo']['error'] === 0 ) {
		$img_id = media_handle_upload('song_artist_photo', $post_id);
		update_field('song_artist_photo', $img_id, $post_id);
	}

	if ( $_FILES['song_file']['error'] === 0 ) {
		$file_id = media_handle_upload('song_file', $post_id);
		update_field('song_file', $file_id, $post_id);
	}

	$html = generate_mail_html($post_id, $user_id, $is_new);
	wp_mail($admin_email, 'Jewish music - song update', $html, $headers);

	$response['post_id'] = $post_id;
	$response['success'] = true;
	return json_encode($response);
}

function delete_song(WP_REST_Request $request)
{
	$response = ['success' => false];
	$id = $request->get_param('id');
	$deleted_post = wp_delete_post($id, true);

	if (is_null($deleted_post)) {
		$resp['message'] = 'No such post';
		return json_encode($resp);
	}

	$response['success'] = true;
	$response['id'] = $id;
	return json_encode($response);
}

function get_songs(WP_REST_Request $request)
{
	$response_songs = [];
	$params = $request->get_params();

	$args = [
		'post_type' => 'song',
		'posts_per_page' => $params['limit']
	];

	if ( isset($params['id']) ) {
		$args['post__in'] = [$params['id']];
	}

	if ( isset($params['author']) ) {
		$args['author'] = $params['author'];
	}

	if ( isset($params['offset']) ) {
		$args['offset'] = $params['offset'];
	}

	$query = new WP_Query($args);
	$count = 0;

	while ($query->have_posts()) {
		$query->the_post();
		$id = get_the_ID();

		$response_songs[$count]['id'] = $id;
		$response_songs[$count]['fields'] = get_fields($id);
		$response_songs[$count]['fields']['thumbnail'] = get_the_post_thumbnail_url($id);

		$count++;
	};
	wp_reset_postdata();
	wp_send_json($response_songs);
}

/* Albums */
function create_album(WP_REST_Request $request) {
	$params = $request->get_params();
	$user_id = $params['user_id'];
	$user_info = get_userdata( $user_id );
	$response = ['success' => false];
	$song_array = get_songs_array( $params );
	$delete_queue = isset($params['delete_queue']) ? explode(',', $params['delete_queue']) : '';
	$user_name = $user_info->display_name;
	$admin_email = get_field('mail_for_upload', 'option'); // TODO: change to acf field
	$headers = ["From: $admin_email", 'Content-Type: text/html; charset=UTF-8'];

	unset($params['user_id']);
	unset($params['delete_queue']);

	if ( isset($params['ch1']) ) {
		unset( $params['ch1'] );
	}

	if ( isset($params['ch2']) ) {
		unset( $params['ch2'] );
	}

	// Create post
	$post_id = isset( $params['post_id'] )
		? $params['post_id']
		: wp_insert_post([
			'post_title'    => wp_strip_all_tags($_POST['album_name']),
			'post_status'   => 'publish',
			'post_type'   => 'album',
			'post_author'   => $user_id
		]);
	$is_new = !isset( $params['post_id'] );

	unset( $params['post_id'] );

	if ( is_wp_error($post_id) ) {
		$response['error'] = ['message' => $post_id->get_error_message()];
		return $response;
		wp_die();
	}

	// Fill ACF fields
	foreach ($params as $key => $value) {
		if ( stristr($key, 'song_name') || stristr($key, 'song_file') ) continue;
		$normal_key = str_replace('_', ' ', $key);

		if ( $key === 'genre' ) {
			$genre_info = implode(", ", $value);
			update_field('genre', $genre_info, $post_id);
			continue;
		}

		update_field($key, $value, $post_id);
	}

	// Fill file fields
	foreach ($song_array as $index => $song_item) {
		$file_index = "song_file_$index";

		if ( $_FILES[$file_index]['error'] === 0 ) {
			$file_id = media_handle_upload($file_index, $post_id);

			if ( is_wp_error($file_id) ) {
				$response['error'] = [
					'message' => $file_id->get_error_message()
				];
				return $response;
				wp_die();
			}

			$song_item['song_file'] = $file_id;
		}

		update_row('album_songs', $index, $song_item, $post_id);
	}

	// Remove file fields
	if ( $delete_queue ) {
		foreach ($delete_queue as $val) {
			if ( in_array($val, array_keys($song_array)) || !$val ) continue;

			update_row('album_songs', $val, [
				'song_name' => '',
				'song_name_he' => '',
				'song_file' => false
			], $post_id);
			delete_row('album_songs', $val, $post_id);
		}
	}

	// Set album cover
	if ( $_FILES['album_cover']['error'] === 0 ) {
		$img_id = media_handle_upload('album_cover', $post_id);
		set_post_thumbnail($post_id, $img_id);
	}

	if ( $_FILES['album_artist_photo']['error'] === 0 ) {
		$img_id = media_handle_upload('album_artist_photo', $post_id);
		update_field('album_artist_photo', $img_id, $post_id);
	}

	$response['post_id'] = $post_id;
	$response['success'] = true;

	$html = generate_mail_html($post_id, $user_id, $is_new);
	wp_mail($admin_email, 'Jewish music - album update', $html, $headers);
	return json_encode($response);
}

function get_songs_array ( $params ) {
	$songs_array = [];
	$song_fields = array_filter($params, function ($key) {
		return stristr($key, 'song_name');
	}, ARRAY_FILTER_USE_KEY);

	foreach ($song_fields as $key => $val) {
		if ( stristr($key, 'he') ) continue;

		$row_index = substr($key, -1);
		$songs_array[$row_index] = [
			'song_name' => $song_fields["song_name_$row_index"],
			'song_name_he' => $song_fields["song_name_he_$row_index"],
		];
	}

	return $songs_array;
}

function delete_album(WP_REST_Request $request)
{
	$response = ['success' => false];
	$id = $request->get_param('id');
	$deleted_post = wp_delete_post($id, true);

	if (is_null($deleted_post)) {
		$resp['message'] = 'No such post';
		return json_encode($resp);
	}

	$response['success'] = true;
	$response['id'] = $id;
	return json_encode($response);
}

function get_albums(WP_REST_Request $request)
{
	$response_albums = [];
	$params = $request->get_params();

	$args = [
		'post_type' => 'album',
		'posts_per_page' => $params['limit']
	];

	if ( isset($params['id']) ) {
		$args['post__in'] = [$params['id']];
	}

	if ( isset($params['author']) ) {
		$args['author'] = $params['author'];
	}

	if ( isset($params['offset']) ) {
		$args['offset'] = $params['offset'];
	}

	$query = new WP_Query($args);
	$count = 0;

	while ($query->have_posts()) {
		$query->the_post();
		$id = get_the_ID();

		$response_albums[$count]['id'] = $id;
		$response_albums[$count]['fields'] = get_fields($id);
		$response_albums[$count]['fields']['thumbnail'] = get_the_post_thumbnail_url($id);

		$count++;
	};
	wp_reset_postdata();
	wp_send_json($response_albums);
}

/* REST callbacks Forgot Password */
function send_mail(WP_REST_Request $request)
{
	$params = $request->get_params();
	$resp = ['success' => false];
	$msg_body = '';
	$user_mail = $params['mail_recovery'];
	// $admin_email = 'admin@coelix.com'; // TODO: change to acf field
	$headers = [
		'from' => $admin_email,
		'content-type' => 'text/html'
	];

	// Email validation
	if (!preg_match('/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9|\-])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/', $user_mail)) {
		$resp['fields'][] = 'mail_recovery';
		return json_encode($resp);
	}

	$password = wp_generate_password(10);

	if ($user = get_user_by('email', $user_mail)) {
		$user_id = $user->ID;
		$userdata = [
			'ID'              => $user_id,
			'user_pass'       => $password,
		];
		wp_update_user($userdata);
	} else {
		return json_encode($resp);
	}

	$msg_body = 'Someone has requested a password reset for the following account:
		Site name: jewish-music
		Your temporary password: ' . $password;

	$resp['success'] = true;
	$resp['message'] = $msg_body;
	wp_mail($user_mail, 'Password recovery', $msg_body, $headers);
	return json_encode($resp);
}


/* Google authorization */
function google_register(WP_REST_Request $request)
{
	$params = $request->get_params();
	$resp = ['success' => false];

	$user_email = $params['mail'];
	$password = wp_generate_password(10);

	$pattern = '/@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
	$replacement = '';
	$user_login = preg_replace($pattern, $replacement, $params['mail']);

	$user = get_user_by('login', $user_login);
	if ($user) {
		$user_id = $user->ID;

		wp_set_auth_cookie($user_id, true);

		$resp['redirect'] = '/account';
		$resp['success'] = true;
		return json_encode($resp);
	}

	$userdata = array(
		'user_pass'       => wp_hash_password($password),
		'user_login'      => $user_login,
		'user_email'      => $user_email,
		'user_pass'       => $password,
		'display_name'      => $params['name'],
		'show_admin_bar_front' => 'false',
	);

	wp_insert_user($userdata);

	wp_signon([
		'user_login'    => $user_login,
		'user_password' => $password,
		'remember'      => true,
	]);

	$resp['redirect'] = '/account';
	$resp['success'] = true;
	$resp['info'] = $params;
	return json_encode($resp);
}

function generate_mail_html ($post_id, $user_id, $is_new = true) {
	$html = '<html><body>';
	$fields = get_fields( $post_id );
	$user = get_userdata( $user_id );
	$post_type = get_post_type( $post_id );

	$html .= $is_new
		? "<h1>New " . ucwords($post_type) . " uploaded</h1>"
		: "<h1>" . ucwords($post_type) . " updated</h1>";

	$html .= '<table rules="all" cellpadding="10" style="border: 1px solid #666">';

	$html .= "<tr><td>Name Of User:</td> <td>{$user -> user_firstname} {$user -> user_lastname}</td></tr>";
	$html .= "<tr><td>Email Of User:</td> <td>{$user -> user_email}</td></tr>";
	$html .= "<tr><td>Phone number Of User:</td> <td>{$user -> description}</td></tr>";

	$html .= "<tr><td>Artist name in English:</td> <td>{$fields["$post_type" . "_artist"]}</td></tr>";
	$html .= "<tr><td>Artist name in Hebrew:</td> <td>{$fields["$post_type" . "_artist_he"]}</td></tr>";

	$html .= "<tr><td>" . ucwords($post_type) . " name in English:</td> <td>{$fields[$post_type . '_name']}</td></tr>";
	$html .= "<tr><td>" . ucwords($post_type) . " name in Hebrew:</td> <td>{$fields[$post_type . '_name_he']}</td></tr>";

	$html .= "<tr><td>Genres:</td> <td> {$fields['genre']}</td></tr>";

	if ( $post_type === 'album' ) {
		$html .= "<tr><td>Release date:</td> <td>{$fields['album_release_date']}</td></tr>";
		$html .= "<tr><td>Record label:</td> <td>{$fields['album_record_label']}</td></tr>";
	} else {
		$html .= "<tr><td>Release date:</td> <td>{$fields['release_date']}</td></tr>";
		$html .= "<tr><td>Record label:</td> <td>{$fields['record_label']}</td></tr>";
	}

	$html .= "<tr><td>Artwork download link:</td> <td>" . get_the_post_thumbnail_url( $post_id ) . "</td></tr>";

	if ( $fields["{$post_type}_artist_photo"] ) {
		$html .= "<tr><td>Artist photo download link:</td> <td>" . $fields["{$post_type}_artist_photo"] . "</td></tr>";
	}

	if ( isset( $fields['song_file'] ) ) {
		$html .= "<tr><td>Song download link:</td> <td>{$fields['song_file']['url']}</td></tr>";
	}

	if ( isset( $fields['album_songs'] ) ) {
		$count = 1;
		foreach ( $fields['album_songs'] as $song ) {
			$html .= "<tr><td>Song $count name in English:</td> <td>{$song['song_name']}</td></tr>";
			$html .= "<tr><td>Song $count name in Hebrew:</td> <td>{$song['song_name_he']}</td></tr>";
			$html .= "<tr><td>Song $count name download link:</td> <td>{$song['song_file']['url']}</td></tr>";
			$count ++;
		}
	}

	if ( isset( $fields['album_comment'] ) ) {
		$html .= "<tr><td>Comment:</td><td>{$fields['album_comment']}</td></tr>";
	}

	if ( isset( $fields['song_comment'] ) ) {
		$html .= "<tr><td>Comment:</td><td>{$fields['song_comment']}</td></tr>";
	}

	$html .= "<tr><td>The form was signed by user:</td> <td>yes</td></tr>";

	if ( $is_new ) {
		$checkbox_text = get_field('checkbox_text', 'option');
		$html .= "<tr><td>" . $checkbox_text['terms_and_conditions'] . "</td> <td>checked by user</td></tr>";
		$html .= "<tr><td>" . $checkbox_text['privacy_policy'] . "</td> <td>checked by user</td></tr>";
	}


	$signature_url = get_user_meta($user_id, 'user_signature', true);
	if ( $signature_url ) {
		$html .= "<tr><td><img src='$signature_url'></td></tr>";
	}

	$html .= '</table></body></html>';

	return $html;
}

function change_signature ( WP_REST_Request $request ) {
	$user_id = $request -> get_param('user_id');
	$userdata = get_userdata( $user_id );
	$hash = wp_hash( random_bytes(5) );
	$message_body = "Go to this link to proceed verification: " . home_url() . "/verification?hash=$hash";

	update_user_meta( $user_id, 'hash', $hash );
	update_user_meta( $user_id, 'hash_verified', false );

	wp_mail( $userdata -> user_email, 'Jewish Music - Verification letter', $message_body );
	wp_send_json( ['success' => true, 'link' => home_url() . "/verification?hash=$hash"] );
}

function generate_pdf ( $html = '' ) {
	$upload_dir = wp_get_upload_dir()['basedir'] . '/pdf';
	$name = "pdf-" . time();

	$mpdf = new \Mpdf\Mpdf();
	$mpdf->WriteHTML( $html );
	$mpdf->Output( "$upload_dir/$name.pdf", \Mpdf\Output\Destination::FILE);

	return "$upload_dir/$name.pdf";
}