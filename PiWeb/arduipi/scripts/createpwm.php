<?php
$ensemble=array();
$jsonpwm=array();
$jsons_l=array();
for ($loop=2; $loop <13 ; $loop++)
    {
    $ensemble["pwm"][$loop]=0;
    }
 for ($loop=22; $loop <49 ; $loop++)
    {
    $ensemble["io_mode"][$loop]="OUT";
    $ensemble["io_etat"][$loop]=0;
    }
echo json_encode($ensemble, JSON_FORCE_OBJECT);
$nom_fichier="../includes/output.json";
$events = json_encode($ensemble, JSON_FORCE_OBJECT);
$fichier=  fopen($nom_fichier,"w");
fputs($fichier, $events);
fclose($fichier);
?>