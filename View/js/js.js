/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
     $(".button-collapse").sideNav();
//DIALOG BUTTONS
  $(".ui-button").addClass("btn");

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
$('.tooltipped').tooltip({delay: 50});
  $('select').material_select();
      $(".ui-dialog").css("box-shadow","0 0 5px black");


});
jQuery.extend(jQuery.validator.messages, {
  required: "Requerido",
  remote: "Por favor, rellena este campo.",
  email: "Por favor, escribe una dirección de correo válida",
  url: "Por favor, escribe una URL válida.",
  date: "Por favor, escribe una fecha válida.",
  dateISO: "Por favor, escribe una fecha (ISO) válida.",
  number: "Número entero válido.",
  digits: "Por favor, escribe sólo dígitos.",
  creditcard: "Por favor, escribe un número de tarjeta válido.",
  equalTo: "Por favor, escribe el mismo valor de nuevo.",
  accept: "Por favor, escribe un valor con una extensión aceptada.",
  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
});
jQuery.extend(jQuery.validator.setDefaults({
    focusInvalid: false,
    errorClass: "invalid",
    validClass: "valid",
}));
//Para que las tareas aparezcan hide de inicio
//DIALOG
$(".ui-dialog").css("z-index","100");

//LOGIN
$("#dialog-login").dialog({
    autoOpen: false,
    closeText: "x",
    modal: true,
    show: { effect: "puff", duration: 500 },
    hide: { effect: "puff", duration: 500 },
    buttons: {
        "Entrar": function () {
            
            $.post("indexController.php", {
                user: $("#user").val(),
                pass: $("#pass").val(),
                ACTION: "LOGEAR"
            }).done(function (data) {
                if(data === "true"){
                    window.location="../Controller/presentacionController.php";
                }else {
                    $("#user").addClass("invalid");
                    $("#pass").addClass("invalid");
                }
            });
            $("#user").val("");
            $("#pass").val("");

        },
        Cancelar: function () {
            $(this).dialog("close");
            $("#user").removeClass("invalid");
            $("#pass").removeClass("invalid");
        }
    }
});
$(document).on("click", "#login", function () {
    $("#dialog-login").dialog("open");
});

//CERRAR SESIÓN
$("#dialog-cierreSession").dialog({
    autoOpen: false,
    closeText: "x",
    modal: true,
    show: { effect: "puff", duration: 500 },
    hide: { effect: "puff", duration: 500 },
    buttons: {
        "Cerrar Sesión": function () {
            window.location="../Controller/indexController.php";
        }
    }
});
$(document).on("click", "#login", function () {
    $("#dialog-cierreSession").dialog("open");
});
