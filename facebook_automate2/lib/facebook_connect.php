<?php
if (isset($_SESSION['id_user'])){
echo 'Bonjour : '.$facebook_profile['last_name'].' '.$facebook_profile['first_name'];
}
?>
<span class="lien_reconnect">

Se re-connecter via Facebook :
	<a href="<?=$loginUrl?>"><img class="fbk_connect_button" src="sources/facebook.png"/></a> / 
		<?php
			echo '<a href="'.$logoutUrl.'" style="color:white;" >Disconnect</a>'; 
		?>
</span>