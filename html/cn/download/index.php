<!DOCTYPE html>
<html lang="en">
<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>Download | Taos Data</title>
  <meta name="description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Download TDengine here!">
  <meta name="keywords" content="TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, download">
  
  <meta name="title" content="Download | Taos Data">
  <meta property="og:site_name" content="Taos Data" />
  <meta property="og:title" content="Download | Taos Data" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/download" />
  <meta property="og:description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Download TDengine here!" />
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/download"/>
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link rel="stylesheet" href="styles/index.css">
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <h1>Download TDengine</h1>
      <p>Enter your email below and click the button to receive an email with the download link for TDengine.</p>
      <form style='display:inline;' id='download-form'>
        <input l placeholder="Email" style='margin-bottom:1rem' id='download-email-input' required pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?">
        <button class='btn btn-primary' style='margin-bottom:1rem;' id='email-download'><span style='line-height:1;' class='sub-btn'>Receive Download Link</span><div class='lds-ring sub-load'><div></div><div></div><div></div><div></div></div></button>
      </form>
    </main>
  </div>
  <script>
    
    $("#email-download").on('click', function(e){
    e.preventDefault();
    //parse email. check for validity;
    let email = $("#download-email-input").val();
    
    //what if they turn off javascript? lmao our site doesn't work then
    if (validateEmail(email)){
      subscribeEmailDownload(email, 'download-form');
      $('#download-email-input').removeClass('invalid-input');
      $('#download-email-input').addClass('valid-input');
      document.getElementById('download-email-input').setCustomValidity(''); 
    }
    else {
      console.log("Invalid email");
      document.getElementById('download-email-input').setCustomValidity('Invalid email'); 
      $('#download-email-input').addClass('invalid-input');
      document.getElementById('download-email-input').reportValidity()
    }
    //play animation while email result comes back;
    return false;
  })
  $("#download-email-input").on('keydown', function(){
    document.getElementById('download-email-input').setCustomValidity(''); 
  });
  </script>
  <?php include($s.'/footer.php'); ?>
</body>
</html>