<?php
// GESTION BDD DU POST
/*if (isset($_POST['type_post']) and $_POST['type_post']!=null){
	//CAS STATUS
	if ($_POST['type_post']=='status'){
		$query = "INSERT INTO fb_automate_post SET type_post = '".$_POST['type_post']."', type_page='".$_POST['type_page']."', message_post='".$_POST['message']."', created_at = NOW(), posted_for=NOW(), uid='".$_SESSION['id_user']."'";
	$res = mysql_query($query) or die(mysql_error());
	}


}*/
//$query = "INSERT INTO fb_automate_user SET uid = '".$user_id."', lastname='".mysql_real_escape_string($me['last_name'])."', firstname='".mysql_real_escape_string($me['first_name'])."', token_access = '".mysql_real_escape_string($token)."', created_at = NOW(), last_login=NOW() ON DUPLICATE KEY UPDATE last_login = NOW()";
//$res = mysql_query($query) or die(mysql_error());



?>
<script language="Javascript">
// ==================
//	Activations - DŽsactivations
// ==================
function active(type_post) {
var selectValue = document.getElementById(type_post).options[document.getElementById(type_post).selectedIndex].value;
	//alert("ooo"+selectValue);
	document.getElementById('photo').disabled=false;
	document.getElementById('lien').disabled=false;
	if (selectValue == 'status'){
	document.getElementById('photo').disabled=true;
	document.getElementById('lien').disabled=true;
	} if (selectValue == 'photo'){
	document.getElementById('lien').disabled=true;
	} if (selectValue == 'lien'){
	document.getElementById('photo').disabled=true;
	}
	return true;
}
</script>


<form id="myform" action="">
Style de la publication : 
<select name="type_post" id="type_post" onchange="active('type_post');">
    <option value="status">Status</option>
    <option value="photo">Photo</option>
    <option value="lien">Lien</option>
</select>
<br/>


Message :<br/><textarea name="message" id="message" rows="8" cols="45" onclick="if (this.value=='Desription de mon message !'){this.value='';}">
Desription de mon message !</textarea><br/>

Lien : <input type="text" name="lien" id="lien" value="@ page" onclick="if (this.value=='@ page'){this.value='';}"/><br/>
Photo : <input type="file" name="photo" id="photo" /><br /><br/>


<!-- DATE JS -->
Date du Post :<br/>
    <input type="text" id="dtPicker" name="ladate" maxlength="9" value="2011-09-02"/>
    <script type="text/javascript">
    dateTimePicker(document.getElementById("dtPicker"), true);
    </script>
<br/>
 H : <input type="text" name="heure" size="5"/>
min : <input type="text" name="min" size="5"/>


<!-- RESULTAT DATE JS -->
<input type="text" onclick="alert(document.getElementById('dtPicker').value);" value="Valeur de l'input date">

<br/><br/>



<select name="type_page" >
<option value="0">SŽlectionnez Fan page</option>
<option value="fan_page">Fan Page</option>
<option value="profil">Profil</option>
</select>

<br/><br/>
<input type="submit" value="Programmer" onclick="document.forms["myform"].submit();" />



</form>



<fb:editor action="" labelwidth="100">
<fb:editor-text label="pseudo" name="pseudo" value="mon pseudo"/>
<fb:editor-date label="j'ai vu le film le " value="5419000" />
<fb:editor-time value="1185930724" name="time" label="a"/>
<fb:editor-button value="Valider"/>
</fb:editor>