<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
//indique que le type de la reponse renvoyee au client sera du Texte
header("Content-Type: text/plain" );
//anti Cache pour HTTP/1.1
header("Cache-Control: no-cache , private");
//anti Cache pour HTTP/1.0
header("Pragma: no-cache");

if ($_POST['action']=="modif_label" )
                {
                $filename = "../includes/constante_s.json";
                $mesconstantes=  json_decode(file_get_contents($filename),true);
                $mesconstantes["label"][$_POST['num_label']]=$_POST['val_label'];
                $datas= json_encode($mesconstantes, JSON_FORCE_OBJECT);
                if (file_put_contents($filename,  $datas)) echo 'OK';
                exit;
                }
if ($_POST['action']=="modif_slide" )
                {
                $filename = "../includes/output.json";
                $mesvar=  json_decode(file_get_contents($filename),true);
                $mesvar["pwm"][$_POST['num_slide']]= ($_POST['num_slide']<10) ? (int) $_POST['val_slide'] : 255-(int) $_POST['val_slide'] ;
                $mavar["pwm"][$_POST['num_slide']]=($_POST['num_slide']<10) ? (int) $_POST['val_slide'] : 255-(int) $_POST['val_slide'] ;
                $datas= json_encode($mesvar, JSON_FORCE_OBJECT);
                $data_modif=json_encode($mavar, JSON_FORCE_OBJECT);
                if (file_put_contents($filename,  $datas)){
                //echo $datas.'<br />';
                if ($handle = fopen("/dev/ttyAMA0", "w+b"))	// we just read data
                    {
                     fwrite($handle,$data_modif."\n\n");
                    fclose($handle);
                    }

                }
                echo "OK";
                exit;
                }

if ($_POST['action']=="modif_io" ) {
                //num_io : qui, mode_io : quoi, state_io :combien
                $filename = "../includes/output.json";
                $mesvar=  json_decode(file_get_contents($filename),true);
                $mesvar["io_".$_POST['mode_io']][$_POST['num_io']]= (($_POST['mode_io']=="etat") ? (int) $_POST['state_io'] : $_POST['state_io']);
                $mavar["io_".$_POST['mode_io']][$_POST['num_io']]=  (($_POST['mode_io']=="etat") ? (int) $_POST['state_io'] : $_POST['state_io']);
                $datas= json_encode($mesvar, JSON_FORCE_OBJECT);
                $data_modif=json_encode($mavar, JSON_FORCE_OBJECT);
                if (file_put_contents($filename,  $datas))  echo "OK";
               exit;
}
?>