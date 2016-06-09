$(document).ready(function () {
    $(document).on("click", "#cambiarPass", function () {
        if($("#passNueva").val().length >= 4 && $("#passNuevaR").val().length >= 4){
        $.post("presentacionController.php", {
            passUsu: $("#passActual").val(),
            passNueva: $("#passNueva").val(),
            passNuevaR: $("#passNuevaR").val(),
            ACTION: "CAMBIARPASS"
        }).done(function (data) {
            if(data === "true"){
                $("#dialog-passCambiado").dialog("open");
                $("#passActual").addClass("valid");
                $("#passNueva").addClass("valid");
                $("#passNuevaR").addClass("valid");
            }else {
                $("#passActual").addClass("invalid");
                $("#passNueva").addClass("invalid");
                $("#passNuevaR").addClass("invalid");
            }
        });
        }else {
            $("#passActual").addClass("invalid");
            $("#passNueva").addClass("invalid");
            $("#passNuevaR").addClass("invalid");
        }
    });
    $("#dialog-passCambiado").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 }
    });
    
    //PIZARRA
    $(document).on("click", ".pizarraProyecto", function () {
        codProReq = $(this).find("input").val(); 
        $("#codProPiz").val(codProReq);
        $("#formPiz").submit();
    });
    
    //ESTADISTICA CHART.JS
    var i = 0;
    $(".porcentaje").each( function() {
      i += 1;
      var horPre =  $(this).find(".horasPrevistas").val();
      var horRea =  $(this).find(".horasReales").val();
      if(horRea == 0){horRea = 0; horPre = 100;}
      var data = [{ value:(horRea*100/horPre).toFixed(), color:"#F7464A", highlight: "#FF5A5E" }, 
                { value: (100-(horRea*100/horPre).toFixed()), color: "#46BFBD", highlight: "#5AD3D1" } ];
      var pieChart= new Chart(document.getElementById("canvas"+i).getContext("2d")).Pie(data, {pointLabelFontSize : 13, pointLabelFontColor:"#ffa45e"}); 
      $(this).find(".per").text((horRea*100/horPre).toFixed() +"%");
    });
    
    //FILTRO
    $("#cambiarEstado").on("change", function(){
        $.post("presentacionController.php", {
          filtro: $(this).val(),
          ACTION: "FILTRO"
        }).done(function (data) {
          $("#panel-proyectos").html(data);
          $(".material-tooltip").remove();
        });
    });
    
 $('.tooltipped').tooltip({delay: 50});
  $('select').material_select();   
});//FIN READY
    

