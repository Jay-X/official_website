var emailRequired = true;
$(document).ready(function () {
  $("#tdengine-rpm").on('click', function () {
    setupPackageDownload("TDengine RPM", "tdengine_rpm");
  });
  $("#tdengine-deb").on('click', function () {
    setupPackageDownload("TDengine DEB", "tdengine_deb");
  });
  $("#tdengine-tar").on('click', function () {
    setupPackageDownload("TDengine Tarball", "tdengine_tar");
  });
  // attach the package download event to clicking the element with tag tdengine-win
  $("#tdengine-win").on('click', function () {
    setupPackageDownload("TDengine Windows", "tdengine_win");
  });
  $("#tdengine-linux").on('click', function () {
    setupPackageDownload("TDengine Linux", "tdengine_linux");
  });  
  $("#tdengine-server-aarch32").on('click', function () {
    setupPackageDownload("TDengine Server Linux AARCH32", "tdengine_server_aarch32");
  });  
  $("#tdengine-server-aarch32-lite").on('click', function () {
    setupPackageDownload("TDengine Server Linux AARCH32 Lite", "tdengine_server_aarch32_lite");
  });
  $("#tdengine-client-aarch32").on('click', function () {
    setupPackageDownload("TDengine Client Linux AARCH32", "tdengine_client_aarch32");
  });
  $("#tdengine-client-aarch32-lite").on('click', function () {
    setupPackageDownload("TDengine Client Linux AARCH32 Lite", "tdengine_client_aarch32_lite");
  });  
  $("#tdengine-alert-linux").on('click', function () {
    setupPackageDownload("TDengine Alert Linux", "tdengine_alert_linux")
  });
  $("#tdengine-alert-windows").on('click', function () {
    setupPackageDownload("TDengine Alert Windows", "tdengine_alert_windows")
  });  
});

// display name is the name of the package shown to the user
// package tag is the name of the key stored in packages.php
function setupPackageDownload(displayName, packageTag) {
  if (emailRequired) {
    popup({width:'520px'},"Download " + displayName + " package","<span style='margin-bottom:1rem;display:block;'>Enter your email in order to receive a download link.</span><form style='display:inline-block;' id='download-form'>        <input l placeholder='Email' style='margin-bottom:1rem' id='download-email-input' required pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\">        <button class='btn btn-primary' style='margin-bottom:1rem;' id='email-download'><span style='line-height:1;' class='sub-btn' id='downloadthis'>Download</span><div class='lds-ring sub-load'><div></div><div></div><div></div><div></div></div></button>      </form>");
    setTimeout(setupDownloadEmailForm('email-download', 'download-email-input', 'download-form', packageTag),400);
  }
  else {
    window.location = globalSiteRoot + 'download/download-new.php?pkg=' + packageTag;
    bannerup("", "<span>" + "Thank you for downloading!" + "</span>");
  }
}

function subscribeEmailDownload(email, formID, pkg) {
  $("#" + formID + " .sub-load").css('display', 'inline-block');
  $("#" + formID + " .sub-btn").css('display', 'none');
  $.post(globalSiteRoot + 'assets/globalscripts/generatelink.php', {
    email: email,
    pkg: pkg,
    lang: siteLang
  }).done(function (data) {
    var res = false;

    try {
      res = JSON.parse(data)[0];
    } catch (err) {
      console.log(data);
      bannerup("", "<span>" + "Sorry, we couldn't process your request due to a server issue for　the time being, we are fixing this issue soon.</span>");
      $("#" + formID + " .sub-btn").css('display', 'inline-block');
      $("#" + formID + " .sub-load").css('display', 'none');
      return;
    }

    if (res.status == 'wrong-email') {}

    console.log(res);
    bannerup("", "<span>" + res.message + "</span>");
    $("#" + formID + " .sub-btn").css('display', 'inline-block');
    $("#" + formID + " .sub-load").css('display', 'none');
  });
}

function setupDownloadEmailForm(button, input, form, pkg) {
  $("#" + button).on('click', function (e) {
    e.preventDefault(); //parse email. check for validity;

    var email = $("#" + input).val(); //what if they turn off javascript? lmao our site doesn't work then

    if (validateEmail(email)) {
      var res = subscribeEmailDownload(email, form, pkg);
      $('#' + input).removeClass('invalid-input');
      $('#' + input).addClass('valid-input');
      document.getElementById(input).setCustomValidity('');
    } else {
      document.getElementById(input).setCustomValidity('Invalid email');
      $('#' + input).addClass('invalid-input');
      document.getElementById(input).reportValidity();
    } //play animation while email result comes back;


    return false;
  });
  $(document).keypress(function (e) {
    $(document).off("keypress");

    if (e.which == 13) {
      $("#" + button).click();
      return false;
    }
  });
  $("#" + input).on('keydown', function () {
    document.getElementById(input).setCustomValidity('');
  });
}
