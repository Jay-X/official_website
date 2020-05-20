$(document).ready(function(){
  $("#support-subscribe").on('click', function(e){
    e.preventDefault();
    //parse email. check for validity;
    let email = $("#support-input").val();
    
    //what if they turn off javascript? lmao our site doesn't work then
    if (validateEmail(email)){
      subscribeEmail(email,'support-subscribe-form');
      $('#support-input').removeClass('invalid-input');
      $('#support-input').addClass('valid-input');
      document.getElementById('support-input').setCustomValidity('');
    }
    else {
      console.log("Invalid email");
      document.getElementById('support-input').setCustomValidity('电子邮件不正确'); 
      $('#support-input').addClass('invalid-input');
      document.getElementById('support-input').reportValidity()
    }
    //play animation while email result comes back;
    return false;
  });
  $("#support-input").on('focus', function () {
    $(document).off("keypress")
    $(document).keypress(function (e) {
      if (e.which == 13) {
        $("#support-subscribe").click();
        return false;
      }
    });
  });
  $("#support-input").on('keydown', function(){
    document.getElementById('support-input').setCustomValidity(''); 
  });
})