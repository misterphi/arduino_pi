$(document).ready(function() {

$(function() {
        // slider Pwm
        $( ".rect" ).each(function() {
            var num = parseInt( $( this ).text(), 10 );
            var lavaleur= $( "#amount"+ num ).attr("savaleur");
            $( this ).empty().slider({
                value: lavaleur,
                range: "min",
                max: 255,
                animate: true,
                orientation: "horizontal",
                slide: function( event, ui ) {
                $( "#amount"+ num ).val( ui.value );
                },
            	stop: function( event, ui ) {
            	$.ajax({
                type: "POST",
                url : "./scripts/update_json.php",
                data : {num_slide : num, val_slide : ui.value, action : "modif_slide" },
                async: false,
                success :function(data)
                    {
                    if (data != "OK") alert('Erreur' +data);
                    }
                });
            	}

         	});

        });
        //setup checkbox E/S logiques
        $("[id^='esl']").button();
        //desactivation case etat
        $("[id$='v']").each(function() {
        id_courantv=$(this).attr('id');
        id_mode=id_courantv.substr(0,5);
        $('label[for="'+ id_courantv+'"]').css('opacity',1);
        if ($('label[for="'+ id_mode+'"]').text()=="E") $("#"+ id_courantv ).button("option", "disabled", true);
        //else $("#"+ id_courantv ).button("option", "disabled", false);
     	});

     	// change chekbox if clic
     	$("[id^='esl']").click(function() {
     		lab= $( this ).button( "option", "label" );
     		id_courant=$(this).attr('id');
                                    indice=id_courant.substr(3,2);
     		if (lab=="E") {
                                        $( this ).button( "option", "label", "S" ); // positionne en sortie
                                        $('label[for="'+ id_courant+'"]').addClass("ui-state-active"); //apparence bouton activé
                                        $("#"+ id_courant+"v").button("option", "disabled", false); //autorise  le chgt de la case état
                                        $("#"+ id_courant+"v").button( "option", "label", "0" );//on met état à 0
                                        $('label[for="'+ id_courant+'v"]').removeClass("ui-state-active");// apparence état 0
                                        change_io (indice,"mode","OUT");
                                        change_io (indice,"etat",0);
     		}
     		else if (lab=="S") {
     		$( this ).button( "option", "label", "E" );
                                    $('label[for="'+ id_courant+'"]').removeClass("ui-state-active");
     		$("#"+ id_courant+"v").button("option", "disabled", true);
		$('label[for="'+ id_courant+'v"]').css('opacity',1);
                                    change_io (indice,"mode","IN");
                                    change_io (indice,"etat",-1);
		}
		else if (lab=="1") {
                                        $( this ).button( "option", "label", "0" );
                                        $('label[for="'+ id_courant+'"]').removeClass("ui-state-active");
                                        change_io (indice,"etat",0);
                                        }
     		else if (lab=="0"){
                                        $( this ).button( "option", "label", "1" );
                                        $('label[for="'+ id_courant+'"]').addClass("ui-state-active");
                                        change_io (indice,"etat",1);
                                        }
		});

//modification d'un label
            $("input").focusout(function() {
            $.ajax({
                type: "POST",
                url : "./scripts/update_json.php",
                data : {num_label : $( this ).attr("num"), val_label : $( this ).val(), action : "modif_label" },
                async: false,
                success :function(data)
                    {
                    if (data != "OK") alert('Erreur' +data);
                    }
                });
		});
    });

function change_io (qui,quoi,combien) {
    $.ajax({
                type: "POST",
                url : "./scripts/update_json.php",
                data : {num_io : qui, mode_io : quoi, state_io :combien ,action : "modif_io" },
                async: false,
                success :function(data)
                    {
                    if (data != "OK") alert('Erreur' +data);
                    }
                });
}
  //Slider RVB
   function hexFromRGB(r, g, b) {
        var hex = [
            r.toString( 16 ),
            g.toString( 16 ),
            b.toString( 16 ),
        ];
        $.each( hex, function( nr, val ) {
            if ( val.length === 1 ) {
                hex[ nr ] = "0" + val;
            }
        });
        return hex.join( "" ).toUpperCase();
    }

    function refreshSwatch() {
        var red = $( "#red" ).slider( "value" ),
            green = $( "#green" ).slider( "value" ),
            blue = $( "#blue" ).slider( "value" ),
            hex = hexFromRGB( red, green, blue );
        $( "#swatch" ).css( "background-color", "#" + hex );
        $( "#amount10" ).val("#"+red.toString(16));
        $( "#amount11" ).val("#"+green.toString(16));
        $( "#amount12" ).val("#"+blue.toString(16));


    }

    $(function() {
        $( "#red, #green, #blue" ).slider({
            orientation: "horizontal",
            range: "min",
            max: 255,
            value: 0,
            slide: refreshSwatch,
            change: refreshSwatch,
            stop: function( event, ui ) {
            num=$(this).attr("nb");
            $.ajax({
                type: "POST",
                url : "./scripts/update_json.php",
                data : {num_slide : num, val_slide : ui.value, action : "modif_slide" },
                async: false,
                success :function(data)
                    {
                    if (data != "OK") alert('Erreur' +data);
                    }
                });

            }
        });
        slired=$( "#amount10" ).attr("savaleur");
        sligreen=$( "#amount11" ).attr("savaleur");
        sliblue= $( "#amount12" ).attr("savaleur");
        $( "#red" ).slider("option", "value", slired );
        $( "#green" ).slider("option", "value",sligreen);
        $( "#blue" ).slider( "option", "value", sliblue);
    });

});