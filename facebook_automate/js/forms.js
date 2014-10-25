

// VERIFICATION FORMULAIRES
function couleur(obj) {
     obj.style.backgroundColor = "#FFFFFF";
}
 
function check() {
	var msg = "";
//ici nous vŽrifions si le champs nom et vide, changeons la couleur du champs et dŽfinissons un message d'alerte
if (document.formulaire.message.value == "")	{
		msg += "Veuillez saisir un message\n";
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
//Si aucun message d'alerte a ŽtŽ initialisŽ on retourne TRUE
	if (msg == "") return(true);
//Si un message d'alerte a ŽtŽ initialisŽ on lance l'alerte
	else	{
		alert(msg);
		return(false);
	}
}

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


function recup_albums(){
	alert("cccc");
//document.getElementById('type_page').value=3;

}
