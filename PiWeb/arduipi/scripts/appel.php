<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
//indique que le type de la reponse renvoyee au client sera du Texte
header("Content-Type: text/plain" );
//anti Cache pour HTTP/1.1
header("Cache-Control: no-cache , private");
//anti Cache pour HTTP/1.0
header("Pragma: no-cache");
//exec("sudo stty -F /dev/ttyACM0  115200");
$cmd_array["rasp_etat"][0]=1;
$io= json_decode(file_get_contents("../includes/output.json"),true);
$cmd_array["io_etat"]=$io["io_etat"];
$cmd_json= file_get_contents("../includes/output.json");
if ($handle = fopen("/dev/ttyAMA0", "wb"))
   {
   if ($cmd_json!="") fwrite($handle,$cmd_json."\n");
   fclose($handle);
  }
  else echo "nok";
?>
