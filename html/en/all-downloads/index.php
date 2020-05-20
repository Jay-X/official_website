<?php
  require $_SERVER['DOCUMENT_ROOT'].'/assets/hidden/packages.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>Downloads | Taos Data</title>
  <meta name="description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT.">
  <meta name="keywords" content="TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things, TAOS Data">
  <meta name="title" content="Downloads | Taos Data">
  <meta property="og:site_name" content="Taos Data" />
  <meta property="og:title" content="Downloads | Taos Data" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/all-downloads/index.php" />
  <meta property="og:description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT." />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/all-downloads/index.php" />
  <link rel='stylesheet' href='/lib/docs/docs.min.css'>
  <script src="scripts/index.js"></script>
</head>
<script>
  var allPackages = <?php echo json_encode($allPackagesNames); ?>;
  var allPackagesDisplayNames = <?php echo json_encode($packagesDisplayNames); ?>;
</script>
<style>
  .documentation a {
    color: var(--b2) !important;
  }
</style>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper documentation'>
      <h1>All Downloads</h1>
      <p>This page contains download links to all versions of TDengine server and client <a href="#tdengine_beta-list">beta version</a>，<a href="#tdengine_tar-list">Tarball</a>, <a href="#tdengine_rpm-list">RPM</a>, <a href="#tdengine_deb-list">Deb</a>, and <a href="#tdengine_win-list">Windows Client</a>, <a href="#tdengine_win-list">Linux Client</a> packages.</p>
      <div id="all-downloads-list">
      </div>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
