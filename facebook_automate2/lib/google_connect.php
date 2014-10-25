<?php
require_once 'lib/google_plus/apiClient.php';
require_once 'lib/google_plus/contrib/apiPlusService.php';

$client = new apiClient();
$client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('477155413165.apps.googleusercontent.com');
$client->setClientSecret('OlowpZsQiYtxZUpfW4FzGgiI');
$client->setRedirectUri('https://matchingfriends.host56.com/facebook_automate2');
$client->setDeveloperKey('AIzaSyCgaaJuE-2i2BR-OLRlVBIz4TAeDFSaO7o');
$plus = new apiPlusService($client);

if (!isset($_SESSION['token']) and isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
//  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
 // echo '<br/>$_SESSION[token] : '.$_SESSION['token'];
}

if ($client->getAccessToken()) {

//TEST
  $me = $plus->people->get('me');

  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
  $url = filter_var($me['url'], FILTER_VALIDATE_URL);
  $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
  $name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $optParams);
  $activityMarkup = '';
  foreach($activities['items'] as $activity) {
    // These fields are currently filtered through the PHP sanitize filters.
    // See http://www.php.net/manual/en/filter.filters.sanitize.php
    $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
    $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
  
  
  }
  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();


//FIN TEST

	 echo 'Bonjour : '.$name;
	echo ' <img class=\'fbk_connect_button\' src='.$img.' />';
	echo "<span class=\"lien_reconnect\">";
echo "Se re-connecter via Google : <a href='$authUrl'><img class=\"fbk_connect_button\" src=\"sources/GooglePlus.jpg\"/></a>";
echo "</span>";

	
	
  $activities = $plus->activities->listActivities('me', 'public');
  //print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';
 // echo '<br/><br/><br/><br/>';
 // print 'Your API ME: <pre>' . print_r($client, true) . '</pre>';


  // The access token may have been updated.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  echo "Se re-connecter via Google : <a href='$authUrl'><img class=\"fbk_connect_button\" src=\"sources/GooglePlus.jpg\"/></a>";
}