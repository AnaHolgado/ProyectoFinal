$(document).ready(function () {
//PROGRAMADORES
    $(document).on("click", "#ALTAUSUARIO", function () {
        if($("#catUsuAlt").parents("td").find($(".select-dropdown")).val() === "Categoría"){
            $("#catUsuAlt").parents("td").find($(".select-dropdown")).addClass("invalid");
            $("#catUsuAlt").parents("td").find($(".select-dropdown")).css("border-bottom","red 0.1em solid");
        }
        if($("#permisoUsuAlt").parents("td").find($(".select-dropdown")).val() === "Permiso"){
            $("#permisoUsuAlt").parents("td").find($(".select-dropdown")).addClass("invalid");
            $("#permisoUsuAlt").parents("td").find($(".select-dropdown")).css("border-bottom","red 0.1em solid");
        }
        if ($("#formUsuAlta").valid() && $("#catUsuAlt").parents("td").find($(".select-dropdown")).val() !== "Categoría" && $("#permisoUsuAlt").parents("td").find($(".select-dropdown")).val() !== "Permiso") {
            $.post("usuarioController.php", {
                nomUsu: $("#nomUsuAlt").val(),
                catUsu: $("#catUsuAlt option:selected").val(),
                emailUsu: $("#emailUsuAlt").val(),
                permisoUsu: $("#permisoUsuAlt option:selected").val(),
                loginUsu: $("#loginUsuAlt").val(),
                passUsu: $("#passUsuAlt").val(),
                ACTION: "ALTA"

            }).done(function (data) {
                $("#listadoUsuarios").html(data);
                //Limpiar fomularios
                $("#nomUsuAlt").val("");
                $("#nomUsuAlt").parent().siblings("td").find("input").val("");            
                $("#nomUsuAlt").parent().siblings("td").find("select").val("-1");
                $(".material-tooltip").remove();
            });
        } 
    });
    $("#catUsuAlt, #permisoUsuAlt").on("change", function(){
        if($("#catUsuAlt").parents("td").find($(".select-dropdown")).val() !== "Categoría"){
            $("#catUsuAlt").parents("td").find($(".select-dropdown")).addClass("valid");
            $("#catUsuAlt").parents("td").find($(".select-dropdown")).css("border-bottom","green 0.1em solid");
        }
        if($("#permisoUsuAlt").parents("td").find($(".select-dropdown")).val() !== "Permiso"){
            $("#permisoUsuAlt").parents("td").find($(".select-dropdown")).addClass("valid");
            $("#permisoUsuAlt").parents("td").find($(".select-dropdown")).css("border-bottom","green 0.1em solid");
        }else {
            
        }
    });
//VALIDACIONES
  $("#formUsuAlta").validate({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
    rules: {
      nomUsu: {
        required: true,
      },
      emailUsuAlt:{
          required: true,
          email: true
      },
      catUsuAlt: {
          required: true,
          number: false
      },
      loginUsuAlt: {
          required: true,
          minlength:4,
          maxlength: 10
      },
      passUsuAlt: {
          required: true,
          minlength:4,
          maxlength:10
      }
    },
    messages: {
      nomUsu: {
        required: "<span class='red-text'>Requerido</span>",
      },
      emailUsuAlt:{
          required: "<span class='red-text'>Requerido</span>",
          email:"<span class='red-text'>No es un mail valido</span>",
      },
      catUsuAlt: {
          required: "<span class='red-text'>Requerido</span>",
      },
      loginUsuAlt: {
          required: "<span class='red-text'>Requerido</span>",
          minlength:"<span class='red-text'>Mínimo 4 caracteres</span>",
          maxlength: "<span class='red-text'>Máximo 10 caracteres</span>",
      },
      passUsuAlt: {
          required: "<span class='red-text validate'>Requerido</span>",
          minlength:"<span class='red-text'>Mínimo 4 caracteres</span>",
          maxlength:"<span class='red-text'>Máximo 10 caracteres</span>",
      }
    },
    submitHandler: function(){
        
    }
  });
    
    //CLIENTES
$(".dropdown-button").dropdown();
  $(document).on("click", "#btnAltaCli", function () {
    if ($("#formCliAlta").valid()){
      $.post("clienteController.php", {
      nomempCli: $("#nomempCliAlta").val(),
      tlfCli: $("#tlfCliAlta").val(),
      emailCli: $("#emailCliAlta").val(),
      nomconCli: $("#nomconCliAlta").val(),
      ACTION: "ALTA"
    }).done(function (data) {
        $("#listadoClientes").html(data);
        //Limpiar fomularios
        $("#nomempCliAlta").val("");
        $("#nomempCliAlta").parent().siblings("td").find("input").val("");
        $(".material-tooltip").remove();
    }).fail(function () {
        alert("ERROR");
    });
 }
  });
  
  //VALIDACIONES
  $("#formCliAlta").validate({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
    rules: {
      nomempCli: {
        required: true,
      },
      emailCli:{
          required: true,
          email: true
      },
      tlfCli: {
          required: true,
          digits: true,
          minlength: 9,
          maxlength: 9
      },
      nomconCli: {
          required: true,
      }
    },
    messages: {
      nomempCli: {
        required: "<span class='red-text'>Requerido</span>",
      },
      emailCli:{
          required: "<span class='red-text'>Requerido</span>",
          email:"<span class='red-text'>No es un mail valido</span>",
      },
      tlfCli: {
          required: "<span class='red-text'>Requerido</span>",
          digits: "<span class='red-text'>Sólo números</span>",
          minlength: "<span class='red-text'>9 dígitos</span>",
          maxlength: "<span class='red-text'>9 digitos</span>",
      },
      nomconCli: {
          required: "<span class='red-text'>Requerido</span>",
          minlength:"<span class='red-text'>Mínimo 4 caracteres</span>",
          maxlength: "<span class='red-text'>Máximo 10 caracteres</span>",
      }
    },
    submitHandler: function(){
        
    }
  });
  
//ALTA PROYECTOS

$(document).on("click", "#ALTA", function () {
    if($("#fasePro").parents("td").find($(".select-dropdown")).val() === "Fase"){
        $("#fasePro").parents("td").find($(".select-dropdown")).addClass("invalid");
        $("#fasePro").parents("td").find($(".select-dropdown")).css("border-bottom","red 0.1em solid");
    }
    if($("#codCli").parents("td").find($(".select-dropdown")).val() === "Cliente"){
        $("#codCli").parents("td").find($(".select-dropdown")).addClass("invalid");
        $("#codCli").parents("td").find($(".select-dropdown")).css("border-bottom","red 0.1em solid");
    }
    if ($("#formProAlta").valid() && $("#fasePro").parents("td").find($(".select-dropdown")).val() !== "Fase" && $("#codCli").parents("td").find($(".select-dropdown")).val() !== "Cliente") {
        $.post("proyectoController.php", {
            nomPro: $("#nomPro").val(),
            fechfinPro: $("#fechfinPro").val(),
            fasePro: $("#fasePro option:selected").val(),
            codCli: $("#codCli option:selected").val(),
            ACTION: "ALTA"
        }).done(function (data) {
            $("#listadoProyecto").html(data);
            //Limpiar fomularios
            $("#nomPro").val("");
            $("#nomPro").parent().siblings("td").find("input").val("");            
            $("#nomPro").parent().siblings("td").find("select").val("-1");
            $(".material-tooltip").remove();
        });
    }
});
//VALIDACIONES
  $("#formProAlta").validate({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
    rules: {
      nomPro: {
        required: true,
      },
      fechfinPro:{
        required: true,
      }
    },
    messages: {
      nomPro: {
        required: "<span class='red-text'>Requerido</span>",
      },
      fechfinPro: {
          required: "<span class='red-text'>Requerido</span>",
      }
    },
    submitHandler: function(){
        
    }
  });
  
  
//REQUISITOS
    $(document).on("click", "#ALTAREQ", function () {
        if($("#estReqAlta").parents("td").find($(".select-dropdown")).val() === "Fase"){
            $("#estReqAlta").parents("td").find($(".select-dropdown")).addClass("invalid");
            $("#estReqAlta").parents("td").find($(".select-dropdown")).css("border-bottom","red 0.1em solid");
        }
        if ($("#formReqAlta").valid() && $("#estReqAlta").parents("td").find($(".select-dropdown")).val() !== "Fase") {
            $.post("requisitoController.php", {
                desReqAlta: $("#desReqAlta").val(),
                estReqAlta: $("#estReqAlta").val(),
                codPro: $("h5 span").text(),
                ACTION: "ALTA"
            }).done(function (data) {
                $("#listado").html(data);
                $("#desReqAlta").val("");
                $("#desReqAlta").parent().siblings("td").find("select").val("-1");
                $(".material-tooltip").remove();
            });
        }
    });
    //VALIDACIONES
  $("#formReqAlta").validate({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
    rules: {
      desReqAlta: {
        required: true,
      },
      estReqAlta:{
        required: true,
      }
    },
    messages: {
      desReqAlta: {
        required: "<span class='red-text'>Requerido</span>",
      },
      estReqAlta: {
          required: "<span class='red-text'>Requerido</span>",
      }
    },
    submitHandler: function(){
    }
  });


//ALTA TAREA
    $(document).on("click", ".ALTATAREA", function () {
        if($(this).parent().siblings("td").find("#estTarAlta").val() === null){
            $(this).parents("tr").find(".filaEstado input").addClass("invalid");
            $(this).parents("tr").find(".filaEstado input").css("border-bottom","red 0.1em solid");
        }
        if($(this).parent().siblings("td").find("#usuTarAlta").val() === null){
            $(this).parents("tr").find(".filaUsuario input").addClass("invalid");
            $(this).parents("tr").find(".filaUsuario input").css("border-bottom","red 0.1em solid");
        }
    if($(this).parents("form").valid() && $(this).parent().siblings("td").find("#estTarAlta").val() !== null && $(this).parent().siblings("td").find("#usuTarAlta").val() !== null){
        $.post("requisitoController.php", {
            codReq: $(this).val(),
            desTar: $(this).parent().siblings("td").find("#desTarAlta").val(),
            estadoTar: $(this).parent().siblings("td").find("#estTarAlta").val(),
            horPreTar: $(this).parent().siblings("td").find("#horPreTarAlta").val(),
            ordTar: $(this).parent().siblings("td").find("#ordTarAlta").val(),
            codUsu: $(this).parent().siblings("td").find("#usuTarAlta").val(),
            codPro: $("h5 span").text(),
            ACTION: "ALTATAREA"
        }).done(function (data) {
            $("#listado").html(data);
            $(".material-tooltip").remove();
        });
    }
    
//VALIDACIONES
  jQuery.validator.setDefaults({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
  });
});
    
    });//FIN READY
    
  