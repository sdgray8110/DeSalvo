<?php
class facebookFeed {
    protected $postsObject;
    protected $fbUserId = '193361797343222';
    protected $fbToken = '177579968987113|m1mxZVGLJOSN8DxjnyotKakgKOs';
    protected $appName = 'DeSalvo Custom Cycles';

    private function getFeed() {
        return file_get_contents('https://graph.facebook.com/'.$this->fbUserId.'/feed?fields=from,type,object_id&access_token='.$this->fbToken);
    }

    private function getImageData($object_id) {
        return file_get_contents('https://graph.facebook.com/'.$object_id);
    }

    private function getPhotoFeed() {
        return file_get_contents('https://graph.facebook.com/'.$this->fbUserId.'/photos');
    }

    private function getCachedFeed() {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/cache/facebookFeed.cache.json');
    }

    public function decodeFeed($feed) {
        $json = $feed;

        return json_decode($json, true);
    }

    private function trimFeed($json) {
        return substr($json, 6, -2 );
    }

    private function mikesPosts() {
        return $this->decodeFeed($this->getCachedFeed());
    }

    public function init() {
        $this->postsObject = $this->mikesPosts();
    }

    public function cachePosts() {
        //$json = $this->getFeed();
        $json = $this->reconstructFeed();
        $cache = "facebookFeed.cache.json";
        $fh = fopen($cache, 'w') or die("can't open file");
        fwrite($fh, $json);
        fclose($fh);
    }

    public function reconstructFeed() {
        $feed = $this->decodeFeed($this->getFeed());
        $feed = $feed['data'];
        $newFeed = array();

        foreach ($feed as $post) {
            if ($post['object_id'] && $post['type'] == 'photo' && $post['from']['name'] == $this->appName) {
                $imageData = $this->getImageData($post['object_id']);
                $newFeed[] = $this->decodeFeed($imageData);
            }
        }

        return json_encode($newFeed);
    }

    public function get_message($post) {
        echo $this->postsObject[$post - 1]['name'];
    }

    public function get_likes($post,$count = false) {
        $likes = count($this->postsObject[$post - 1]['likes']['data']);

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

        if (!$url) {
            echo $this->imageMarkup($post['picture'],$post['name']);
            return true;
        } else {
            echo $post['picture'];
            return true;
        }
    }

    public function get_medium_picture($post,$url = false) {
        $post = $this->postsObject[$post - 1];
        $picture = $this->getMediumImg($post['picture']);

        if (!$url) {
            echo $this->imageMarkup($picture,$post['name']);
            return true;
        } else {
            echo $picture;
            return true;
        }
    }

    public function get_original_picture($post,$url = false) {
        $post = $this->postsObject[$post - 1];
        $picture = $this->getOriginalImg($post['picture']);

        if (!$url) {
            echo $this->imageMarkup($picture,$post['name']);
            return true;
        } else {
            echo $picture;
            return true;
        }
    }

    public function get_date($post) {
        $post = $this->postsObject[$post - 1];
        $stamp = strtotime($post['created_time']);

        echo date('l, M j, Y', $stamp);
    }

    public function get_link($post) {
        $post = $this->postsObject[$post - 1];

        echo $post['link'];
    }
}

?>