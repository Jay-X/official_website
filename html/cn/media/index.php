<?php
//Process GET for tag, category, name searches
$tags=$categories=$searchKey=$page="";
$page = 1;
if (isset($_GET['tags'])) {
  // $_GET['tags'] is an array;
  $tags = $_GET['tags'];
}
if (isset($_GET['search'])) {
  // $_GET['tags'] is an array;
  $searchKey = $_GET['search'];
}
if (isset($_GET['categories'])) {
  // $_GET['tags'] is an array;
  $categories = $_GET['categories'];
}
if (isset($_GET['page'])) {
  // $_GET['tags'] is an array;
  $page = $_GET['page'];
}

//Check if we can use our cache for certain uris
require("../../assets/globalscripts/db_connect.php");
$result = mysqli_query($db, "SELECT * FROM wp_wrc_caches WHERE (request_uri LIKE '/blog/wp-json/wp/v2/posts?%' OR request_uri LIKE '/blog/wp-json/wp/v2/users%' OR request_uri LIKE '/blog/wp-json/wp/v2/categories%') AND expiration >= '2000-10-25'");
$cached_links = array();
while ($row = mysqli_fetch_assoc($result)) {
  array_push($cached_links,$row['request_uri']);
}
$category_names = array();
if (isset($_GET['categories'])){
$stmt = $db->stmt_init();
$catarr = explode(",",$categories);
$q = "SELECT * FROM wp_terms WHERE term_id in ". '('. $categories.')';
$stmt->prepare($q);
$stmt->execute();

$result = $stmt->get_result();
while ($row = mysqli_fetch_assoc($result)) {
  array_push($category_names,$row['name']);
}
}
?>
<!DOCTYPE html>
<html lang="cn">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>媒体报道 | 涛思数据</title>
<meta name="description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine">
  <meta name="title" content="媒体报道 | TDengine">
  <meta property="og:site_name" content="涛思数据 | TDengine" />
  <meta property="og:title" content="媒体报道 | TDengine" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/media" />
  <meta property="og:description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/media"/>
  <link rel='stylesheet' href="/styles/media/index.css">
  <script>
    var cacheablearr = <?php echo json_encode($cached_links); ?>;
    //convert cacheable links to map for fast lookup
    var cacheable = {};
    cacheablearr.forEach(function(link){
      cacheable[link] = 1;
    });
  </script>
<script type="text/javascript">
    $(document).ready(function(){
      loadScript("scripts/index.js", function(){});
});
  </script>
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <h1 id='title'>媒体报道</h1>
      <div class='recent-news-wrapper'>
        
      </div>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>
</html>
