<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>快速上手 | TDengine</title><meta name='description' content='是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine'><meta name='title' content='快速上手 | TDengine'><meta property='og:site_name' content='涛思数据 | TDengine'/><meta property='og:title' content='快速上手 | TDengine'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><meta property='og:description' content='是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script><script>$(document).ready(function(){loadScript('scripts/index.js?v=2', function(){});});</script></head><body><?php include($s.'/header.php'); ?><script>$('#getting-started-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>立即开始</h1>
<a class='anchor' id='快速上手'></a><h2>快速上手</h2>
<p>TDengine软件分为服务器和客户端两部分，服务器部分taosd目前仅能在Linux系统上安装和运行，客户端仅能在Linux或Windows上运行。如果应用需要在Mac上运行，只能使用TDengine的RESTful接口连接服务器。用户可根据需求选择通过<a href="#通过源码安装">源码</a>或者<a href="#通过安装包安装">安装包</a>来安装。</p>
<a class='anchor' id='通过源码安装'></a><h3>通过源码安装</h3>
<p>请参考我们的<a href="https://github.com/taosdata/TDengine">TDengine github主页</a>下载源码并安装.</p>
<a class='anchor' id='通过安装包安装'></a><h3>通过安装包安装</h3>
<p>服务器部分，我们提供三种安装包，请选择你所需要的。TDengine的安装非常简单，从下载到安装成功仅仅只要几秒钟。</p>
<ul id='packageList'>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/hidden/packages.php'; ?>
<li><a id='tdengine-rpm' style='color:var(--b2)'><?php echo $packagesNames['tdengine_rpm']; ?> (5.3M) </a></li>
<li><a id='tdengine-deb' style='color:var(--b2)'><?php echo $packagesNames['tdengine_deb']; ?> (2.5M)</a></li>
<li><a id='tdengine-tar' style='color:var(--b2)'><?php echo $packagesNames['tdengine_tar']; ?> (5.3M)</a></li>
</ul>
客户端部分，Windows和Linux安装包如下：
<ul>
<li><a id='tdengine-linux' style='color:var(--b2)'><?php echo $packagesNames['tdengine_linux']; ?> (3.4M)</a></li>
<li><a id='tdengine-win' style='color:var(--b2)'><?php echo $packagesNames['tdengine_win']; ?> (2.3M)</a></li>
</ul>
AARCH32 Linux安装包如下：
<ul>
<li><a id='tdengine-server-aarch32' style='color:var(--b2)'><?php echo $packagesNames['tdengine_server_aarch32']; ?> (1.9M)</a></li>
<li><a id='tdengine-server-aarch32-lite' style='color:var(--b2)'><?php echo $packagesNames['tdengine_server_aaarch32_lite']; ?> (1.2M)</a></li>
<li><a id='tdengine-client-aarch32' style='color:var(--b2)'><?php echo $packagesNames['tdengine_client_aarch32']; ?> (1.0M)</a></li>
<li><a id='tdengine-client-aarch32-lite' style='color:var(--b2)'><?php echo $packagesNames['tdengine_client_aaarch32_lite']; ?> (0.9M)</a></li>
</ul>
<p>如果想下载最新beta版及之前版本的安装包，请点击<a href="../all-downloads/">这里</a></p>
<p>目前，TDengine只支持在使用<a href="https://en.wikipedia.org/wiki/Systemd"><code>systemd</code></a>做进程服务管理的linux系统上安装。其他linux系统的支持正在开发中。用<code>which</code>命令来检测系统中是否存在<code>systemd</code>:</p>
<pre><code class="cmd language-cmd">which systemd</code></pre>
<p>如果系统中不存在<code>systemd</code>命令，请考虑<a href="#通过源码安装">通过源码安装</a>TDengine。</p>
<a class='anchor' id='启动并体验TDengine'></a><h2>启动并体验TDengine</h2>
<p>服务器程序安装成功后，用户可使用<code>systemctl</code>命令来启动TDengine的服务进程。</p>
<pre><code class="cmd language-cmd">systemctl start taosd</code></pre>
<p>检查服务是否正常工作。</p>
<pre><code class="cmd language-cmd">systemctl status taosd</code></pre>
<p>如果TDengine服务正常工作，那么您可以通过TDengine的命令行程序<code>taos</code>来访问并体验TDengine。</p>
<p><strong>注：<em>systemctl</em> 命令需要 <em>root</em> 权限来运行，如果您非 <em>root</em> 用户，请在命令前添加 <em>sudo</em></strong></p>
<a class='anchor' id='TDengine命令行程序'></a><h2>TDengine命令行程序</h2>
<p>执行TDengine命令行程序，您只要在Linux终端执行<code>taos</code>即可</p>
<pre><code class="cmd language-cmd">taos</code></pre>
<p>如果TDengine终端链接服务成功，将会打印出欢迎消息和版本信息。如果失败，则会打印错误消息出来（请参考<a href="https://www.taosdata.com/cn/faq/">FAQ</a>来解决终端链接服务端失败的问题）。如果不在TDengine服务器上运行taos, 需要安装有TDengine客户端程序，而且使用-h命令行参数来指定服务器IP地址。TDengine终端的提示符号如下：</p>
<pre><code class="cmd language-cmd">taos&gt;</code></pre>
<p>在TDengine终端中，用户可以通过SQL命令来创建/删除数据库、表等，并进行插入查询操作。在终端中运行的SQL语句需要以分号结束来运行。示例：</p>
<pre><code class="mysql language-mysql">create database db;
use db;
create table t (ts timestamp, speed int);
insert into t values ('2019-07-15 00:00:00', 10);
insert into t values ('2019-07-15 01:00:00', 20);
select * from t;
          ts          |   speed   |
===================================
 19-07-15 00:00:00.000|         10|
 19-07-15 01:00:00.000|         20|
Query OK, 2 row(s) in set (0.001700s)</code></pre>
<p>除执行SQL语句外，系统管理员还可以从TDengine终端检查系统运行状态，添加删除用户账号等。</p>
<a class='anchor' id='命令行参数'></a><h3>命令行参数</h3>
<p>您可通过配置命令行参数来改变TDengine终端的行为。以下为常用的几个命令行参数：</p>
<ul>
<li>-c, --config-dir: 指定配置文件目录，默认为<em>/etc/taos</em></li>
<li>-h, --host: 指定服务的IP地址，默认为本地服务</li>
<li>-s, --commands: 在不进入终端的情况下运行TDengine命令</li>
<li>-u, -- user:  链接TDengine服务器的用户名，缺省为root</li>
<li>-p, --password: 链接TDengine服务器的密码，缺省为taosdata</li>
<li>-?, --help: 打印出所有命令行参数</li>
</ul>
<p>示例：</p>
<pre><code class="cmd language-cmd">taos -h 192.168.0.1 -s "use db; show tables;"</code></pre>
<a class='anchor' id='运行SQL命令脚本'></a><h3>运行SQL命令脚本</h3>
<p>TDengine终端可以通过<code>source</code>命令来运行SQL命令脚本.</p>
<pre><code>taos&gt; source &lt;filename&gt;;</code></pre>
<p>我们在目录“/tests/examples/bash/”下面提供了一个示例脚本“demo.sql",您可以直接将"filename"替换为我们的示例脚本快速尝试一下。 </p>
<a class='anchor' id='Shell小技巧'></a><h3>Shell小技巧</h3>
<ul>
<li>可以使用上下光标键查看已经历史输入的命令</li>
<li>修改用户密码。在shell中使用alter user命令</li>
<li>ctrl+c 中止正在进行中的查询</li>
<li>执行<code>RESET QUERY CACHE</code>清空本地缓存的表的schema</li>
</ul>
<a class='anchor' id='TDengine-极速体验'></a><h2>TDengine 极速体验</h2>
<p>启动TDengine的服务，在Linux终端执行taosdemo </p>
<pre><code>&gt; taosdemo</code></pre>
<p>该命令将在数据库test下面自动创建一张超级表meters，该超级表下有1万张表，表名为"t0" 到"t9999"，每张表有10万条记录，每条记录有 （f1, f2， f3）三个字段，时间戳从"2017-07-14 10:40:00 000" 到"2017-07-14 10:41:39 999"，每张表带有标签areaid和loc, areaid被设置为1到10, loc被设置为"beijing"或者“shanghai"。</p>
<p>执行这条命令大概需要10分钟，最后共插入10亿条记录。</p>
<p>在TDengine客户端输入查询命令，体验查询速度。</p>
<ul>
<li>查询超级表下记录总条数：</li>
</ul>
<pre><code>taos&gt;select count(*) from test.meters;</code></pre>
<ul>
<li>查询10亿条记录的平均值、最大值、最小值等：</li>
</ul>
<pre><code>taos&gt;select avg(f1), max(f2), min(f3) from test.meters;</code></pre>
<ul>
<li>查询loc="beijing"的记录总条数：</li>
</ul>
<pre><code>taos&gt;select count(*) from test.meters where loc="beijing";</code></pre>
<ul>
<li>查询areaid=10的所有记录的平均值、最大值、最小值等：</li>
</ul>
<pre><code>taos&gt;select avg(f1), max(f2), min(f3) from test.meters where areaid=10;</code></pre>
<ul>
<li>对表t10按10s进行平均值、最大值和最小值聚合统计：</li>
</ul>
<pre><code>taos&gt;select avg(f1), max(f2), min(f3) from test.t10 interval(10s);</code></pre>
<p>Note: taosdemo命令本身带有很多选项，配置表的数目、记录条数等等，请执行 <code>taosdemo --help</code>详细列出。您可以设置不同参数进行体验。</p>
<a class='anchor' id='主要功能'></a><h2>主要功能</h2>
<p>TDengine的核心功能是时序数据库。除此之外，为减少研发的复杂度、系统维护的难度，TDengine还提供缓存、消息队列、订阅、流式计算等功能。更详细的功能如下：</p>
<ul>
<li>使用类SQL语言用插入或查询数据</li>
<li>支持C/C++, Java(JDBC), Python, Go, RESTful, and Node.JS 开发接口</li>
<li>可通过Python/R/Matlab or TDengine shell做Ad Hoc查询分析</li>
<li>通过定时连续查询支持基于滑动窗口的流式计算</li>
<li>使用超级表来更灵活高效的聚合多个时间线的数据</li>
<li>时间轴上聚合一个或多个时间线的数据</li>
<li>支持数据订阅，一旦有新数据，就立即通知应用</li>
<li>支持缓存，每个时间线或设备的最新数据都从内存里快速获取</li>
<li>历史数据与实时数据处理完全透明，不用区别对待</li>
<li>支持链接Telegraf, Grafana等第三方工具</li>
<li>成套的配置和工具，让你更好的管理TDengine </li>
</ul>
<p>对于企业版，TDengine还提供如下高级功能：</p>
<ul>
<li>线性水平扩展能力，以提供更高的处理速度和数据容量</li>
<li>高可靠，无单点故障，提供运营商级别的服务</li>
<li>多个副本自动同步，而且可以跨机房</li>
<li>多级存储，让历史数据处理的成本更低</li>
<li>用户友好的管理后台和工具，让管理更轻松简单 </li>
</ul>
<p>TDengine是专为物联网、车联网、工业互联网、运维监测等场景优化设计的时序数据处理引擎。与其他方案相比，它的插入查询速度都快10倍以上。单核一秒钟就能插入100万数据点，读出1000万数据点。由于采用列式存储和优化的压缩算法，存储空间不及普通数据库的1/10.</p>
<a class='anchor' id='深入了解TDengine'></a><h2>深入了解TDengine</h2>
<p>请继续阅读<a href="../documentation">文档</a>来深入了解TDengine。</p></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>
