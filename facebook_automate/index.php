<?php
// INCLUDES TWEETER
require_once ('lib/EpiCurl.php');
require_once ('lib/EpiOAuth.php');
require_once ('lib/EpiTwitter.php');
require_once ('lib/secret.php');
require_once ('lib/tweeter_init.php');
// INCLUDES FACEBOOK
require_once ('facebook_actions.php');
?>
<html>
	<head>
		<title>
			Facebook Automator
		</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<style>
			body
			{
				padding:30px;
			}
		</style>
	</head>
	<body>


<?php if($currentUser) { ?>

	<?php if($_GET["fbstatus"]=="updated") : ?>
		<span style="color:green; font-weight:bold;">Votre status facebook a été modifié !</span>
	<?php endif; ?>

	<h2>Infos à propos de ... vous ! </h2>

	<ul>
	<li>Nom : <?=$facebook_profile["name"];?>
	<li>Page Facebook : <?=$facebook_profile["email"];?>
	<li>Email : <?=$facebook_profile["name"];?>
	<li>Sexe : <?=$facebook_profile["gender"];?>
	</ul>

	<h2>Tableau complet des infos ( $facebook_profile )</h2>
	<pre>
	<?php print_r($facebook_profile); ?>
	</pre>

	<h2>Poster sur votre mur Facebook</h2>

	<p>
		Donnez votre avis sur l'article par exemple !
	</p>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="status" value="" placeholder="Votre message ici !" /><br />
		<input type="submit" value="Poster sur mon mur !" />
	</form>

<?php } else { ?>
----------------------------------------------------------------------------<br/>
Fin Traitement automatique : connections Test : <br/>
----------------------------------------------------------------------------<br/>
Phase Serveur non connecte : <br/>
	Se connecter via Facebook <br />
	<a href="<?=$loginUrl?>"><img src="http://www.ao6-labs.eu/wp-content/uploads/2011/07/facebook-connect-logo1.jpg"></a>

<?php } // FIN ELSE if($currentUser) ?>
</body>
</html>