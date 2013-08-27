/***************************************************************************************************************************
											FUNCIONES JAVASCRIPT
****************************************************************************************************************************										
Version	=	1.0
Autor	=	Pedro Troncoso M. / Google
Fecha	=	Desde 04/12/2008
/**************************************************************************************************************************/

/**************************************************************************************************************************
	FUNCION PARA CONFIRM - Parametros (Mensaje a mostrar,  destino a direccionar, nombre del formulario)
***************************************************************************************************************************/
function confirmar(msj, dest, form)
{
	var agree=confirm(msj);
	if (agree){
		document.form.action = dest;
		return true ;
	}else{
		return false ;
	}
}
/************************************************************************************************************************
					FUNCION PARA CAMBIAR COLOR DE FONDO
*************************************************************************************************************************/
function CambiaColor(esto,fondo,texto)
{
    esto.style.background	= fondo;
    esto.style.color		= texto;
	esto.style.cursor		= 'hand';
}

/************************************************************************************************************************
					FUNCION PARA VALIDAR CAMPO DE EMAIL (CORREO)
*************************************************************************************************************************/
function isEmailAddress(theElement, nombre_del_elemento )
{
	var s = theElement.value;
	var filter=/^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9_]+\.[A-Za-z0-9_.]+[A-za-z]$/;
	if (s.length == 0 ) return true;
	if (filter.test(s))
	return true;
else
	alert("Ingrese una direccion de correo valida");
	theElement.focus();
	return false;
}

/************************************************************************************************************************
					FUNCION PARA ABRIR UN POPUT CENTRADO INDEPENDIENTE DE LA RESOLUCION Y EL NAVEGADOR
*************************************************************************************************************************
** Parametros **
pagina	= ruta de la pagina que vamos a abrir
ancho	= ancho del poput
alto	= alto del poput
rez		= (yes,no) si el popup se podra maximizar
************************************************************************************************************************/
function abrirVentanac(pagina, ancho, alto,rez,scr) {
	
    var iz 	= (screen.width - ancho)/2;
    var de 	= (screen.height - alto)/2;
 
    var opciones= "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars="+scr+", resizable="+rez+", width="+ancho+", height="+alto+", top="+de+", left="+iz+"";
    window.open(pagina,"",opciones);
}

/************************************************************************************************************************
					FUNCION PARA ABRIR UN POPUT MAXIMIZADO
*************************************************************************************************************************
** Parametros **
pagina	= ruta de la pagina que vamos a abrir
rez		= (yes,no) si el popup se podra maximizar

************************************************************************************************************************/
function abrirVentanaM(pagina, rez) {
	
    var iz 	= (screen.width);
    var de 	= (screen.height);
 
    var opciones= "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable="+rez+", width="+iz+", height="+de+"";
    window.open(pagina,"",opciones);
}

/**********************************************************************************************************************
		FUNCION PARA VALIDAR LA CANTIDAD DE CARACTERES PERMITIDOS EN UNA CAJA DE TEXTO
***********************************************************************************************************************
** parametro **
t		= trae la caja de texto
c		= cantidad de caracteres permitidos
**********************************************************************************************************************/
function verificar(t,c)
{
	var aux		= t.value;
	var largo	= (aux.length);
	if(largo == c)
	{
		alert("Ha  completado el maximo de caracteres permitidos");
	}
}

/**********************************************************************************************************************
		FUNCION PARA VALIDAR RUT CHILENO
***********************************************************************************************************************
** Parametros **
Objeto		= Trae  el valor de la caja de texto
Autor		= Giovanny TarifeÒo - www.teayudo.cl
*********************************************************************************************************************/
function Valida_Rut( Objeto ){
var tmpstr = "";
var intlargo = Objeto.value
 if (intlargo.length > 0){ 	
    
    	crut = Objeto.value 
    	largo = crut.length;
    
    if ( largo < 2 )
    {
        alert('Rut Invalido')
		Objeto.value="";
        Objeto.focus()
        return false;
    }
    for ( i=0; i < crut.length ; i++ )
                if ( crut.charAt(i) != ' ' && crut.charAt(i) != '.' && crut.charAt(i) != '-' )
                {
                tmpstr = tmpstr + crut.charAt(i);
                }
            rut = tmpstr;
    crut=tmpstr;
    largo = crut.length;

    if ( largo > 2 )
        rut = crut.substring(0, largo - 1);
    else
        rut = crut.charAt(0);

    dv = crut.charAt(largo-1);

    if ( rut == null || dv == null )
            return 0;

    var dvr = '0';
    suma = 0;
    mul  = 2;

    for (i= rut.length-1 ; i >= 0; i--)
    {
        suma = suma + rut.charAt(i) * mul;
        if (mul == 7)
            mul = 2;
        else
            mul++;
    }

    res = suma % 11;
    if (res==1)
        dvr = 'k';
    else if (res==0)
        dvr = '0';
    else
    {
        dvi = 11-res;
        dvr = dvi + "";
    }


    if ( dvr != dv.toLowerCase() )
    {
	alert('El Rut Ingresado es Invalido')
	Objeto.value="";
	Objeto.focus();
    return false;
    }
    return true;
  }   
}

/*******************************************************************************************************************************************************************************************
					DESDE AQUI FUNCIONES PARA AGREGAR DIAS A UNA FECHA
*******************************************************************************************************************************************************************************************/
var aFinMes = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 

  function finMes(nMes, nAno){ 
   return aFinMes[nMes - 1] + (((nMes == 2) && (nAno % 4) == 0)? 1: 0); 
  } 

   function padNmb(nStr, nLen, sChr){ 
    var sRes = String(nStr); 
    for (var i = 0; i < nLen - String(nStr).length; i++) 
     sRes = sChr + sRes; 
    return sRes; 
   } 

   function makeDateFormat(nDay, nMonth, nYear){ 
    var sRes; 
    sRes = padNmb(nDay, 2, "0") + "/" + padNmb(nMonth, 2, "0") + "/" + padNmb(nYear, 4, "0"); 
    return sRes; 
   } 
    
  function incDate(sFec0){ 
   var nDia = parseInt(sFec0.substr(0, 2), 10); 
   var nMes = parseInt(sFec0.substr(3, 2), 10); 
   var nAno = parseInt(sFec0.substr(6, 4), 10); 
   nDia += 1; 
   if (nDia > finMes(nMes, nAno)){ 
    nDia = 1; 
    nMes += 1; 
    if (nMes == 13){ 
     nMes = 1; 
     nAno += 1; 
    } 
   } 
   return makeDateFormat(nDia, nMes, nAno); 
  } 

  function decDate(sFec0){ 
   var nDia = Number(sFec0.substr(0, 2)); 
   var nMes = Number(sFec0.substr(3, 2)); 
   var nAno = Number(sFec0.substr(6, 4)); 
   nDia -= 1; 
   if (nDia == 0){ 
    nMes -= 1; 
    if (nMes == 0){ 
     nMes = 12; 
     nAno -= 1; 
    } 
    nDia = finMes(nMes, nAno); 
   } 
   return makeDateFormat(nDia, nMes, nAno); 
  } 

  function addToDate(sFec0, sInc){ 
   var nInc = Math.abs(parseInt(sInc)); 
   var sRes = sFec0; 
   if (parseInt(sInc) >= 0) 
    for (var i = 0; i < nInc; i++) sRes = incDate(sRes); 
   else 
    for (var i = 0; i < nInc; i++) sRes = decDate(sRes); 
   return sRes; 
  } 

  function recalcF1(){ 
  	
	var fe3 = document.f.f3.value;
	var fe4 = document.f.f4.value;
	if(fe4=="")
	{ 
		var fecha = fe3;
	}else{
		var fecha = fe4;
	}
		
  
   with (document.f){ 
    f5.value = addToDate(fecha, t2.value); 
   } 
  }
  
/****************************************************************************************************************************************************************************************
				CALCULA ENTRE FECHAS : D M A - D M - D - S D
****************************************************************************************************************************************************************************************/
function cerosIzq(sVal, nPos){
    var sRes = sVal;
    for (var i = sVal.length; i < nPos; i++)
     sRes = "0" + sRes;
    return sRes;
   }

   function armaFecha(nDia, nMes, nAno){
    var sRes = cerosIzq(String(nDia), 2);
    sRes = sRes + "/" + cerosIzq(String(nMes), 2);
    sRes = sRes + "/" + cerosIzq(String(nAno), 4);
    return sRes;
   }

   function sumaMes(nDia, nMes, nAno, nSum){
    if (nSum >= 0){
     for (var i = 0; i < Math.abs(nSum); i++){
      if (nMes == 12){
       nMes = 1;
       nAno += 1;
      } else nMes += 1;
     }
    } else {
     for (var i = 0; i < Math.abs(nSum); i++){
      if (nMes == 1){
       nMes = 12;
       nAno -= 1;
      } else nMes -= 1;
     }
    }
    return armaFecha(nDia, nMes, nAno);
   }

   function esBisiesto(nAno){
    var bRes = true;
    res = bRes && (nAno % 4 == 0);
    res = bRes && (nAno % 100 != 0);
    res = bRes || (nAno % 400 == 0);
    return bRes;
   }

   function finMes(nMes, nAno){
    var nRes = 0;
    switch (nMes){
     case 1: nRes = 31; break;
     case 2: nRes = 28; break;
     case 3: nRes = 31; break;
     case 4: nRes = 30; break;
     case 5: nRes = 31; break;
     case 6: nRes = 30; break;
     case 7: nRes = 31; break;
     case 8: nRes = 31; break;
     case 9: nRes = 30; break;
     case 10: nRes = 31; break;
     case 11: nRes = 30; break;
     case 12: nRes = 31; break;
    }
    return nRes + (((nMes == 2) && esBisiesto(nAno))? 1: 0);
   }

   function diasDelAno(nAno){
    var nRes = 365;
    if (esBisiesto(nAno)) nRes++;
    return nRes;
   }

   function anosEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes = Math.max(0, nAn1 - nAn0 - 1);
	    if (nAn1 != nAn0)
	     if ((nMe1 > nMe0) || ((nMe1 == nMe0) && (nDi1 >= nDi0)))
	      nRes++;
	    return nRes;
   }

   function mesesEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes;
	    if ((nMe1 < nMe0) || ((nMe1 == nMe0) && (nDi1 < nDi0))) nMe1 += 12;
	    nRes = Math.max(0, nMe1 - nMe0 - 1);
	    if ((nDi1 > nDi0) && (nMe1 != nMe0)) nRes++;
	    return nRes;
   }

   function diasEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes;
	    if (nDi1 < nDi0) nDi1 += finMes(nMe0, nAn0);
	    nRes = Math.max(0, nDi1 - nDi0);
	    return nRes;
   }

   function mayorOIgual(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var bRes = false;
	    bRes = bRes || (nAn1 > nAn0);
	    bRes = bRes || ((nAn1 == nAn0) && (nMe1 > nMe0));
	    bRes = bRes || ((nAn1 == nAn0) && (nMe1 == nMe0) && (nDi1 >= nDi0));
	    return bRes;
   }

   function calcula()
   {
	    var sFc0 = document.frm.fecha0.value; // Se asume v·lida
	    var sFc1 = document.frm.fecha1.value; // Se asume v·lida
	    var nDi0 = parseInt(sFc0.substr(0, 2), 10);
	    var nMe0 = parseInt(sFc0.substr(3, 2), 10);
	    var nAn0 = parseInt(sFc0.substr(6, 4), 10);
	    var nDi1 = parseInt(sFc1.substr(0, 2), 10);
	    var nMe1 = parseInt(sFc1.substr(3, 2), 10);
	    var nAn1 = parseInt(sFc1.substr(6, 4), 10);
	    if (mayorOIgual(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1))
		{
		     var nAno = anosEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nMes = mesesEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nDia = diasEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nTtM = nAno * 12 + nMes;
		     var nTtD = nDia;
		     for (var i = nAn0; i < nAn0 + nAno; i++) nTtD += diasDelAno(nAno);
		     for (var j = nMe0; j < nMe0 + nMes; j++) nTtD += finMes(j, nAn1);
		     var nTSS = Math.floor(nTtD / 7);
		     var nTSD = nTtD % 7;
		     document.f.difDMA.value = String(nAno) + " aÒos, " + String(nMes) + " meses, " + String(nDia) + " dÌas";
		     document.f.difDM.value = String(nTtM) + " meses, " + String(nDia) + " dÌas";
		     document.f.difD.value = String(nTtD) + " dÌas";
		     document.f.difSD.value = String(nTSS) + " semanas, " + String(nTSD) + " dÌas";
	    } else alert("Error en rango");
   }
/**********************************************************************************************************************************************************************************************

**********************************************************************************************************************************************************************************************/
/***************************************************
Formatea fecha dd/mm/aaaa

esta es la forma para ejecutar la funcion de formateo de fecha
<input name="fecha" type="text" size="10" maxlength="10" onKeyUp = "this.value=formateafecha(this.value);"> 

*/
function IsNumeric(valor) 
{ 
var log=valor.length; 
var sw="S"; 

for (x=0; x<log; x++) 
{ 
	v1=valor.substr(x,1); 
	v2 = parseInt(v1); 
	//Compruebo si es un valor numÈrico 
	if (isNaN(v2)) { sw= "N";} 
} 
if (sw=="S") {return true;} else {return false; } 
} 

var primerslap=false; 
var segundoslap=false; 

function formateafecha(fecha) 
{ 
var long = fecha.length; 
var dia; 
var mes; 
var ano; 

if ((long>=2) && (primerslap==false)) { dia=fecha.substr(0,2); 
if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslap=true; } 
else { fecha=""; primerslap=false;} 
} 
else 
{ dia=fecha.substr(0,1); 
if (IsNumeric(dia)==false) 
{fecha="";} 
if ((long<=2) && (primerslap=true)) {fecha=fecha.substr(0,1); primerslap=false; } 
} 
if ((long>=5) && (segundoslap==false)) 
{ mes=fecha.substr(3,2); 
if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslap=true; } 
else { fecha=fecha.substr(0,3);; segundoslap=false;} 
} 
else { if ((long<=5) && (segundoslap=true)) { fecha=fecha.substr(0,4); segundoslap=false; } } 
if (long>=7) 
{ ano=fecha.substr(6,4); 
if (IsNumeric(ano)==false) { fecha=fecha.substr(0,6); } 
else { if (long==10){ if ((ano==0) || (ano<1900) || (ano>2100)) { fecha=fecha.substr(0,6); } } } 
} 

if (long>=10) 
{ 
fecha=fecha.substr(0,10); 
dia=fecha.substr(0,2); 
mes=fecha.substr(3,2); 
ano=fecha.substr(6,4); 
// AÒo no viciesto y es febrero y el dia es mayor a 28 
if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; } 
} 
return (fecha); 
} 
/*******************************************************************/


/*----------------------------------------------------------------------------------------------------------------------------------
FUNCION PARA FORMATEAR CENTRO DE COSTO
-----------------------------------------------------------------------------------------------------------------------------------*/
var primerslap  = false; 
var segundoslap = false; 

function formateaccosto(ccosto) 
{ 
	var long = ccosto.length; 
	var dia; 
	var mes; 
	var ano; 

	if ((long>=2) && (primerslap==false)) 
	{ 
		dia = ccosto.substr(0,2); 
		if ((IsNumeric(dia)==true) && (dia<=99) && (dia!="00")) 
		{ 
			ccosto=ccosto.substr(0,2)+"-"+ccosto.substr(3,7); primerslap=true; 
		} else { 
			ccosto=""; primerslap=false;
		} 
	} else { 
		dia = ccosto.substr(0,1); 
		if (IsNumeric(dia)==false) 
		{
			ccosto="";
		} 
		if ((long<=2) && (primerslap=true)) 
		{
			ccosto=ccosto.substr(0,1); primerslap=false; 
		} 
	} 
		
	if ((long>=5) && (segundoslap==false)) 
	{ 
		mes=ccosto.substr(3,2); 
		if ((IsNumeric(mes)==true) &&(mes<=99) && (mes!="00")) 
		{ 
			ccosto=ccosto.substr(0,5)+"-"+ccosto.substr(6,4); segundoslap=true; 
		} else { 
			ccosto=ccosto.substr(0,3);; 
			segundoslap=false;
		} 
	} else { 
		if ((long<=5) && (segundoslap=true)) 
		{ 
			ccosto=ccosto.substr(0,4); segundoslap=false; 
		} 
	} 
	if (long>=7)
	{ 
		ano = ccosto.substr(6,2); 
		if (IsNumeric(ano)==false) 
		{
			/*ano2 = ano.substr(0,2); // primeros dos digitos de ano
			
			if (IsNumeric(ano)==false)
			{
			}else{*/
			ccosto=ccosto.substr(0,6); 
	
		} else { 
			if (long==8)
			{ //alert("Llegamos a 8");
				if ((ano<0) || (ano>99)) 
				{ 
					ccosto=ccosto.substr(0,6); 
				} 
			} 
		} 
	} 

	if (long>=8) 
	{ 
		ccosto	= ccosto.substr(0,8); 
		dia		= ccosto.substr(0,2); 
		mes		= ccosto.substr(3,2); 
		ano		= ccosto.substr(6,2); 
	// AÒo no viciesto y es febrero y el dia es mayor a 28 
		/*if ( (ano%4 != 0) && (mes == 02) && (dia > 28) ) 
		{ 
			ccosto=ccosto.substr(0,2)+"-"; 
		} */
	}
	return (ccosto); 
} 
/*******************************************************************/


/*----------------------------------------------------------------------------------------------------------------------------------


-----------------------------------------------------------------------------------------------------------------------------------*/

function validastring(field){
	if (field.value==""){return false;}
	var valid = "·ÈÌÛ˙¡…Õ”⁄‡ËÏÚ˘¿»Ã“Ÿ0123456789abcdefghijklmnÒopqrstuvwxyzABCDEFGHIJKLMN—OPQRSTUVWXYZ°!ø?=()/\&%$∑#@|{}[]*;:.-_∫™^,' "
	var ok = "yes";
	var temp;
	for (var i=0; i<field.value.length; i++) {
	temp = "" + field.value.substring(i, i+1);
	if (valid.indexOf(temp) == "-1") ok = "no";
	}
	if (ok == "no") {
	alert("Entrada de dato no valida! Ha escrito caracteres no validos en esta entrada de datos!");
	field.value="";field.focus();field.select();
	   }else{
	   if (field.value=="")field.value=""
	   }
} 

 function valida(field){
 	if(field.rut.value=="" || field.dv.value=="" || field.fec_nac.value==""){
		alert("Por favor ingrese los datos solicitados");
	}else{
		if(field.fec_nac.value.length<10){ 
			alert("Campo fecha de nacimiento incompleto, por favor verifique\n\n Recuerde el formato: dd mm aaaa");
			field.fec_nac.value="";
		}else{
			field.action="main.php?cod=1";
			field.submit();
		}
	}
 }
 
function limpiar(field){
		field.action="main.php";
		field.submit();
 	
 }
 

function lugar_pago(field){
	if(field.lp_region.value!="#"){
		dir="lugar_pago.php?reg="+field.lp_region.value;
		new_window(dir);
	}else{
		alert("Por favor, seleccione una regiÛn");
	}
	
}