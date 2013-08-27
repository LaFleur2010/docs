<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 Softtime S.A.
    http://www.softtimesa.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');
$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>

<div id="landing_page">
    <h1>Bienvenidos a nuestro sistema de Soporte</h1>
    <p>
        Con el fin de agilizar las solicitudes de apoyo y un mejor servicio, utilizamos un sistema de ticket de soporte. A cada solicitud de ayuda se le asigna un numero &uacute;nico que se utilizara para rastrear el progreso y respuestas en l&iacute;nea. Se requiere una direcci&oacute;n de email valida para enviar un ticket.
    </p>

    <div id="new_ticket">
        <h3>Genere un nuevo Ticket</h3>
        <br>
        <div>Por favor, proporcione detalles de su requerimiento, esto nos ayudara a entender y entregar una mejor ayuda. Para actualizar un ticket presentado anteriormente, por favor entrar.</div>
        <p>
            <a href="open.php" class="green button">Generar nuevo Ticket</a>
        </p>
    </div>

    <div id="check_status">
        <h3>Revizar estado de Ticket</h3>
        <br>
        <div>Proporcionamos los archivos y la historia de todas sus solicitudes de soporte actuales y pasados de forma completa con las respuestas.</div>
        <p>
            <a href="view.php" class="blue button">Revizar estado de Ticket</a>
        </p>
    </div>
</div>
<div class="clear"></div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<p>Be sure to browse our <a href="kb/index.php">Frequently Asked Questions (FAQs)</a>, before opening a ticket.</p>
</div>
<?php
} ?>
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
