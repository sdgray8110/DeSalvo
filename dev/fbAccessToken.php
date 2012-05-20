<?php
$FBid = '197651303610913';

$app_id = '177579968987113';
$app_secret = '1216cf0246db9168059a974ddaf0459f';

$access_token = file_get_contents("https://graph.facebook.com/oauth/access_token?type=client_cred&client_id=".$app_id."&client_secret=".$app_secret);

echo $access_token;

?>