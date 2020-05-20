var menuDisplayed = false;
var timerToToggleMenu;
var chosenLang;
$(document).ready(function () {
  setTimeout(function(){
    $(".siteloadbar").css("opacity",'0');
    $(".siteloadbar2").css("opacity",'0');
    setTimeout(function(){
      $(".siteloadbar2").css("display",'none');
      $(".siteloadbar").css("display",'none');
    },1000)
  },2100);
  /*
  window.onbeforeunload = function(){
  $(".siteloadbar2").css("display",'block');
  $(".siteloadbar").css("display",'block');
  $("#progressbars").css('opacity','1');
};
*/
  //Add hover support for drop down menus

  /*
  $(".dropdown").hover(function(){
    $(this).children()[1].classList.add("show");
  },function(){
    $(this).children()[1].classList.remove("show");
  });*/
  //bind enter for subscribe
  $("#email-input").on('focus', function () {
    $(document).off("keyup");
    $(document).keyup(function (e) {
      if (e.key == '"Enter') {
        $("#subscribe-email").click();
        return false;
      }
    });
  });
  $(document).keyup(function (e) {
    if (e.key === "Escape") {
      // escape key maps to keycode `27`
      popdown();
    }
  });
  $("#menu-button").on('click', function () {
    if (menuDisplayed === true && !$("#navbarSupportedContent").hasClass('collapsing')) {
      menuDisplayed = false;
      $("#page-cover").css('top', '-100vh');
      $("#menu-bar").css('display', 'block');
      $("#close-bar").css('display', 'none');
    } else if (menuDisplayed === false && !$("#navbarSupportedContent").hasClass('collapsing')) {
      menuDisplayed = true;
      $("#page-cover").css('top', '0px');
      $("#menu-bar").css('display', 'none');
      $("#close-bar").css('display', 'block');
    }
  });
  chosenLang = localStorage.getItem('taosdata.com-lang');

  console.log("L:" + chosenLang);

  if (chosenLang == null) {
    var userLang = navigator.language || navigator.userLanguage;
    chosenLang = userLang;
    
    //document.cookie = 'taosdata_lang=' + chosenLang.substr(0, 2) + '; expires=865562488911107';
    chosenLang = chosenLang.substr(0, 2);
    localStorage.setItem('taosdata.com-lang',chosenLang)
  }

  if (chosenLang.substr(0, 2) == 'zh') {//serve chinese page
    //setCookie('taosdata.com-lang', chosenLang, '9999999');
  } else {}

  $("#select-en").on('click', function () {
    //setCookie('taosdata_lang', 'en', '9999999');
    var replaced = window.location.href.substr(0, 30).replace(/cn/, 'en');
    window.location = replaced + window.location.href.substring(30, window.location.href.length);
    localStorage.setItem('taosdata.com-lang','en')
  });
  $("#select-cn").on('click', function () {
    var replaced = window.location.href.substr(0, 30).replace(/en/, 'cn');
    window.location = replaced + window.location.href.substring(30, window.location.href.length);
    localStorage.setItem('taosdata.com-lang','cn')
  });
  $(".wechat-social").on('click', function () {
    if (siteLang == "en"){
      popup({
        width: 'calc(100% - 40px)',
        max_width: '300px'
      }, "WeChat Account", '<img style="width:100%;" src="/assets/images/taosdataqrcode.png">');
    }
    else if (siteLang == "cn") {
      popup({
        width: 'calc(100% - 40px)',
        max_width: '300px'
      }, "微信公众号", '<img style="width:100%;" src="/assets/images/taosdataqrcode.png">');
    }
  });
  $("#subscribe-email").on('click', function (e) {
    e.preventDefault(); //parse email. check for validity;

    var email = $("#email-input").val(); //what if they turn off javascript? lmao our site doesn't work then

    if (validateEmail(email)) {
      var res = subscribeEmail(email, 'email-subscribe-form');
      $('#email-input').removeClass('invalid-input');
      $('#email-input').addClass('valid-input');
      document.getElementById('email-input').setCustomValidity('');
    } else {
      //console.log("Invalid email");
      document.getElementById('email-input').setCustomValidity('Invalid email');
      $('#email-input').addClass('invalid-input');
      document.getElementById('email-input').reportValidity();
      
    } //play animation while email result comes back;


    return false;
  });
  $("#email-input").on('keydown', function () {
    document.getElementById('email-input').setCustomValidity('');
  });
  // retrieve appropriate language announcement
  var excludedAnnouncementCategory = englishCategory;
  if (siteLang == 'en') {
    excludedAnnouncementCategory = chineseCategory;
  }
  fetch(wp_endpoint + 'wp-json/wp/v2/posts?categories=' + announcementCategory)
  .then(function(r){
    return r.json();
  })
  .then(function(r){
    if (r.length) {
      for (var i = 0; i < r.length; i++) {
        if (r[i].categories.indexOf(excludedAnnouncementCategory) == -1) {
          console.log(r[i].categories, excludedAnnouncementCategory)
          setAnnouncement(r[i]);
          break;
        }
      }
      
    }
  });
  
  
});

function setAnnouncement(announcement) {
  if (localStorage.getItem("lastClosedAnnouncementID") == announcement.id) {
    return;
  }
  var announcementContent = announcement.content.rendered;
  $("#announcement-wrapper").css("display", "block");
  $("#announcement-content").html(announcementContent);
  $(".content-wrapper").css("margin-top", "calc(4.6rem + 25px + 0.5rem)");
  $(".navbar").css("top", "calc(25px + 0.5rem)");
  $("#close-announcement").on('click', function() {
    removeAnnouncement(announcement);
  });
}
function removeAnnouncement(announcement) {
  $("#announcement-wrapper").css("display","none");
  $(".content-wrapper").css("margin-top", "4.6rem");
  $(".navbar").css("top", "0px");
  localStorage.setItem("lastClosedAnnouncementID", announcement.id);
}
function popup(options, title, html) {
  Object.keys(options).forEach(function (key) {
    var t = key.replace('_', '-');
    $("#popup").css(t, options[key]);
  });
  $("#popup-title").css('background-color', 'var(--b1)');
  $("#popup-title-text").text(title);
  $("#popup-content").html(html);
  $("#popup").css('display', 'block');
  $("#popup-page-cover").css('display', 'block');
  setTimeout(function () {
    $("#popup-page-cover").css('opacity', '1');
    $("#popup").css('opacity', '1');
  }, 50);
}

function popdown() {
  $("#popup-page-cover").css('opacity', '0');
  $("#popup").css('opacity', '0');
  setTimeout(function () {
    $("#popup").css('display', 'none');
    $("#popup-page-cover").css('display', 'none');
  }, 500);
}

var bannerID = 1;

function bannerup(options, html) {
  var id = bannerID;
  bannerID += 1;
  $(".banner-wrapper").append("<div class='banner' id='banner-" + id + "'><span class='close-banner' onclick='bannerdown(" + id + ")'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='32' height='32'><path fill='#fefefe' d='M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z' /></svg></span><div class='banner-content'></div></div>");
  $("#banner-" + id + " .banner-content").append(html);
}

function bannerdown(id) {
  $('#banner-' + id).remove();
}

function subscribeEmail(email, formID) {
  $("#" + formID + " .sub-load").css('display', 'inline-block');
  $("#" + formID + " .sub-btn").css('display', 'none');
  $.post(globalSiteRoot + 'assets/globalscripts/subscribe.php', {
    email: email,
    lang: siteLang
  }).done(function (data) {
    var res = JSON.parse(data)[0];

    if (res.status == 'wrong-email') {}

    bannerup("", "<span>" + res.message + "</span>");
    $("#" + formID + " .sub-btn").css('display', 'inline-block');
    $("#" + formID + " .sub-load").css('display', 'none');
  });
}

function validateEmail(email) {
  var re = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g;
  return re.test(email);
}