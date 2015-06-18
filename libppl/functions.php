<?php

// funtion to avoid xss
function clean_scriptsppl($url) {
	$urlclean = preg_replace('/((\%3C)|(\&lt;)|<)(script\b)[^>]*((\%3E)|(\&gt;)|>)(.*?)((\%3C)|(\&lt;)|<)(\/script)((\%3E)|(\&gt;)|>)|((\%3C)|<)((\%69)|i|(\%49))((\%6D)|m|(\%4D))((\%67)|g|(\%47))[^\n]+((\%3E)|>)/is', "", $url);
	return $urlclean;
}

add_action("wp_ajax_nopriv_my_user_vote", "my_user_vote");

function my_user_vote() {

	if (!wp_verify_nonce($_REQUEST['nonce'], "votingsystem")) {
		exit("No naughty business please");
	}
	$poll_ID = $_REQUEST["pollid"];
	$poll = $_REQUEST["poll"];
	$poll = base64_decode($poll);
	$poll = explode(",", $poll);
	if (is_array($poll)) {
		foreach ($poll as $key) {
			$vote_count = get_post_meta($key, "postpoll-votes-" . $poll_ID, true);
			$vote_count = ($vote_count == '') ? 0 : $vote_count;
			$new_vote_count = $vote_count + 1;
			$vote = update_post_meta($key, "postpoll-votes-" . $poll_ID, $new_vote_count);
			$totals[$key] = $new_vote_count;
		}
		if (isset($_REQUEST['cookies']) && $_REQUEST['cookies'] == 1) {
			setcookie('voted', 1, time() + 3600 * 24 * 100, COOKIEPATH, COOKIE_DOMAIN, false);}
	} else {
		$vote_count = get_post_meta($poll, "postpoll-votes-" . $poll_ID, true);
		$vote_count = ($vote_count == '') ? 0 : $vote_count;
		$new_vote_count = $vote_count + 1;
		$vote = update_post_meta($poll, "postpoll-votes-" . $poll_ID, $new_vote_count);
		$totals = $new_vote_count;
		if (isset($_REQUEST['cookies']) && $_REQUEST['cookies'] == 1) {
			setcookie('voted', 1, time() + 3600 * 24 * 100, COOKIEPATH, COOKIE_DOMAIN, false);}
	}

	if ($vote === false) {
		$result['type'] = "error";
		$result['vote_count'] = $vote_count;
		$result['poll'] = $poll;
	} else {
		$result['type'] = "success";
		$result['vote_count'] = $totals;
	}

	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$result = json_encode($result);
		echo $result;
	} else {
		wp_redirect($_SERVER["HTTP_REFERER"]);
	}

	wp_die();

}

add_action('init', 'my_script_enqueuer');

function my_script_enqueuer() {
	wp_register_script("my_voter_script", WP_PLUGIN_URL . '/post_poll/libppl/my_voter_script.js', array('jquery'));
	wp_localize_script('my_voter_script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

	wp_enqueue_script('jquery');
	wp_enqueue_script('my_voter_script');

}

function postpoll_create_widget() {
	include_once plugin_dir_path(__FILE__) . 'widget.php';
	register_widget('postpoll_widget');
}
add_action('widgets_init', 'postpoll_create_widget');