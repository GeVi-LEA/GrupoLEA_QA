$(document).ready(function () {
  $.backstretch(
    [
      "assets/img/login2.jpg",
      "assets/img/login3.jpg",
      "assets/img/login4.jpg",
      "assets/img/login5.jpg",
      "assets/img/login6.jpg",
      "assets/img/login7.jpg",
      "assets/img/login8.jpg",
    ],
    { duration: 6000, fade: 1000 }
  );

  $("#formularioLogin").submit(function (e) {
    if ($("#user").val() === "" || $("#password").val() === "") {
      e.preventDefault();
      $.confirm({
        title: "¡Atención!",
        content: "<b>Usuario/password</b> no pueden estar vacios.",
        type: "red",
        typeAnimated: true,
        animation: "zoom",
        closeAnimation: "right",
        backgroundDismiss: false,
        backgroundDismissAnimation: "shake",
        buttons: {
          tryAgain: {
            text: "Aceptar",
            btnClass: "btn btn-danger",
            action: function () {
              if ($("#user").val() === "") {
                $("#user").addClass("required");
              }
              if ($("#password").val() === "") {
                $("#password").addClass("required");
              }
            },
          },
        },
      });
    } else if ($("#passwordConfirm").length > 0) {
      if ($("#passwordConfirm").val() !== $("#password").val()) {
        e.preventDefault();
        $.confirm({
          title: "¡Atención!",
          content: "<b>Password</b> no coinciden.",
          type: "red",
          typeAnimated: true,
          animation: "zoom",
          closeAnimation: "right",
          backgroundDismiss: false,
          backgroundDismissAnimation: "shake",
          buttons: {
            tryAgain: {
              text: "Aceptar",
              btnClass: "btn btn-danger",
              action: function () {
                $("#passwordConfirm").addClass("required");
                $("#password").addClass("required");
              },
            },
          },
        });
      }
    }
  });

  $("#user, #password, #passwordConfirm ").click(function () {
    $(this).removeClass("required");
  });
});
