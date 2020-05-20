<?php 
$success = false;
if (isset($_GET['email']) && isset($_GET['key'])){
  ob_start();
  $s=$_SERVER['DOCUMENT_ROOT'];
  require $s.'/assets/globalscripts/db_connect.php';
  
  if (!$db) {
    exit("[{\"status\":\"Connection Failed\",\"message\":\"Something went wrong with our server, we apologize...\"}]");
  }

  $unsubHash = $_GET['key'];
  
  $email = $_GET['email'];
  $rowC = 0;
  // Instantiation and passing `true` enables exceptions
  if($stmt1 = $db->prepare('SELECT id FROM user_data WHERE email=? AND unsubscribeHash=?')) {
    if (!$stmt1->bind_param('ss', $email,$unsubHash)) {
      echo "Bind error";
    }
    if(!$stmt1->execute()){
      echo "Error";
    }
    $result = $stmt1->get_result();
    if (!$result) {
      echo("[{\"status\":\"Selection Failed\",\"message\":\"Something went wrong, we apologize...\"}]");
    }
    else {
      $rowC = mysqli_num_rows($result);
      echo $rowC;
    }
  }
  else {
    echo("[{\"status\":\"Query Failed\",\"message\":\"Something went wrong, we were unable to subscribe your email. Try using the exact unsubscribe link given in the email\"}]");
  }
  if ($rowC == 0){
    exit("[{\"status\":\"Incorrect Link\",\"message\":\"Something went wrong, we were unable to subscribe your email. Try using the exact unsubscribe link given in the email\"}]");
  }
  else {
    //exists, then do update
    if (!($stmt = $db->prepare("UPDATE user_data SET subscribed=0 WHERE email=?"))) {
      //exit("Prep update failed");
    }
    if (!$stmt->bind_param("s", $email)) {
      //exit("Binding update failed");
    }
    if (!$stmt->execute()) {
      //exit("Execute update failed");
    }
    else {
      $success = true;
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>Unsubscribe | Taos Data</title>
  <meta name="description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT.">
  <meta name="keywords" content="TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things, TAOS Data">
  <meta name="title" content="Unsubscribe | Taos Data">
  <meta property="og:site_name" content="Taos Data" />
  <meta property="og:title" content="Unsubscribe | Taos Data" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/unsubscribe.php" />
  <meta property="og:description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT." />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/unsubscribe.php"/>
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <?php if ($success == true) { ?>
      <h1>Unsubscribed :(</h1>
      <?php  } else { ?>
      <h1>Error occured :(</h1>
      <?php }?>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>
</html>