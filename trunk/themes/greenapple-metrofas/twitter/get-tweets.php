<?php
session_start();
require_once("twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library

include_once('../../../config/config.inc.php');
include_once('../../../init.php');
         
$twitteruser =  Configuration::get('td_twitter_id');
$notweets = 30;
$consumerkey = Configuration::get('td_consumer_key');
$consumersecret = Configuration::get('td_consumer_secret');
$accesstoken = Configuration::get('td_consumer_token');
$accesstokensecret =Configuration::get('td_consumer_tsecret');
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
  
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
echo json_encode($tweets);

?>