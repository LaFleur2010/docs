<?php
header("Content-Type: application/x-msexcel; name=\"".$_GET['filename'].".xls\"");
header("Content-Disposition: inline; filename=\"".$_GET['filename']."\"");

$fname=$_GET['filename'];
/*echo("<script>alert('".$fname."');</script>");*/
$fh=fopen($fname,"rb");
fpassthru($fh);
unlink($fname);

?>
