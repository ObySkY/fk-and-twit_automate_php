<?php
//GESTION DES VARIABLE SESSIONS
session_start();


// CHARGEMENT DES CONFIG ET LIBS

	// Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/

// INCLUDES FACEBOOK
  require_once('../config/index.php');
  require_once('lib/fonctions.php');
  require_once('lib/facebook_actions.php');
// INCLUDES TWEETER
/*require_once ('lib/EpiCurl.php');
require_once ('lib/EpiOAuth.php');
require_once ('lib/EpiTwitter.php');
require_once ('lib/secret.php');*/



//CREATION DES COOKIES DE SESSIONS VALABLES 1 AN
	//SI FACEBOOK COOKIE NOT EXIST
	if (!isset($_COOKIE['id_user']) and isset($_SESSION['id_user']) and $_SESSION['id_user']!=0){
		//setcookie('id_user', $_SESSION['id_user'], time() + 365*24*3600, null, null, false, true);
	}
	//SI Tweeter COOKIE NOT EXIST
	if (!isset($_COOKIE['ot'])and !isset($_COOKIE['ots']) and isset($_SESSION['ot']) and isset($_SESSION['ots'])){
		//setcookie('ot', $_SESSION['ot'], time() + 365*24*3600, null, null, false, true);
		//setcookie('ots', $_SESSION['ots'], time() + 365*24*3600, null, null, false, true);
	}
//GESTION DES COOKIES
	//FACEBOOK
	if (isset($_COOKIE['id_user'])){
		//$_SESSION['id_user']=$_COOKIE['id_user'];
	}
	//TWEETER
	if (isset($_COOKIE['ot']) and isset($_COOKIE['ots'])){
		//$_SESSION['ot']=$_COOKIE['ot'];
		//$_SESSION['ots']=$_COOKIE['ots'];
	}
// FIN CREATION GESTION DES COOKIES VALABLES 1 AN
?>
<html>

  <head>
	<link rel="stylesheet" href="css/date.css" />
		<!--<link rel="stylesheet" href="css/prettyForms/prettyForms.css" />-->
			<link rel="stylesheet" href="css/form.css" />
  </head>
  
<body>
<!-- VERSION 0.3 -->
VerSion 1.4 - encore en DEVeloppement ! <br/>
<?php

echo '<div id="entete_facebook">';
		include 'lib/facebook_connect.php';
echo '</div>';
echo '<br/>';
	/*echo '<div id="entete_twiiter">';
		include 'lib/tweeter_connect.php';
	echo '</div>';*/
	
	/*echo '<div id="entete_google">';
		include 'lib/google_connect.php';
	echo '</div>';*/
	// comment test
	echo '<div id="application">';
		include 'application.php';
	echo '</div>';
		
	echo '<br/><div id="liste_post">';
		include 'liste_post.php';
	echo '</div>';
	
	
	echo '<br/><div id="">';
	echo '</div>';

  ?>
  <!-- GOOGLE ANALYTIC -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39722476-1', 'obysky.com');
  ga('send', 'pageview');

</script>

</body>
</html>