<!DOCTYPE html>
<html lang="en">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>Products | TDengine</title>
  <meta name="description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Find in-depth information about the various products offered by Taos Data and how to get started with using one of the fastest and scalable big data platforms in the world.">
  <meta name="keywords" content="TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Products, efficient">
  <meta name="title" content="Products | TAOS Data">
  <meta property="og:site_name" content="TAOS Data" />
  <meta property="og:title" content="Products | TAOS Data" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/products" />
  <meta property="og:description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Find in-depth information about the various products offered by Taos Data and how to get started with using one of the fastest and scalable big data platforms in the world." />
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
      <h1>TDengine Products</h1>
      <section class='row section' id='products-display'>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#community-edition-link' id='community-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>Community Edition</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>Free, Open Sourced</li>
                <li class='good-feature'>Light Weight ...</li>
              </ul>
            </div>
          </a>
        </div>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#enterprise-edition-link' id='enterprise-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>Enterprise Edition</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>Highly Available</li>
                <li class='good-feature'>Linearly Scalable ...</li>
              </ul>
            </div>
          </a>
        </div>
        <div class='col-xl-4 product-wrapper'>
          <a class='product' href='#cloud-edition-link' id='cloud-edition-mini'>
            <h2 class='product-title'><span class='tdengine'>TDengine</span><span style='font-size:0.8em;'>Cloud Edition</span></h2>
            <div class='features-wrapper'>
              <ul class='features'>
                <li class='good-feature'>Fully automated</li>
                <li class='good-feature'>Zero Management</li>
              </ul>
            </div>
          </a>
        </div>
      </section>
      <a class='anchor' id='community-edition-link'></a>
      <section class='row section product-section-wrapper ' id='community-edition'>
        <div class='product-section'>
          <h2>Community Edition</h2>
          <p>TDengine Community Edition is the open-source version and is available under the AGPL license. It is an ideal platform to process small to medium scale data set. It has all the core features required to process IoT data efficiently, including:</p>
          <ul>
            <li>SQL like query language is used to insert or explore data</li>
            <li>C/C++, Java(JDBC), Python, Go, RESTful, and Node.JS interfaces are supported</li>
            <li>Ad hoc queries/analysis via integrated Python/R/Matlab or TDengine shell</li>
            <li>Continuous queries to support sliding-window based stream computing</li>
            <li>Super table to aggregate multiple time-streams efficiently with flexibility </li>
            <li>Built-in messaging system to support publisher/subscriber model</li>
            <li>Built-in cache for each time stream to make latest data available as fast as light speed</li>
            <li>Handling of historical data and real-time data is made transparent and is the same </li>
            <li>Package is only 1.5M, it takes just a few seconds from download to run it successfully </li>
          </ul>
          <a href="../getting-started/#Quick Start"><button class='btn btn-primary' style='margin-right:0.5rem;margin-bottom:0.5rem;'>Quickstart</button></a>
          <a href="https://github.com/taosdata/TDengine" target="_blank"><button class='btn btn-primary' style='margin-bottom:0.5rem;'>Goto GitHub</button></a>
        </div>
      </section>
      <a class='anchor' id='enterprise-edition-link'></a>
      <section class='row section product-section-wrapper ' id='enterprise-edition'>
        <div class='product-section'>
          <h2>Enterprise Edition</h2>
          <p>TDengine Enterprise Edition is the carrier-grade distributed version to meet the big data challenges with uncompromising scalability, uptime and agility. Besides the features in the community edition, it has the most comprehensive set of advanced features, including:</p>
          <ul>
            <li>Linear scalability to guarantee that a high volume of data can be processed </li>
            <li>High availability to deliver the carrier-grade service </li>
            <li>Built-in replication between nodes which may span multiple geographical sites </li>
            <li>Multi-tier storage to make historical data management simpler and cost-effective</li>
            <li>Web-based management tools and other tools to make maintenance simpler</li>
            <li>More industry data interface and third-party tools are supported </li>
            <li>7*24 professional service </li>
          </ul>
          <a class='contact-sales'><button class='btn btn-primary' style='margin-right:0.5rem;margin-bottom:0.5rem;'>Contact Sales</button></a>
        </div>
      </section>
      <a class='anchor' id='cloud-edition-link'></a>
      <section class='row section product-section-wrapper ' id='cloud-edition'>
        <div class='product-section'>
          <h2>Cloud Edition</h2>
          <p>TDengine Cloud Service is built on TDengine Enterprise Edition and runs on AWS/Aliyun. It delivers the elastic scalability and reduces the complexity of deploying and managing the TDengine platform. With the professional support team, it provides the carrier-grade service.</p>
          <ul>
            <li>Scale the processing power to meet data growth by a simple click</li>
            <li>Zero management, no annoyance for deployment and operations </li>
            <li>Check the running status, usage, and statistics from the user-friendly web site</li>
            <li>Pay monthly, cost-effective, ideal for small to medium size enterprise</li>
            <li>7*24 professional service </li>
          </ul>
           <a href="https://marketplace.huaweicloud.com/product/OFFI454488918838128640" target="_blank"><button class='btn btn-primary' style='margin-bottom:0.5rem;'>Quick Start</button></a>
          <!--a class='contact-sales'><button class='btn btn-primary' style='margin-right:0.5rem;margin-bottom:0.5rem;'>Contact Sales</button></a>-->
        </div>
      </section>
      <a class='anchor' id='roadmap'></a>
      <h2 b>Product  Roadmap</h2>
      <ul>
        <li>Support event-driven stream computing</li>
        <li>Support user defined functions</li>
        <li>Support MQTT connection</li>
        <li>Support OPC connection</li>
        <li>Support Hadoop and Spark connections</li>
        <li>Support Tableau and other BI tools</li>
      </ul>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
