// -----------------------------------------
// Source  :	http://cogites.com
// Script  :	E RESERV
// Version :	5
// revente et redistribution interdites 
// Vous devez laisser le copyright.
// -----------------------------------------

//	Activations - Désactivations menu client connu ou nouveau client
function GereControle(Controleur, Controle, Masquer) {
var objControleur = document.getElementById(Controleur);
var objControle = document.getElementById(Controle);
	if (Masquer=='1')
		objControle.style.visibility=(objControleur.checked==true)?'visible':'hidden';
	else
		objControle.disabled=(objControleur.checked==true)?false:true;
	return true;
}

//	Pop-up calendrier centré
function newWindow(a_str_windowURL, a_str_windowName, a_int_windowWidth, a_int_windowHeight, a_bool_scrollbars, a_bool_resizable, a_bool_menubar, a_bool_toolbar, a_bool_addressbar, a_bool_statusbar, a_bool_fullscreen) {
  var int_windowLeft = (screen.width - a_int_windowWidth) / 2;
  var int_windowTop = (screen.height - a_int_windowHeight) / 2;
  var str_windowProperties = 'height=' + a_int_windowHeight + ',width=' + a_int_windowWidth + ',top=' + int_windowTop + ',left=' + int_windowLeft + ',scrollbars=' + a_bool_scrollbars + ',resizable=' + a_bool_resizable + ',menubar=' + a_bool_menubar + ',toolbar=' + a_bool_toolbar + ',location=' + a_bool_addressbar + ',statusbar=' + a_bool_statusbar + ',fullscreen=' + a_bool_fullscreen + '';
  var obj_window = window.open(a_str_windowURL, a_str_windowName, str_windowProperties)
    if (parseInt(navigator.appVersion) >= 4) {
      obj_window.window.focus();
    }
}

//	rafraichissemement des pages de listes aprés des changements
function refreshParent() {
  window.opener.location.href = window.opener.location.href;
  if (window.opener.progressWindow)
 {
   window.opener.progressWindow.close()
  }
  window.close();
}

//	prévention contre les suppression intenpestives
function verif_form()
	{
 	resultat = confirm("Toute suppression est définitive. Confirmer la suppression ?");
	if(resultat=="0")
		{
		return false;
		}
	return true;
	}
	
	
	
	//	prévention contre les duplications malheureuses
function verif_duplic()
	{
 	resultat = confirm("Toute duplication est irréversible. Confirmer la duplication ?");
	if(resultat=="0")
		{
		return false;
		}
	return true;
	}


//	pour les contrats
function addRow(tableID) {
  var ni = document.getElementById('mainTable');
  var numi = document.getElementById('theValue');
  var num = document.getElementById("theValue").value + 1;
  numi.value = num;
  var divIdName = "myDiv"+num;

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			row.style.display = 'none';
			var cell1 = row.insertCell(0);

			var element1 = document.createElement("input");
			element1.type = "text";
			element1.id = "header " + divIdName;
			element1.name = "header " + divIdName;
			cell1.appendChild(element1);


			var cell3 = row.insertCell(1);
			var element2 = document.createElement("textarea");
			element2.id = "desc " + divIdName;
			element2.name = "desc " + divIdName;
			element2.cols = 80;
			element2.rows = 8;
			cell3.appendChild(element2);

			var element1 = document.createElement("img");
			element1.src = "img/arrow_up.png";
			element1.height="20"
			element1.setAttribute("onClick", "swapRowUp(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);");
			element1.title="Monter le bloc d'une position"
			cell1.appendChild(element1);

			var element1 = document.createElement("img");
			element1.src = "img/arrow_down.png";
			element1.height="20"
			element1.setAttribute("onClick", "swapRowDown(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);");
			element1.title="Descendre le bloc d\'une position"
			cell1.appendChild(element1);

			var element1 = document.createElement("img");
			element1.src = "img/cancel.png";
			element1.height="20"
			element1.setAttribute("onClick", "deleteRow(this.parentNode.parentNode.parentNode.parentNode);");
			element1.title="Supprimer le bloc courant"
			cell1.appendChild(element1);

			var element1 = document.createElement("img");
			element1.src = "img/add.png";
			element1.height="20"
			element1.setAttribute("onClick", "addRow(\'mainTable\');");
			element1.title="Ajouter un bloc en bas de page"
			cell1.appendChild(element1);

	document.myForm.submit();
}


function deleteRow(r) {
	var i=r.parentNode.parentNode.rowIndex;
	document.getElementById('mainTable').deleteRow(i);
	document.myForm.submit();
}



// donne le focus à un champ
function donner_focus(chp)
{
document.getElementById(chp).focus();
}



//	afficher / masquer l'aide pour les contrats
var state = 'none';
function showhide(layer_ref) {
	if (state == 'block') {
		state = 'none';
	}
	else {
		state = 'block';
	}
	if (document.all) { //IS IE 4 or 5 (or 6 beta)
		eval( "document.all." + layer_ref + ".style.display = state");
	}
	if (document.layers) { //IS NETSCAPE 4 or below
		document.layers[layer_ref].display = state;
	}
	if (document.getElementById &&!document.all) {
		hza = document.getElementById(layer_ref);
		hza.style.display = state;
	}
}