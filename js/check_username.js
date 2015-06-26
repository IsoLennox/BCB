$(document).ready(function() {
 $("#username").keyup(function(e) {
   var username = $(this).val();
   var user_available = $("#username_result div.available");
   var taken = $("#username_result .taken");
   var needed = $("#username_result .need_username");

   $("#username_result").css("height","43px");

   if (username == "") {
     user_available.fadeOut();
     taken.fadeOut();
     needed.fadeIn();
   } else {
     $.ajax({
       url: "validation.php?new_username="+username,
       dataType: "text"}).done(function(available) {
         if (available == "valid") {
           taken.fadeOut();
           user_available.fadeIn();
         } else if (available == "taken") {
           taken.fadeIn();
         } //end else
     }); //end .done()
   } //end else
 }); //end keyup
}); //end document ready