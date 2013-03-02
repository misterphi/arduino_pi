<!doctype html>

<html lang=fr">
<head>
    <meta charset="utf-8" />
    <title>Contrôle Arduino</title>
    <link rel="stylesheet" href="../../jquery-ui-themes/redmond/jquery-ui.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <script src="../../jquery/jquery.js"></script>
    <script src="../../jquery-ui/jquery-ui.js"></script>
    <script src="./js/arduino.js"></script>
    <script>
        function requete() {
      $.ajax({    url : "./scripts/appel.php" });
       setTimeout("requete()",500);
   }

   function retour() {
   $.ajax({
                url : "./scripts/retour_arduino.php",
                success :function(data)
                    {
                   if ( data.charAt(0)=="{") {
                  //entrées analogiques
                  var  valeurs=$.parseJSON(data);
                  var n=0;
                  $("#ea").find("td.i_a").each(function() {
                  $(this).html((($("#coef_a_i" + (n + 50)).val())*valeurs.a_i[n]).toPrecision(5));
                  n++;
                  });
                  //entrées logiques
                  n=0;
                  $("[id$='v']").each(function() {
                     id_courant=$(this).attr('id');
                    if (valeurs.l_i[n] != -1) $( this ).button( "option", "label", valeurs.l_i[n] );
                    if (valeurs.l_i[n] == 1) $('label[for="'+ id_courant+'"]').addClass("ui-state-active");
                    else if (valeurs.l_i[n] ==0)  $('label[for="'+ id_courant+'"]').removeClass("ui-state-active");
                  n++;
                    });

                    }
                    }
                });
       setTimeout("retour()",500);
    }
    setTimeout("requete()",500);
   setTimeout("retour()",750);
    </script>
    </head>
<?php
$etiquettes=  json_decode(file_get_contents("./includes/constante_s.json"),true);
$output=  json_decode(file_get_contents("./includes/output.json"),true);
//$input=  json_decode(file_get_contents("./includes/input.json"),true);
?>
<body>
 <div class="conteneur">
    <div class="demi">
        <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
        <span class="ui-icon ui-icon-lightbulb" style="float: left; margin: -2px 5px 0 0;"></span>
        Entrées/Sorties logiques
        </p>
        <div class="enter" ">
        <table class="jtable demi ui-state-hover ui-corner-all">
        <tr><th class="ui-state-default pad4">Label</th>
        <th class="ui-state-default pad4">Broche</th>
        <th class="ui-state-default pad4">Mode E/S</th>
        <th class="ui-state-default pad4">Etat</th>
        </tr>
        <?php
        for ($loop=22; $loop < 49; $loop++){
            echo'<tr><td class="ui-widget-content"  ><input type="text" id="lab_es';
            echo $loop;
            echo '" style="border: 0; color: #cc2828; font-weight: bold;" size="22" num="'.$loop.'" value="';
            echo  $etiquettes["label"][$loop];
            echo '"/></td>';
            echo'<td class="ui-widget-content aucentre ">'.$etiquettes["pin"][$loop].'</td>';
            echo'<td class="ui-widget-content aucentre ">';
            if ($output["io_mode"][$loop]=="IN") echo '<input type="checkbox" class="mycheck" id="esl'.$loop.'"/><label for="esl'.$loop.'">E';
            else echo '<input type="checkbox" class="mycheck " id="esl'.$loop.'"/><label for="esl'.$loop.'" class="ui-state-active" aria-pressed="true">S';
            echo '</label></td>';
            echo'<td class="ui-widget-content aucentre ">
            <input type="checkbox" class="mycheck';
            echo '" id="esl'.$loop.'v"';
            echo '/><label for="esl'.$loop.'v" ';
            if ($output["io_etat"][$loop]==1) echo 'class="ui-state-active"';
            echo '>'.$output["io_etat"][$loop].'</label></td></tr>';
            }
        ?>
        </table>
        </div>
</div>
        <div class="demi2">
            <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
            <span class="ui-icon ui-icon-signal" style="float: left; margin: -2px 5px 0 0;"></span>
            Sorties PWM
            </p>
                <div id="eq">
                <p>
                <table class="jtable demi2 ui-state-hover ui-corner-all">
                <tr><th class="ui-state-default pad4">Label</th>
                <th class="ui-state-default pad4">Broche</th>
                <th class="ui-state-default pad4">Valeur</th>
                <th class="ui-state-default pad4">Réglage</th>
                </tr>
                <?php
                for ($loop=2; $loop < 13; $loop++)
                    {
                    echo'<tr><td class="ui-widget-content  "  ><input type="text" id="lab_pwm';
                    echo $loop;
                    echo '" style="border: 0; color: #cc2828; font-weight: bold; " size="22" num="'.$loop.'" value="';
                    echo $etiquettes["label"][$loop] ;
                    echo '"/></td>';
                    echo'<td class="ui-widget-content">';
                    echo '<label for="amount';
                    echo $loop;
                    echo '">';
                    echo $etiquettes["pin"][$loop];
                    echo '</label></td><td class="ui-widget-content" ><input type="text" id="amount';
                    echo $loop;
                    echo '" style="border: 0; width: 25px; color: #f6931f; font-weight: bold;" ';
                    if ($loop <10) {
                        echo 'value="'.$output["pwm"][$loop].'"';
                        echo ' savaleur="'.$output["pwm"][$loop];
                    }
                    else {
                        echo 'value="'.(255 -  $output["pwm"][$loop]).'"';
                        echo ' savaleur="'.(255 -  $output["pwm"][$loop]);
                    }
                    echo '" />
                    </td><td class="ui-widget-content">
                    <span ';
                    if ($loop==10) echo ' id="red" nb="'.$loop.'" >';
                    elseif ($loop==11) echo ' id="green" nb="'.$loop.'" >';
                    elseif ($loop==12) echo ' id="blue" nb="'.$loop.'" >';
                    else {
                        echo ' class="rect">';
                        echo $loop;
                    }
                    echo ' </span></td></tr>';
                    }
                ?>
                <tr><td colspan="3" >Couleur d'une LED RVB connectée en 10, 11,12</td><td>
                                    <div id="swatch" class="ui-widget-content ui-corner-all"></div></td></tr>
                </table>
                </p>
                </div >
        </div>
            <div class="demi3">
                <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
                <span class="ui-icon ui-icon-shuffle" style="float: left; margin: -2px 5px 0 0;"></span>
                 Bus I2C
                </p>
                <div class="demi3">
                    <table class="jtable demi3 ui-state-hover ui-corner-all">
                    <tr><th class="ui-state-default pad4">Label</th>
                    <th class="ui-state-default pad4">Valeur</th>
                   <th class="ui-state-default pad4Unités">Unités</th>
                    </tr>
                    <?php
                    for ($loop=66; $loop < 78; $loop++){
                        echo'<tr><td class="ui-widget-content"  ><input type="text" id="lab_i2c';
                        echo $loop;
                        echo '" style="border: 0; color: #cc2828; font-weight: bold; " size="22" num="'.$loop.'" value="';
                        echo $etiquettes["label"][$loop] ;
                        echo '"/></td>';
                        echo'<td class="ui-widget-content  aucentre "></td>';
                        echo'<td class="ui-widget-content aucentre "><input type="text" class="aucentre" id="unit_i2c'.$loop.'"  style="border: 0;font-weight: bold; " size="10"></td></tr>';
                        }
                    ?>
                    </table>
                </div>
                </div>
                <div class="demi2">
                    <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
                    <span class="ui-icon ui-icon-lightbulb" style="float: left; margin: -2px 5px 0 0;"></span>
                    Entrées Analogiques
                    </p>
                    <div class="demi2" id="ea" >
                    <table class="jtable demi2 ui-state-hover ui-corner-all">
                    <tr><th class="ui-state-default pad4">Label</th>
                    <th class="ui-state-default pad4">Broche</th>
                    <th class="ui-state-default pad4">Coef</th>
                    <th class="ui-state-default pad4">Valeur</th>
                    <th class="ui-state-default pad4">Unités</th>
                    </tr>
                    <?php
                    for ($loop=50; $loop < 66; $loop++){
                        echo'<tr><td class="ui-widget-content"  ><input type="text" id="lab_ea';
                        echo $loop;
                        echo '" style="border: 0; color: #cc2828; font-weight: bold; " size="22" num="'.$loop.'" value="';
                        echo $etiquettes["label"][$loop] ;
                        echo '"/></td>';
                        echo'<td class="ui-widget-content aucentre ">'.$etiquettes["pin"][$loop].'</td>';
                        echo'<td class="ui-widget-content  aucentre "><input type="text" class="aucentre" id="coef_a_i'.$loop.'"  style="border: 0;font-weight: bold; " size="10" value="1"></td>';
                        echo'<td class="ui-widget-content i_a  aucentre "></td>';
                        echo'<td class="ui-widget-content  aucentre "><input type="text" class="aucentre" id="unit_a_i'.$loop.'"  style="border: 0;font-weight: bold; " size="10"></td></tr>';
                        }
                        ?>
                        </table>
                        </div>
	</div>
	<div class="demi3">
                    <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
                    <span class="ui-icon ui-icon-shuffle" style="float: left; margin: -2px 5px 0 0;"></span>
                    Bus SPI
                    </p>
                        <div class="demi3">
                            <table class="jtable demi3 ui-state-hover ui-corner-all">
                            <tr><th class="ui-state-default pad4">Label</th>
                            <th class="ui-state-default pad4">Valeur</th>
                            <th class="ui-state-default pad4Unités">Unités</th>
                            </tr>
                            <?php
                            for ($loop=78; $loop < 86; $loop++){
                                echo'<tr><td class="ui-widget-content"  ><input type="text" id="lab_spi';
                        echo $loop;
                        echo '" style="border: 0; color: #cc2828; font-weight: bold; " size="22" num="'.$loop.'" value="';
                        echo $etiquettes["label"][$loop] ;
                        echo '"/></td>';
                        echo'<td class="ui-widget-content aucentre "></td>';
                        echo'<td class="ui-widget-content aucentre "><input type="text" class="aucentre" id="unit_spi'.$loop.'" style="border: 0;font-weight: bold; " size="10"></td></tr>';

                                 }
                            ?>
                            </table>
                            </div>
                        </div>
                    <div class="demi4">
                        <p class="ui-state-default ui-corner-all ui-helper-clearfix pad4">
                        <span class="ui-icon ui-icon-shuffle" style="float: left; margin: -2px 5px 0 0;"></span>
                        Ports série
                         </p>
                        <div id="master" ></div>
	</div>
</div>
</body>
</html> 