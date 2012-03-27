<?php
class facebookFeed {
    protected $postsObject;
    protected $fbUserId = '193361797343222';
    protected $fbToken = '177579968987113|m1mxZVGLJOSN8DxjnyotKakgKOs';

    private function getFeed() {
        $json = file_get_contents('https://graph.facebook.com/'.$this->fbUserId.'/feed?access_token='.$this->fbToken.'&callback');

        return $this->trimFeed($json);
    }

    private function getCachedFeed() {
        return file_get_contents('../cache/facebookFeed.cache.json');
    }

    public function decodeFeed() {
        $json = $this->getCachedFeed();

        return json_decode($json, true);
    }

    private function trimFeed($json) {
        return substr($json, 6, -2 );
    }


    private function mikesPosts() {
        $feed = $this->decodeFeed();
        $feed = $feed['data'];
        $mikesPosts = array();

        foreach ($feed as $post) {
            if ($post['from']['id'] == $this->fbUserId) {
                $mikesPosts[] = $post;
            }
        }

        return $mikesPosts;
    }

    public function init() {
        $this->postsObject = $this->mikesPosts();
    }

    public function cachePosts() {
        $json = $this->getFeed();
        $cache = "facebookFeed.cache.json";
        $fh = fopen($cache, 'w') or die("can't open file");
        fwrite($fh, $json);
        fclose($fh);
    }

    public function get_message($post) {
        echo $this->postsObject[$post - 1]['message'];
    }

    public function get_likes($post,$count = false) {
        $likes = $this->postsObject[$post - 1]['likes']['count'];

        if ($count) {
            echo $likes;
        } else {
            $verbiage = $likes == 1 ? ' person likes this' : ' people like this';

            echo $likes . $verbiage;
        }
    }

    private function imageMarkup($picture,$caption) {
        return '<img src="'.$picture.'" alt="'.$caption.'" />';
    }

    private function getMediumImg($picture) {
        $picture = $this->getOriginalImg($picture);
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

    public function get_thumbnail($post,$url = false) {
        $post = $this->postsObject[$post - 1];

        if ($post['type'] != 'photo') {
            return false;
        } else if (!$url) {
            echo $this->imageMarkup($post['picture'],$post['caption']);
            return true;
        } else {
            echo $post['picture'];
            return true;
        }
    }

    public function get_medium_picture($post,$url = false) {
        $post = $this->postsObject[$post - 1];
        $picture = $this->getMediumImg($post['picture']);

        if ($post['type'] != 'photo') {
            return false;
        } else if (!$url) {
            echo $this->imageMarkup($picture,$post['caption']);
            return true;
        } else {
            echo $picture;
            return true;
        }
    }

    public function get_original_picture($post,$url = false) {
        $post = $this->postsObject[$post - 1];
        $picture = $this->getOriginalImg($post['picture']);

        if ($post['type'] != 'photo') {
            return false;
        } else if (!$url) {
            echo $this->imageMarkup($picture,$post['caption']);
            return true;
        } else {
            echo $picture;
            return true;
        }
    }

    public function get_date($post) {
        $post = $this->postsObject[$post - 1];
        $stamp = strtotime($post['created_time']);

        echo date('l, F j, Y', $stamp);
    }

    public function get_link($post) {
        $post = $this->postsObject[$post - 1];

        echo $post['link'];
    }
}

?>