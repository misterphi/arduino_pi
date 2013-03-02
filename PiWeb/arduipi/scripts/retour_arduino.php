<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
//indique que le type de la reponse renvoyee au client sera du Texte
header("Content-Type: text/plain" );
//anti Cache pour HTTP/1.1
header("Cache-Control: no-cache , private");
//anti Cache pour HTTP/1.0
header("Pragma: no-cache");
    if ($handle = @fopen("/dev/ttyAMA0", "r+b"))	{
        stream_set_timeout($handle, 3);
       stream_set_blocking ( $handle, 1);
       $data = stream_get_line($handle, 1024, "#");
        echo $data;
        fclose($handle);
    } //else echo "pb";
            ?>
