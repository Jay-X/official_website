<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>文档 | 涛思数据</title><meta name='description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine'><meta name='title' content='文档 | 涛思数据'><meta property='og:site_name' content='涛思数据'/><meta property='og:title' content='文档 | 涛思数据'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/administrator-ch/index.php'/><meta property='og:description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/administrator-ch/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>系统管理</h1>
<a class='anchor' id='文件目录结构'></a><h2>文件目录结构</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#文件目录结构' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>安装TDengine的过程中，安装程序将在操作系统中创建以下目录或文件：</p>
<figure><table>
<thead>
<tr>
<th>目录/文件</th>
<th style="text-align:left;">说明</th>
</tr>
</thead>
<tbody>
<tr>
<td>/etc/taos/taos.cfg</td>
<td style="text-align:left;">默认[配置文件]</td>
</tr>
<tr>
<td>/usr/local/taos/driver</td>
<td style="text-align:left;">动态链接库目录</td>
</tr>
<tr>
<td>/var/lib/taos</td>
<td style="text-align:left;">默认数据文件目录,可通过[配置文件]修改位置.</td>
</tr>
<tr>
<td>/var/log/taos</td>
<td style="text-align:left;">默认日志文件目录,可通过[配置文件]修改位置</td>
</tr>
<tr>
<td>/usr/local/taos/bin</td>
<td style="text-align:left;">可执行文件目录</td>
</tr>
</tbody>
</table></figure>
<a class='anchor' id='可执行文件'></a><h3>可执行文件</h3>
<p>TDengine的所有可执行文件默认存放在 <em>/usr/local/taos/bin</em> 目录下。其中包括：</p>
<ul>
<li><em>taosd</em>：TDengine服务端可执行文件</li>
<li><em>taos</em>： TDengine Shell可执行文件</li>
<li><em>taosdump</em>：数据导出工具</li>
<li><em>rmtaos</em>： 卸载TDengine的脚本, 该脚本会删除全部的程序和数据文件。请务必谨慎执行，如非必须不建议使用。</li>
</ul>
<p>您可以通过修改系统配置文件taos.cfg来配置不同的数据目录和日志目录</p>
<a class='anchor' id='服务端配置'></a><h2>服务端配置</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#服务端配置' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine系统后台服务程序是<code>taosd</code>，其启动时候读取的配置文件缺省目录是<code>/etc/taos</code>。可以通过命令行执行参数-c指定配置文件目录，比如</p>
<pre><code>taosd -c /home/user</code></pre>
<p>指定<code>taosd</code>启动的时候读取<code>/home/user</code>目录下的配置文件taos.cfg。</p>
<p>下面仅仅列出一些重要的配置参数，更多的参数请看配置文件里的说明。各个参数的详细介绍及作用请看前述章节。<strong>注意：配置修改后，需要重启<em>taosd</em>服务才能生效。</strong></p>
<p><strong>privateIp</strong></p>
<ul>
<li>默认值：物理节点IP地址列表中的第一个IP地址</li>
</ul>
<p>对外提供服务的IP地址。</p>
<p><strong>publicIp</strong></p>
<ul>
<li>默认值：与privateIp相同</li>
</ul>
<p>对于阿里等云平台，此为公网IP地址，publicIp在内部映射为对应的privateIP地址，仅对企业版有效。</p>
<p><strong>masterIp</strong></p>
<ul>
<li>默认值：与privateIp相同</li>
</ul>
<p>集群内第一个物理节点的privateIp地址，仅对企业版有效。</p>
<p><strong>secondIp</strong></p>
<ul>
<li>默认值：与privateIp相同</li>
</ul>
<p>集群内第二个物理节点的privateIp地址，仅对企业版有效。</p>
<p><strong>mgmtShellPort</strong></p>
<ul>
<li>默认值： <em>6030</em></li>
</ul>
<p>数据库服务中管理节点与客户端通信使用的TCP/UDP端口号。</p>
<blockquote>
  <p>端口范围 <em>6030</em> - <em>6034</em> 均用于UDP通讯。此外，还使用端口 <em>6030</em> 用于TCP通讯。</p>
</blockquote>
<p><strong>vnodeShellPort</strong></p>
<ul>
<li>默认值： <em>6035</em></li>
</ul>
<p>数据节点与客户端通信使用的TCP/UDP端口号。</p>
<blockquote>
  <p>端口范围 <em>6035</em> - <em>6039</em> 的5个端口用于UDP通信。此外，还使用端口 <em>6035</em> 用于TCP通讯。</p>
</blockquote>
<p><strong>mgmtVnodePort</strong></p>
<ul>
<li>默认值： <em>6040</em></li>
</ul>
<p>管理节点与数据节点通信使用的TCP/UDP端口号，仅对企业版有效。</p>
<blockquote>
  <p>端口范围 <em>6040</em> - <em>6044</em> 的5个端口用于UDP通信。此外，还使用端口 <em>6040</em> 用于TCP通讯。</p>
</blockquote>
<p><strong>vnodeVnodePort</strong></p>
<ul>
<li>默认值： <em>6045</em></li>
</ul>
<p>数据节点与数据节点通信使用的TCP/UDP端口号，仅对企业版有效。</p>
<blockquote>
  <p>端口范围 <em>6045</em> - <em>6049</em> 的5个端口用于UDP通信。此外，还使用端口 <em>6045</em> 用于TCP通讯。</p>
</blockquote>
<p><strong>mgmtMgmtPort</strong></p>
<ul>
<li>默认值： <em>6050</em></li>
</ul>
<p>管理节点与管理节点通信使用的UDP端口号，仅对企业版有效。</p>
<p><strong>mgmtSyncPort</strong></p>
<ul>
<li>默认值： <em>6050</em></li>
</ul>
<p>管理节点与管理节点同步使用的TCP端口号，仅对企业版有效。</p>
<p><strong>httpPort</strong></p>
<ul>
<li>默认值： <em>6020</em></li>
</ul>
<p>RESTful服务使用的端口号，所有的HTTP请求（TCP）都需要向该接口发起查询/写入请求。</p>
<p><strong>dataDir</strong></p>
<ul>
<li>默认值：/var/lib/taos</li>
</ul>
<p>数据文件目录，所有的数据文件都将写入该目录。</p>
<p><strong>logDir</strong></p>
<ul>
<li>默认值：/var/log/taos</li>
</ul>
<p>日志文件目录，客户端和服务器的运行日志将写入该目录。</p>
<p><strong>shellActivityTimer</strong></p>
<ul>
<li>默认值：3</li>
</ul>
<p>系统在服务端保持结果集的最长时间，单位：秒，范围[1-120]。</p>
<p><strong>maxUsers</strong></p>
<ul>
<li>默认值：10,000</li>
</ul>
<p>系统允许创建用户数量的上限</p>
<p><strong>maxDbs</strong></p>
<ul>
<li>默认值：1,000</li>
</ul>
<p>系统允许的创建数据库的上限</p>
<p><strong>maxTables</strong></p>
<ul>
<li>默认值：650,000</li>
</ul>
<p>系统允许创建数据表的上限。</p>
<blockquote>
  <p>系统能够创建的表受到多种因素的限制，单纯地增大该参数并不能直接增加系统能够创建的表数量。例如，由于每个表创建均需要消耗一定量的缓存空间，系统可用内存一定的情况下，创建表的总数的上限是一个固定的值。</p>
</blockquote>
<p><strong>monitor</strong></p>
<ul>
<li>默认值：1（激活状态）</li>
</ul>
<p>服务器内部的系统监控开关。监控主要负责收集物理节点的负载状况，包括CPU、内存、硬盘、网络带宽、HTTP请求量的监控记录，记录信息存储在<code>LOG</code>库中。0表示关闭监控服务，1表示激活监控服务。</p>
<p><strong>numOfLogLines</strong></p>
<ul>
<li>默认值：10,000,000</li>
</ul>
<p>单个日志文件允许的最大行数（10,000,000行）。</p>
<p><strong>debugFlag</strong></p>
<ul>
<li>默认值：131（仅输出错误和警告信息）</li>
</ul>
<p>系统（服务端和客户端）运行日志开关：</p>
<ul>
<li>131 仅输出错误和警告信息</li>
<li>135 输出错误（ERROR）、警告（WARN）、信息（Info）</li>
</ul>
<p>不同应用场景的数据往往具有不同的数据特征，比如保留天数、副本数、采集频次、记录大小、采集点的数量、压缩等都可完全不同。为获得在存储上的最高效率，TDengine提供如下存储相关的系统配置参数：</p>
<ul>
<li>days：数据文件存储数据的时间跨度，单位为天</li>
<li>keep：数据保留的天数</li>
<li>rows: 文件块中记录条数</li>
<li>comp: 文件压缩标志位，0：关闭，1:一阶段压缩，2:两阶段压缩</li>
<li>ctime：数据从写入内存到写入硬盘的最长时间间隔，单位为秒</li>
<li>clog：数据提交日志(WAL)的标志位，0为关闭，1为打开</li>
<li>tables：每个vnode允许创建表的最大数目</li>
<li>cache: 内存块的大小（字节数）</li>
<li>tblocks: 每张表最大的内存块数</li>
<li>ablocks: 每张表平均的内存块数</li>
<li>precision：时间戳为微秒的标志位，ms表示毫秒，us表示微秒</li>
</ul>
<p>对于一个应用场景，可能有多种数据特征的数据并存，最佳的设计是将具有相同数据特征的表放在一个库里，这样一个应用有多个库，而每个库可以配置不同的存储参数，从而保证系统有最优的性能。TDengine容许应用在创建库时指定上述存储参数，如果指定，该参数就将覆盖对应的系统配置参数。举例，有下述SQL： </p>
<pre><code> create database demo days 10 cache 16000 ablocks 4</code></pre>
<p>该SQL创建了一个库demo, 每个数据文件保留10天数据，内存块为16000字节，每个表平均占用4个内存块，而其他参数与系统配置完全一致。</p>
<a class='anchor' id='客户端配置'></a><h2>客户端配置</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#客户端配置' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine系统的前台交互客户端应用程序为taos（Windows平台上为taos.exe）。与服务端程序一样，也可以通过设置taos.cfg来配置<code>taos</code>启动和运行的配置项。启动的时候如果不指定taos加载配置文件路径，默认读取<code>/etc/taos/</code>路径下的<code>taos.cfg</code>文件。指定配置文件来启动<code>taos</code>的命令如下：</p>
<pre><code>taos -c /home/cfg/</code></pre>
<p><strong>注意：启动设置的是配置文件所在目录，而不是配置文件本身</strong></p>
<p>如果<code>/home/cfg/</code>目录下没有配置文件，程序会继续启动并打印如下告警信息：</p>
<pre><code class="plaintext language-plaintext">Welcome to the TDengine shell from linux, client version:1.6.4.0
option file:/home/cfg/taos.cfg not found, all options are set to system default</code></pre>
<p>更多taos的使用方法请见<a href="#_TDengine_Shell命令行程序">Shell命令行程序</a>。本节主要讲解taos客户端应用在配置文件taos.cfg文件中使用到的参数。</p>
<p>客户端配置参数说明</p>
<p><strong>masterIP</strong></p>
<ul>
<li>默认值：127.0.0.1</li>
</ul>
<p>客户端连接的TDengine服务器IP地址，如果不设置默认连接127.0.0.1的节点。以下两个命令等效：</p>
<pre><code>taos
taos -h 127.0.0.1</code></pre>
<p>其中的IP地址是从配置文件中读取的masterIP的值。</p>
<p><strong>locale</strong></p>
<ul>
<li>默认值：系统中动态获取，如果自动获取失败，需要用户在配置文件设置或通过API设置</li>
</ul>
<p>TDengine为存储中文、日文、韩文等非ASCII编码的宽字符，提供一种专门的字段类型<code>nchar</code>。写入<code>nchar</code>字段的数据将统一采用<code>UCS4-LE</code>格式进行编码并发送到服务器。需要注意的是，<strong>编码正确性</strong>是客户端来保证。因此，如果用户想要正常使用<code>nchar</code>字段来存储诸如中文、日文、韩文等非ASCII字符，需要正确设置客户端的编码格式。</p>
<p>客户端的输入的字符均采用操作系统当前默认的编码格式，在Linux系统上多为<code>UTF-8</code>，部分中文系统编码则可能是<code>GB18030</code>或<code>GBK</code>等。在docker环境中默认的编码是<code>POSIX</code>。在中文版Windows系统中，编码则是<code>CP936</code>。客户端需要确保正确设置自己所使用的字符集，即客户端运行的操作系统当前编码字符集，才能保证<code>nchar</code>中的数据正确转换为<code>UCS4-LE</code>编码格式。</p>
<p>在 Linux 中 locale 的命名规则为：
<code>&lt;语言&gt;_&lt;地区&gt;.&lt;字符集编码&gt;</code>
如：<code>zh_CN.UTF-8</code>，zh代表中文，CN代表大陆地区，UTF-8表示字符集。字符集编码为客户端正确解析本地字符串提供编码转换的说明。Linux系统与Mac OSX系统可以通过设置locale来确定系统的字符编码，由于Windows使用的locale中不是POSIX标准的locale格式，因此在Windows下需要采用另一个配置参数<code>charset</code>来指定字符编码。在Linux系统中也可以使用charset来指定字符编码。</p>
<p><strong>charset</strong></p>
<ul>
<li>默认值：系统中动态获取，如果自动获取失败，需要用户在配置文件设置或通过API设置</li>
</ul>
<p>如果配置文件中不设置<code>charset</code>，在Linux系统中，taos在启动时候，自动读取系统当前的locale信息，并从locale信息中解析提取charset编码格式。如果自动读取locale信息失败，则尝试读取charset配置，如果读取charset配置也失败，<strong>则中断启动过程</strong>。</p>
<p>在Linux系统中，locale信息包含了字符编码信息，因此正确设置了Linux系统locale以后可以不用再单独设置charset。例如：</p>
<pre><code>locale zh_CN.UTF-8</code></pre>
<p>在Windows系统中，无法从locale获取系统当前编码。如果无法从配置文件中读取字符串编码信息，<code>taos</code>默认设置为字符编码为<code>CP936</code>。其等效在配置文件中添加如下配置：</p>
<pre><code>charset CP936</code></pre>
<p>如果需要调整字符编码，请查阅当前操作系统使用的编码，并在配置文件中正确设置。</p>
<p>在Linux系统中，如果用户同时设置了locale和字符集编码charset，并且locale和charset的不一致，后设置的值将覆盖前面设置的值。</p>
<pre><code>locale zh_CN.UTF-8
charset GBK</code></pre>
<p>则<code>charset</code>的有效值是<code>GBK</code>。</p>
<pre><code>charset GBK
locale zh_CN.UTF-8</code></pre>
<p><code>charset</code>的有效值是<code>UTF-8</code>。</p>
<p><strong>sockettype</strong></p>
<ul>
<li>默认值：UDP</li>
</ul>
<p>客户端连接服务端的套接字的方式，可以使用<code>UDP</code>和<code>TCP</code>两种配置。
在客户端和服务端之间的通讯需要经过恶劣的网络环境下（如公共网络、互联网）、客户端与数据库服务端连接不稳定（由于MTU的问题导致UDP丢包）的情况下，可以将连接的套接字类型调整为<code>TCP</code></p>
<blockquote>
  <p>注意：客户端套接字的类型需要和服务端的套接字类型相同，否则无法连接数据库。</p>
</blockquote>
<p><strong>compressMsgSize</strong></p>
<ul>
<li>默认值：-1（不压缩）</li>
</ul>
<p>客户端与服务器之间进行消息通讯过程中，对通讯的消息进行压缩的阈值，默认值为-1（不压缩）。如果要压缩消息，建议设置为64330字节，即大于64330字节的消息体才进行压缩。在配置文件中增加如下配置项即可：</p>
<pre><code>compressMsgSize 64330</code></pre>
<p>如果配置项设置为0，<code>compressMsgSize 0</code>表示对所有的消息均进行压缩。</p>
<p><strong>timezone</strong></p>
<ul>
<li>默认值：从系统中动态获取当前的时区设置</li>
</ul>
<p>客户端运行系统所在的时区。为应对多时区的数据写入和查询问题，TDengine采用Unix时间戳(<a href="https://en.wikipedia.org/wiki/Unix_time">Unix Timestamp</a>)来记录和存储时间戳。Unix时间戳的特点决定了任一时刻不论在任何时区，产生的时间戳均一致。需要注意的是，Unix时间戳是在客户端完成转换和记录。为了确保客户端其他形式的时间转换为正确的Unix时间戳，需要设置正确的时区。</p>
<p>在Linux系统中，客户端会自动读取系统设置的时区信息。用户也可以采用多种方式在配置文件设置时区。例如：</p>
<pre><code>timezone UTC-8
timezone GMT-8
timezone Asia/Shanghai</code></pre>
<p>均是合法的设置东八区时区的格式。</p>
<p>时区的设置对于查询和写入SQL语句中非Unix时间戳的内容（时间戳字符串、关键词<code>now</code>的解析）产生影响。例如：</p>
<pre><code>SELECT count(*) FROM table_name WHERE TS&lt;'2019-04-11 12:01:08';</code></pre>
<p>在东八区，SQL语句等效于</p>
<pre><code>SELECT count(*) FROM table_name WHERE TS&lt;1554955268000;</code></pre>
<p>在UTC时区，SQL语句等效于</p>
<pre><code>SELECT count(*) FROM table_name WHERE TS&lt;1554984068000;</code></pre>
<p>为了避免使用字符串时间格式带来的不确定性，也可以直接使用Unix时间戳。此外，还可以在SQL语句中使用带有时区的时间戳字符串，例如：RFC3339格式的时间戳字符串，<code>2013-04-12T15:52:01.123+08:00</code>或者ISO-8601格式时间戳字符串<code>2013-04-12T15:52:01.123+0800</code>。上述两个字符串转化为Unix时间戳不受系统所在时区的影响。</p>
<p><strong>defaultUser</strong></p>
<ul>
<li>默认值：root</li>
</ul>
<p>登录用户名，客户端登录的时候，如果不指定用户名，则自动使用该用户名登录。默认情况下，以下的两个命令等效</p>
<pre><code>taos
taos -u root</code></pre>
<p>用户名为从配置中读取的<code>defaultUser</code>配置项。如果更改<code>defaultUser abc</code>，则以下两个命令等效：</p>
<pre><code>taos
taos -u abc</code></pre>
<p><strong>defaultPass</strong></p>
<ul>
<li>默认值：taosdata</li>
</ul>
<p>登录用户名，客户端登录的时候，如果不指定密码，则自动使用该密码登录。默认情况下，以下的两个命令等效</p>
<pre><code>taos
taos -ptaosdata</code></pre>
<p>TCP/UDP端口，以及日志的配置参数，与server的配置参数完全一样。使用命令<code>taos -?</code> 可查看<code>taos</code>允许的可选项。</p>
<a class='anchor' id='用户管理'></a><h2>用户管理</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#用户管理' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>系统管理员可以在CLI界面里添加、删除用户，也可以修改密码。CLI里SQL语法如下：</p>
<pre><code>CREATE USER user_name PASS ‘password’</code></pre>
<p>创建用户，并制定用户名和密码，密码需要用单引号引起来</p>
<pre><code>DROP USER user_name</code></pre>
<p>删除用户，限root用户使用</p>
<pre><code>ALTER USER user_name PASS ‘password’  </code></pre>
<p>修改用户密码, 为避免被转换为小写，密码需要用单引号引用</p>
<pre><code>SHOW USERS</code></pre>
<p>显示所有用户</p>
<a class='anchor' id='数据导入'></a><h2>数据导入</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#数据导入' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine提供两种方便的数据导入功能，一种按脚本文件导入，一种按数据文件导入。</p>
<p><strong>按脚本文件导入</strong></p>
<p>TDengine的shell支持source filename命令，用于批量运行文件中的SQL语句。用户可将建库、建表、写数据等SQL命令写在同一个文件中，每条命令单独一行，在shell中运行source命令，即可按顺序批量运行文件中的SQL语句。以‘#’开头的SQL语句被认为是注释，shell将自动忽略。</p>
<p><strong>按数据文件导入</strong></p>
<p>TDengine也支持在shell对已存在的表从CSV文件中进行数据导入。每个CSV文件只属于一张表且CSV文件中的数据格式需与要导入表的结构相同。其语法如下</p>
<pre><code class="mysql language-mysql">insert into tb1 file a.csv b.csv tb2 c.csv …
import into tb1 file a.csv b.csv tb2 c.csv …</code></pre>
<blockquote>
  <p>注意：导入的CSV文件不能够带表头, 且表的列与CSV文件的列需要严格对应。
  同样还可以使用<a href="https://github.com/taosdata/TDengine/tree/develop/importSampleData">样例数据导入工具</a>对数据进行横向和纵向扩展导入。</p>
</blockquote>
<a class='anchor' id='数据导出'></a><h2>数据导出</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#数据导出' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>为方便数据导出，TDengine提供了两种导出方式，分别是按表导出和用taosdump导出。</p>
<p><strong>按表导出CSV文件</strong></p>
<p>如果用户需要导出一个表或一个STable中的数据，可在shell中运行</p>
<pre><code>select * from &lt;tb_name&gt; &gt;&gt; a.csv</code></pre>
<p>这样，表tb中的数据就会按照CSV格式导出到文件a.csv中。</p>
<p><strong>用taosdump导出数据</strong></p>
<p>TDengine提供了方便的数据库导出工具taosdump。用户可以根据需要选择导出所有数据库、一个数据库或者数据库中的一张表,所有数据或一时间段的数据，甚至仅仅表的定义。其用法如下：</p>
<ul>
<li>导出数据库中的一张或多张表：taosdump [OPTION…] dbname tbname …</li>
<li>导出一个或多个数据库：      taosdump [OPTION…] --databases dbname…</li>
<li>导出所有数据库（不含监控数据库）：taosdump [OPTION…] --all-databases</li>
</ul>
<p>用户可通过运行taosdump --help获得更详细的用法说明</p>
<a class='anchor' id='系统连接、任务查询管理'></a><h2>系统连接、任务查询管理</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#系统连接、任务查询管理' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>系统管理员可以从CLI查询系统的连接、正在进行的查询、流式计算，并且可以关闭连接、停止正在进行的查询和流式计算。CLI里SQL语法如下：</p>
<pre><code>SHOW CONNECTIONS</code></pre>
<p>显示数据库的连接，其中一列显示ip:port, 为连接的IP地址和端口号。</p>
<pre><code>KILL CONNECTION &lt;connection-id&gt;</code></pre>
<p>强制关闭数据库连接，其中的connection-id是SHOW CONNECTIONS中显示的 ip:port字串，如“192.168.0.1:42198”，拷贝粘贴即可。</p>
<pre><code>SHOW QUERIES</code></pre>
<p>显示数据查询，其中一列显示ip:port:id, 为发起该query应用的IP地址，端口号，以及系统分配的ID。</p>
<pre><code>KILL QUERY &lt;query-id&gt;</code></pre>
<p>强制关闭数据查询，其中query-id是SHOW QUERIES中显示的ip:port:id字串，如“192.168.0.1:42198:11”，拷贝粘贴即可。</p>
<pre><code>SHOW STREAMS</code></pre>
<p>显示流式计算，其中一列显示ip:port:id, 为启动该stream的IP地址、端口和系统分配的ID。</p>
<pre><code>KILL STREAM &lt;stream-id&gt;</code></pre>
<p>强制关闭流式计算，其中的中stream-id是SHOW STREAMS中显示的ip:port:id字串，如“192.168.0.1:42198:18”，拷贝粘贴即可。</p>
<a class='anchor' id='系统监控'></a><h2>系统监控</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/administrator-ch.md#系统监控' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine启动后，会自动创建一个监测数据库<code>LOG</code>，并自动将服务器的CPU、内存、硬盘空间、带宽、请求数、磁盘读写速度、慢查询等信息定时写入该数据库。TDengine还将重要的系统操作（比如登录、创建、删除数据库等）日志以及各种错误报警信息记录下来存放在<code>LOG</code>库里。系统管理员可以通过客户端程序查看记录库中的运行负载信息，（在企业版中）还可以通过浏览器查看数据的图标可视化结果。</p>
<p>这些监测信息的采集缺省是打开的，但可以修改配置文件里的选项<code>monitor</code>将其关闭或打开。</p></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>