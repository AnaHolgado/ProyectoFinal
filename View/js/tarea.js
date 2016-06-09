$(document).ready(function () {
    //MODIFICAR TAREA
    $(document).on("click", ".MODIFICARTAREA", function () {
        var that = $(this);
        if ( $(this).parent().siblings("td").find("#desTar").val() !== "" && 
                $(this).parent().siblings("td").find("#estTar").val() !== -1 && 
                $(this).parent().siblings("td").find("#horPreTar").val() >= 0 && 
                $(this).parent().siblings("td").find("#horReaTar").val() >= 0 &&
                $(this).parent().siblings("td").find("#usuTar").val() !== -1){
        $.post("requisitoController.php", {
            codTar: $(this).parent().siblings("td").find("#codTar").val(),
            codReq: $(this).val(),
            desTar: $(this).parent().siblings("td").find("#desTar").val(),
            estadoTar: $(this).parent().siblings("td").find("#estTar").val(),
            horPreTar: $(this).parent().siblings("td").find("#horPreTar").val(),
            horReaTar: $(this).parent().siblings("td").find("#horReaTar").val(),
            ordTar: $(this).parent().siblings("td").find("#ordTar").val(),
            codUsu: $(this).parent().siblings("td").find("#usuTar").val(),
            codPro: $("h5 span").text(),
            ACTION: "MODIFICARTAREA"
        }).done(function (data) {
            $("#listado").html(data);
            $("#dialog-TareaMod").dialog("open");
            $(".material-tooltip").remove();
        });
    } else {
        if($(this).parent().siblings("td").find("#desTar").val() === ""){
            $(this).parent().siblings("td").find("#desTar").addClass("invalid");
        }
        if($(this).parent().siblings("td").find("#horPreTar").val() < 0){
            $(this).parent().siblings("td").find("#horPreTar").addClass("invalid");
        }
        if($(this).parent().siblings("td").find("#horReaTar").val() < 0){
            $(this).parent().siblings("td").find("#horReaTar").addClass("invalid");
        }
    }
    });
    
    $("#dialog-TareaMod").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 }
    });
    
// BORRAR TAREA
    $("#dialog-tareaBor").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 },
        show: {
            effect: "blind",
            duration: 1000
        },
        hide: {
            effect: "explode",
            duration: 1000,
        },
        buttons: {
            "Borrar": function () {
                $.post("requisitoController.php", {
                    codTar: codTar,
                    codReq: codReq,
                    codPro: codPro,
                    ACTION: "BORRARTAREA"
                }).done(function(data){
                    $("#listado").html(data);
                });
                $(this).dialog("close");
            },
            Cancelar: function () {
                $(this).dialog("close");
            }
        }
    });
    $(document).on("click", ".BORRARTAREA", function () {
        codTar = $(this).parent().siblings("td").find("#codTar").val();
        codReq = $(this).val();
        codPro = $("h5 span").text();
        $("#dialog-tareaBor").dialog("open");
    });
    
  $('.tooltipped').tooltip({delay: 50});
  $('select').material_select();
  $(".ui-dialog").css("box-shadow","0 0 5px black");

});//FIN READY