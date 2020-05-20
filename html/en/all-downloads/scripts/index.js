let emailRequired = true;
$(document).ready(function () {

  let allPackageKeys = Object.keys(allPackagesDisplayNames);

  allPackageKeys.forEach(function(packageKey) {
    $("#all-downloads-list").append("<h2>" + allPackagesDisplayNames[packageKey] + "</h2><ul id='" + packageKey +"-list'></ul>");
  });
  for (let packageType in allPackages) {
    allPackages[packageType].forEach(function (pkg) {
      $("#" + packageType + "-list").append("<li><a l>" + pkg + "</a></li>")
    });
    let packageLinks = $("#" + packageType + "-list" + " li");
    for (let i = 0; i < packageLinks.length; i++) {
      $(packageLinks[i]).on('click', function () {
        if (emailRequired) {
          popup({
            width: '520px'
          }, "Download " + allPackagesDisplayNames[packageType] + " package", "<span style='margin-bottom:1rem;display:block;'>Enter your email in order to receive a download link.</span><form style='display:inline-block;' id='download-form'>        <input l placeholder='Email' style='margin-bottom:1rem' id='download-email-input' required pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\">        <button class='btn btn-primary' style='margin-bottom:1rem;' id='email-download'><span style='line-height:1;' class='sub-btn' id='downloadthis'>Download</span><div class='lds-ring sub-load'><div></div><div></div><div></div><div></div></div></button>      </form>");
          setTimeout(setupDownloadEmailForm('email-download', 'download-email-input', 'download-form', packageType, i), 400);
        } else {
          window.location = globalSiteRoot + 'download/download-new.php?pkg=' + packageType;
          bannerup("", "<span>" + "Thank you for downloading!" + "</span>");
        }
      });
    }
  }

});




function subscribeEmailDownload(email, formID, pkg, index = -1) {
  $("#" + formID + " .sub-load").css('display', 'inline-block');
  $("#" + formID + " .sub-btn").css('display', 'none');
  $.post(globalSiteRoot + 'assets/globalscripts/generatelink.php', {
    email: email,
    pkg: pkg,
    lang: siteLang,
    pkgIndex: index,
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

function setupDownloadEmailForm(button, input, form, pkg, index) {
  $("#" + button).on('click', function (e) {
    e.preventDefault(); //parse email. check for validity;

    var email = $("#" + input).val(); //what if they turn off javascript? lmao our site doesn't work then

    if (validateEmail(email)) {
      var res = subscribeEmailDownload(email, form, pkg, index);
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
