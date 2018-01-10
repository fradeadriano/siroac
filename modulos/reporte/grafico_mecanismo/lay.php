<script language="javascript" type="text/javascript">	
// 1
function doit(){ 
	if (document.getElementById("mecanismo").value == "")
	{
			alert(acentos("seleccione un Mecanismo V&aacute;lido!!"));
			return document.getElementById("mecanismo").focus();		
	}	
	
	if (document.getElementById("desde").value == "") {
		if(validarFecha(document.getElementById("desde").value) == false) {
				alert(acentos("Ingrese una fecha v&aacute;lida!!"));
				return document.getElementById("desde").focus();
		} 
	}
	if (document.getElementById("hasta").value == "") {
		if(validarFecha(document.getElementById("hasta").value) == false) {
				alert(acentos("Ingrese una fecha v&aacute;lida!!"));
				return document.getElementById("hasta").focus();
		}
	}
	document.getElementById("Formgra").action = "modulos/reporte/listado_mecanismos/titulo.php";
	document.getElementById("Formgra").target="_blank";
	document.getElementById("Formgra").submit();
}

//2
function limp(){
	ajax = new sack();
	ajax.requestFile = "modulos/reporte/reimpresion_mecanismo/reporte_list.php";
	ajax.onCompletion = mostrarContenido1;
	ajax.runAJAX();
} 
</script>