<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>文档 | 涛思数据</title><meta name='description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine'><meta name='title' content='文档 | 涛思数据'><meta property='og:site_name' content='涛思数据'/><meta property='og:title' content='文档 | 涛思数据'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connections-with-other-tools-ch/index.php'/><meta property='og:description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connections-with-other-tools-ch/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>与其他工具的连接</h1>
<a class='anchor' id='Telegraf'></a><h2>Telegraf</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connections%20with%20other%20Tools-ch.md#telegraf' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine能够与开源数据采集系统<a href="https://www.influxdata.com/time-series-platform/telegraf/">Telegraf</a>快速集成，整个过程无需任何代码开发。</p>
<a class='anchor' id='安装Telegraf'></a><h3>安装Telegraf</h3>
<p>目前TDengine支持Telegraf 1.7.4以上的版本。用户可以根据当前的操作系统，到Telegraf官网下载安装包，并执行安装。下载地址如下：https://portal.influxdata.com/downloads</p>
<a class='anchor' id='配置Telegraf'></a><h3>配置Telegraf</h3>
<p>修改Telegraf配置文件/etc/telegraf/telegraf.conf中与TDengine有关的配置项。 </p>
<p>在output plugins部分，增加[[outputs.http]]配置项： </p>
<ul>
<li>url：http://ip:6020/telegraf/udb，其中ip为TDengine集群的中任意一台服务器的IP地址，6020为TDengine RESTful接口的端口号，telegraf为固定关键字，udb为用于存储采集数据的数据库名称，可预先创建。</li>
<li>method: "POST" </li>
<li>username: 登录TDengine的用户名</li>
<li>password: 登录TDengine的密码</li>
<li>data_format: "json"</li>
<li>json_timestamp_units:      "1ms"</li>
</ul>
<p>在agent部分：</p>
<ul>
<li>hostname: 区分不同采集设备的机器名称，需确保其唯一性</li>
<li>metric_batch_size: 30，允许Telegraf每批次写入记录最大数量，增大其数量可以降低Telegraf的请求发送频率，但对于TDengine，该数值不能超过50</li>
</ul>
<p>关于如何使用Telegraf采集数据以及更多有关使用Telegraf的信息，请参考Telegraf官方的<a href="https://docs.influxdata.com/telegraf/v1.11/">文档</a>。</p>
<a class='anchor' id='Grafana'></a><h2>Grafana</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connections%20with%20other%20Tools-ch.md#grafana' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine能够与开源数据可视化系统<a href="https://www.grafana.com/">Grafana</a>快速集成搭建数据监测报警系统，整个过程无需任何代码开发，TDengine中数据表中内容可以在仪表盘(DashBoard)上进行可视化展现。</p>
<a class='anchor' id='安装Grafana'></a><h3>安装Grafana</h3>
<p>目前TDengine支持Grafana 5.2.4以上的版本。用户可以根据当前的操作系统，到Grafana官网下载安装包，并执行安装。下载地址如下：https://grafana.com/grafana/download。</p>
<a class='anchor' id='配置Grafana'></a><h3>配置Grafana</h3>
<p>TDengine的Grafana插件在安装包的/usr/local/taos/connector/grafana目录下。</p>
<p>以CentOS 7.2操作系统为例，将tdengine目录拷贝到/var/lib/grafana/plugins目录下，重新启动grafana即可。</p>
<a class='anchor' id='使用-Grafana'></a><h3>使用 Grafana</h3>
<h4>配置数据源</h4>
<p>用户可以直接通过 localhost:3000 的网址，登录 Grafana 服务器(用户名/密码:admin/admin)，通过左侧 <code>Configuration -&gt; Data Sources</code> 可以添加数据源，如下图所示：</p>
<p><img src="../assets/add_datasource1.jpg" alt="img" /></p>
<p>点击 <code>Add data source</code> 可进入新增数据源页面，在查询框中输入 TDengine 可选择添加，如下图所示：</p>
<p><img src="../assets/add_datasource2.jpg" alt="img" /></p>
<p>进入数据源配置页面，按照默认提示修改相应配置即可：</p>
<p><img src="../assets/add_datasource3.jpg" alt="img" /></p>
<ul>
<li>Host： TDengine 集群的中任意一台服务器的 IP 地址与 TDengine RESTful 接口的端口号(6020)，默认 http://localhost:6020。</li>
<li>User：TDengine 用户名。</li>
<li>Password：TDengine 用户密码。</li>
</ul>
<p>点击 <code>Save &amp; Test</code> 进行测试，成功会有如下提示：</p>
<p><img src="../assets/add_datasource4.jpg" alt="img" /></p>
<h4>创建 Dashboard</h4>
<p>回到主界面创建 Dashboard，点击 Add Query 进入面板查询页面：</p>
<p><img src="../assets/create_dashboard1.jpg" alt="img" /></p>
<p>如上图所示，在 Query 中选中 <code>TDengine</code> 数据源，在下方查询框可输入相应 sql 进行查询，具体说明如下：</p>
<ul>
<li>INPUT SQL：输入要查询的语句（该 SQL 语句的结果集应为两列多行），例如：<code>select avg(mem_system) from log.dn where  ts &gt;= $from and ts &lt; $to interval($interval)</code> ，其中，from、to 和 interval 为 TDengine插件的内置变量，表示从Grafana插件面板获取的查询范围和时间间隔。除了内置变量外，<code>也支持可以使用自定义模板变量</code>。</li>
<li>ALIAS BY：可设置当前查询别名。 </li>
<li>GENERATE SQL： 点击该按钮会自动替换相应变量，并生成最终执行的语句。</li>
</ul>
<p>按照默认提示查询当前 TDengine 部署所在服务器指定间隔系统内存平均使用量如下：</p>
<p><img src="../assets/create_dashboard2.jpg" alt="img" /></p>
<blockquote>
  <p>关于如何使用Grafana创建相应的监测界面以及更多有关使用Grafana的信息，请参考Grafana官方的<a href="https://grafana.com/docs/">文档</a>。</p>
</blockquote>
<h4>导入 Dashboard</h4>
<p>在 Grafana 插件目录 /usr/local/taos/connector/grafana/tdengine/dashboard/ 下提供了一个 <code>tdengine-grafana.json</code> 可导入的 dashboard。</p>
<p>点击左侧 <code>Import</code> 按钮，并上传 <code>tdengine-grafana.json</code> 文件：</p>
<p><img src="../assets/import_dashboard1.jpg" alt="img" /></p>
<p>导入完成之后可看到如下效果：</p>
<p><img src="../assets/import_dashboard2.jpg" alt="img" /></p>
<a class='anchor' id='Matlab'></a><h2>Matlab</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connections%20with%20other%20Tools-ch.md#matlab' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>MatLab可以通过安装包内提供的JDBC Driver直接连接到TDengine获取数据到本地工作空间。</p>
<a class='anchor' id='MatLab的JDBC接口适配'></a><h3>MatLab的JDBC接口适配</h3>
<p>MatLab的适配有下面几个步骤，下面以Windows10上适配MatLab2017a为例：</p>
<ul>
<li>将TDengine安装包内的驱动程序JDBCDriver-1.0.0-dist.jar拷贝到${matlab_root}\MATLAB\R2017a\java\jar\toolbox</li>
<li>将TDengine安装包内的taos.lib文件拷贝至${matlab_ root _dir}\MATLAB\R2017a\lib\win64</li>
<li>将新添加的驱动jar包加入MatLab的classpath。在${matlab_ root _dir}\MATLAB\R2017a\toolbox\local\classpath.txt文件中添加下面一行</li>
</ul>
<p>​          <code>$matlabroot/java/jar/toolbox/JDBCDriver-1.0.0-dist.jar</code></p>
<ul>
<li>在${user_home}\AppData\Roaming\MathWorks\MATLAB\R2017a\下添加一个文件javalibrarypath.txt, 并在该文件中添加taos.dll的路径，比如您的taos.dll是在安装时拷贝到了C:\Windows\System32下，那么就应该在javalibrarypath.txt中添加如下一行：</li>
</ul>
<p>​          <code>C:\Windows\System32</code></p>
<a class='anchor' id='在MatLab中连接TDengine获取数据'></a><h3>在MatLab中连接TDengine获取数据</h3>
<p>在成功进行了上述配置后，打开MatLab。</p>
<ul>
<li><p>创建一个连接：</p>
<p><code>conn = database(‘db’, ‘root’, ‘taosdata’, ‘com.taosdata.jdbc.TSDBDriver’, ‘jdbc:TSDB://127.0.0.1:0/’)</code></p></li>
<li><p>执行一次查询：</p>
<p><code>sql0 = [‘select * from tb’]</code></p>
<p><code>data = select(conn, sql0);</code></p></li>
<li><p>插入一条记录:</p>
<p><code>sql1 = [‘insert into tb values (now, 1)’]</code></p>
<p><code>exec(conn, sql1)</code></p></li>
</ul>
<p>更多例子细节请参考安装包内examples\Matlab\TDengineDemo.m文件。</p>
<a class='anchor' id='R'></a><h2>R</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connections%20with%20other%20Tools-ch.md#r' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>R语言支持通过JDBC接口来连接TDengine数据库。首先需要安装R语言的JDBC包。启动R语言环境，然后执行以下命令安装R语言的JDBC支持库：</p>
<pre><code class="R language-R">install.packages('rJDBC', repos='http://cran.us.r-project.org')</code></pre>
<p>安装完成以后，通过执行<code>library('RJDBC')</code>命令加载 <em>RJDBC</em> 包：</p>
<p>然后加载TDengine的JDBC驱动：</p>
<pre><code class="R language-R">drv&lt;-JDBC("com.taosdata.jdbc.TSDBDriver","JDBCDriver-1.0.0-dist.jar", identifier.quote="\"")</code></pre>
<p>如果执行成功，不会出现任何错误信息。之后通过以下命令尝试连接数据库：</p>
<pre><code class="R language-R">conn&lt;-dbConnect(drv,"jdbc:TSDB://192.168.0.1:0/?user=root&amp;password=taosdata","root","taosdata")</code></pre>
<p>注意将上述命令中的IP地址替换成正确的IP地址。如果没有任务错误的信息，则连接数据库成功，否则需要根据错误提示调整连接的命令。TDengine支持以下的 <em>RJDBC</em> 包中函数：</p>
<ul>
<li>dbWriteTable(conn, "test", iris, overwrite=FALSE, append=TRUE)：将数据框iris写入表test中，overwrite必须设置为false，append必须设为TRUE,且数据框iris要与表test的结构一致。</li>
<li>dbGetQuery(conn, "select count(*) from test")：查询语句</li>
<li>dbSendUpdate(conn, "use db")：执行任何非查询sql语句。例如dbSendUpdate(conn, "use db")， 写入数据dbSendUpdate(conn, "insert into t1 values(now, 99)")等。</li>
<li>dbReadTable(conn, "test")：读取表test中数据</li>
<li>dbDisconnect(conn)：关闭连接</li>
<li>dbRemoveTable(conn, "test")：删除表test</li>
</ul>
<p>TDengine客户端暂不支持如下函数：</p>
<ul>
<li>dbExistsTable(conn, "test")：是否存在表test</li>
<li>dbListTables(conn)：显示连接中的所有表</li>
</ul></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>