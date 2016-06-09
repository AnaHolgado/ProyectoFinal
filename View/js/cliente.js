$(document).ready(function () {
  
// BORRAR
  var fila;
  $("#dialog-clienteBor").dialog({
    autoOpen: false,
    closeText: "x",
    modal: true,
    show: { effect: "puff", duration: 500 },
    hide: { effect: "puff", duration: 500 },
    buttons: {
      "Borrar": function () {
        $.post("clienteController.php", {
          codCli: codCli,
          ACTION: "BORRAR"
        }).done(function (data) {
            fila.fadeOut(600,function(){
                $("#listadoClientes").html(data);
            });
        });
        $(this).dialog("close");
      },
      Cancelar: function () {
        $(this).dialog("close");
      }
    }
  });
  $(document).on("click", ".borrarCliente", function () {
    codCli = $(this).parent().siblings("td").find(".clienteCodigo").val();
    fila = $(this).parent().parent();
    $("#dialog-clienteBor").dialog("open");
  });
//FIN BORRAR

    
//MODIFICAR
//DIALOG CLIENTES
$(".confirmarModCliente").hide();

$(".modificarCliente").on("click", function(){
    $(this).parent().parent().children("td").find("input").removeAttr("readonly");
    $(this).parent().parent().children("td").find("input").css("pointer-events","all");
    $(this).hide();
    $(this).parent().find(".confirmarModCliente").show();

    $(this).parent().parent().css("background","rgba(0,0,0,0.1)");
    $(this).parent().parent().css("boxShadow","0.1em 0.1em 0.1em black");
});
$(".confirmarModCliente").on("click", function(){
    var codCli = $(this).parent().siblings("td").find(".clienteCodigo").val();
    var nomempCli = $(this).parent().siblings("td").find(".cliNomEmpMod").val();
    var tlfCli = $(this).parent().siblings("td").find(".cliTelMod").val();
    var emailCli = $(this).parent().siblings("td").find(".cliEmailMod").val();
    var nomconCli = $(this).parent().siblings("td").find(".cliNomConMod").val();
    
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if(nomempCli !=="" && emailCli !== "" && regex.test(emailCli) && nomconCli !== "" && tlfCli.length === 9){
        $(this).parent().parent().children("td").find("input").attr("readonly","readonly");
        $(this).parent().parent().children("td").find("input").css("pointer-events","none");
        $(this).parent().find(".modificarCliente").show();
        $(this).hide();

        $(".material-tooltip").remove();
        $(this).parent().parent().css("background","inherit");
        $(this).parent().parent().css("boxShadow","none");
        $.post("clienteController.php", {
            codCli: codCli,
            nomempCli: nomempCli,
            tlfCli: tlfCli,
            emailCli: emailCli,
            nomconCli: nomconCli,
            ACTION: "MODIFICAR"
        }).done(function (data) {
            $("#listadoCliente").html(data);
            $("#listadoCliente *").removeClass("valid");
            $("#dialog-ClienteMod").dialog("open");
        }).fail(function(){
            alert("ERROR");
        });
    }else {
        if(nomempCli === ""){
            $(this).parent().siblings("td").find(".cliNomEmpMod").addClass("invalid");
            $(this).parent().siblings("td").find(".cliNomEmpMod").css("border-bottom","red 0.1em solid");
        }
        if(!regex.test(emailCli) || emailCli === ""){
            $(this).parent().siblings("td").find(".cliEmailMod").addClass("invalid");
            $(this).parent().siblings("td").find(".cliEmailMod").css("border-bottom","red 0.1em solid");
        }
        if(nomconCli === ""){
            $(this).parent().siblings("td").find(".cliNomConMod").addClass("invalid");
            $(this).parent().siblings("td").find(".cliNomConMod").css("border-bottom","red 0.1em solid");
        }
        if(tlfCli === "" || tlfCli.length !== 9){
            $(this).parent().siblings("td").find(".cliTelMod").addClass("invalid");
            $(this).parent().siblings("td").find(".cliTelMod").css("border-bottom","red 0.1em solid");
        }
    }
});
$("#dialog-ClienteMod").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 }
    });

//DIALOG BUTTONS
    //$(".ui-button").addClass("btn");
    $('.tooltipped').tooltip({delay: 50});
    $('select').material_select();
    $(".ui-dialog").css("box-shadow","0 0 5px black");
    


});//FIN READY

