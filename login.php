<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
include('config.php');


if(isset($_SESSION['name']) && isset($_SESSION['twitter_id'])) //check whether user already logged in with twitter
{

	echo "<h2>Name</h2> :".$_SESSION['name']."<br>";
	echo "<h2>Twitter ID</h2> :".$_SESSION['twitter_id']."<br>";
	echo "Image :<img src='".$_SESSION['image']."'/><br>";
	echo "<br/><a href='logout.php'>Logout</a>";
    echo "Time and Date of Tweet: ".$items['created_at']."<br />";
    echo "Tweet: ". $items['text']."<br />";
    echo "Tweeted by: ". $items['user']['name']."<br />";
    echo "Screen name: ". $items['user']['screen_name']."<br />";
    echo "Followers: ". $items['user']['followers_count']."<br />";
    echo "Friends: ". $items['user']['friends_count']."<br />";
    echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
}
else // Not logged in
{

	$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
	$request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

	if(	$request_token)
	{
		$token = $request_token['oauth_token'];
		$_SESSION['request_token'] = $token ;
		$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
		
		switch ($connection->http_code) 
		{
			case 200:
				$url = $connection->getAuthorizeURL($token);
				//redirect to Twitter .
		    	header('Location: ' . $url); 
			    break;
			default:
			    echo "Coonection with twitter Failed";
		    	break;
		}

	}
	else //error receiving request token
	{
		echo "Error Receiving Request Token";
	}
}
?>