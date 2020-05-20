<!DOCTYPE html>
<html lang="cn">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>产品 | TDengine</title>
  <meta name="description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine">
  <meta name="title" content="产品 | TDengine">
  <meta property="og:site_name" content="涛思数据 | TDengine" />
  <meta property="og:title" content="产品 | TDengine" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/products" />
  <meta property="og:description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/products" />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link href="/styles/products/index.min.css" rel="stylesheet">
  <script>$(document).ready(function(){loadScript("scripts/index.js?v=3", function(){});});</script>
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
    $("#products-href").addClass('active');
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <h1>TDengine产品</h1>
      <section class='row section' id='products-display'>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#community-edition-link' id='community-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>社区版</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>免费，开源</li>
                <li class='good-feature'>轻量级，含所有核心功能</li>
              </ul>
            </div>
          </a>
        </div>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#enterprise-edition-link' id='enterprise-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>企业版</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>高可靠，线性扩展</li>
                <li class='good-feature'>7*24小时专业技术服务</li>
              </ul>
            </div>
          </a>
        </div>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#cloud-edition-link' id='cloud-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>云服务版</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>全自动，零管理</li>
                <li class='good-feature'>运营商级的大数据服务</li>
              </ul>
            </div>
          </a>
        </div>
      </section>
      <a class='anchor' id='community-edition-link'></a>
      <section class='row section product-section-wrapper ' id='community-edition'>
        <div class='product-section'>
          <h2>社区版</h2>
          <p>TDengine社区版是一开源版本，采用的是AGPL许可证，是一个处理中小规模的物联网数据平台。它具备高效处理物联网数据所需要的所有功能，包括:</p>
          <ul>
            <li>类SQL查询语言来插入或查询数据</li>
            <li>支持C/C++, Java(JDBC), Python, Go, RESTful, and Node.JS 等开发接口</li>
            <li>通过TDengine Shell或Python/R/Matlab可做各种Ad Hoc查询分析</li>
            <li>通过连续查询，支持基于滑动窗口的流式计算</li>
            <li>引入超级表，让设备之间的数据聚合通过标签变得简单、灵活</li>
            <li>内嵌消息队列，应用可订阅最新的数据</li>
            <li>内嵌缓存机制，每台设备的最新状态或记录都可快速获得</li>
            <li>无历史数据与实时数据之分，对应用而言，透明且完全一样</li>
            <li>安装包仅1.5M，从下载到成功运行仅仅几秒的时间</li>
          </ul>
          <a href="../getting-started/#Quick Start"><button class='btn btn-primary' style='margin-right:0.5rem;margin-bottom:0.5rem;'>快速上手</button></a>
          <a href="https://github.com/taosdata/TDengine" target="_blank"><button class='btn btn-primary' style='margin-bottom:0.5rem;'>Goto GitHub</button></a>
        </div>
      </section>
      <a class='anchor' id='enterprise-edition-link'></a>
      <section class='row section product-section-wrapper ' id='enterprise-edition'>
        <div class='product-section'>
          <h2>企业版</h2>
          <p>TDengine企业版是一个运营商级别的分布式版本，它具备超高的可靠性，超强的水平扩展能力，以应对大数据的挑战。除社区版所有功能外，它还有如下功能：</p>
          <ul>
            <li>线性扩展能力，以保证任何规模的数据量都可以处理</li>
            <li>无单点故障，高可靠，以保证运营商级的服务</li>
            <li>内嵌数据实时同步，可跨机房将数据实时复制到不同节点</li>
            <li>支持多级存储，方便可靠的前提下，进一步降低存储成本</li>
            <li>提供可视化的管理工具，让运维更加简单</li>
            <li>支持更多的工业数据接口以及更多的第三方工具</li>
            <li>7*24的专业技术支持</li>
          </ul>
          <!--<a id='download-free-trial'><button class='btn btn-primary' style='margin-right:0.5rem;margin-bottom:0.5rem;'>下载试用版</button></a>-->
          <a class='contact-sales'><button class='btn btn-primary' style='margin-bottom:0.5rem;'>联系销售</button></a>
        </div>
      </section>
      <a class='anchor' id='cloud-edition-link'></a>
      <section class='row section product-section-wrapper ' id='cloud-edition'>
        <div class='product-section'>
          <h2>云服务版</h2>
          <p>TDengine云服务版是将TDengine企业版运行公有云上，具备弹性伸缩、零管理的特点，通过专业的技术服务团队，提供运营商级的物联网大数据平台服务。</p>
          <ul>
            <li>鼠标简单一点，即可扩容，以应对数据量的高速增长</li>
            <li>零管理，再也没有系统安装、部署、维护的烦恼</li>
            <li>从管理后台，可以查看运行状态、使用情况，以及各种统计</li>
            <li>按月按使用量付费，中小企业的理想选择</li>
            <li>7*24小时专业技术服务</li>
          </ul>
          <a href="https://marketplace.huaweicloud.com/product/OFFI454488918838128640" target="_blank"><button class='btn btn-primary' style='margin-bottom:0.5rem;'>快速体验</button></a>
        </div>
      </section>
      <a class='anchor' id='roadmap'></a>
      <h2 b>产品路线图</h2>
      <ul>
        <li>支持事件驱动的流计算</li>
        <li>支持用户自定义函数</li>
        <li>支持MQTT接口</li>
        <li>支持OPC接口</li>
        <li>支持Hadoop, Spark连接器</li>
        <li>支持Tableau和其他BI工具</li>
      </ul>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
