// VERIFICATION FORMULAIRES
function couleur(obj) {
     obj.style.backgroundColor = "#FFFFFF";
}

function check() {
	var msg = "";
// DEBUT LIKE A VIRER
	//if (document.getElementById('album').innerHTML = file('http://www.obysky.com/dev/timetopostit/facebook_automate2/php/if_like_page.php') !="ok"){
	//	msg += "VOUS DEVEZ AIMER MA PAGE POUR EN PROFITER GRATUITEMENT ! \n Si le LIKE de la page n'est pas affichÈ, actualisez la page avec F5 ou Ctrl+R, activez Javascript sui-je bÍte vous ne veriez pas ce message ! ... puis sinon.... \n AIMEZ MOI !)";
//}
// FIN LIKE A VIRER

//ici nous vérifions si le champs message et vide, changeons la couleur du champs et définissons un message d'alerte
if (document.formulaire.message.value == "")	{
		msg += "Veuillez saisir un message\n";
		document.formulaire.message.style.backgroundColor = "#F3C200";
}
// VERIF LONGUEUR TEXTE
if (document.formulaire.message.value.length > 450)	{
		msg += "Longueur du message superieur a 450 carracteres\n";
		document.formulaire.message.style.backgroundColor = "#F3C200";
	}
//meme manipulation pour le champ heure
if (document.formulaire.heure.value == "")	{
		msg += "Veuillez saisir une heure \n";
		document.formulaire.heure.style.backgroundColor = "#F3C200";
	}
if (document.formulaire.heure.value > "23" || document.formulaire.heure.value < "0")	{
		msg += "Veuillez saisir une heure correcte \n";
		document.formulaire.heure.style.backgroundColor = "#F3C200";
	}
//meme manipulation pour le champ minutes
if (document.formulaire.heure.value == "")	{
		msg += "Veuillez saisir une heure \n";
		document.formulaire.heure.style.backgroundColor = "#F3C200";
	}
if (document.formulaire.min.value > "59" || document.formulaire.min.value < "0")	{
		msg += "Veuillez saisir des minutes correcte \n";
		document.formulaire.min.style.backgroundColor = "#F3C200";
	}
// Verif pour album si photo
if (document.formulaire.type_post.value=='album' && document.formulaire.my_file_element.value.length <= 0)	{
		msg += "Veuillez choisir une ou plusieurs photos pour un album \n";
		document.formulaire.my_file_element.style.backgroundColor = "#F3C200";
	}
// Verif le lien
if (document.formulaire.lien.value.length > 150)	{
		msg += "Longueur du lien superieur a 150 carracteres\n";
		document.formulaire.lien.style.backgroundColor = "#F3C200";
	}
// Verif le lien SI WEB
var reg = new RegExp(/(http):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/);
var result = reg.test(document.formulaire.lien.value);
if (result==false && document.formulaire.lien.value!='')	{
		msg += "Structure du lien invalide\n";
		document.formulaire.lien.style.backgroundColor = "#F3C200";
	}

//Si aucun message d'alerte a été initialisé on retourne TRUE
	if (msg == "") return(true);
//Si un message d'alerte a été initialisé on lance l'alerte
	else	{
		alert(msg);
		return(false);
	}
}
function calcul_textarea (){
document.getElementById('calcul_textarea').innerHTML = 450-document.formulaire.message.value.length
}
function calcul_tweet_textarea (){
	if ((140-document.formulaire.message.value.length)<0){
		document.getElementById('calcul_tweet_textarea').innerHTML = "Twitter : " + (140-document.formulaire.message.value.length) + " -> le texte sera tronque \340 l'envoi";
	}else {
		document.getElementById('calcul_tweet_textarea').innerHTML = "Twitter : " + (140-document.formulaire.message.value.length);
	}
}

function calcul_lien (){
document.getElementById('calcul_lien').innerHTML = 150-document.formulaire.lien.value.length

}
/*function active(type_post) {
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
}*/ 
function recup_albums (){
if (document.getElementById('type_post').value=='album'){
	document.getElementById('album').innerHTML = file('http://www.obysky.com/dev/timetopostit/facebook_automate2/php/recup_albums.php?id='+escape(document.getElementById('type_page').value));
}
}

function file(fichier)
{
if(window.XMLHttpRequest) // FIREFOX
xhr_object = new XMLHttpRequest();
else if(window.ActiveXObject) // IE
xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
else
return(false);
xhr_object.open("GET", fichier, false);
xhr_object.send(null);
if(xhr_object.readyState == 4) return(xhr_object.responseText);
else return(false);
}
function afichage_album(){

	if (document.getElementById('type_post').value=='album'){
		document.getElementById('album').style.display="inline";
		document.getElementById('lien').style.display="none";
		document.getElementById('album').innerHTML = file('http://www.obysky.com/dev/timetopostit/facebook_automate2/php/recup_albums.php?id='+escape(document.getElementById('type_page').value));
	}else{
		document.getElementById('lien').style.display="inline";
		document.getElementById('album').style.display="none";
}
}

function afficher_masquer_liste_post(){
 if (document.getElementById('liste_post_table').style.display=="none"){
 	document.getElementById('liste_post_table').style.display="block";
 }else {
 	document.getElementById('liste_post_table').style.display="none";
 }
	
}
function execute_script_post(){
	fichier= 'http://www.obysky.com/dev/Copie%20de%20applis_facebook/facebook_automate/index.php';
	if(window.XMLHttpRequest) // FIREFOX
xhr_object = new XMLHttpRequest();
else if(window.ActiveXObject) // IE
xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
else
return(false);
xhr_object.open("GET", fichier, false);
xhr_object.send(null);
if(xhr_object.readyState == 4) return(xhr_object.responseText);
else return(false);
}


function desactive_tweet(){
	if (document.getElementById('type_post').value=='album'){
		document.getElementById('twitter').checked=false;
	}
}
function verif_tweet(){
	if (document.getElementById('type_post').value=="album"){
		alert ("Impossible de tweeter pour un album ...");
		document.getElementById('twitter').checked=false;
	}
}
function verif_google(){
	alert ("FonctionnalitÈ non disponible pour le moment...");
		document.getElementById('google').checked=false;
}
function message_result(){
	//document.getElementById('message_result').innerHTML = file('http://matchingfriends.host56.com/facebook_automate2/php/recup_textarea.php?adress='+escape(document.getElementById('message').value));

}