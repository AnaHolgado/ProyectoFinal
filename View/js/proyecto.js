$(document).ready(function () {


// BORRAR
    var fila;
    $("#dialog-proyectoBor").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 },
        buttons: {
            "Borrar": function () {
                $.post("proyectoController.php", {
                    codPro: codPro,
                    ACTION: "BORRAR"
                }).done(function (data) {fila.fadeOut(600,function(){
                    $("#listadoProyecto").html(data);
                    $(".material-tooltip").remove();
                    }).fail(function(){
                        alert("ERROR");
                    });
                });
                $(this).dialog("close");
            },
            Cancelar: function () {
                $(this).dialog("close");
            }
        }
    });
    $(document).on("click", ".borrarProyecto", function () {
        codPro = $(this).parent().siblings("#proyectoCodigo").text();
        fila = $(this).parent().parent();
        $("#dialog-proyectoBor").dialog("open");
    });

//MODIFICAR
    $(".confirmarModProyecto").hide();
    $(".modificarProyecto").on("click", function(){
       $(this).parent().parent().children("td").find("input").removeAttr("readonly");
       $(this).parent().parent().children("td").find("input").css("pointer-events","all");
       $(this).parent().parent().children("td").find(".fechfinProMod").css("pointer-events","all");
       $(this).parent().parent().children("td").find(".faseProMod").css("pointer-events","all");
       $(this).parent().parent().children("td").find(".nomempCliMod").css("pointer-events","all");
       $(this).hide();
       $(this).parent().find(".confirmarModProyecto").show();

       $(this).parent().parent().css("background","rgba(0,0,0,0.1)");
       $(this).parent().parent().css("boxShadow","0.1em 0.1em 0.1em black");
    });
    $(".confirmarModProyecto").on("click", function(){
        var codPro = $(this).parent().siblings("td").find(".codPro").val();
        var nomPro = $(this).parent().siblings("td").find(".nomProMod").val();
        var codCli = $(this).parent().siblings("td").find(".nomempCliMod option:selected").val();
        var fechfinPro = $(this).parent().siblings("td").find(".fechfinProMod").val();
        var fasePro = $(this).parent().siblings("td").find(".faseProMod option:selected").val();
        if(nomPro !=="" && fechfinPro !== ""){
            $(this).parent().parent().children("td").find("input").attr("readonly","readonly");
            $(this).parent().parent().children("td").find("input").css("pointer-events","none");
            $(this).parent().parent().children("td").find(".faseProMod").css("pointer-events","none");
            $(this).parent().parent().children("td").find(".fechfinProMod").css("pointer-events","none");
            $(this).parent().parent().children("td").find(".nomempCliMod").css("pointer-events","none");
            $(this).hide();
            $(this).parent().find(".modificarProyecto").show();

            $(this).parent().parent().css("background","inherit");
            $(this).parent().parent().css("boxShadow","none");
            $(".material-tooltip").remove();
        $.post("proyectoController.php", {
            codPro: codPro,
            nomPro: nomPro,
            fasePro: fasePro,
            fechfinPro: fechfinPro,
            codCli: codCli,
            ACTION: "MODIFICAR"
        }).done(function (data) {
            $("#listadoProyecto").html(data);
            $("#dialog-ProyectoMod").dialog("open");
        }).fail(function(){
            alert("ERROR");
        });
        } else {
            if(nomPro === ""){
                $(this).parent().siblings("td").find(".nomProMod").addClass("invalid");
                $(this).parent().siblings("td").find(".nomProMod").css("border-bottom","red 0.1em solid");
            }
            if(fechfinPro === ""){
                $(this).parent().siblings("td").find(".fechfinProMod").addClass("invalid");
                $(this).parent().siblings("td").find(".fechfinProMod").css("border-bottom","red 0.1em solid");
            }
        }
    });
    $("#dialog-ProyectoMod").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 }
    });

//REQUISITOS
var codProReq;
    $(document).on("click", ".requisitosProyecto", function () {
        codProReq = $(this).parent().siblings("#proyectoCodigo").text(); 
        $("#codProReq").val(codProReq);
        $("#formReq").submit();
    });

//PIZARRA
    $(document).on("click", ".pizarraProyecto", function () {
        codProReq = $(this).parent().siblings("#proyectoCodigo").text(); 
        $("#codProPiz").val(codProReq);
        $("#formPiz").submit();
    });
  
  $('.tooltipped').tooltip({delay: 50});
  $('select').material_select();
  
   
 //DATEPICKER

  $('.datepicker').pickadate({
    //selectMonths: true, // Creates a dropdown to control month
    //selectYears: 15, // Creates a dropdown of 15 years to control year
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
      'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado'],
    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    format: 'dd-mm-yyyy',
    today: 'hoy',
    clear: 'limpiar',
    closeText: 'cerrar',
    firstDay: 'monday'
  });
});//FIN READY