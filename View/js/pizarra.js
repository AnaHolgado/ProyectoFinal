$(document).ready(function () {    
//PIZARRA   
    $( ".draggable" ).draggable();
 
    $( ".pendiente" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      activate: function(){
          document.getElementById('player').play();
      },
      drop: function( event, ui ) {
        codTar = parseInt(ui.draggable.find("input").val());
        if(ui.draggable){
            $.post("pizarraController.php", {
              codTar: codTar,
              estadoTar:"PENDIENTE",
              ACTION: "MODIFICARESTADOTAREA"
            }).done(function(data){
               $(ui.draggable).fadeOut(500);         
               $(ui.draggable).fadeIn(500);
            });
            $(this).find("h6").fadeOut(500);         
            $(this).find("h6").fadeIn(500);
        }
      }
    });
    var that;
    $( ".proceso" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      drop: function( event, ui ) {
        codTar = parseInt(ui.draggable.find("input").val());
        if(ui.draggable){
            that=$(ui.draggable);
        $.post("pizarraController.php", {
          codTar: codTar,
          estadoTar:"EN PROCESO",
          ACTION: "MODIFICARESTADOTAREA"
        }).done(function(data){
            that.fadeOut(500);         
            that.fadeIn(500);
        });
         $(this).find("h6").fadeOut(500);         
         $(this).find("h6").fadeIn(500);
        }
      }
    });
    $( ".completado" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      drop: function( event, ui ) {
        codTar = parseInt(ui.draggable.find("input").val());
        if(ui.draggable){
            that = $(ui.draggable);
            $("#dialog-horasRealizadas").dialog("open");
        }
      }
    });
 
 //DIALOG
    $("#dialog-horasRealizadas").dialog({
        autoOpen: false,
        closeText: "X",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 },
        buttons: {
            "CONTINUAR": function () {
                if($("#horReaTar").val() > 0){
                    $("#horReaTar").removeClass("invalid");
                $.post("pizarraController.php", {
                    codTar: codTar,
                    horReaTar: $("#horReaTar").val(),
                    estadoTar:"COMPLETADO",
                    ACTION: "MODIFICARESTADOCOMPLETADOTAREA"
                  }).done(function(data){
                    $(".completado h6").fadeOut("500");
                    $(".completado h6").fadeIn("500");
                    that.fadeOut(500);         
                    that.fadeIn(500);
                  });
                $(this).dialog("close");
            }else {
                $("#horReaTar").addClass("invalid");
                
            }
            },
            CANCELAR: function () {
                $(this).dialog("close");
                 that.css("top",0).css("left",0);
            }
        }
    });
    $(".draggable").on("mouseenter mouseleave", function(){
        $(this).find(".desc").hide()/*.toggleClass("truncate")*/.fadeIn(50);
    });
//    $(".draggable").on("mousedown", function(){
//       $(this).css("width", "7.5em").css("height", "7.5em");
//    });
    $(".ui-dialog").css("box-shadow","0 0 5px black");

});

