
<?php
// GESTION BDD DU POST
//echo 'token : '.$facebook->getAccessToken().'<br/>';

//SECURITE DES VARIABLES

if (isset($_POST['dtPicker'])){$_POST['dtPicker'] = Securite::bdd($_POST['dtPicker']);}
if (isset($_POST['heure'])){$_POST['heure'] = Securite::bdd($_POST['heure']);}
if (isset($_POST['min'])){$_POST['min'] = Securite::bdd($_POST['min']);}
if (isset($_POST['type_post'])){$_POST['type_post'] = Securite::bdd($_POST['type_post']);}
if (isset($_POST['type_page'])){$_POST['type_page'] = Securite::bdd($_POST['type_page']);}
if (isset($_POST['message'])){$_POST['message'] = Securite::bdd($_POST['message']);}
if (isset($_POST['lien'])){$_POST['lien'] = Securite::bdd($_POST['lien']);}
if (isset($_POST['photo'])){$_POST['photo'] = Securite::bdd($_POST['photo']);}

// TRAITEMENT DATE
if (isset($_POST['dtPicker']) and $_POST['dtPicker']!=null){
	$date = $_POST['dtPicker'].' '.$_POST['heure'].':'.$_POST['min'].':00';
}

// TRAITEMENT FORMULAIRE
if (isset($_SESSION['id_user']) and $_SESSION['id_user']!= null)
{
	//CAS OU TWIITER EST ACTIF
	if (isset($_POST['twitter']) and $_POST['twitter']!=null and isset($_POST['type_post']) and $_POST['type_post']=="profil\_page"){
		$twiiter=$_SESSION['username'];
	}else{
		$twiiter='';
	}
	//FIN CAS OU TWIITER EST ACTIF
	
if (isset($_POST['type_post']) and $_POST['type_post']!=null and isset($_POST['type_page']) and $_POST['type_page']!=null and isset($_POST['message']) and $_POST['message']!=null){
	//TOUS LES CAS
	if (isset($_POST['message']) and $_POST['message']!=null){
	
	
		$query = "INSERT INTO fb_automate_post SET type_post = '".$_POST['type_post']."', type_page='".$_POST['type_page']."', message_post='".$_POST['message']."', created_at = NOW(), posted_for='".$date."', lien_post='".$_POST['lien']."', uid='".$_SESSION['id_user']."', uname='".$twiiter."', uid_album='".$_POST['album']."'";
		if ($res = mysql_query($query) or die(mysql_error())){
			echo date('G').' h '.date('i').' : Programmation effectue !<br/>';
		}
	} // CAS PHOTO
	if (isset($_FILES['photo']) and count($_FILES['photo']['name']) > '1'){
	echo count($_FILES['photo']['name']);
		$UID=mysql_insert_id();
			
		if (photo_insert ("photo","img")==true){echo 'photo upload !';}else {echo '<span style="color:#CC0000;font-weight:bold;background-color:#009900;"> -- Probleme de telechargement sur la photo : Publication annule ! -- </span><br/>';$rek_sup=mysql_query("DELETE FROM fb_automate_post WHERE id_post=".$UID."");
		
				echo count($_FILES['photo']['name']);
		
		}
	}else {echo 'Pas de photo a publier';}
}
?>
<!-- INSERT TRAITEMENTS JAVASCRIPTS FORMULAIRES -->
<script src="js/date.js"></script>
<script src="js/forms.js"></script>
<script src="js/multifile.js"></script>
<?php
// PUBLIER DE SUITE
if (isset($_POST['publier']) and $_POST['publier']!=null){

?>
<script type="text/javascript">
	execute_script_post();
	document.getElementById('liste_post').innerHTML = file('http://www.obysky.com/dev/timetopostit/facebook_automate2/liste_post.php');
</script>
<?php
}
// FIN PUBLIER DE SUITE
?>
<br/>
 <!-- INVIT FRIENDS -->
 <img src="sources/invite_facebook.png" id="facebook"  style="cursor:pointer;" alt="Autoriser les pop up !" />
 <!-- LIKE -->
 <br/>   
 debut le like : pas compatible AD Block !
<div class="fb-like-box" data-href="https://www.facebook.com/pages/Time-To-Post-It/345064018946390" data-width="292" data-show-faces="false" data-stream="false" data-header="false"></div>
 
 fin le like
 <!-- AFFICHAGE FORMULAIRE -->
<form id="formulaire" name="formulaire" action="" method="post" enctype="multipart/form-data" onSubmit="return check();"><fieldset><legend> Creer une tache planifie : </legend>
<div id="gauche">
<br/>
Plateforme :
       <input type="checkbox" name="facebook" id="facebook" checked title="Facebook" disabled="disabled" /> <label for="facebook" title="Facebook">Facebook</label>
       
       <?php if (isset($_SESSION['ot']) and isset($_SESSION['ots'])){ ?>
       <input type="checkbox" name="twitter" id="twitter" title="Seul le commentaire sera pris en compte" onclick="verif_tweet();" /> <label for="twitter" title="Seul le commentaire sera pris en compte" onclick="verif_tweet();" >Twitter</label>
       <?php } ?>
       
       <?php if (isset($_SESSION['token'])){ ?>
       <input type="checkbox" name="google" id="google" title="Indisponible pour le moment" onclick="verif_google();"/> <label for="google" title="Indisponible pour le moment" onclick="verif_google();" >Google</label>
		<?php } ?>
<br/><br/>
Style de la publication : <br/>
<div class="styled-select">
<select name="type_post" id="type_post" onchange="afichage_album();desactive_tweet();">
    <option value="profil_page">Publier sur un(e) Profil / Page</option>
    <option value="album" >Publier photo(s) dans un Album</option>
</select>
</div>
<br/>
<br/>

Selection de la page :<br/>
<div class="styled-select">
<select id="type_page" name="type_page" onchange="recup_albums();" >
<option value="profil">Profil</option>
<?php
$query = ('SELECT * FROM fb_automate_page WHERE uid ='.$_SESSION['id_user'].'');
	$res = mysql_query($query) or die(mysql_error());
	
	while ($row = mysql_fetch_array($res)){
	echo '<option value="'.$row['uid_page'].'">'.$row['name_page'].'</option>';
	}
?>
</select>
</div>
<br/>
<!-- SELECTION ALBUM -->

<span id="album" name="album"></span>
<script>
recup_albums();
</script>
<!--<select id="album" name="album" value="recup_albums('profil')" >
</select>-->
<!--<div id="album2"></div>-->
<!-- FIN SELECTION ALBUM --><br/>
Message :<br/><textarea name="message" id="message" rows="8" cols="45" onclick="if (this.value=='Desription de mon message !'){this.value='';}" onkeyup="calcul_textarea();calcul_tweet_textarea();message_result();">
Desription de mon message !</textarea><span id="calcul_textarea" style="color:red;"> 450 </span> <span id="calcul_tweet_textarea" style="color:red;margin-left:20px;">Twitter : 140 </span><br/>

<div id="message_result">
</div>

Lien : <input type="text" name="lien" id="lien" value="" onclick="if (this.value=='@ page'){this.value='';}" onkeyup="calcul_lien()"/><span id="calcul_lien" style="color:red;"> 150 </span><br/>
<!--
Photo : <input type="file" name="photo" id="photo" /> format : 'JPEG','JPG','jpg','jpeg','png','PNG<br/>
(Redimensionnement automatique - Taille max : 10 Mo<br /><br/>
-->
<!-- TEST PHOTO -->


	<!-- The file element -- NOTE: it has an ID -->
	Photo(s) : <input id="my_file_element" type="file" name="photo[]" >
	<br/><span class="descriptions">formats : 'JPEG','JPG','jpg','jpeg'<br/>
( Redimensionnement automatique - Taille max : 10 Mo )</span>
<br/><br/>
<!-- This is where the output will appear -->
<div id="files_list">Fichiers : </div>
<script>
	<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
	var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 0 );
	<!-- Pass in the file element -->
	multi_selector.addElement( document.getElementById( 'my_file_element' ) );
</script>
<br/>






<!-- FIN TEST PHOTO -->

<!-- DATE JS -->
<br/>
</div>
<div id="droite">
Date du Post :<br/>
    <input type="text" id="dtPicker" name="dtPicker" maxlength="9" value="<?php echo date('Y').'-'.date('m').'-'.date('d'); ?>"/>
    <script type="text/javascript">
    dateTimePicker(document.getElementById("dtPicker"), true);
    </script>
<br/>
 H : <input type="text" name="heure" size="5" value="<?php echo date('G'); ?>"/>
min : <input type="text" name="min" size="5" value="<?php echo date('i'); ?>"/>


</div>
<br/>
<button type="submit" value="Programmer" name="programmer" style="border: 0;" onclick="document.forms["myform"].submit();" >
    <img src="sources/bouton_programmer.png" alt="submit" />
</button>

<button type="submit" name="publier" value="Publier maintenant" style="border: 0;" onclick="document.forms["myform"].submit();" >
    <img src="sources/bouton_publiez.png" alt="submit" />
</button>


</fieldset></form>
<?php
}else {
//DEBUT PAGE NON CONNECTE FACEBOOK FB
?>
<br/>

<br/>
Non connecte - Se connecter via Facebook <br/>
	<a href="<?=$loginUrl?>"><img src="sources/facebook-connect-logo1.jpg"></a><br/><br/>

	//PHOTO PAGE ACUEIL PRINCIPALE
<a href="http://www.obysky.com/dev/timetopostit/facebook_automate2/"><img src="../maquett_app_home.jpg"/></a><?php


	//FIN PAGE NON CONNECTE FACEBOOK FB
	}
		$base_url='http://'.$_SERVER['HTTP_HOST'].'/dev/timetopostit/facebook_automate2/';  

?>
<!-- INVIT FRIENDS -->
<div id="fb-root"></div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
   <script type="text/javascript">
  window.fbAsyncInit = function() {
     FB.init({ 
       appId:'<?php echo "331422990223833"; ?>', cookie:true, 
       status:true, xfbml:true,oauth : true 
     });
   };
   (function(d){
           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           ref.parentNode.insertBefore(js, ref);
         }(document));
 $('#facebook').click(function(e) {
    FB.login(function(response) {
      if(response.authResponse) {
	  window.open('<?php echo $base_url; ?>invite.php','invite.php','menubar=no, status=no, scrollbars=yes, menubar=no, width=800, height=600');
         // parent.location ='<?php echo $base_url; ?>invite.php';
      }
 },{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'});
});
   </script>
   
   <script>
   // SCRIPT BUTTON LIKE
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=331422990223833";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
