<?php
	include ('inc/config_db.php');
	require('inc/lib.db.php');
	
	$ods		= $_GET['ods'];
	$usuario	= $_GET['usuario'];
	$origen		= $_GET['origen'];
	$fe			= date("Y-m-d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subir archivos multiple</title>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>

<script type="text/javascript">

$(function(){

	var valor_t = $('#aux').val();
	var valor_u = $('#aux_usuario').val(); // Usuario
	var valor_o = $('#aux_origen').val(); // Origen de la llamada
	
	if(valor_o == "PLANOS"){
		var ruta = "planos/IngresoPlanos/";
	}
	if(valor_o == "ODS"){
		var ruta = "Carpetas ODS/";
	}
	if(valor_o == "COT"){
		var ruta = "Licitaciones/Carpetas/";
	}
	
	$('#swfupload-control').swfupload({
		
		upload_url: "upload-file.php?ods="+ valor_t+"&usuario="+ valor_u+"&origen="+ valor_o,
		file_post_name: 'uploadfile',
		file_size_limit : "3000",
		file_types : "*.*",
		file_types_description : "PDF",
		file_upload_limit : 6,
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
			var pathtofile='<a href="'+ruta+''+valor_t+'/'+file.name+'" target="_blank" >Ver archivo &raquo;</a>';
			item.addClass('success').find('p.status').html('| '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	

</script>
<style type="text/css" >
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
<body onunload="parent.actualizar();">
<div id="swfupload-control">
	<p>Subir hasta 6 archivos en forma simultanea, el peso maximo es de 5 MB c/u</p>
    <input type="button" id="button" />
	
  <p id="queuestatus" ></p>
	<ol id="log">
	  <input name="aux" type="hidden" id="aux" value="<?php echo $ods; ?>" size="1" />
      <input name="aux_usuario" type="hidden" id="aux_usuario" value="<?php echo $usuario; ?>" size="1" />
	  <input name="aux_origen" type="hidden" id="aux_origen" value="<?php echo $origen; ?>" size="1" />
	</ol>
</div>

</body>
</html>