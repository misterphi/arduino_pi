<?php
for ($loop=0; $loop <16 ; $loop++)
    {
    $ensemble["a_i"][$loop]=0;
    }
echo json_encode($ensemble);
$nom_fichier="../includes/input.json";
$events = json_encode($ensemble);
$fichier=  fopen($nom_fichier,"w");
fputs($fichier, $events);
fclose($fichier);
?>
