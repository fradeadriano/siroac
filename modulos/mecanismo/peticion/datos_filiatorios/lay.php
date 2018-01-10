<script language="javascript" type="text/javascript">
messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);

//1
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}

//2
function closeMessage(){
	messageObj.close();	
}

// 3
function cargar_lista_bsq(tr){
	var My_path = tr;
	var spasc = mostrarContenido3;		
	llamarlistado(My_path,spasc);
}

// 4
function mostrarContenido3(){
	document.getElementById("ajaxtd").innerHTML = ajax.response;
}

// 5
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

// 6
function eje(){
	if (document.getElementById("cadena").value!="")
		{	
			var vr = document.getElementById("cadena").value;
			
			if(document.getElementById("cedul").checked == true){
				var vn = "cedula";
			} 
			
			if(document.getElementById("apelli").checked == true){
				var vn = "apellido";
			}
			
			if(document.getElementById("nombr").checked == true){
				var vn = "nombre";
			}
			busq_formal(vr,vn);
		} else {
			document.getElementById("cadena").focus();	
		}
}

// 7
function cancel() 
{
	document.getElementById("cedul").checked = true;
	document.getElementById("cadena").value = "";
	cargar_lista_bsq("modulos/mantenimiento/ciudadano/bsq_list.php?pagina=1");	
}

// 8
function busq_formal(a1,a2){ 
	var My_path = "modulos/mecanismo/peticion/datos_filiatorios/bsq_list.php?pagina=1&pa1="+a1+"&pa2="+a2;
	var spasc = mostrarContenido3;
	llamarlistado(My_path,spasc);
}

// 9
function devolver(id,ced,nom,tele,dire){
	document.getElementById("id_ciudadano").value = id;
	document.getElementById("cedula_ciu").value = ced;
	document.getElementById("nombre_ciu").value = nom;
	document.getElementById("telefonos_ciu").value = tele;
	document.getElementById("direccion_ciu").value = dire;
	closeMessage();	
	
}

// 10
function mostrarContenido2(){
	document.getElementById("listregistros").innerHTML = ajax.response;
}

//11
function cargar_parroquias(My_param){
	var My_path = "modulos/mecanismo/peticion/datos_filiatorios/c.parroquia.php?mY_id_municipio="+My_param;
	var spasc = mostrarContenido1;
	llamarcombo(My_path,spasc);
}


// 12
function mostrarContenido1(){
	document.getElementById("comb_P").innerHTML = ajax.response;
}

// 13
function llamarcombo(archivo,spasc){
	ajax = new sack();
	ajax.requestFile = archivo;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}


// 18
function mostrarContenido4(){
	document.getElementById("salvar").innerHTML = ajax.response;
}

// 14
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

	var cad = document.getElementById("tmovil").value.split("-");
	if ((cad[0]!="0412") && (cad[0]!="0416") && (cad[0]!="0414") && (cad[0]!="0426") && (cad[0]!="0424"))
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
		
	if (document.getElementById("id_municipio").value == ""){
		alert(acentos("Debe especificar el municipio donde vive el ciudadano"));
		return document.getElementById("municipio").focus();
	}
	
	$valores = "?accion="+document.getElementById("registrar").value+"&nombres="+document.getElementById("nombres").value+"&apellidos="+document.getElementById("apellidos").value+"&cedula="+document.getElementById("cedula").value+"&thabitacion="+document.getElementById("thabitacion").value+"&tmovil="+document.getElementById("tmovil").value+"&direccion="+document.getElementById("direccion").value+"&id_parroquia="+document.getElementById("id_parroquia").value+"&email="+document.getElementById("email").value+"&odireccion="+document.getElementById("odireccion").value+"&municipio="+document.getElementById("municipio").value;
	//var My_Second_path = "modulos/mecanismo/denuncia/save_ciudadano.php"+$valores;
	//var spasc = mostrarContenido4;
	//llamarlistado(My_Second_path,spasc);
	//alert($valores);
	
	window.frames.salvar_ciudadano.location.href="modulos/mecanismo/peticion/datos_filiatorios/save_ciudadano.php"+$valores;
	


}

// 15
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

// 16
var p_telefonico = new Array(4,7)
var patron2 = new Array(1,3,3,3,3)
var patron3 = new Array(1,13)
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

// 17
function parroquia_cargada(vara){
	document.getElementById("id_parroquia").value = vara;
}

// 18
function cargar_id_muni(vvv){
	document.getElementById("id_municipio").value = vvv;
}

//19
function devolver_valores(id,nom,ced,tele,dire)
{
	document.getElementById("id_ciudadano").value = id;
	document.getElementById("cedula_ciu").value = ced;
	document.getElementById("nombre_ciu").value = nom;
	document.getElementById("telefonos_ciu").value = tele;
	document.getElementById("direccion_ciu").value = dire;
	closeMessage();	
}

//20

function ajustes_instanciapp(val) {
	if(val=="expandir"){
		document.getElementById("instancia").style.display="";
		document.getElementById("val_instancia").value=0;		
	} else if(val=="contraer"){
		document.getElementById("instancia").style.display="none";
		document.getElementById("val_instancia").value=1;
		document.getElementById("instancia_pp").value="";
		document.getElementById("direccion_instancia").value="";
		document.getElementById("rif_instancia").value="";
		document.getElementById("ente_financiero").value="";
		document.getElementById("nombre_proy").value="";		
		document.getElementById("mon_financiado").value="";
		document.getElementById("nomb_comite").value="";		
		document.getElementById("nomb_comite").readOnly=true;
		document.getElementById("no_pert").checked=true;		
	}
}

//21

function ajustes_organizacion(val) {
	if(val=="expandir"){
		document.getElementById("organizacion").style.display="";
		document.getElementById("val_organizacion").value=0;		
	} else if(val=="contraer"){
		document.getElementById("organizacion").style.display="none";
		document.getElementById("val_organizacion").value=1;
		document.getElementById("nom_organizacion").value="";
		document.getElementById("direccion_organizacion").value="";
		document.getElementById("rif_organizacion").value="";
		document.getElementById("telef_organizacion").value="";	
		document.getElementById("otr_telef_organizacion").value="";		
	}
}

//22

function ajustes_involucrados(val) {
	if(val=="expandir"){
		document.getElementById("involucrados").style.display="";
		document.getElementById("val_involucrados").value=0;		
	} else if(val=="contraer"){
		document.getElementById("involucrados").style.display="none";
		document.getElementById("val_involucrados").value=1;
		document.getElementById("hechos").value = "";
	}
}

//23

function ajustes_fecha(val) {
	if(val=="expandir"){
		document.getElementById("fecha").style.display="";
		document.getElementById("val_fecha").value=0;		
	} else if(val=="contraer"){
		document.getElementById("fecha").style.display="none";
		document.getElementById("val_fecha").value=1;
		document.getElementById("fecha_hechos").value = "";
	}
}

//24

function ajustes_narracion(val) {
	if(val=="expandir"){
		document.getElementById("narracion").style.display="";
		document.getElementById("val_narracion").value=0;		
	} else if(val=="contraer"){
		document.getElementById("narracion").style.display="none";
		document.getElementById("val_narracion").value=1;
		document.getElementById("narracion_hechos").value="";		
	}
}

//25

function ajustes_observacion(val) {
	if(val=="expandir"){
		document.getElementById("observacion").style.display="";
		document.getElementById("val_observacion").value=0;		
	} else if(val=="contraer"){
		document.getElementById("observacion").style.display="none";
		document.getElementById("val_observacion").value=1;
		document.getElementById("observacion_hechos").value="";		
	}
}

//26

function ajustes_pruebas(val) {
	if(val=="expandir"){
		document.getElementById("pruebas").style.display="";
		document.getElementById("val_prueba").value=0;		
	} else if(val=="contraer"){
		document.getElementById("pruebas").style.display="none";
		document.getElementById("val_prueba").value=1;
	}
}

// 27
function pertene(val){
	if(val=="si_pert"){
		document.getElementById("nomb_comite").readOnly=false;
	} else if (val=="no_pert") {
		document.getElementById("nomb_comite").readOnly=true;
		document.getElementById("nomb_comite").value="";
	}
}

//28
function sub_marine(){
	if(validacion()==false){
			return;
	} 
	document.getElementById("accion").value = document.getElementById("registrar").value;
	document.form_denuncia.submit();	
}

//29
function validacion() 
{
	if (document.getElementById("asesoria").value == "" || /^\s+$/.test(document.getElementById("asesoria").value)){		
			alert(acentos("Seleccione una Comunicaci&oacute;n!!"));
			document.getElementById("asesoria").focus;
			return false;
		}
		
		var h = 0;
		var contenedor1 = 0;
	   for (i=0;i<document.form_denuncia.elements.length;i++)
	   {
			if(document.form_denuncia.elements[i].type == "checkbox")
			{
				if(document.form_denuncia.elements[i].checked == false)
				{
					h = h+1;
				} else {
					if(contenedor1==""){
							contenedor1 = "interposicion:"+document.form_denuncia.elements[i].value;
						} else if(contenedor1!=""){
							contenedor1 = contenedor1 +"-"+document.form_denuncia.elements[i].value;						
						}	
				}
			}
		}	
			
		if(h==5){
			alert(acentos("Seleccione al menos una Interposici&oacute;n de Mecan&iacute;smo !!"));
			return false;		
		} 
		
		document.getElementById("contenedor_1").value = contenedor1;


	if (document.getElementById("id_ciudadano").value == "" || /^\s+$/.test(document.getElementById("id_ciudadano").value)){		
			alert(acentos("DATOS DEL CIUDADANO: Seleccione un Ciudadano!!"));
			return false;
		}

/*	if (document.getElementById("val_instancia").value==0) 
	{
		if (document.getElementById("instancia_pp").value == "" || /^\s+$/.test(document.getElementById("instancia_pp").value)){		
				alert(acentos("INSTANCIA DEL PODER POPULAR: Ingrese una Instancia del Poder Popular!!"));
				document.getElementById("instancia_pp").focus();
				return false;
			} 		
		
		if (document.getElementById("direccion_instancia").value == "" || /^\s+$/.test(document.getElementById("direccion_instancia").value)){		
				alert(acentos("INSTANCIA DEL PODER POPULAR: Ingrese una Direcci&oacute;n de la Instancia del Poder Popular!!"));
				document.getElementById("direccion_instancia").focus();
				return false;
			} 				
	}
	
	if (document.getElementById("val_organizacion").value==0) 
	{
		if (document.getElementById("nom_organizacion").value == "" || /^\s+$/.test(document.getElementById("nom_organizacion").value)){		
				alert(acentos("MIEMBROS DE ORGANIZACI&Oacute;N SINDICAL O GREMIAL: Ingrese una Organizaci&oacute;n Sindical o Gremial!!"));
				document.getElementById("nom_organizacion").focus();
				return false;
			} 		
		
		if (document.getElementById("direccion_organizacion").value == "" || /^\s+$/.test(document.getElementById("direccion_organizacion").value)){		
				alert(acentos("MIEMBROS DE ORGANIZACI&Oacute;N SINDICAL O GREMIAL: Ingrese una Direcci&oacute;n de Organizaci&oacute;n Sindical o Gremial!!"));
				document.getElementById("direccion_organizacion").focus();
				return false;
			} 
		if (document.getElementById("rif_organizacion").value == "" || /^\s+$/.test(document.getElementById("rif_organizacion").value)){		
				alert(acentos("MIEMBROS DE ORGANIZACI&Oacute;N SINDICAL O GREMIAL: Ingrese un Rif. de Organizaci&oacute;n Sindical o Gremial!!"));
				document.getElementById("rif_organizacion").focus();
				return false;
			} 		
		
		if (document.getElementById("telef_organizacion").value == "" || /^\s+$/.test(document.getElementById("telef_organizacion").value)){		
				alert(acentos("MIEMBROS DE ORGANIZACI&Oacute;N SINDICAL O GREMIAL: Ingrese un Tel&eacute;fono de Organizaci&oacute;n Sindical o Gremial!!"));
				document.getElementById("telef_organizacion").focus();
				return false;
			}										
	}	
	
	if (document.getElementById("val_involucrados").value==0) 
	{
		if (document.getElementById("hechos").value == "" || /^\s+$/.test(document.getElementById("hechos").value)){		
				alert(acentos("PERSONAS, ORGANISMOS O INSTITUCIONES INVOLUCRADAS EN LOS HECHOS: Debe Ingresar los Actores Involucrados!!"));
				document.getElementById("hechos").focus();
				return false;
			} 												
	}	
	
	if (document.getElementById("val_fecha").value==0) 
	{
		if (document.getElementById("fecha_hechos").value == "" || /^\s+$/.test(document.getElementById("fecha_hechos").value)){		
				alert(acentos("FECHA EN LA CUAL OCURRI&Oacute; U OCURRIERON LOS HECHOS: Debe Ingresar la Fecha Cuando Ocurrieron los Hechos!!"));
				document.getElementById("fecha_hechos").focus();
				return false;
			} 												
	}	
*/	
	if (document.getElementById("val_narracion").value==0) 
	{
		if (document.getElementById("narracion_hechos").value == "" || /^\s+$/.test(document.getElementById("narracion_hechos").value)){		
				alert(acentos("NARRACI&Oacute;N DE LOS PRESUNTOS ACTOS, HECHOS U OMISIONES: Debe Ingresar la narraciones de los Hechos!!"));
				document.getElementById("narracion_hechos").focus();
				return false;
			} 												
	}
	
	if (document.getElementById("val_observacion").value==0) 
	{
		if (document.getElementById("observacion_hechos").value == "" || /^\s+$/.test(document.getElementById("observacion_hechos").value)){		
				alert(acentos("OBSERVACIONES: Debe Ingresar las Observaciones!!"));
				document.getElementById("observacion_hechos").focus();
				return false;
			} 												
	}
/*
	if (document.getElementById("val_prueba").value==0) 
	{
		var contenedor2 = "";
		if(document.getElementById("si_do").checked == true){
			if(contenedor2==""){
					contenedor2 = "Documentos:"+document.getElementById("docu_folios").value;
				}
		}
		
		if(document.getElementById("si_act").checked == true){
			if(contenedor2==""){
					contenedor2 = "Actas:"+document.getElementById("acta_folios").value;
				} else if(contenedor2!=""){
					contenedor2 = contenedor2 +"!Actas:"+document.getElementById("acta_folios").value;
				}
		}

		if(document.getElementById("si_fo").checked == true){
			if(contenedor2==""){
					contenedor2 = "Fotografias:"+document.getElementById("foto_folios").value;
				} else if(contenedor2!=""){
					contenedor2 = contenedor2 +"!Fotografias:"+document.getElementById("foto_folios").value;
				}
		}

		if(document.getElementById("si_pru_otro").checked == true){
			if(contenedor2==""){
					contenedor2 = "otros:"+document.getElementById("otros_folios").value+":"+document.getElementById("pru_otro_descr").value;  
				} else if(contenedor2!=""){
					contenedor2 = contenedor2 +"!otros:"+document.getElementById("otros_folios").value+":"+document.getElementById("pru_otro_descr").value;  
				}
		}

		document.getElementById("contenedor_2").value = contenedor2;
	}			
*/	
}
//30
function abcd(val){
	if(val=="si_pru_otro"){
		document.getElementById("pru_otro_descr").readOnly=false;
		document.getElementById("otros_folios").readOnly=false;		
		
	} else if (val=="no_pru_otro") {
		document.getElementById("pru_otro_descr").readOnly=true;
		document.getElementById("otros_folios").readOnly=true;	
		document.getElementById("pru_otro_descr").value="";
		document.getElementById("otros_folios").value="";		
	}
}

//31
function habilite(val){
	switch(val){
		case "si_do":
			document.getElementById("docu_folios").readOnly=false;
		break;
		case "no_do":
			document.getElementById("docu_folios").readOnly=true;
			document.getElementById("docu_folios").value="";
		break;	
		
		case "si_act":
			document.getElementById("acta_folios").readOnly=false;
		break;
		case "no_act":
			document.getElementById("acta_folios").readOnly=true;
			document.getElementById("acta_folios").value="";
		break;			

		case "si_fo":
			document.getElementById("foto_folios").readOnly=false;
		break;
		case "no_fo":
			document.getElementById("foto_folios").readOnly=true;
			document.getElementById("foto_folios").value="";
		break;	
	}
}

//32
function cargar_municipos(My_param,selec){
	var My_path = "modulos/mecanismo/peticion/datos_filiatorios/c.municipio.php?mY_id_estado="+My_param;
	var spasc = mostrarContenido5;
	llamarcombo(My_path,spasc);
}

// 33
function mostrarContenido5(){
	document.getElementById("comb_M").innerHTML = ajax.response;
}
</script>