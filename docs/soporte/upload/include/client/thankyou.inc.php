<?php
if(!defined('OSTCLIENTINC') || !is_object($ticket)) die('Kwaheri rafiki!');
//Please customize the message below to fit your organization speak!
?>
<div style="margin:5px 100px 100px 0;">
    <?php echo Format::htmlchars($ticket->getName()); ?>,<br>
    <p>
     Gracias por contactarte con nosotros.<br>
     A sido creado el ticket de soporte, a la brevedad se comunicaran con usted.</p>
          
    <?php if($cfg->autoRespONNewTicket()){ ?>
    <p>Un correo electrónico con el número de ticket se ha enviado al <b><?php echo $ticket->getEmail(); ?></b>.
        Usted necesitará el número de ticket junto con su correo electrónico para ver el estado y el progreso en línea. 
    </p>
    <p>
     Si desea enviar comentarios o información sobre la misma cuestión adicional, por favor, siga las instrucciones que aparecen en el correo electrónico.
    </p>
    <?php } ?>
    <p>Equipo de Soporte Softtime.</p>
</div>
