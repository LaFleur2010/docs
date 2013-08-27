function ingreso(){

	if (confirm('¿Desea Ingresar esta encuesta?')) {
		return true;
		$("#encuesta").attr("action","ingreso.php");
		$("#encuesta").submit();
	}else{
		return false;
	}
}

function cerrar(){
	if(confirm('¿Desea cerrar Sesion?')){
		return true;
		$("#menu").attr("action","cerrar.php");
		$("#menu").submit();
	}else{
		return false;
	}
}