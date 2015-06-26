$(document).ready(function() {
 $("#email").keyup(function(e) {
   var email = $(this).val();

   $("#email_result").css("height","43px");

   if (email == "") {
     $("#email_result .available, #email_result .taken").fadeOut();
     $(".need_email").fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_email="+email,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           $(".need_email, #email_result .taken").fadeOut();
           $("#email_result div.available").fadeIn();
         } else {
           $("#email_result .available, .need_email").fadeOut();
           $("#email_result div.taken").fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready