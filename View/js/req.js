$(document).ready(function () {
 
// BORRAR
    $("#dialog-requisitoBor").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 },
        buttons: {
            "Borrar": function () {
                $.post("requisitoController.php", {
                    codReq: codReq,
                    codPro: codPro,
                    ACTION: "BORRAR"
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
    $(document).on("click", ".BORRAR", function () {
        codReq = $(this).val();
        codPro = $("h5 span").text();
        $("#dialog-requisitoBor").dialog("open");
    });

//MODIFICAR REQUISITO
    $(".confirmarModRequisito").hide();
    
    $(document).on("click", ".MODIFICAR", function () {
       $(this).parent().parent().children("td").find("input").removeAttr("readonly");
       $(this).parent().parent().children("td").find("input").css("pointer-events","all");

       $(this).parent().parent().children("td").find("textarea").removeAttr("readonly");
       $(this).parent().parent().children("td").find(".estadoReqMod").css("pointer-events","all");
       $(this).hide();
       
       $(this).parent().parent().css("background","rgba(0,0,0,0.1)");
       $(this).parent().parent().css("boxShadow","0.1em 0.1em 0.1em black");
       $(this).parent().find(".confirmarModRequisito").show();
    });
    $(".confirmarModRequisito").on("click", function(){
        codReq = $(this).val();
        desReq = $(this).parents("table").find(".desReqMod").val();
        estadoReq = $(this).parents("table").find(".estadoReqMod option:selected").text();
        if(desReq !=="" && estadoReq !== ""){
        $(this).parent().parent().children("td").find("input").attr("readonly","readonly");
        $(this).parent().parent().children("td").find("input").css("pointer-events","none");
        $(this).parent().parent().children("td").find("textarea").attr("readonly","readonly");
        $(this).parent().parent().children("td").find(".estadoReqMod").css("pointer-events","none");
        $(this).hide();
        $(this).parent().find(".MODIFICAR").show();

        $(this).parent().parent().css("background","inherit");
        $(this).parent().parent().css("boxShadow","none");
        $(".material-tooltip").remove();

         $.post("requisitoController.php", {
             codReq: codReq,
             desReq: desReq,
             estadoReq: estadoReq,
             codPro: $("h5 span").text(),
             ACTION: "MODIFICAR"
         }).done(function (data) {
             $("#listado").html(data);
         });
        } else {
            if(desReq === ""){
                $(this).parent().siblings("td").find(".desReqMod").addClass("invalid");
                $(this).parent().siblings("td").find(".desReqMod").css("border-bottom","red 0.1em solid");
            }
            if(estadoReq === ""){
                $(this).parent().siblings("td").find(".estadoReqMod").addClass("invalid");
                $(this).parent().siblings("td").find(".estadoReqMod").css("border-bottom","red 0.1em solid");
            }
        }
    });

//MOSTRAR TAREAS
$(".tablaTareas").hide();
$(".TAREA").on("click",function(){
    $(this).parents("div").find(".tablaTareas").fadeToggle( 500 );
});
//FIN MOSTRAR TAREAS
  $('.tooltipped').tooltip({delay: 50});
  $('select').material_select();
  $(".ui-dialog").css("box-shadow","0 0 5px black");
});//FIN READY