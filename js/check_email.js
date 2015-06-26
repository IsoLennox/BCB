$(document).ready(function() {
 $("#email").keyup(function(e) {
   var email = $(this).val();

   $("#email_result").css("height","43px");

   if (email == "") {
     $(".available, .taken").fadeOut();
     $(".need_email").fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_email="+email,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           $(".need_email, .taken").fadeOut();
           $("div.available").fadeIn();
         } else {
           $(".available, .need_email").fadeOut();
           $("div.taken").fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready