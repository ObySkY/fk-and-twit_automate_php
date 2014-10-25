<?php 
function bouton_suppr($id)
{
echo '<input type="radio" name="suppr" value="'.$id.'" class="suppr"/>';
}// FIN FUNCTION
if (isset ($_POST['suppr']) and $_POST['suppr']!=NULL)
{	// SUPPRESSION DANS LA BASE
	$rek_sup=mysql_query("DELETE FROM fb_automate_post WHERE id_post=".$_POST['suppr']."");
	echo 'Element supprime ! <br/>';
	//SUPPRESSION DES IMAGES	
	//LISTAGE FICHIERS
$dirname = './img/';
$dir = opendir($dirname);
while($file = readdir($dir)) {
if($file != '.' && $file != '..' && !is_dir($dirname.$file))
{
	if (preg_match("#^".$_POST['suppr']."_#", $file))
    {
		unlink($dirname.$file); // Ceci supprimera le fichier
    }
	
}
}
closedir($dir); 
//FIN LISTAGE FICHIERS
	//FIN SUPPRESSION IMAGES
}//FIN TRAITEMENT SUPPR

// DEBUT GESTION DE LA PAGINATION
if(isset($_GET['page'])) {
	$page = $_GET['page'];
	$_SESSION['page']=$_GET['page'];
} else {
	if(isset($_SESSION['page'])) {
		$page=$_SESSION['page'];
	}else{
		$page = 1;
	}
}
// DEBUT NOMBRES DE POST PAR PAGES

if(isset($_GET['nbrpage'])) {
	$nbpdparpage = $_GET['nbrpage'];
	$_SESSION['nbrpage']=$_GET['nbrpage'];
	$page = 1;
} else {
	if(isset($_SESSION['nbrpage'])) {
		$nbpdparpage=$_SESSION['nbrpage'];
	}else{
		$nbpdparpage = 10;
	}
}
// FIN NOMBRES DE POST PAR PAGES
$premierpd = ($page-1)*$nbpdparpage;
// FIN GESTION DE LA PAGINATION

// DEBUT LISTE POSTS
if (isset($_SESSION['id_user'])){
echo 'Liste des POSTS : ';
echo '<input type="submit" value="Afficher / Masquer" onclick="afficher_masquer_liste_post();" />';

//DEBUT CHOIX NOMBRE POST AFFICHE
	echo '<span style="float:right;"> Posts par page : ';
	$i = 10;
	while($i <= 100) {
		echo '<a class="link" href="index.php?nbrpage='.$i.'">|'.$i.'|</a>  ';
	$i = $i+10;
	}
	echo '</span>';
//FIN CHOIX NOMBRE POST AFFICHE

$query2 = ('SELECT * FROM fb_automate_user,fb_automate_post WHERE fb_automate_post.uid = fb_automate_user.uid and fb_automate_user.uid = '.$_SESSION['id_user'].' order by posted_for DESC LIMIT '.$premierpd.', '.$nbpdparpage.' ');
$res2 = mysql_query($query2) or die(mysql_error());

echo '<form action="" method="post" enctype="multipart/form-data"><table id="liste_post_table" name="liste_post" border="0">';
echo '
<tr>
	<td><input type="submit" value="Supprimer" /></td><td>Date de prevision</td><td>Message</td><td>Cree le</td><td>Lien</td><td>Page</td><td>Type</td><td>Twitter</td><td>Posted</td><td>Photo</td>
</tr>';
$color_ligne=0;
while ($row2 = mysql_fetch_array($res2)){
	// RECUP NOM PAGE
	$query3 = ('SELECT * FROM fb_automate_post,fb_automate_page WHERE fb_automate_page.uid_page = fb_automate_post.type_page and fb_automate_post.id_post = '.$row2['id_post'].'');
	$res3 = mysql_query($query3) or die(mysql_error());
	 $row3 = mysql_fetch_array($res3);
	 
	 if ($row3['name_page']==null){$row3['name_page']='profil';}
	// FIN RECUP NOM PAGE
echo '<tr ';
	if ($color_ligne%2!=0){
		echo 'style="background-color:#d0d0d1;"';
	}else {
		echo 'style="background-color:#ededee;"';
	}$color_ligne++;
echo '><td><center>'; bouton_suppr($row2['id_post']); echo'</center></td><td>'.$row2['posted_for'].'</td><td>'.$row2['message_post'].'</td><td>'.$row2['created_at'].'</td><td>'.$row2['lien_post'].'</td><td>'.$row3['name_page'].'</td><td>'.$row2['type_post'].'</td><td>'.$row2['uname'].'</td>

<td>';
if ($row2['posted_post']==0){
echo 'en attente';
}else {echo 'poste';}

echo'</td>

<td class="img_liste_post_table">
';

// DEBUT PHOTO LISTE

//$filename = '../facebook_automate2/img/'.$row2['id_post'].'.jpg';
//if (file_exists($filename)) {echo 'photo exist !!!<br/>';
//	echo '<img src="../facebook_automate2/img/'.$row2['id_post'].'.jpg" width="200px">';
//}
//LISTAGE FICHIERS
$dirname = './img/';
$dir = opendir($dirname);
while($file = readdir($dir)) {
if($file != '.' && $file != '..' && !is_dir($dirname.$file))
{
	if (preg_match("#^".$row2['id_post']."_#", $file))
    {
		echo '<img class="img_liste_post" src="'.$dirname.$file.'">';
    }
	
}
}
closedir($dir); 
//FIN LISTAGE FICHIERS


//FIN PHOTO LISTE


echo'
</td></tr>';



}
echo '</table></form>';

/*affichage des pages - on calcule le nombre de page qu'il y aura*/
			$retour = mysql_query('SELECT COUNT(*) as nbpd FROM fb_automate_user,fb_automate_post WHERE fb_automate_post.uid = fb_automate_user.uid and fb_automate_user.uid = '.$_SESSION['id_user'].'');
			
			$donnees = mysql_fetch_array($retour);
			$totalpd = $donnees['nbpd'];
			$nbpage = ceil($totalpd / $nbpdparpage);
			echo '<p id="page">Page : ';
			for($i = 1;$i <= $nbpage; $i++) {
				echo '<a class="link" href="index.php?page='.$i.'">|'.$i.'|</a>  ';
			}
			echo '</p>';
}
// FIN LISTE POSTS
?>