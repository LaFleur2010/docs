<?php
//*********************************************************************************************************************************
	include('inc/config_db.php');
	require('inc/lib.db.php');
	
	$id 		= $_GET['vid'];
	$factura 	= $_GET['factura'];
	$origen		= "FACTURAS";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir facturas</title>
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>


<script type="text/javascript" LANGUAGE="JavaScript">

/* SUBIR ARCHIVOS*/
$(function()
{
	var id_det 		= $('#aux_id').val();
	var valor_u 	= $('#aux_usuario').val(); // Usuario
	var valor_o 	= $('#aux_origen').val(); // Origen de la llamada
	
	if(valor_o == "FACTURAS"){
		var ruta = "Facturas";
	}
	
	$('#swfupload-control').swfupload({
		
		upload_url: "upload-fileone.php?id="+ id_det+"&usuario="+ valor_u+"&origen="+ valor_o+"&id="+ id_det,
		file_post_name: 'uploadfile',
		file_size_limit : "3000",
		file_types : "*.*",
		file_types_description : "PDF",
		file_upload_limit : 1,
		flash_url : "js/swfupload/swfupload.swf",
		button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'Archivo: <em>'+file.name+'</em> ('+Math.round(file.size/5120)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Tamaño del archivo '+file.name+' es superior al limite');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Archivos seleccionados: '+numFilesSelected+' / Archivos en cola: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="'+ruta+'/'+id_det+'.pdf" target="_blank" >Ver archivo &raquo;</a>';
			item.addClass('success').find('p.status').html('| '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	
/* FIN SUBIR ARCHIVOS*/
</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #FFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#log {margin:0; padding:0; width:500px;}
-->

#swfupload-control p{ margin:10px 5px; font-size:0.9em; }
#log{ margin:0; padding:0; width:500px;}
#log li{ list-style-position:inside; margin:2px; border:1px solid #ccc; padding:10px; font-size:12px; 
	font-family:Arial, Helvetica, sans-serif; color:#333; background:#fff; position:relative;}
#log li .progressbar{ border:1px solid #333; height:5px; background:#fff; }
#log li .progress{ background: green; width:0%; height:5px; }
#log li p{ margin:0; line-height:18px; }
#log li.success{ border:1px solid #339933; background:#ccf9b9; }
#log li span.cancel{ position:absolute; top:5px; right:5px; width:20px; height:20px; 
	background:url('js/swfupload/cancel.png') no-repeat; cursor:pointer; }
</style>

</head>
<body>
<table width="507" height="180" border="0" align="center" class="txtnormal">
  <tr>
    <td width="501" height="178" align="center" valign="top">
    
    <form id="fi" name="fi" method="post" action="" style="display:inline;" >
      <table width="502" height="271" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
        <tr>
          <td width="498" height="269" align="center"><table width="499" height="252" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
            <tr>
              <td width="499" align="center" valign="top">
              <?php
				
				if($factura != ""){
					echo"La Factura ya Fue Subida:<br>";
					echo"<br /><img src='imagenes/pdf.png' width='60' height='60' style='border: solid 3px #FFFFFF' /><br /><br />";
				}else{
					echo "Seleccioneeeeee la factura que desea subir. El documento debe estar en formato PDF.<br/><br/>";
				}
              ?>
                
                
                <div id="swfupload-control">
                <?php
               /* if($_SESSION['usuario_tipo'] == "Bodega" or $_SESSION['usuario_tipo'] == "0"){*/
                  echo "<input type='button' id='button' />";
				/*}*/
                 ?> 
                  <p id="queuestatus" ></p>
                  <ol id="log">
                    <input type="hidden" name="aux" id="aux" value="<?php echo $id_det; ?>" size="2" />
                    <input type="hidden" name="aux_origen" id="aux_origen" value="<?php echo $origen; ?>" size="2" />
                    <input type="hidden" name="aux_id" id="aux_id" value="<?php echo $id; ?>" size="2" />
                    </ol>
                </div>                </td>
            </tr>
            </table></td>
        </tr>
      </table>
      <label></label>
    </form></td>
  </tr>
</table>
</body>
</html>
