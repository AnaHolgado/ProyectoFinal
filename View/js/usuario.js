$(document).ready(function () {

// BORRAR
    var fila;
    var codUsu;
    $("#dialog-usuarioBor").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 },
        buttons: {
            "Borrar": function () {
                $.post("usuarioController.php", {
                    codUsu: codUsu,
                    ACTION: "BORRAR"
                }).done(function (data) {
                    fila.fadeOut(600,function(){
                        $("#listadoUsuarios").html(data);
                    });
                });
                $(this).dialog("close");
                $(".material-tooltip").remove();
            },
            Cancelar: function () {
                $(this).dialog("close");
            }
        }
    });
    $(document).on("click", ".borrarUsuario", function () {
        codUsu = $(this).parent().siblings(".codUsu").val();
        fila = $(this).parent().parent();
        $("#dialog-usuarioBor").dialog("open");
    });

//MODIFICAR
    $(".confirmarModUsuario").hide();

    $(".modificarUsuario").on("click", function(){
       $(this).parent().parent().children("td").find("input").removeAttr("readonly");
       $(this).parent().parent().children("td").find("input").css("pointer-events","all");
       $(this).parent().parent().children("td").find(".permiso").css("pointer-events","all");
       $(this).parent().parent().children("td").find(".categoria").css("pointer-events","all");
       $(this).hide();
       $(this).parent().find(".confirmarModUsuario").show();

       $(this).parent().parent().css("background","rgba(0,0,0,0.1)");
       $(this).parent().parent().css("boxShadow","0.1em 0.1em 0.1em black");
    });
    $(".confirmarModUsuario").on("click", function(){
        var codUsu = $(this).parent().siblings(".codUsu").val();
        var nomUsu = $(this).parent().siblings("td").find(".nom").val();
        var catUsu = $(this).parent().siblings("td").find(".categoria option:selected").val();
        var emailUsu = $(this).parent().siblings("td").find(".email").val();
        var permisoUsu = $(this).parent().siblings("td").find(".permiso option:selected").val();
        var loginUsu = $(this).parent().siblings("td").find(".login").val();
        var passUsu = $(this).parent().siblings("td").find(".passUsu").val();
        
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        if(nomUsu !=="" && emailUsu !== "" && regex.test(emailUsu) && loginUsu !== "" && loginUsu.length >= 4 && passUsu !== "" &&passUsu.length >= 4){
            $(this).parent().parent().children("td").find("input").attr("readonly","readonly");
            $(this).parent().parent().children("td").find("input").css("pointer-events","none");
            $(this).parent().parent().children("td").find(".permiso").css("pointer-events","none");
            $(this).parent().parent().children("td").find(".categoria").css("pointer-events","none");
            $(this).hide();
            $(this).parent().find(".modificarUsuario").show();

            $(this).parent().parent().css("background","inherit");
            $(this).parent().parent().css("boxShadow","none");
            $(".material-tooltip").remove();
            $.post("usuarioController.php", {
                nomUsu: nomUsu,
                codUsu: codUsu,
                catUsu: catUsu,
                emailUsu: emailUsu,
                permisoUsu: permisoUsu,
                loginUsu: loginUsu,
                passUsu: passUsu,
                ACTION: "MODIFICAR"
            }).done(function (data) {
                $("#listadoUsuarios").html(data);
                $("#dialog-UsuarioMod").dialog("open");
            });
        }else {
            if(nomUsu === ""){
                $(this).parent().siblings("td").find(".nom").addClass("invalid");
                $(this).parent().siblings("td").find(".nom").css("border-bottom","red 0.1em solid");
            }
            if(!regex.test(emailUsu) || emailUsu === ""){
                $(this).parent().siblings("td").find(".email").addClass("invalid");
                $(this).parent().siblings("td").find(".email").css("border-bottom","red 0.1em solid");
            }
            if(loginUsu === "" || loginUsu.length < 4){
                $(this).parent().siblings("td").find(".login").addClass("invalid");
                $(this).parent().siblings("td").find(".login").css("border-bottom","red 0.1em solid");
            }
            if(passUsu === "" || passUsu.length < 4){
                $(this).parent().siblings("td").find(".passUsu").addClass("invalid");
                $(this).parent().siblings("td").find(".passUsu").css("border-bottom","red 0.1em solid");
            }
        }
    
    });
    $("#dialog-UsuarioMod").dialog({
        autoOpen: false,
        closeText: "x",
        modal: true,
        show: { effect: "puff", duration: 500 },
        hide: { effect: "puff", duration: 500 }
    });

    //Inicilizar para componenetes dinámicos
    $('.tooltipped').tooltip({delay: 50});
    $('select').material_select();
    $('.modal-trigger').leanModal();
    $(".ui-dialog").css("box-shadow","0 0 5px black");



  
   
  
});//FIN READY
    

