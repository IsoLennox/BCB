$(document).ready(function() {
 $("#username").keyup(function(e) {
   var username = $(this).val();
   var user_available = $("#username_result div.available");
   var taken = $("#username_result .taken");
   var needed = $("#username_result .need_username");

   $("#username_result").css("height","43px");

   if (username == "") {
     $(".available, .taken").fadeOut();
     $(".need_username").fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_username="+username,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           $(needed, taken).fadeOut();
           user_available.fadeIn();
         } else {
           $(user_available, needed).fadeOut();
           $(taken).fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready