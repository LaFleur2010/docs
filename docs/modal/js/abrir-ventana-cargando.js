function cargando() {
	var src = 'modal/img/ventana-modal-cargando/cargando.gif';
	VentanaModal.inicializar();
	VentanaModal.setSize(180, 180);
	VentanaModal.setClaseVentana("");
	VentanaModal.setIdVentana("ventana-modal-ventana");
	
	var html = '<img src="' + src + '" alt="Cargando..." title="Cargando...">';
	
	VentanaModal.setContenido(html);
	VentanaModal.mostrar();
	setTimeout("VentanaModal.cerrar()", 3000);
}