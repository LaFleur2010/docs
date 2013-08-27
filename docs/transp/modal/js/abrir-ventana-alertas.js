function alerta(mensaje, titulo) {
	var alto = '230';
	var ancho = '550';
	var icono = 'icono.gif';
	VentanaModal.inicializar();
	VentanaModal.setSize(ancho, alto);
	VentanaModal.setClaseVentana("");
	VentanaModal.setIdVentana("ventana-modal-ventana");
	
	var src = 'modal/img/alerta/';
	var styleTitulo = 'font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000;';
	var styleMensaje = 'font-family: \'Trebuchet MS\', Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #000000; height: ' + (alto - 150) + 'px; vertical-align: top; text-align: left;';
	
	if (titulo == null || titulo == '')  
		titulo = '&nbsp;';
		
	if (mensaje == null || mensaje == '')  
		mensaje = '&nbsp;';
	else {
		while (mensaje.indexOf("\n") != -1)
			mensaje = mensaje.replace("\n", "<br>");
	}
		
	var html = ''
	+ '<table border="0" cellspacing="0" cellpadding="0">'
	+ '<tr> '
	+ '<td style="' + bgImg(src + "superior-izquierda.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior.png") + ' height: 35px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior-derecha.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr>'
	+ '<td style="' + bgImg(src + "izquierda.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="background-color: #ffffff;"><table width="100%" border="0" cellspacing="5" cellpadding="0">'
	+ '<tr><td style="width: 70px; height: 70px;"><img src="' + src + icono + '" alt="Alerta"></td>'
	+ '<td style="' + styleTitulo + '">' + titulo + '</td></tr>'
	+ '<tr><td>&nbsp;</td>'
	+ '<td style="' + styleMensaje + '">' + mensaje + '</td></tr>'
	+ '<tr><td colspan="2" align="center">'
	+ '<img src="' + src + 'aceptar.gif" alt="Aceptar" title="Aceptar" style="cursor: pointer;" onclick="VentanaModal.cerrar()">'
	+ '</td></tr></table>'
	+ '</td><td style="' + bgImg(src + "derecha.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr><td style="' + bgImg(src + "inferior-izquierda.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior.png") + ' height: 65px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior-derecha.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '</tr></table>';
	
	VentanaModal.setContenido(html);
	VentanaModal.mostrar();
}


function info(mensaje, titulo) {
	var alto = '230';
	var ancho = '550';
	var icono = 'icono.gif';
	VentanaModal.inicializar();
	VentanaModal.setSize(ancho, alto);
	VentanaModal.setClaseVentana("");
	VentanaModal.setIdVentana("ventana-modal-ventana");
	
	var src = 'modal/img/info/';
	var styleTitulo = 'font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000;';
	var styleMensaje = 'font-family: \'Trebuchet MS\', Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #000000; height: ' + (alto - 150) + 'px; vertical-align: top; text-align: left;';
	
	if (titulo == null || titulo == '')  
		titulo = '&nbsp;';

	if (mensaje == null || mensaje == '')  
		mensaje = '&nbsp;';
	else {
		while (mensaje.indexOf("\n") != -1)
			mensaje = mensaje.replace("\n", "<br>");
	}
		
	var html = ''
	+ '<table border="0" cellspacing="0" cellpadding="0">'
	+ '<tr> '
	+ '<td style="' + bgImg(src + "superior-izquierda.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior.png") + ' height: 35px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior-derecha.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr>'
	+ '<td style="' + bgImg(src + "izquierda.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="background-color: #ffffff;"><table width="100%" border="0" cellspacing="5" cellpadding="0">'
	+ '<tr><td style="width: 70px; height: 70px;"><img src="' + src + icono + '" alt="Info"></td>'
	+ '<td style="' + styleTitulo + '">' + titulo + '</td></tr>'
	+ '<tr><td>&nbsp;</td>'
	+ '<td style="' + styleMensaje + '">' + mensaje + '</td></tr>'
	+ '<tr><td colspan="2" align="center">'
	+ '<img src="' + src + 'aceptar.gif" alt="Aceptar" title="Aceptar" style="cursor: pointer;" onclick="VentanaModal.cerrar()">'
	+ '</td></tr></table>'
	+ '</td><td style="' + bgImg(src + "derecha.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr><td style="' + bgImg(src + "inferior-izquierda.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior.png") + ' height: 65px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior-derecha.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '</tr></table>';
	
	VentanaModal.setContenido(html);
	VentanaModal.mostrar();
}


function confirmar(mensaje, titulo, accionTrue, accionFalse) {
	var alto = '230';
	var ancho = '550';
	var icono = 'icono.gif';
	VentanaModal.inicializar();
	VentanaModal.setSize(ancho, alto);
	VentanaModal.setClaseVentana("");
	VentanaModal.setIdVentana("ventana-modal-ventana");
	
	var src = 'modal/img/confirmar/';
	var styleTitulo = 'font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000;';
	var styleMensaje = 'font-family: \'Trebuchet MS\', Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #000000; height: ' + (alto - 150) + 'px; vertical-align: top; text-align: left;';
	
	if (titulo == null || titulo == '')  
		titulo = '&nbsp;';
	
	if (mensaje == null || mensaje == '')  
		mensaje = '&nbsp;';
	else {
		while (mensaje.indexOf("\n") != -1)
			mensaje = mensaje.replace("\n", "<br>");
	}
		
	var html = ''
	+ '<table border="0" cellspacing="0" cellpadding="0">'
	+ '<tr> '
	+ '<td style="' + bgImg(src + "superior-izquierda.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior.png") + ' height: 35px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior-derecha.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr>'
	+ '<td style="' + bgImg(src + "izquierda.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="background-color: #ffffff;"><table width="100%" border="0" cellspacing="5" cellpadding="0">'
	+ '<tr><td style="width: 70px; height: 70px;"><img src="' + src + icono + '" alt="Info"></td>'
	+ '<td style="' + styleTitulo + '">' + titulo + '</td></tr>'
	+ '<tr><td>&nbsp;</td>'
	+ '<td style="' + styleMensaje + '">' + mensaje + '</td></tr>'
	+ '<tr><td colspan="2" align="center">'
	+ '<img src="' + src + 'si.gif" alt="S&iacute;" title="S&iacute;" style="cursor: pointer;" onclick="VentanaModal.cerrar();' + accionTrue + '">'
	+ '<span style="cursor: default;">&nbsp;&nbsp;&nbsp;</span>'
	+ '<img src="' + src + 'no.gif" alt="No" title="No" style="cursor: pointer;" onclick="VentanaModal.cerrar();' + accionFalse + '">'
	+ '</td></tr></table>'
	+ '</td><td style="' + bgImg(src + "derecha.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr><td style="' + bgImg(src + "inferior-izquierda.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior.png") + ' height: 65px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior-derecha.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '</tr></table>';
	
	VentanaModal.setContenido(html);
	VentanaModal.mostrar();
}



function error(mensaje, titulo) {
	var alto = '230';
	var ancho = '550';
	var icono = 'icono.gif';
	VentanaModal.inicializar();
	VentanaModal.setSize(ancho, alto);
	VentanaModal.setClaseVentana("");
	VentanaModal.setIdVentana("ventana-modal-ventana");
	
	var src = 'modal/img/error/';
	var styleTitulo = 'font-family: Arial, Verdana, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000;';
	var styleMensaje = 'font-family: \'Trebuchet MS\', Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color: #000000; height: ' + (alto - 150) + 'px; vertical-align: top; text-align: left;';
	
	if (titulo == null || titulo == '')  
		titulo = '&nbsp;';
		
	if (mensaje == null || mensaje == '')  
		mensaje = '&nbsp;';
	else {
		while (mensaje.indexOf("\n") != -1)
			mensaje = mensaje.replace("\n", "<br>");
	}
		
	var html = ''
	+ '<table border="0" cellspacing="0" cellpadding="0">'
	+ '<tr> '
	+ '<td style="' + bgImg(src + "superior-izquierda.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior.png") + ' height: 35px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "superior-derecha.png") + ' width: 40px; height: 35px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr>'
	+ '<td style="' + bgImg(src + "izquierda.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="background-color: #ffffff;"><table width="100%" border="0" cellspacing="5" cellpadding="0">'
	+ '<tr><td style="width: 70px; height: 70px;"><img src="' + src + icono + '" alt="Error"></td>'
	+ '<td style="' + styleTitulo + '">' + titulo + '</td></tr>'
	+ '<tr><td>&nbsp;</td>'
	+ '<td style="' + styleMensaje + '">' + mensaje + '</td></tr>'
	+ '<tr><td colspan="2" align="center">'
	+ '<img src="' + src + 'aceptar.gif" alt="Aceptar" title="Aceptar" style="cursor: pointer;" onclick="VentanaModal.cerrar()">'
	+ '</td></tr></table>'
	+ '</td><td style="' + bgImg(src + "derecha.png") + ' width: 40px; height: ' + (alto - 100) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '</tr><tr><td style="' + bgImg(src + "inferior-izquierda.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior.png") + ' height: 65px; width: ' + (ancho - 80) + 'px; font-size: 8px;">&nbsp;</td>'
	+ '<td style="' + bgImg(src + "inferior-derecha.png") + ' width: 40px; height: 65px; font-size: 8px;">&nbsp;</td>'
	+ '</tr></table>';
	
	VentanaModal.setContenido(html);
	VentanaModal.mostrar();
}

function bgImg(imgSrc) {
	if (VentanaModal.MSIE) 
		return " filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=scale, src='" + imgSrc + "'); ";
	else
		return " background-image: url(" + imgSrc + "); ";
}