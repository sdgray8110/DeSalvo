<?php
/*
Plugin Name: Facebook Recent Wallposts
Plugin URI: http://www.mapletonhillmedia.com
Version: 0.1
Author: Spencer Gray
Description: Grabs the most recent posts from a user's wall
*/

$fb = new fb_posts();

class fb_posts {


    public function __construct() {
        $this->set_vars();
        $this->set_assets();
        $this->add_actions();
        $this->savedFeeds = $this->get_saved_feeds();
    }

    private function get_saved_feeds() {
        $feeds = fb_posts::dbQuery("SELECT * FROM " . $this->tableName);

        return $feeds;
    }

    private function set_vars() {
        global $wpdb;

        $this->tableName = $wpdb->prefix . 'mhm_fb_posts';
    }

    private function set_assets() {
        $pluginAdminPath = '/wp-content/plugins/mhm-fb-posts/admin/';
        $pluginJSPath = '/wp-content/plugins/mhm-fb-posts/js/';

        $this->pluginContext = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/mhm-fb-posts/';
        $this->settingsPage = $this->pluginContext . 'admin/settings.php';
        $this->adminStylesheet = $pluginAdminPath . 'admin.css';
        $this->globalJS = $pluginJSPath . 'global.js';
        $this->adminJS = $pluginJSPath . 'admin.js';
        $this->validationJS = $pluginJSPath . 'validation.js';
        $this->templateJS = $pluginJSPath . 'jquery.template.min.js';
    }

    private function add_actions() {
        register_activation_hook(__FILE__, array(&$this,installer));
        register_activation_hook(__FILE__, array(&$this,feed_cron_activate));
        register_deactivation_hook(__FILE__, array(&$this,feed_cron_deactivate));
        add_filter('cron_schedules', array(&$this,'update_cron_schedules'));
        add_action('feed_cron_event', array(&$this,'feed_cron_trigger'));
        add_action('wp_ajax_verify_app', array(&$this, 'verify_app'));
        add_action('wp_ajax_save_new_feed', array(&$this, 'save_new_feed'));
        add_action('admin_menu', array(&$this, 'add_admin_menu'));
        add_action('admin_init', array(&$this,post_install_redirect));
    }

    public function pageData($query = false) {
        $data = new stdClass();
        $data->savedFeeds = !query ? $this->savedFeeds : $this->get_saved_feeds();

        return $data;
    }

    public function get_template($name) {
        include_once($this->pluginContext . 'tpl/' . $name . '.html');
    }

    public function add_admin_menu() {
        add_menu_page('Facebook Feed', 'Facebook Feed', 'add_users', 'fb-feed-settings', array(&$this, 'get_settings_page'), '');
    }

    public function get_settings_page() {
        include($this->settingsPage);
    }

    public function installer() {
        global $wpdb;

        $tableExists = count($wpdb->get_results("SHOW TABLES LIKE '".$this->tableName."'"));
        $query = $wpdb->prepare(
            "CREATE TABLE " . $this->tableName . "(
            ID INT KEY NOT NULL AUTO_INCREMENT,
            cronStamp DATETIME,
            feedName VARCHAR(240),
            fbUserID VARCHAR(240),
            fbAppID VARCHAR(240),
            fbSecret VARCHAR(240),
            fbToken VARCHAR(240),
            fbLimit INT(10),
            fbOwnerOnly TINYINT(1),
            fbPhotosOnly TINYINT(1),
            fbFeed LONGTEXT)"
        );

        if(!$tableExists) {
            add_option('fb_posts_redirect_on_first_activation', 'true');
            $wpdb->query($query);
        }
    }

    public function post_install_redirect() {
        if (get_option('fb_posts_redirect_on_first_activation') == 'true') {
            update_option('fb_posts_redirect_on_first_activation', 'false');
            wp_redirect(admin_url() . 'admin.php?page=fb-feed-settings');
        }
    }

    public function verify_app() {
        $data = new postData();
        $tokenResponse = $this->get_app_token($data);

        if (isset($tokenResponse['token'])) {
            $data->fbToken = $tokenResponse['token'];
            $feed = $this->get_feed($data);

            echo json_encode($feed[0]);
        } else {
            echo $tokenResponse['response'];
        }

        die();
    }

    public function save_new_feed($feeds = null) {
        $feeds = $feeds ? $feeds : new postData();

        if (!is_array($feeds)) {
            $feeds = array($feeds);
        }

        foreach ($feeds as $data) {
            $data->fbFeed = json_encode($this->get_feed($data));
            $data->cronStamp = date('Y-m-d H:i:s', time());
            $rowExists = fb_posts::dbQuery("SELECT feedName FROM ".$this->tableName." WHERE feedName = '" . $data->feedName . "'",true);
            unset($data->action);

            if (!$rowExists) {
                $this->insert_row($this->tableName, $data);
            } else {
                $where = array('feedName' => $data->feedName);
                $this->update_row($this->tableName,$data,$where);
            }
        }

        echo json_encode($this->pageData(true));

        die();
    }

    private static function dbQuery($query, $count = false) {
        global $wpdb;

        $results = $wpdb->get_results($query);

        if ($count) {
            return count($results);
        }

        return $results;
    }

    private static function feedColumns($exclude = array()) {
        global $wpdb;
        $columns = fb_posts::dbQuery("SHOW COLUMNS FROM " . $wpdb->prefix . 'mhm_fb_posts');
        $arr = array();

        foreach ($columns as $column) {
            if (!in_array($column->Field, $exclude)) {
                $arr[] = $column->Field;
            }
        }

        return $arr;
    }

    private function insert_row($table,$data) {
        global $wpdb;
        $data = get_object_vars($data);

        $wpdb->insert($table,$data);
    }

    private function update_row($table,$data,$where) {
        global $wpdb;
        $data = get_object_vars($data);

        $wpdb->update($table,$data,$where);
    }

    private function get_app_token($data) {
        $fmt = 'https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=%s&client_secret=%s';
        $url = sprintf($fmt,$data->fbAppID,$data->fbSecret);
        $response = $this->jsonCurlRequest($url,false);
        $match = 'access_token=';

        if (substr($response,0,13) == $match) {
            $token = str_replace($match,'',$response);
            return array('token' => $token);
        } else {
            return array(
                'error' => 'true',
                'response' => $response
            );
        }
    }

    public function get_feed($data) {
        $fmt = 'https://graph.facebook.com/%s/feed?access_token=%s';
        $url = sprintf($fmt,$data->fbUserID,$data->fbToken);
        $raw = $this->jsonCurlRequest($url);
        $i = 0;
        $feed = array();

        foreach($raw->data as $post) {
            $entry = new fbWallPost($post,$data->fbToken);

            if ($this->evaluatePost($entry, $data) && $i < $data->fbLimit) {
                $feed[] = $entry;
                $i++;
            }
        }

        return $feed;
    }

    private function evaluatePost($entry, $data) {
        $rules = array('fbOwnerOnly', 'fbPhotosOnly');
        $evaluated = array();
        $valid = 0;

        foreach ($rules as &$rule) {
            if ($data->$rule == '1') {
                $evaluated[] = $rule;
                $valid += $this->$rule($entry,$data);
            }
        }

        return $valid == count($evaluated);
    }

    private function fbOwnerOnly($entry, $data) {
        if ($entry->from->id == $data->fbUserID) {
            return 1;
        }

        return 0;
    }

    private function fbPhotosOnly($entry,$data) {

        if ($entry->type == 'photo') {
            return 1;
        }

        return 0;
    }

    private function jsonCurlRequest($url,$decode = true) {
        $ch = curl_init($url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
        );

        curl_setopt_array( $ch, $options );

        if ($decode) {
            return json_decode(curl_exec($ch));
        }

        return curl_exec($ch);
    }

    public function update_cron_schedules($schedules) {
        $schedules['minute'] = array(
            'interval' => 60,
            'display' => __('Once Per Minute')
        );
        $schedules['15minute'] = array(
            'interval' => 15,
            'display' => __('Once Every 15 Minutes')
        );

        return $schedules;
    }

    public function feed_cron_activate() {
        wp_schedule_event(current_time('timestamp'),'15minute','feed_cron_event');
    }

    public function feed_cron_deactivate() {
        wp_clear_scheduled_hook('feed_cron_event');
    }

    public function feed_cron_trigger() {
        $columns = fb_posts::feedColumns(array('ID', 'fbFeed','cronStamp'));
        $feeds = array();

        if (count($this->savedFeeds)) {
            foreach($this->savedFeeds as $feed) {
                $trimmedFeed = new stdClass();

                foreach($feed as $key => $value) {
                    if (in_array($key,$columns)) {
                        $trimmedFeed->$key = $value;
                    }
                }

                $feeds[] = $trimmedFeed;
            }

            $this->save_new_feed($feeds);
        }
    }

    private static function public_feed_request() {
        global $wpdb;

        return fb_posts::dbQuery("SELECT * FROM " . $wpdb->prefix . 'mhm_fb_posts');
    }

    private static function indexFeeds($data, $json, $index = 'name') {
        $feeds = array();

        foreach ($data as $feed) {

            $theFeed = json_decode($feed->fbFeed);

            foreach ($theFeed as &$theItem) {
                unset($theItem->fbToken);
            }

            if ($index == 'name') {
                $feeds[$feed->feedName] = $theFeed;
            } else {
                $feeds[] = $theFeed;
            }
        }

        return $json ? json_encode($feeds) : $feeds;
    }

    /* API METHODS */
    public static function get_fb_feeds($json = false) {
        $data = fb_posts::public_feed_request();

        return fb_posts::indexFeeds($data,$json);
    }

    public static function get_indexed_fb_feeds($json = false) {
        $data = fb_posts::public_feed_request();

        return fb_posts::indexFeeds($data,$json,false);
    }
}

class postData {
    public function __construct() {
        $this->build();
    }

    private function build() {
        foreach ($_POST as $key => $value) {
            $this->$key = $this->clean($value);
        }
    }

    private function clean($str) {
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }
}

class fbWallPost {
    public function __construct($post,$token) {
        $this->updatePost($post,$token);
    }

    private function updatePost($post,$token) {
        if ($this->isValid($post)) {
            foreach ($post as $key => $value) {
                $this->$key = $value;
            }
            $this->date = $this->setDate();
            $this->fbToken = $token;

            if (isset($post->picture)) {
                $this->picture = $this->setImages($post->picture);
            }
        } else {
            $this->invalidPostError();
        }
    }

    private function isValid($post) {
        $valid = false;

        if (isset($post->id)) {
            $valid = true;
        }

        return $valid;
    }

    private function invalidPostError() {
        $this->error = new stdClass();
        $this->error->message = 'Invalid User ID or Empty Feed';
        $this->error->type = 'Null Data';
        $this->error->code = 'N/A';
    }

    private function setImages($picture) {
        $data = new stdClass();
        $data->original = $this->getOriginalImg($picture);
        $data->medium = $this->getMediumImg($data->original);
        $data->thumb = $this->getThumbImg($picture);

        return $data;
    }

    private function getMediumImg($picture) {
        $arr = explode('/',$picture);
        $start = array_slice($arr, 0, count($arr) - 1);
        $end = $arr[count($arr) - 1];
        $start[] = 's320x320';
        $start[] = $end;

        return implode('/',$start);
    }

    private function getOriginalImg($picture) {
        return str_replace('s.jpg', 'n.jpg', $picture);
    }

    private function getThumbImg($picture) {
        return str_replace('n.jpg', 's.jpg', $picture);
    }

    private function setDate() {
        $time = strtotime($this->created_time);
        $date = new stdClass();
        $date->month = date('F',$time);
        $date->day = date('j',$time);
        $date->day_of_week = date('l',$time);
        $date->year = date('Y',$time);
        $date->time_ago = $this->time_ago($this->created_time);

        return $date;
    }

    private function time_ago($date) {

        if(empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if(empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}