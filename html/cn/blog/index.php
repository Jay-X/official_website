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
  <title>博客 | TDengine</title>
  <meta name="description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine">
  <meta name="title" content="博客 | TDengine">
  <meta property="og:site_name" content="涛思数据 | TDengine"/>
  <meta property="og:title" content="博客 | TDengine"/>
  <meta property="og:type" content="article"/>
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/blog"/>
  <meta property="og:description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。"/>
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/blog"/>
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link href="/styles/blog/index.min.css" rel="stylesheet">
  <script type="application/javascript">
    /*
    var js_posts = <?php echo json_encode($posts_array); ?>;
    var js_authors = <?php echo json_encode($post_authors); ?>;
    var js_allCatsArr = <?php echo json_encode($allCategories); ?>;
    var js_allCats = {};

    for (let i =0; i < js_allCatsArr.length; i++) {
      js_allCats[js_allCatsArr[i].term_id] = js_allCatsArr[i];
    }
    
    
    var js_avatars = <?php echo json_encode($avatars); ?>;
    js_posts = js_posts.map((a,i) => {
      a['avatar_url'] = js_avatars[i];
      return a;
    })
    */
    var cacheablearr = <?php echo json_encode($cached_links); ?>;
    //convert cacheable links to map for fast lookup
    var cacheable = {};
    cacheablearr.forEach(function(link){
      cacheable[link] = 1;
    });
    var js_tags = "<?php echo $tags; ?>";
    var js_categories = "<?php echo $categories; ?>";
    var js_searchKey = "<?php echo $searchKey; ?>";
    var js_page = "<?php echo $page; ?>";
    var js_categories_names = <?php echo json_encode($category_names); ?>;
    
  </script>
    <script type="text/javascript">
    $(document).ready(function(){
      loadScript("/lib/fetch.min.js", function(){});
loadScript("<?php echo $path ?>blog/scripts/post.js", function(){});
loadScript("scripts/blog.js?v=3", function(){});
});
  </script>
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <h1 id='title'>Blog</h1>
      <div class='searchBar'>
        <input placeholder="Search..." id='searchKey'><button class='btn btn-primary' onclick="search()">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width='22' height="22"><path d="M337.509 305.372h-17.501l-6.571-5.486c20.791-25.232 33.922-57.054 33.922-93.257C347.358 127.632 283.896 64 205.135 64 127.452 64 64 127.632 64 206.629s63.452 142.628 142.225 142.628c35.011 0 67.831-13.167 92.991-34.008l6.561 5.487v17.551L415.18 448 448 415.086 337.509 305.372zm-131.284 0c-54.702 0-98.463-43.887-98.463-98.743 0-54.858 43.761-98.742 98.463-98.742 54.7 0 98.462 43.884 98.462 98.742 0 54.856-43.762 98.743-98.462 98.743z"/></svg>
        </button>
      </div>
      <div id='title-divider'>
      </div>
      <section class='row'>
        <div id='posts-list-wrapper' class='col-lg-9' style='margin-top:1rem;'>
          <div id='posts-list'>
            <div class='blank-placeholder-posts'>

              <div class='post'>
                <div class='post-title-blank blank'></div>
                <br>
                <img src="/assets/images/defaultavatar.jpg" class='post-author-avatar'>
                <div class='post-meta'>
                  <div class='post-author blank'></div>
                  <br>
                  <div class='post-time blank'></div>
                  <div class='post-tags blank'></div>
                </div>
                <div class='post-desc blank'></div>
                <div class='blank' style='width: 100px; height:1.2em;margin-top:0.4em'></div>
              </div>
              <div class='post'>
                <div class='post-title-blank blank'></div>
                <br>
                <img src="/assets/images/defaultavatar.jpg" class='post-author-avatar'>
                <div class='post-meta'>
                  <div class='post-author blank'></div>
                  <br>
                  <div class='post-time blank'></div>
                  <div class='post-tags blank'></div>
                </div>
                <div class='post-desc blank'></div>
                <div class='blank' style='width: 100px; height:1.2em;margin-top:0.4em'></div>
              </div>
              <div class='post'>
                <div class='post-title-blank blank'></div>
                <br>
                <img src="/assets/images/defaultavatar.jpg" class='post-author-avatar'>
                <div class='post-meta'>
                  <div class='post-author blank'></div>
                  <br>
                  <div class='post-time blank'></div>
                  <div class='post-tags blank'></div>
                </div>
                <div class='post-desc blank'></div>
                <div class='blank' style='width: 100px; height:1.2em;margin-top:0.4em'></div>
              </div>
              <div class='post'>
                <div class='post-title-blank blank'></div>
                <br>
                <img src="/assets/images/defaultavatar.jpg" class='post-author-avatar'>
                <div class='post-meta'>
                  <div class='post-author blank'></div>
                  <br>
                  <div class='post-time blank'></div>
                  <div class='post-tags blank'></div>
                </div>
                <div class='post-desc blank'></div>
                <div class='blank' style='width: 100px; height:1.2em;margin-top:0.4em'></div>
              </div>
            </div>
            <?php if (isset($_GET['search'])) { ?>
            <h3 style='overflow:hidden;text-overflow: ellipsis;'>搜索结果: "<?php echo $_GET['search'];?>"</h3>
            <?php } ?>
          </div>
          <div id='pagination'></div>
        </div>
          <div id='rightbar' class='col-lg-3'>
            <div class='tags-list' style='margin-bottom:0.8rem;'>
              <h3 style='line-height:1.5;font-weight:400;font-size:1.2em;'>选择类别</h3>
            </div>
            <form class='long-form' id='long-email-subscribe-form'>
              <h3 style='font-size:1.2em;line-height:1.4;font-weight:400;'>订阅产品更新</h3>
              <input placeholder="邮件" l style='margin-bottom:-1px;border-radius:0.25rem;margin-bottom:0.5rem;' id='long-email' required pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?">
              <button class='btn btn-primary' style='width:100%;' id='long-form-submit'><span class='sub-btn' style='line-height:1;'>订阅</span><div class='lds-ring sub-load' style='padding-top:0;'><div></div><div></div><div></div><div></div></div></button>
              <div style='font-size:0.8em;line-height:1.4;'>通过订阅我的电子邮件,我承认我已阅读了<a style='line-height:1.4' l href="/<?php echo $lang; ?>/privacy">隐私政策</a>。</div>
            </form>
          </div>
      </section>

    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
