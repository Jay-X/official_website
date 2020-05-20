<?php
  require $_SERVER['DOCUMENT_ROOT'].'/assets/hidden/packages.php';
?>
<!DOCTYPE html>
<html lang="cn">
<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>下载 | Taos Data</title>
  <meta name="description" content="TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine">
  <meta name="title" content="下载 | 涛思数据">
  <meta property="og:site_name" content="涛思数据" />
  <meta property="og:title" content="下载 | 涛思数据" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/all-downloads" />
  <meta property="og:description" content="TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/all-downloads" />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
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
      <h1>所有下载链接</h1>
      <p>这个页面包含TDengine Server和Client的最新<a href="#tdengine_beta-list">beta版本</a>，所有<a href="#tdengine_tar-list">Tarball</a>, <a href="#tdengine_rpm-list">RPM</a>, <a href="#tdengine_deb-list">Deb</a>, 以及 <a href="#tdengine_win-list">Windows Client</a>, <a href="#tdengine_linux-list">Linux Client</a>安装包的版本。</p>
      <div id="all-downloads-list">
      </div>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
