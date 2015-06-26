$(document).ready(function() {
 $("#email").keyup(function(e) {
   var email = $(this).val();
   var email_available = $("#email_result div.available");
   var taken = $("#email_result .taken");
   var needed = $("#email_result .need_email");

   $("#email_result").css("height","43px");

   if (email == "") {
     taken.fadeOut();
     email_available.fadeOut();
     needed.fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_email="+email,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           taken.fadeOut();
           email_available.fadeIn();
         } if (available == "taken") {
           taken.fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready