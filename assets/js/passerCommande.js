require( "smartwizard/dist/css/smart_wizard_all.css");
const smartWizard = require("smartwizard");


newColis= function(){
    let htmlContent ='<div class="row rowColis"><div class="col-md-2"><label class="labelColis"></label></div><div class="col-md-2"><label>Poids(Kg):</label><input type="text" class="form-control poidColis" name=poidColis[] id="" value="" ></div><div class="col-md-2"><label>Longeur(Cm):</label><input type="text" class="form-control longeurColis" name=longueurColis[] id="" value="" ></div><div class="col-md-2"><label>Largeur(Cm):</label><input type="text" class="form-control largeurColis" name=largeurColis[] id="" value="" ></div><div class="col-md-2"><label>Hauteur(Kg):</label><input type="text" class="form-control hauteurColis" name=hauteurColis[] id="" value="" ></div><div class="col-md-2"><button class="btnColis" id="" onclick="" title="Supprimer"><i class="fa fa-trash"></i></button></div></div>' 
    $("#content_Colis").append(htmlContent);
    initColis();
}

deleteColis= function(index){
    $("#rowColis_"+index).remove();
    initColis();
}

initColis= function(){
    let i = 1
    $(".rowColis").each(function(){
        $(this).attr("id","rowColis_"+i);
        i++;
    });
    i = 1
    $(".poidColis").each(function(){
        $(this).attr("id","poidColis_"+i);
        i++;
    });
    i = 1
    $(".longeurColis").each(function(){
        $(this).attr("id","longeurColis_"+i);
        i++;
    });
    i = 1
    $(".largeurColis").each(function(){
        $(this).attr("id","largeurColis_"+i);
        i++;
    });
    i = 1
    $(".hauteurColis").each(function(){
        $(this).attr("id","hauteurColis_"+i);
        i++;
    });
    i = 1
    $(".labelColis").each(function(){
        $(this).attr("id","labelColis_"+i);
        $(this).html("Colis "+i);
        i++;
    });
    i = 1;
    $(".btnColis").each(function(){
        $(this).attr("id","btnColis_"+i);
        $(this).attr("onclick","deleteColis("+ i +"); return false;");
        i++;
    });

}


// Function to fetch the ajax content
provideContent = function(idx, stepDirection, stepPosition, selStep, callback) {
 
    // You can use stepDirection to get ajax content on the forward movement and stepPosition to identify the step position
      let ajaxURL = "YOUR AJAX URL";
      console.log("steps");
      console.log(idx);
      console.log(stepDirection);
      console.log(stepPosition);
      console.log(selStep);
      console.log(callback);
      console.log("value :");
      console.log($('.colisHauteur').map(function() {
        return this.value;
     }).get());
      if(idx == 2){
        var colisPoids = [];
        var colisLongueur = [];
        var colisLargeur = [];
        var colisHauteur = [];
        $(".poidColis").each(function(){
            colisPoids.push($(this).val());
        });
        $(".longeurColis").each(function(){
            colisLongueur.push($(this).val());
        });
        $(".largeurColis").each(function(){
            colisLargeur.push($(this).val());
        });
        $(".hauteurColis").each(function(){
            colisHauteur.push($(this).val());
        });
        $(".mask").show();
        console.log(colisPoids,colisLongueur);
        $.ajax({
            method  : "GET",
            url     : window.getPriceColis,
            data : {
                "kilometrage":"480",
                "colisPoids": colisPoids,
                "colisLongueur":colisLongueur,
                "colisLargeur":colisLargeur,
                "colisHauteur":colisHauteur
            },
            beforeSend: function( xhr ) {
                // Show the loader
                //$('#smartwizard').smartWizard("loader", "show");
            }
        }).done(function( res ) {
            let htmlLivreur= '';

            for( var i = 0;i<res.length;i++){
                htmlLivreur +='<input class="form-check-input" type="radio" name="livreruPrice" id="livreruPrice'+ i +'" value="'+ res[i].id +'"><label class="form-check-label" for="livreruPrice'+ i +'"> '+ res[i].nom +'('+ res[i].prixTotal + ')' +'</label></div>'
            }
            $("#content_Livreurs").html(htmlLivreur);
            
            //$('#smartwizard').smartWizard("loader", "hide");
            $(".mask").hide();
        }).fail(function(err) {
     
            // Hide the loader
            //$('#smartwizard').smartWizard("loader", "hide");
            $(".mask").hide();
        });

      }else if(idx == 4){
        var htmlDepartRecap = "<label>Adresse Départ</label><p>"+ $("#adresseDepart").val() +"<br>"+$("#codePostalDepart").val()+"<br>"+ $("#villeDepart").val() +"<br>"+ $("#paysDepart").val() +"</p>";
        var htmlFinalRecap = "<label>Adresse Arrivée</label><p>"+ $("#adresseFinal").val() +"<br>"+$("#codePostalFinal").val()+"<br>"+ $("#villeFinal").val() +"<br>"+ $("#paysFinal").val() +"</p>";

        $("#adresseDepartRec").html(htmlDepartRecap);
        $("#adresseArriveeRec").html(htmlFinalRecap);
      }
      // Ajax call to fetch your content
      /**/
    callback();
  }

$(function() {
    $('#smartwizard').smartWizard(
        {
            autoAdjustHeight: true,
            getContent: provideContent
        }
    );
    $("#showAdresseArrivee").on("change",function(e){
        if(this.checked){
            $(".mask").show();          
            $.ajax({
                url: window.getAdresseClient,
                dataType: "json",
                type: "GET",
                async: true,
                data: { },
                success: function (data) {
                    $("#adresseFinal").attr("value",data.adresse);
                    $("#codePostalFinal").attr("value",data.codePostal);
                    $("#villeFinal").attr("value",data.ville);
                    $("#paysFinal").attr("value",data.pays);
                    $(".mask").hide();
                },
                error: function (xhr, exception) {
                    var msg = "";
                    if (xhr.status === 0) {
                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                    } else if (xhr.status == 404) {
                        msg = "Requested page not found. [404]" + xhr.responseText;
                    } else if (xhr.status == 500) {
                        msg = "Internal Server Error [500]." +  xhr.responseText;
                    } else if (exception === "parsererror") {
                        msg = "Requested JSON parse failed.";
                    } else if (exception === "timeout") {
                        msg = "Time out error." + xhr.responseText;
                    } else if (exception === "abort") {
                        msg = "Ajax request aborted.";
                    } else {
                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                    }
                    $(".mask").hide();
                }
            });

        }else{
            console.log("not checked");
            $("#adresseFinal").attr("value","");
            $("#codePostalFinal").attr("value","");
            $("#villeFinal").attr("value","");
            $("#paysFinal").attr("value","");
        }
    });
     
    $("#modeLivraison").on('change',function(){
        if($(this).val() == 2){
            $(".mask").show();
            $.ajax({
                url: window.getPointRelaisUrl,
                dataType: "json",
                type: "GET",
                async: true,
                data: { },
                success: function (data) {
                    let htmlOptions = "<option value=''>Selectionnez un point de relais</option>";
                    if(data){
                        for(var i=0 ; i < data.length ; i++){
                            htmlOptions +='<option value="'+data[i].id+'">'+data[i].nom+'</option>';
                        }
                    }
                    $("#listPointRelais").html(htmlOptions); 
                   $("#pointDeRelaisList").show();
                   $(".mask").hide();
                },
                error: function (xhr, exception) {
                    var msg = "";
                    if (xhr.status === 0) {
                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                    } else if (xhr.status == 404) {
                        msg = "Requested page not found. [404]" + xhr.responseText;
                    } else if (xhr.status == 500) {
                        msg = "Internal Server Error [500]." +  xhr.responseText;
                    } else if (exception === "parsererror") {
                        msg = "Requested JSON parse failed.";
                    } else if (exception === "timeout") {
                        msg = "Time out error." + xhr.responseText;
                    } else if (exception === "abort") {
                        msg = "Ajax request aborted.";
                    } else {
                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                    }
                    $(".mask").hide();
                }
            }); 
        }else{
            $("#pointDeRelaisList").hide();
        }
    });

    $("#listPointRelais").on('change',function(){
        console.log($(this).val());
        if($(this).val() != undefined){
            $(".mask").show();
            $.ajax({
                url: window.getOnePointRelaisUrl,
                dataType: "json",
                type: "GET",
                async: true,
                data: { point_relais_id: $(this).val() },
                success: function (data) {
                    $("#adresseFinal").attr("value",data.adresse);
                    $("#codePostalFinal").attr("value",data.codePostal);
                    $("#villeFinal").attr("value",data.ville);
                    $("#paysFinal").attr("value",data.pays);
                    $("#adresseArrivee").show();
                    $(".mask").hide();
                },
                error: function (xhr, exception) {
                    var msg = "";
                    if (xhr.status === 0) {
                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                    } else if (xhr.status == 404) {
                        msg = "Requested page not found. [404]" + xhr.responseText;
                    } else if (xhr.status == 500) {
                        msg = "Internal Server Error [500]." +  xhr.responseText;
                    } else if (exception === "parsererror") {
                        msg = "Requested JSON parse failed.";
                    } else if (exception === "timeout") {
                        msg = "Time out error." + xhr.responseText;
                    } else if (exception === "abort") {
                        msg = "Ajax request aborted.";
                    } else {
                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                    }
                    $(".mask").hide();
                }
            }); 
        }
    });

    $('input[type=radio][name=livreruPrice]').on('change',function(){
        console.log(this);    
    });

    $('input[type=radio][name=modalityPayment]').on('change',function(){
        console.log(this);
    });

});