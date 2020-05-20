
$(function(){
	$(".advice").on('click', function(){
    popup({width: '520px'}, "联系销售", "<span style='margin-bottom:0.5rem;display:block;'>请填写信息与我们业务人员直接联系</span><form style='display:inline-block;' id='contact-sales-form'>        <input l placeholder='姓名' class='name' required><input l plain placeholder='公司名' class='company'><input l placeholder='邮件' style='margin-bottom:0.5rem' id='contact-sales-email-input' required pattern=\"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\"><input l plain placeholder='手机号' class='phone'><textarea placeholder='留言...' l class='message' required></textarea>        <button class='btn btn-primary' style='margin-bottom:0.5rem;' id='contact-sales'><span style='line-height:1;' class='sub-btn' id='downloadthis'>提交</span><div class='lds-ring sub-load'><div></div><div></div><div></div><div></div></div></button>      </form>");
    
    setTimeout(function () {
        setupContactSales('contact-sales', 'contact-sales-form', 'contact-sales-email-input');
    },400);
  });


});


function setupContactSales(button, form, emailInput) {
  $("#" + button).on('click', function (e) {
    e.preventDefault();
    //parse email. check for validity;
    let email = $("#" + emailInput).val();

    if ($("#" + form + " .name").val() == "") {
      let ele = $("#" + form + " .name");
      $('#' + form + " .name").addClass('invalid-input');
      ele[0].setCustomValidity('请输入你的名字');
      ele[0].reportValidity();
      return false;
    }
    else {
      $("#" + form + " .name").removeClass('invalid-input');
    }
    if (validateEmail(email)) {
      $('#' + emailInput).removeClass('invalid-input');
      $('#' + emailInput).addClass('valid-input');
      document.getElementById(emailInput).setCustomValidity('');

    } else {
      document.getElementById(emailInput).setCustomValidity('电子邮件不正确');
      $('#' + emailInput).addClass('invalid-input');
      document.getElementById(emailInput).reportValidity()
      return false;
    }

    if ($("#" + form + " .message").val() == "") {
      let ele = $("#" + form + " .message");
      ele.addClass('invalid-input');
      ele[0].setCustomValidity('请留言');
      ele[0].reportValidity();
      return false;
    }
    else {
      let ele = $("#" + form + " .message");
      ele.removeClass('invalid-input');
    }
    let res = contactSales(form);
    //play animation while email result comes back;
    return false;
  });
  $(document).keyup(function (e) {
    if (e.which == 'Enter') {
      $("#" + button).click();
      return false;
    }
  });
  $("#" + emailInput).on('keydown', function () {
    document.getElementById(emailInput).setCustomValidity('');
  });
}

function contactSales(form) {
  let name = $("#" + form + " .name").val();
  let cmp = $("#" + form + " .company").val();
  let msg = $("#" + form + " .message").val();
  let phone = $("#" + form + " .phone").val();
  let email = $("#" + form + " #contact-sales-email-input").val();
  let message = "<h1>" +name + " wishes to contact sales</h1><p>Email: " + email + "</p>";
  $("#" + form + " .sub-load").css('display', 'inline-block');
  $("#" + form + " .sub-btn").css('display', 'none');
  if (phone != "") {
    message += "<p>Phone: " + phone + "</p>";
  }
  if (cmp != "") {
    message += "<p>Company: " + cmp + "</p>";
  }
  message += "<p>Their message:</p><p>" + msg + "</p>";
  $.post(globalSiteRoot + 'assets/globalscripts/email.php', {
    from: 'support@taosdata.com',
    fromname: email,
    to: 'jhtao@taosdata.com',
    subject: '联系销售',
    message:message,
    successmsg:"成功联系销售",
    errormsg:"抱歉，暂时联系不到销售"
  }).done(function (data) {
    let res = JSON.parse(data)[0];
    console.log(res);
    bannerup("", "<span>" + res.message + "</span>")
    $("#" + form + " .sub-btn").css('display', 'inline-block');
    $("#" + form + " .sub-load").css('display', 'none');
    if (res.status=='success'){
    $.post(globalSiteRoot + 'assets/globalscripts/email.php', {
      from: 'support@taosdata.com',
      fromname: '涛思数据技术支持',
      to: email,
      subject: '联系销售确认',
      message:'<h1>成功联系到销售</h1><p>您的留言:</p><p>' +msg +'</p>'
    });
    }
  });
}

