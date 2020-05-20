<!DOCTYPE html>
<html lang="en">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>About | TAOS Data</title>
  <meta name="description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Learn about the company here and the ideologies we abide by.">
  <meta name="keywords" content="TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, About, Team, Core Team, Core Values, Job openings, Jobs, Employment, Mission, Mission Statement">
  <meta name="title" content="About | TAOS Data">
  <meta property="og:site_name" content="TAOS Data" />
  <meta property="og:title" content="About | TAOS Data" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/about" />
  <meta property="og:description" content="TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Learn about the company here and the ideologies we abide by." />
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/about" />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link href="/styles/about/index.min.css" rel="stylesheet">
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
    $("#about-us-href").addClass('active');
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <section id='intro'>
        <h1 id='intro-title' style='text-align:left;margin-left:0;'>About</h1>
        <h2 b>About the Company</h2>
        <p>To address the technology challenges in the exponential growth of connected devices, TAOS Data is aimed at building a big data platform for Internet of Things (IoT). With a deep understanding of data characteristics of the IoT, TAOS Data has designed an innovative way to collect, store, compute, and analyze time-series data. Its flagship product, TDengine, outperforms other time-series databases by at least 10 times in terms of insert/query performance. </p>
        <p>TDengine’s kernel (storage and computing engine) and community edition are 100% open-sourced under the AGPL license. TAOS Data is fully committed to maintaining this open development model and believes that no software will win the market unless its core functionalities are fully open.</p>
        <p>TAOS Data’s mission is to make customer success by providing a full-stack IoT big data platform that reduces operational complexity and total cost of ownership. TAOS Data is backed by GGV Capital, Sequoia China, Future Capital, Yonghuiruijin Capital and Manzi Fund. It is headquartered in Beijing, with team members distributed across Beijing and California.</p>
        <h2 b>Team</h2>
        <p>We are direct, truthful, self-driven, and action-oriented. We focus on one thing and pay attention to details. We are curious, try things, break things and never stop learning from failures. We believe in open source and open collaboration.</p>
        <img src="team2.jpg" id='teamimage'>
        <p>If you like our core values, we would like to hear from you! </p>
        <br>
        <a class='anchor' id='contact'></a>
        <h2 b>Contact Us</h2>
        <ul>
        <li>Office: Suite 9-1912 Reward Building C, No.203 Section 2, Wangjing Lize Zhongyuan, Chaoyang, Beijing</li>
        <li>Business: <a l href='mailto:business@taosdata.com' target='_blank' class='url'>business@taosdata.com</a></li>
        <li>Talents: <a l href='mailto:hr@taosdata.com' target='_blank' class='url'>hr@taosdata.com</a></li>

        </ul>

      </section>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>