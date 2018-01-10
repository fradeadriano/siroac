<script language="javascript" type="text/javascript">
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

/*	if (document.getElementById("thabitacion").value == ""){
		alert(acentos("Debe colocar el tel&eacute;fono de habitaci&oacute;n del ciudadano"));
		return document.getElementById("thabitacion").focus();
	}*/
	
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

	if (document.getElementById("municipio").value == ""){
		alert(acentos("Debe especificar el municipio donde vive el ciudadano"));
		return document.getElementById("municipio").focus();
	}
	
/*	if (document.getElementById("id_parroquia").value == ""){
		alert(acentos("Debe especificar la parroquia donde vive el ciudadano"));
		return document.getElementById("id_parroquia").focus();
	}*/
	
	document.form_ciu.accion.value = document.form_ciu.registrar.value;
	document.form_ciu.submit();			
	
}

// 8
function cargar_lista(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido2;		
	llamarlistado(My_path,spasc);
}

// 9
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

// 10
function mostrarContenido2(){
	document.getElementById("listregistros").innerHTML = ajax.response;
}

messageObj = new DHTMLSuite.modalMessage();
messageObj.setWaitMessage('Cargando Pantalla..!');
messageObj.setShadowOffset(0);
DHTMLSuite.commonObj.setCssCacheStatus(false);

// 11
function displayMessage(url,ancho,largo){
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(ancho,largo);
	messageObj.setShadowDivVisible(false);
	messageObj.display();
}
//12
function closeMessage(){
	messageObj.close();	
}
// 13
function cargar_lista_bsq(tr){
	var My_path = tr;
	var spasc = mostrarContenido3;		
	llamarlistado(My_path,spasc);
}
// 14
function mostrarContenido3(){
	document.getElementById("ajaxtd").innerHTML = ajax.response;
}

// 15
function devolver(id){
	var rut = "modulos/mantenimiento/ciudadano/ciudadano_d.php?pagina=1&b_id="+id;
	var spasc = mostrarContenido2;
	llamarlistado(rut,spasc);
	closeMessage();	
}

// 16
function eje(){
		if (document.getElementById("cadena").value!="")
			{	
				var vr = document.getElementById("cadena").value;
				
				if(document.getElementById("ced").checked == true){
					var vn = "cedula";
				} 
				
				if(document.getElementById("apellido").checked == true){
					var vn = "apellido";
				}
				
				if(document.getElementById("nombre").checked == true){
					var vn = "nombre";
				}
				busq_formal(vr,vn);
			} else {
				document.getElementById("cadena").focus();	
			}
}
// 17
function cancel() 
{
	document.getElementById("cedula").checked = true;
	document.getElementById("cadena").value = "";
	cargar_lista_bsq("modulos/mantenimiento/ciudadano/bsq_list.php?pagina=1");	
}

// 18
function busq_formal(a1,a2){ 
	var My_path = "modulos/mantenimiento/ciudadano/bsq_list.php?pagina=1&pa1="+a1+"&pa2="+a2;
	var spasc = mostrarContenido3;
	llamarlistado(My_path,spasc);
}
// 19
function cancel_principal() 
{
	document.getElementById("registrar").value = "Registrar";
	document.getElementById("registrar").title = "Registrar";
	cargar_lista_desp_cance("modulos/mantenimiento/ciudadano/ciudadano_d.php?pagina=1");
	document.getElementById("municipio").value = "";
	document.getElementById("parroquia").value = "";
	document.getElementById("id_parroquia").value = "";		
	document.getElementById("id_ciudadano").value = "";		
	document.getElementById("id_municipio").value = "";	
}
// 20
function subir(valor,id,nom,apell,ced,ema,tel,dir,odir,paro,muni,esta,tel_habi){
		document.getElementById("estado").value = esta;
		document.getElementById("id_municipio").value = muni;
		cargar_municipio_modif(esta,muni);
		cargar_parroquias_modif(muni,paro);
		document.getElementById("id_parroquia").value = paro;
		document.getElementById("id_ciudadano").value = id;
		document.getElementById("nombres").value = nom;	
		document.getElementById("apellidos").value = apell;
		document.getElementById("cedula").value = ced;	
		document.getElementById("email").value = ema;				
		document.getElementById("tmovil").value = tel;			
		document.getElementById("thabitacion").value = tel_habi;
		document.getElementById("direccion").value = dir;
		document.getElementById("odireccion").value = odir;
		document.getElementById("registrar").value = valor;
		document.getElementById("registrar").title = valor;
}
//21
function cargar_parroquias_modif(My_param,ghfdryhbk){
	var My_path = "modulos/mantenimiento/ciudadano/c.parroquia.php?mY_id_municipio="+My_param+"&selec="+ghfdryhbk;
	var spasc = mostrarContenido1;
	llamarcombo1(My_path,spasc);
}

//22
function cargar_municipos(My_param,selec){
	var My_path = "modulos/mantenimiento/ciudadano/c.municipio.php?mY_id_estado="+My_param;
	var spasc = mostrarContenido5;
	llamarcombocargMuni(My_path,spasc);
}

// 23
function mostrarContenido5(){
	document.getElementById("comb_M").innerHTML = ajax_muni.response;
}

// 24
function cargar_id_muni(vvv){
	document.getElementById("id_municipio").value = vvv;
}

//25
function cargar_municipio_modif(My_param,ghfdryhbk){
	var My_path2 = "modulos/mantenimiento/ciudadano/c.municipio.php?mY_id_estado="+My_param+"&selec="+ghfdryhbk;
	var spasc2 = mostrarContenido5;
	llamarcombo2(My_path2,spasc2);
}

//26
function llamarcombo1(archivo,spasc){
	ajax = new sack();
	ajax.requestFile = archivo;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}

//28
function llamarcombo2(archivo,spasc){
	ajax_muni = new sack();
	ajax_muni.requestFile = archivo;
	ajax_muni.onCompletion = spasc;
	ajax_muni.runAJAX();
}

//28
function llamarcombocargMuni(archivo,spasc){
	ajax_muni = new sack();
	ajax_muni.requestFile = archivo;
	ajax_muni.onCompletion = spasc;
	ajax_muni.runAJAX();
}

// 29
function cargar_lista_desp_cance(rt){ 
	var My_path = rt;
	var spasc = mostrarContenido2;		
	llamarlistado(My_path,spasc);
}
</script>