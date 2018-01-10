<script language="javascript" type="text/javascript">	

var param = "";
// 1
function doit(){ //si
	if(validacion()==false){
			return;
	}
	//alert(param) ;	
	var ruta = "modulos/reporte/reimpresion_mecanismo/reporte_list.php?condiciones="+param;	
	cargar_lista_corres(ruta);
	param = "";
}
// 2
function validacion() {
var evaluador =0;
var echa = "";

	if (document.getElementById("mecanismo").value == null || document.getElementById("mecanismo").value.length == 0 || /^\s+$/.test(document.getElementById("mecanismo").value))
	{
		evaluador = evaluador + 1;
	} else {	
		// campo5 = id_organismo	
		if (param==""){
			param = "campo1:"+document.getElementById("mecanismo").value;				
		} else {
			param = param+"!campo1:"+document.getElementById("mecanismo").value;							
		}		
	}	
	
	if (document.getElementById("desde").value != null || document.getElementById("desde").value.length != 0)
	{
		if(validarFecha(document.getElementById("desde").value) == false) {
			alert(acentos("Ingrese una Fecha Desde v&aacute;lida!!"));
			document.getElementById("desde").select();	
			return false;
			}		
		// campo4 = sel_fecha	
		echa = document.getElementById("desde").value+"_";
	}	
	
	if (document.getElementById("hasta").value != null || document.getElementById("hasta").value.length != 0)
	{
		if(validarFecha(document.getElementById("hasta").value) == false) {
			alert(acentos("Ingrese una Fecha Hasta v&aacute;lida!!"));
			document.getElementById("hasta").select();	
			return false;
		}	
		// campo4 = sel_fecha	
		echa = echa+document.getElementById("hasta").value;
	} 
	
	if (echa.length != 0)
	{
		if (param==""){
			param = "campo2:"+echa;				
		} else {
			param = param+"!campo2:"+echa;							
		}	
	} else {
		evaluador = evaluador + 1;
	}	


	
	if (document.getElementById("id_ciudadano").value == null || document.getElementById("id_ciudadano").value.length == 0 || /^\s+$/.test(document.getElementById("id_ciudadano").value))
	{		
		evaluador = evaluador + 1;
	} else {
		// campo5 = id_organismo	
		if (param==""){
			param = "campo3:"+document.getElementById("id_ciudadano").value;				
		} else {
			param = param+"!campo3:"+document.getElementById("id_ciudadano").value;							
		}		
	}	
	
	if (document.getElementById("id_registro_mecanismo").value == null || document.getElementById("id_registro_mecanismo").value.length == 0 || /^\s+$/.test(document.getElementById("id_registro_mecanismo").value))
	{		
		evaluador = evaluador + 1;
	} else {
		// campo5 = id_organismo	
		if (param==""){
			param = "campo4:"+document.getElementById("id_registro_mecanismo").value;				
		} else {
			param = param+"!campo4:"+document.getElementById("id_registro_mecanismo").value;							
		}		
	}			
	
	if(evaluador==4){
		alert(acentos("Ingrese al menos un criterio de b&uacute;squeda v&aacute;lido para realizar el filtrado!!"));
		return false;		
	} 
			
	return param;	
}

// 3
function llamarlistado(ruta,spasc){
	ajax = new sack();
	ajax.requestFile = ruta;
	ajax.onCompletion = spasc;
	ajax.runAJAX();
}
// 4
function mostrarContenido1(){
	document.getElementById("zone").innerHTML = ajax.response;	
}
//5
function cargar_lista_corres(rt){ 
	var spasc = mostrarContenido1;
	llamarlistado(rt,spasc);
}

//6
function exprt(){
	if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
			alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
			document.getElementById("condiciones").focus();
			return false;
	} 				
	document.getElementById("rep").action = "modulos/reporte/listado_mecanismos/excel.php";;
	document.getElementById("rep").submit();
}

//41
function graphi_s(o,i){
	if(i==0){
		document.getElementById("condiciones").value = o;
		if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
				alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
				document.getElementById("condiciones").focus();
				return false;
		} 	
		document.getElementById("gra").action = "modulos/reporte/reimpresion_mecanismo/xls.php";
		document.getElementById("gra").target="_blank";
		document.getElementById("gra").submit();
	} else {
		document.getElementById("condiciones").value = o;
		if (document.getElementById("condiciones").value == null || document.getElementById("condiciones").value.length == 0 || /^\s+$/.test(document.getElementById("condiciones").value)){
				alert(acentos("Ha ocurrido un fallo, por favor vuelva a cargar el Modulo!"));
				document.getElementById("condiciones").focus();
				return false;
		} 	
		document.getElementById("gra").action = "modulos/reporte/reimpresion_mecanismo/xlss.php";
		document.getElementById("gra").target="_blank";
		document.getElementById("gra").submit();	
	}
}
//42
function limp(){
	ajax = new sack();
	ajax.requestFile = "modulos/reporte/reimpresion_mecanismo/reporte_list.php";
	ajax.onCompletion = mostrarContenido1;
	ajax.runAJAX();
} 
</script>