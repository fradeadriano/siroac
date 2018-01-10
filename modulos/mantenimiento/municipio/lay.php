<script language="javascript" type="text/javascript">
// 7
function subb()
{
	if (document.getElementById("estado").value == ""){
		alert(acentos("Debe colocar el estado"));
		return document.getElementById("estado").focus();
	}

	if (document.getElementById("municipio").value == ""){
		alert(acentos("Debe colocar el municipio"));
		return document.getElementById("municipio").focus();
	}

	document.form_mun.accion.value = document.form_mun.registrar.value;
	document.form_mun.submit();			
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
	var rut = "modulos/mantenimiento/municipio/municipio_d.php?pagina=1&b_id="+id;
	var spasc = mostrarContenido2;
	llamarlistado(rut,spasc);
	closeMessage();	
}

// 16
function eje(){
	if (document.getElementById("estadobsq").value!="")
		{	
			busq_formal(document.getElementById("estadobsq").value);
		} else {
			document.getElementById("estadobsq").focus();	
		}
}
// 17
function cancel() 
{
	document.getElementById("estadobsq").value = "";
	cargar_lista_bsq("modulos/mantenimiento/municipio/bsq_list.php?pagina=1");	
}

// 18
function busq_formal(a1){ 
	var My_path = "modulos/mantenimiento/municipio/bsq_list.php?pagina=1&pa1="+a1;
	var spasc = mostrarContenido3;
	llamarlistado(My_path,spasc);
}
// 19
function cancel_principal() 
{
	document.getElementById("registrar").value = "Registrar";
	document.getElementById("registrar").title = "Registrar";
	cargar_lista("modulos/mantenimiento/municipio/municipio_d.php?pagina=1");	
}
// 20
function subir(valor,id_mu,mu,est,id_est){
		document.getElementById("municipio").value = mu;
		document.getElementById("estado").value = id_est;
		document.getElementById("id_municipio").value = id_mu;		
		document.getElementById("registrar").value = valor;
		document.getElementById("registrar").title = valor;
}
//21
function cargar_parroquias_modif(My_param,ghfdryhbk){
	var My_path = "modulos/mantenimiento/ciudadano/c.parroquia.php?mY_id_municipio="+My_param+"&selec="+ghfdryhbk;
	var spasc = mostrarContenido1;
	llamarcombo(My_path,spasc);
}
</script>