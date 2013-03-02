<?
//constantes
$mesconstantes=array("label"=>array(),"pin"=>array());

//dynamiques
$dyna_var=array(	"e_s_l"=>array(
									array("broche"=>array()),
									array("mode"=>array()),
									array("etat"=>array())
									),
					"pwm"=>array(	
									array("broche"=>array()),
									array("valeur"=>array()),
									),
					"e_a"=>array(	array("broche"=>array()),
									array("valeur"=>array())
									),
					"i2c"=>array(	array("adresse"=>array()),
									array("mode"=>array()),
									array("valeur"=>array()),
									),
					"spi"=>array()

					);

//pwm
for ($loop=2; $loop <10 ; $loop++)
	{
	$mesconstantes["label"][$loop]="-";
	$mesconstantes["pin"][$loop]="Pwm".$loop;
	$dyna_var["pwm"]["broche"][$loop]=$loop;
	$dyna_var["pwm"]["valeur"][$loop]=0;
	
	}
	
$mesconstantes["label"][10]="Rouge";
$mesconstantes["pin"][10]="Pwm10";	
$mesconstantes["label"][11]="Vert";
$mesconstantes["pin"][11]="Pwm11";	
$mesconstantes["label"][12]="Bleu";
$mesconstantes["pin"][12]="Pwm12";	
$dyna_var["pwm"]["broche"][10]=10;
$dyna_var["pwm"]["valeur"][10]=240;
$dyna_var["pwm"]["broche"][11]=11;
$dyna_var["pwm"]["valeur"][11]=120;
$dyna_var["pwm"]["broche"][12]=12;
$dyna_var["pwm"]["valeur"][12]=60;

for ($loop=22; $loop < 50; $loop++)
	{
	$mesconstantes["label"][$loop]="-";
	$mesconstantes["pin"][$loop]="".$loop;
	}
	
for ($loop=50; $loop < 66; $loop++)
	{
	$mesconstantes["label"][$loop]="-";
	$mesconstantes["pin"][$loop]="A".($loop - 50);
	}	

for ($loop=66; $loop < 86; $loop++)
	{
	$mesconstantes["label"][$loop]="-";
	}	
	
	$nom_fichier="constante_s.json";
	$events = json_encode($mesconstantes);
    $fichier=  fopen($nom_fichier,"w");
    fputs($fichier, $events);
    fclose($fichier);
    
    $nom_fichier="data_s.json";
	$events = json_encode($dyna_var);
    $fichier=  fopen($nom_fichier,"w");
    fputs($fichier, $events);
    fclose($fichier);
  echo 'terminé';  
?>