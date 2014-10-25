    /*
     * Codé par Gnieark http://blog-du-grouik.tinad.fr/ Novembre 2011 version 0.3.1
     * Ditribué sans aucune garantie.
     * Vous pouvez faire ce que vous voullez de ce code, l'utiliser, le revendre,
     * le modifier etc... à condition de laisser intact le présent avertissement et la paternité.
     * même en cas de "minification" du code.
     */
if(!Element.setAttribute){Element.prototype.setAttribute=function(attribut,valeur){switch(attribut)
{case"onClick":case"onMouseOut":case"onMouseOver":eval('this.'+attribut.toLowerCase()+'=function(){'+valeur+'}');return;break;case"type":var newObject=document.createElement(this.tagName);newObject.type=valeur;if(this.size)newObject.size=this.size;if(this.value)newObject.value=this.value;if(this.name)newObject.name=this.name;if(this.id)newObject.id=this.id;if(this.className)newObject.className=this.className;this.parentNode.replaceChild(newObject,this);return;break;case"class":var correctAttribut="className";break;default:var correctAttribut=attribut;break;}
eval('this.'+correctAttribut+'="'+valeur+'"');}}
lesJours=new Array('dim','lun','mar','mer','jeu','ven','sam');lesJoursFull=new Array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');lesMois=new Array('janvier','fevrier','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','decembre');function createElem(type,attributes)
{var elem=document.createElement(type);for(var i in attributes)
{elem.setAttribute(i,attributes[i]);}
return elem;}
function dtpickerDateOfInput(inputDate)
{try{var laDateArray=inputDate.getAttribute("value").split("-");var laDate=new Date(laDateArray[0],laDateArray[1]-1,laDateArray[2]);}catch(err){return false;}
return laDate;}
function dtpickerDateToInput(inputDate,ladate)
{inputDate.setAttribute("value",ladate.getFullYear()+"-"+(ladate.getMonth()+1)+"-"+ladate.getDate());}
function dtpickerChgMonth(inputDate,increment)
{var lastdate=dtpickerDateOfInput(inputDate);dtpickerChgSelectedDate(inputDate,new Date(lastdate.getFullYear(),lastdate.getMonth()+increment,lastdate.getDate()));}
function dtpickerChgYear(inputDate,increment)
{var lastdate=dtpickerDateOfInput(inputDate);dtpickerChgSelectedDate(inputDate,new Date(lastdate.getFullYear()+increment,lastdate.getMonth(),lastdate.getDate()));}
function dtpickerChgSelectedDate(inputDate,newDate)
{var oldDate=dtpickerDateOfInput(inputDate);var oldDateMonth=oldDate.getMonth();var oldDateYear=oldDate.getFullYear();var oldDateJourDuMois=oldDate.getDate();var newDateMonth=newDate.getMonth();var newDateYear=newDate.getFullYear();var newDateJourDuMois=newDate.getDate();var inputDateId=inputDate.getAttribute("id");if((oldDateMonth!=newDateMonth)||(oldDateYear!=newDateYear)){var name=inputDate.getAttribute("name");var tableBody=dtpickerSetTableBody(newDate,inputDate);document.getElementById("datetimePickerTbody"+name).parentNode.replaceChild(tableBody,document.getElementById("datetimePickerTbody"+name));tableBody.setAttribute("id","datetimePickerTbody"+name);}else{document.getElementById(inputDateId+"-td"+oldDateYear+"-"+oldDateMonth+"-"+oldDateJourDuMois).setAttribute("class","dayUnSelected");document.getElementById(inputDateId+"-td"+newDateYear+"-"+newDateMonth+"-"+newDateJourDuMois).setAttribute("class","daySelected");dtpickerDateToInput(inputDate,newDate);}
document.getElementById(inputDateId+"thTitre").innerHTML=lesJoursFull[newDate.getDay()]+" "+newDateJourDuMois+" "+lesMois[newDateMonth]+" "+newDateYear;}
function dtpickerSetTableBody(selectedDate,inputDate)
{var tBody=createElem("tbody");var selectedJour=selectedDate.getDate();var selectedMois=selectedDate.getMonth();var selectedAnnee=selectedDate.getFullYear();var inputDateId=inputDate.getAttribute("id");var trDays=createElem("tr");tBody.appendChild(trDays);for(var i=0;i<7;i++)
{var tdLeJour=createElem("td",{});tdLeJour.innerHTML=lesJours[i];trDays.appendChild(tdLeJour);}
tBody.appendChild(trDays);var unDuMois=new Date(selectedDate.getFullYear(),selectedDate.getMonth(),1);var unDuMoisSuivant=new Date(unDuMois.getFullYear(),unDuMois.getMonth()+1,1);var startDate=new Date(unDuMois.getFullYear(),unDuMois.getMonth(),unDuMois.getDate()-unDuMois.getDay());var increment=0;var currentDate=startDate;var currentDateMonth=currentDate.getMonth();var currentDateYear=currentDate.getFullYear();var currentDateJourDuMois=currentDate.getDate();while(currentDate<=unDuMoisSuivant)
{var trDates=createElem("tr");for(var dayNumber=0;dayNumber<7;dayNumber++)
{if((currentDateJourDuMois==selectedJour)&&(currentDateMonth==selectedMois)){var tdclass="daySelected";}else{var tdclass="dayUnSelected";}
if(currentDateMonth!=selectedMois){var tdclass="dayWrongMonth";}
var tdJour=createElem("td",{"onClick":"dtpickerChgSelectedDate(document.getElementById('"+inputDateId+"'), new Date("+currentDateYear+","+currentDateMonth+","+currentDate.getDate()+"));","class":tdclass,"id":inputDateId+"-td"+currentDateYear+"-"+currentDateMonth+"-"+currentDateJourDuMois,"title":lesJoursFull[currentDate.getDay()]+" "+currentDateJourDuMois+"-"+(currentDateMonth+1)+"-"+currentDateYear});tdJour.innerHTML=currentDateJourDuMois;trDates.appendChild(tdJour);increment++;currentDate=new Date(startDate.getFullYear(),startDate.getMonth(),startDate.getDate()+increment);currentDateMonth=currentDate.getMonth();currentDateYear=currentDate.getFullYear();currentDateJourDuMois=currentDate.getDate();}
tBody.appendChild(trDates);}
var trTitre=createElem("tr",{"class":"dtPickerNavTr"});var tdMonth=createElem("td",{"colSpan":4});var emPrevious=createElem("em",{"onClick":"dtpickerChgMonth(document.getElementById('"+inputDateId+"'), -1)","class":"dtPickerEmButton","title":"Mois précédent"});emPrevious.innerHTML="<";tdMonth.appendChild(emPrevious);var emMonth=createElem("em",{});emMonth.innerHTML=" "+lesMois[selectedMois]+" ";tdMonth.appendChild(emMonth);var emNext=createElem("em",{"onClick":"dtpickerChgMonth(document.getElementById('"+inputDateId+"'), +1)","class":"dtPickerEmButton","title":"Mois suivant"});emNext.innerHTML=">";tdMonth.appendChild(emNext);trTitre.appendChild(tdMonth);var tdYear=createElem("td",{"colSpan":3});var emPrevious=createElem("em",{"onClick":"dtpickerChgYear(document.getElementById('"+inputDateId+"'), -1)","class":"dtPickerEmButton","title":selectedAnnee-1});emPrevious.innerHTML="<";tdYear.appendChild(emPrevious);var emYear=createElem("em",{});emYear.innerHTML=" "+selectedAnnee+" ";tdYear.appendChild(emYear);var emNext=createElem("em",{"onClick":"dtpickerChgYear(document.getElementById('"+inputDateId+"'), +1)","class":"dtPickerEmButton","title":selectedAnnee+1});emNext.innerHTML=">";tdYear.appendChild(emNext);trTitre.appendChild(tdYear);tBody.appendChild(trTitre);dtpickerDateToInput(document.getElementById(inputDateId),selectedDate);return tBody;}
function dateTimePickerChangeSelect(inputDate)
{var name=inputDate.getAttribute("name");var newDate=new Date(document.getElementById("datetimePickerSelectAnnee"+name).value,document.getElementById("datetimePickerSelectMois"+name).value,document.getElementById("datetimePickerSelectJour"+name).value);dtpickerDateToInput(inputDate,newDate);document.getElementById("datetimePickerSelectAnnee"+name).value=newDate.getFullYear();document.getElementById("datetimePickerSelectMois"+name).value=newDate.getMonth();document.getElementById("datetimePickerSelectJour"+name).value=newDate.getDate();}
function dateTimePicker(inputDate,reduire)
{var ladate=dtpickerDateOfInput(inputDate);if(ladate==false){ladate=new Date();}
var leMois=ladate.getMonth();var lAnnee=ladate.getFullYear();var leJour=ladate.getDate();var name=inputDate.getAttribute("name");var inputDateId=inputDate.getAttribute("id");inputDate.setAttribute("type","hidden");try{document.createEvent("TouchEvent");var isTactile=true;}catch(e){var isTactile=false;}
document.write('<div id="datetimePicker'+name+'" class="dateTimePicker"></div>');if(isTactile)
{var selectJour=createElem("select",{"id":"datetimePickerSelectJour"+name,"onChange":"dateTimePickerChangeSelect(document.getElementById('"+inputDateId+"'));"});for(var i=1;i<32;i++)
{if(i==leJour){var optionJour=createElem("option",{"value":i,"selected":"selected"});}else{var optionJour=createElem("option",{"value":i});}
optionJour.innerHTML=i;selectJour.appendChild(optionJour);}
document.getElementById('datetimePicker'+name).appendChild(selectJour);var selectMois=createElem("select",{"id":"datetimePickerSelectMois"+name,"onChange":"dateTimePickerChangeSelect(document.getElementById('"+inputDateId+"'));"});for(var i=0;i<12;i++)
{if(leMois==i){var optionMois=createElem("option",{"value":i,"selected":"selected"});}else{var optionMois=createElem("option",{"value":i});}
optionMois.innerHTML=lesMois[i];selectMois.appendChild(optionMois);}
document.getElementById('datetimePicker'+name).appendChild(selectMois);var selectAnnee=createElem("select",{"id":"datetimePickerSelectAnnee"+name,"onChange":"dateTimePickerChangeSelect(document.getElementById('"+inputDateId+"'));"});for(var i=1900;i<2100;i++)
{if(lAnnee==i){var optionAnnee=createElem("option",{"value":i,"selected":"selected"});}else{var optionAnnee=createElem("option",{"value":i});}
optionAnnee.innerHTML=i;selectAnnee.appendChild(optionAnnee);}
document.getElementById('datetimePicker'+name).appendChild(selectAnnee);}else{if(reduire){var tableJours=createElem("table",{"id":"datetimePickerTable"+name,"onMouseOver":"document.getElementById('datetimePickerTbody"+name+"').setAttribute('class','dtPickerOn');","onMouseOut":"document.getElementById('datetimePickerTbody"+name+"').setAttribute('class','dtPickerOff');"});}else{var tableJours=createElem("table",{"id":"datetimePickerTable"+name});}
var lignesTitres=createElem("thead",{});var trTitre=createElem("tr",{});var thTitre=createElem("th",{"colSpan":7,"id":inputDateId+"thTitre"});thTitre.innerHTML=lesJoursFull[ladate.getDay()]+" "+leJour+" "+lesMois[leMois]+" "+lAnnee+" ";trTitre.appendChild(thTitre);lignesTitres.appendChild(trTitre);tableJours.appendChild(lignesTitres);var tableBody=dtpickerSetTableBody(ladate,inputDate);tableBody.setAttribute("id","datetimePickerTbody"+name);if(reduire){tableBody.setAttribute("class","dtPickerOff");}else{tableBody.setAttribute("class","dtPickerOn");}
tableJours.appendChild(tableBody);document.getElementById('datetimePicker'+name).appendChild(tableJours);}}
