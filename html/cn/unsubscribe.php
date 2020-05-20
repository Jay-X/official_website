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
<html lang="cn">
<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>取消订阅 | 涛思数据</title>
  <meta name="description" content="TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine">
  <meta name="title" content="取消订阅 | 涛思数据">
  <meta property="og:site_name" content="涛思数据" />
  <meta property="og:title" content="取消订阅 | 涛思数据" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/unsubscribe.php" />
  <meta property="og:description" content="TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
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
      <h1>取消订阅了 :(</h1>
      <?php  } else { ?>
      <h1>Error occured :(</h1>
      <?php }?>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>
</html>