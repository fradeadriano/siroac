//1
function cargar_parroquias(My_param){
	var My_path = "modulos/mantenimiento/ciudadano/c.parroquia.php?mY_id_municipio="+My_param;
	var spasc = mostrarContenido1;
	llamarcombo(My_path,spasc);
}

// 2
function mostrarContenido1(){
	document.getElementById("comb_P").innerHTML = ajax.response;
}

// 3
function llamarcombo(archivo,spasc){
	ajax = new sack();
	ajax.requestFile = archivo;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

// 4
function parroquia_cargada(vara){
	document.getElementById("id_parroquia").value = vara;
}

// 5
var p_telefonico = new Array(4,7)
var patron2 = new Array(1,3,3,3,3)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}

// 6
function validateForm(x)
{
	var w = x.charAt(0);
	if (w == "-" || w == "_" || w == "."){
		alert(acentos("Caracter no v&aacute;lido como inicio de correo electr&oacute;nico"));
	} else {		
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
	
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  { 
			alert(acentos("Correo Electr&oacute;nico Inv&aacute;lido!"));
			window.document.form_ciu.email.value=""; 
		  }
	}
}

// 7
function subb()
{
	if (document.getElementById("nombres").value == ""){
		alert(acentos("Debe colocar el nombre del ciudadano"));
		return document.getElementById("nombres").focus();
	}

	if (document.getElementById("apellidos").value == ""){
		alert(acentos("Debe colocar el apellido del ciudadano"));
		return document.getElementById("apellidos").focus();
	}

	if (document.getElementById("cedula").value == ""){
		alert(acentos("Debe colocar la c&eacute;dula del ciudadano"));
		return document.getElementById("cedula").focus();
	}

	if (document.getElementById("thabitacion").value == ""){
		alert(acentos("Debe colocar el tel&eacute;fono de habitaci&oacute;n del ciudadano"));
		return document.getElementById("thabitacion").focus();
	}
	
	var cad = document.getElementById("tmovil").value.split("-");
	if ( (cad[0]!="0412") && (cad[0]!="0416") && (cad[0]!="0414") && (cad[0]!="0426") && (cad[0]!="0424"))
	{
		alert(acentos("Ingrese un c&oacute;digo de &aacute;rea v&aacute;lido para tel&eacute;fonos moviles!!"));
		document.getElementById("tmovil").select();	
		return false;		
	}
	
	if (document.getElementById("tmovil").value == ""){
		alert(acentos("Debe colocar el tel&eacute;fono movil del ciudadano"));
		return document.getElementById("tmovil").focus();
	}

	if (document.getElementById("direccion").value == ""){
		alert(acentos("Debe especificar alguna direcci&oacute;n del ciudadano"));
		return document.getElementById("direccion").focus();
	}		

	if (document.getElementById("id_parroquia").value == ""){
		alert(acentos("Debe especificar la parroquia donde vive el ciudadano"));
		return document.getElementById("id_parroquia").focus();
	}
	
	document.form_ciu.accion.value = document.form_ciu.registrar.value;
	document.form_ciu.submit();			
	
}