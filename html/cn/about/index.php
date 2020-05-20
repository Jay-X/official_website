<!DOCTYPE html>
<html lang="cn">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>关于 | 涛思数据</title>
  <meta name="description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine">
  <meta property="og:site_name" content="涛思数据 | TDengine"/>
  <meta name="title" content="关于 | 涛思数据">
  <meta property="og:site_name" content="涛思数据 | TDengine" />
  <meta property="og:title" content="关于 | 涛思数据" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/about" />
  <meta property="og:description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
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
        <h1 id='intro-title' style='text-align:left;margin-left:0;'>关于我们</h1>
        <h2 b>关于公司</h2>
        <p>北京涛思数据科技有限公司(TAOS Data) 瞄准日益增长的物联网数据市场，专注时序空间大数据的存储、查询、分析和计算。不依赖任何开源或第三方软件，开发了拥有自主知识产权、自主可控的高性能、可伸缩、高可靠、零管理的物联网大数据平台TDengine，可广泛运用于物联网、车联网、工业互联网、IT运维等领域。公司已经申请多项技术发明专利，且全部提交PCT专利申请。</p>
        <p>涛思数据采用AGPL许可证，已经将TDengine的内核(存储和计算引擎)以及社区版100%开源。涛思数据将尽最大努力打造开发者社区，维护这个开源的商业模式，相信不将最核心的代码开源，任何软件都将无法赢得市场。涛思数据希望通过开源，快速获得市场反馈，完善产品，完善生态，而且吸引更多的开发者加入到这个项目中。</p>
        <p>抱着给行业赋能，让客户成功的使命，涛思数据旨在通过技术创新，为物联网、工业互联网等行业提供全栈、高性能、低成本的大数据平台，创造出商业价值和社会价值。公司获得GGV纪源资本、红杉资本中国基金、永辉瑞金、明势资本、蛮子基金等多家机构的投资。公司总部设在北京，团队成员在北京和美国硅谷。</p>
        <h2 b>关于团队</h2>
        <p>公司创始人陶建辉在美国留学工作十多年后，回国创业，曾成功创办了“和信”与“快乐妈咪”两家高科技企业。公司研发团队全部毕业于中国科大、中国科学院、清华、上海交大、美国密歇根大学、马里兰大学等知名学府或机构，都拥有硕士或博士学历，在分布式计算、数据存储和数据库上有多年的研发经验。</p>
        <p>涛思数据团队直率、真诚、专注、注重细节、自我驱动而且目标导向。团队对世界始终保持好奇心，喜欢尝试、折腾，从不停止从失败中学习。拥抱开源，相信合作的力量。</p>
        <img src="team3.jpg" id='teamimage'>
        <p>如果你喜欢团队的价值观，欢迎加入！</p>
        <br>
        <h2 b>已获奖励</h2>
        <ul>
            <li>挚物·AIoT产业领袖榜单（2019-2020）AIoT成长企业榜TOP15</li>
            <li>2019中国大数据大会TOP10大数据应用最佳案例实践</li>
            <li>2019中关村国际前沿科技创新大赛总决赛季军</li>
            <li>2019中关村国际前沿科技创新大赛大数据与云计算TOP10</li>
            <li>2019世界物联网黑科技未来之星TOP20强</li>
            <li>CSDN 2019优秀物联网案例TOP30+</li>
            <li>2019 AWS AI Fusion Award 企业服务|潜力产品奖</li>
            <li>2019年星河奖最佳大数据产品奖</li>
            <li>2019(首届)全球工业互联网大会“全球工业互联网+智能制造大赛”总决赛优胜奖</li>
            <li>2019(首届)全球工业互联网大会“全球工业互联网+智能制造大赛”北京分站赛一等奖</li>
            <li>2018年朝阳区“凤凰计划”优秀海外学人初创企业自主资助</li>  
        </ul>
        <a class='anchor' id='contact'></a>
        <h2 b>联系我们</h2>
        <ul>
          <li>办公室：北京市朝阳区望京利泽中园二区203号洛娃大厦C座9层1912室</li>
          <li>商务合作：<a l href='mailto:business@taosdata.com'>business@taosdata.com</a></li>
          <li>人才招聘：点击了解 <a href="/<?php echo $lang?>/careers" l style="color:#4da0dd"><u>在招岗位</u></a></li>
        </ul>
      </section>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
