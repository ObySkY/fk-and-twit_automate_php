<?php

$contenu = file_get_contents($_GET['adress']);
//TITRE DE LA PAGE
if(preg_match('#<title>(.+)<\/title>#', $contenu, $titre))
{
echo '<b>Titre de la page :</b>
'.$titre[1];
}
else {  echo 'Cette page n\'a pas de titre !'; }
//PHOTOS DE LA PAGE
if(preg_match_all('#<img(.+)src="(.+)"(.+)>#U', $contenu, $titre))
{

$i=0;
$max=count($titre[2]);
echo $max;
	
echo '<br/><b>images :</b><br />';
while ($i<$max){
echo '
<img src="'.$_GET['adress'].$titre[2][$i].'" style="max-height:80px;" />';
$i++;
	}
}
else {  echo '<br/>Cette page n\'a pas de photos !'; }

?>