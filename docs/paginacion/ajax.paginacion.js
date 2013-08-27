function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function Pagina(nropagina){
	//donde se mostrará los registros
	divContenido 	= document.getElementById('contenido');
	c_p_sol 		= document.formu.c_p_sol.value;
	c_est	 		= document.formu.c_est.value;
	c_ods	 		= document.formu.c_ods.value;
	c_cc	 		= document.formu.c_cc.value;
	c_areas	 		= document.formu.c_areas.value;
	c_f_sol	 		= document.formu.c_f_sol.value;
	
	ajax=objetoAjax();
	//uso del medoto GET
	//indicamos el archivo que realizará el proceso de paginar
	//junto con un valor que representa el nro de pagina
	ajax.open("POST", "paginador.php");
	divContenido.innerHTML= '<img src="cargando.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divContenido.innerHTML = ajax.responseText
		}
	}
	//como hacemos uso del metodo GET
	//colocamos null ya que enviamos 
	//el valor por la url ?pag=nropagina
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("pag="+nropagina+"&c_p_sol="+c_p_sol+"&c_est="+c_est+"&c_ods="+c_ods+"&c_cc="+c_cc+"&c_areas="+c_areas+"&c_f_sol="+c_f_sol)
}