<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>文档 | 涛思数据</title><meta name='description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine'><meta name='title' content='文档 | 涛思数据'><meta property='og:site_name' content='涛思数据'/><meta property='og:title' content='文档 | 涛思数据'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connector-ch/index.php'/><meta property='og:description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connector-ch/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>连接器</h1>
<p>TDengine提供了丰富的应用程序开发接口，其中包括C/C++、JAVA、Python、RESTful、Go等，便于用户快速开发应用。</p>
<a class='anchor' id='C/C++-Connector'></a><h2>C/C++ Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#c/c++-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>C/C++的API类似于MySQL的C API。应用程序使用时，需要包含TDengine头文件 <em>taos.h</em>（安装后，位于 <em>/usr/local/taos/include</em>）：</p>
<pre><code class="C language-C">#include &lt;taos.h&gt;</code></pre>
<p>在编译时需要链接TDengine动态库 <em>libtaos.so</em> （安装后，位于 <em>/usr/local/taos/driver</em>，gcc编译时，请加上 -ltaos）。 如未特别说明，当API的返回值是整数时，<em>0</em> 代表成功，其它是代表失败原因的错误码，当返回值是指针时， <em>NULL</em> 表示失败。</p>
<a class='anchor' id='C/C++同步API'></a><h3>C/C++同步API</h3>
<p>传统的数据库操作API，都属于同步操作。应用调用API后，一直处于阻塞状态，直到服务器返回结果。TDengine支持如下API：</p>
<ul>
<li><p><code>TAOS *taos_connect(char *ip, char *user, char *pass, char *db, int port)</code></p>
<p>创建数据库连接，初始化连接上下文。其中需要用户提供的参数包含：TDengine管理主节点的IP地址、用户名、密码、数据库名字和端口号。如果用户没有提供数据库名字，也可以正常连接，用户可以通过该连接创建新的数据库，如果用户提供了数据库名字，则说明该数据库用户已经创建好，缺省使用该数据库。返回值为空表示失败。应用程序需要保存返回的参数，以便后续API调用。</p></li>
<li><p><code>void taos_close(TAOS *taos)</code></p>
<p>关闭连接, 其中taos是taos_connect函数返回的指针。</p></li>
<li><p><code>int taos_query(TAOS *taos, char *sqlstr)</code></p>
<p>该API用来执行SQL语句，可以是DQL语句也可以是DML语句，或者DDL语句。其中的taos参数是通过taos_connect()获得的指针。返回值-1表示失败。</p></li>
<li><p><code>TAOS_RES *taos_use_result(TAOS *taos)</code></p>
<p>选择相应的查询结果集。</p></li>
<li><p><code>TAOS_ROW taos_fetch_row(TAOS_RES *res)</code></p>
<p>按行获取查询结果集中的数据。</p></li>
<li><p><code>int taos_num_fields(TAOS_RES *res)</code></p>
<p>获取查询结果集中的列数。</p></li>
<li><p><code>TAOS_FIELD *taos_fetch_fields(TAOS_RES *res)</code></p>
<p>获取查询结果集每列数据的属性（数据类型、名字、字节数），与taos_num_fileds配合使用，可用来解析taos_fetch_row返回的一个元组(一行)的数据。</p></li>
<li><p><code>void taos_free_result(TAOS_RES *res)</code></p>
<p>释放查询结果集以及相关的资源。查询完成后，务必调用该API释放资源，否则可能导致应用内存泄露。</p></li>
<li><p><code>void taos_init()</code></p>
<p>初始化环境变量。如果应用没有主动调用该API，那么应用在调用taos_connect时将自动调用。因此一般情况下应用程序无需手动调用该API。 </p></li>
<li><p><code>char *taos_errstr(TAOS *taos)</code></p>
<p>获取最近一次API调用失败的原因,返回值为字符串。</p></li>
<li><p><code>char *taos_errno(TAOS *taos)</code></p>
<p>获取最近一次API调用失败的原因，返回值为错误代码。</p></li>
<li><p><code>int taos_options(TSDB_OPTION option, const void * arg, ...)</code></p>
<p>设置客户端选项，目前只支持时区设置（<em>TSDB_OPTION_TIMEZONE</em>）和编码设置（<em>TSDB_OPTION_LOCALE</em>）。时区和编码默认为操作系统当前设置。 </p></li>
</ul>
<p>上述12个API是C/C++接口中最重要的API，剩余的辅助API请参看<em>taos.h</em>文件。</p>
<p><strong>注意</strong>：对于单个数据库连接，在同一时刻只能有一个线程使用该链接调用API，否则会有未定义的行为出现并可能导致客户端crash。客户端应用可以通过建立多个连接进行多线程的数据写入或查询处理。</p>
<a class='anchor' id='C/C++-参数绑定接口'></a><h3>C/C++ 参数绑定接口</h3>
<p>除了直接调用 <code>taos_query</code> 进行查询，TDengine也提供了支持参数绑定的Prepare API，与 MySQL 一样，这些API目前也仅支持用问号<code>?</code>来代表待绑定的参数，具体如下：</p>
<ul>
<li><p><code>TAOS_STMT* taos_stmt_init(TAOS *taos)</code></p>
<p>创建一个 TAOS_STMT 对象用于后续调用。</p></li>
<li><p><code>int taos_stmt_prepare(TAOS_STMT *stmt, const char *sql, unsigned long length)</code></p>
<p>解析一条sql语句，将解析结果和参数信息绑定到stmt上，如果参数length大于0，将使用此此参数作为sql语句的长度，如等于0，将自动判断sql语句的长度。</p></li>
<li><p><code>int taos_stmt_bind_param(TAOS_STMT *stmt, TAOS_BIND *bind)</code></p>
<p>进行参数绑定，bind指向一个数组，需保证此数组的元素数量和顺序与sql语句中的参数完全一致。TAOS_BIND 的使用方法与 MySQL中的 MYSQL_BIND 一致，具体定义如下：</p></li>
</ul>
<pre><code class="c language-c">  typedef struct TAOS_BIND {
    int            buffer_type;
    void *         buffer;
    unsigned long  buffer_length;  // 未实际使用
    unsigned long *length;
    int *          is_null;
    int            is_unsigned;    // 未实际使用
    int *          error;          // 未实际使用
  } TAOS_BIND;</code></pre>
<ul>
<li><p><code>int taos_stmt_add_batch(TAOS_STMT *stmt)</code></p>
<p>将当前绑定的参数加入批处理中，调用此函数后，可以再次调用<code>taos_stmt_bind_param</code>绑定新的参数。需要注意，此函数仅支持 insert/import 语句，如果是select等其他SQL语句，将返回错误。</p></li>
<li><p><code>int taos_stmt_execute(TAOS_STMT *stmt)</code></p>
<p>执行准备好的语句。目前，一条语句只能执行一次。</p></li>
<li><p><code>TAOS_RES* taos_stmt_use_result(TAOS_STMT *stmt)</code></p>
<p>获取语句的结果集。结果集的使用方式与非参数化调用时一致，使用完成后，应对此结果集调用 <code>taos_free_result</code>以释放资源。</p></li>
<li><p><code>int taos_stmt_close(TAOS_STMT *stmt)</code></p>
<p>执行完毕，释放所有资源。</p></li>
</ul>
<a class='anchor' id='C/C++异步API'></a><h3>C/C++异步API</h3>
<p>同步API之外，TDengine还提供性能更高的异步调用API处理数据插入、查询操作。在软硬件环境相同的情况下，异步API处理数据插入的速度比同步API快2~4倍。异步API采用非阻塞式的调用方式，在系统真正完成某个具体数据库操作前，立即返回。调用的线程可以去处理其他工作，从而可以提升整个应用的性能。异步API在网络延迟严重的情况下，优点尤为突出。</p>
<p>异步API都需要应用提供相应的回调函数，回调函数参数设置如下：前两个参数都是一致的，第三个参数依不同的API而定。第一个参数param是应用调用异步API时提供给系统的，用于回调时，应用能够找回具体操作的上下文，依具体实现而定。第二个参数是SQL操作的结果集，如果为空，比如insert操作，表示没有记录返回，如果不为空，比如select操作，表示有记录返回。</p>
<p>异步API对于使用者的要求相对较高，用户可根据具体应用场景选择性使用。下面是三个重要的异步API： </p>
<ul>
<li><p><code>void taos_query_a(TAOS *taos, char *sqlstr, void (*fp)(void *param, TAOS_RES *, int code), void *param);</code></p>
<p>异步执行SQL语句。taos是调用taos_connect返回的数据库连接结构体。sqlstr是需要执行的SQL语句。fp是用户定义的回调函数。param是应用提供一个用于回调的参数。回调函数fp的第三个参数code用于指示操作是否成功，0表示成功，负数表示失败(调用taos_errstr获取失败原因)。应用在定义回调函数的时候，主要处理第二个参数TAOS_RES *，该参数是查询返回的结果集。 </p></li>
<li><p><code>void taos_fetch_rows_a(TAOS_RES *res, void (*fp)(void *param, TAOS_RES *, int numOfRows), void *param);</code></p>
<p>批量获取异步查询的结果集，只能与taos_query_a配合使用。其中<em>res</em>是_taos_query_a回调时返回的结果集结构体指针，fp为回调函数。回调函数中的param是用户可定义的传递给回调函数的参数结构体。numOfRows表明有fetch数据返回的行数（numOfRows并不是本次查询满足查询条件的全部元组数量）。在回调函数中，应用可以通过调用taos_fetch_row前向迭代获取批量记录中每一行记录。读完一块内的所有记录后，应用需要在回调函数中继续调用taos_fetch_rows_a获取下一批记录进行处理，直到返回的记录数（numOfRows）为零（结果返回完成）或记录数为负值（查询出错）。</p></li>
<li><p><code>void taos_fetch_row_a(TAOS_RES *res, void (*fp)(void *param, TAOS_RES *, TAOS_ROW row), void *param);</code></p>
<p>异步获取一条记录。其中res是taos_query_a回调时返回的结果集结构体指针。fp为回调函数。param是应用提供的一个用于回调的参数。回调时，第三个参数TAOS_ROW指向一行记录。不同于taos_fetch_rows_a，应用无需调用同步API taos_fetch_row来获取一个元组，更加简单。数据提取性能不及批量获取的API。</p></li>
</ul>
<p>TDengine的异步API均采用非阻塞调用模式。应用程序可以用多线程同时打开多张表，并可以同时对每张打开的表进行查询或者插入操作。需要指出的是，<strong>客户端应用必须确保对同一张表的操作完全串行化</strong>，即对同一个表的插入或查询操作未完成时（未返回时），不能够执行第二个插入或查询操作。</p>
<a class='anchor' id='C/C++-连续查询接口'></a><h3>C/C++ 连续查询接口</h3>
<p>TDengine提供时间驱动的实时流式计算API。可以每隔一指定的时间段，对一张或多张数据库的表(数据流)进行各种实时聚合计算操作。操作简单，仅有打开、关闭流的API。具体如下： </p>
<ul>
<li><p><code>TAOS_STREAM *taos_open_stream(TAOS *taos, char *sqlstr, void (*fp)(void *param, TAOS_RES *, TAOS_ROW row), int64_t stime, void *param)</code></p>
<p>该API用来创建数据流，其中taos是调用taos_connect返回的结构体指针；sqlstr是SQL查询语句（仅能使用查询语句）；fp是用户定义的回调函数指针，每次流式计算完成后，均回调该函数，用户可在该函数内定义其内部业务逻辑；param是应用提供的用于回调的一个参数，回调时，提供给应用；stime是流式计算开始的时间，如果是0，表示从现在开始，如果不为零，表示从指定的时间开始计算（UTC时间从1970/1/1算起的毫秒数）。返回值为NULL，表示创建成功，返回值不为空，表示成功。TDengine将查询的结果（TAOS_ROW）、查询状态（TAOS_RES）、用户定义参数（PARAM）传递给回调函数，在回调函数内，用户可以使用taos_num_fields获取结果集列数，taos_fetch_fields获取结果集每列数据的类型。</p></li>
<li><p><code>void taos_close_stream (TAOS_STREAM *tstr)</code></p>
<p>关闭数据流，其中提供的参数是taos_open_stream的返回值。用户停止流式计算的时候，务必关闭该数据流。</p></li>
</ul>
<a class='anchor' id='C/C++-数据订阅接口'></a><h3>C/C++ 数据订阅接口</h3>
<p>订阅API目前支持订阅一张或多张表，并通过定期轮询的方式不断获取写入表中的最新数据。 </p>
<ul>
<li><p><code>TAOS_SUB *taos_subscribe(TAOS* taos, int restart, const char* topic, const char *sql, TAOS_SUBSCRIBE_CALLBACK fp, void *param, int interval)</code></p>
<p>该函数负责启动订阅服务，成功时返回订阅对象，失败时返回 <code>NULL</code>，其参数为：</p></li>
<li><p>taos：已经建立好的数据库连接</p></li>
<li><p>restart：如果订阅已经存在，是重新开始，还是继续之前的订阅</p></li>
<li><p>topic：订阅的主题（即名称），此参数是订阅的唯一标识</p></li>
<li><p>sql：订阅的查询语句，此语句只能是 <code>select</code> 语句，只应查询原始数据，只能按时间正序查询数据</p></li>
<li><p>fp：收到查询结果时的回调函数（稍后介绍函数原型），只在异步调用时使用，同步调用时此参数应该传 <code>NULL</code></p></li>
<li><p>param：调用回调函数时的附加参数，系统API将其原样传递到回调函数，不进行任何处理</p></li>
<li><p>interval：轮询周期，单位为毫秒。异步调用时，将根据此参数周期性的调用回调函数，为避免对系统性能造成影响，不建议将此参数设置的过小；同步调用时，如两次调用<code>taos_consume</code>的间隔小于此周期，API将会阻塞，直到时间间隔超过此周期。</p></li>
<li><p><code>typedef void (*TAOS_SUBSCRIBE_CALLBACK)(TAOS_SUB* tsub, TAOS_RES *res, void* param, int code)</code></p>
<p>异步模式下，回调函数的原型，其参数为：</p></li>
<li><p>tsub：订阅对象</p></li>
<li><p>res：查询结果集，注意结果集中可能没有记录</p></li>
<li><p>param：调用 <code>taos_subscribe</code>时客户程序提供的附加参数</p></li>
<li><p>code：错误码</p></li>
<li><p><code>TAOS_RES *taos_consume(TAOS_SUB *tsub)</code></p>
<p>同步模式下，该函数用来获取订阅的结果。 用户应用程序将其置于一个循环之中。 如两次调用<code>taos_consume</code>的间隔小于订阅的轮询周期，API将会阻塞，直到时间间隔超过此周期。 如果数据库有新记录到达，该API将返回该最新的记录，否则返回一个没有记录的空结果集。 如果返回值为 <code>NULL</code>，说明系统出错。 异步模式下，用户程序不应调用此API。</p></li>
<li><p><code>void taos_unsubscribe(TAOS_SUB *tsub, int keepProgress)</code></p>
<p>取消订阅。 如参数 <code>keepProgress</code> 不为0，API会保留订阅的进度信息，后续调用 <code>taos_subscribe</code> 时可以基于此进度继续；否则将删除进度信息，后续只能重新开始读取数据。</p></li>
</ul>
<a class='anchor' id='Java-Connector'></a><h2>Java Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#java-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine 为了方便 Java 应用使用，提供了遵循 JDBC 标准(3.0)API 规范的 <code>taos-jdbcdriver</code> 实现。目前可以通过 <a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">Sonatype Repository</a> 搜索并下载。</p>
<p>由于 TDengine 是使用 c 语言开发的，使用 taos-jdbcdriver 驱动包时需要依赖系统对应的本地函数库。</p>
<ul>
<li><p>libtaos.so 
在 linux 系统中成功安装 TDengine 后，依赖的本地函数库 libtaos.so 文件会被自动拷贝至 /usr/lib/libtaos.so，该目录包含在 Linux 自动扫描路径上，无需单独指定。</p></li>
<li><p>taos.dll
在 windows 系统中安装完客户端之后，驱动包依赖的 taos.dll 文件会自动拷贝到系统默认搜索路径 C:/Windows/System32 下，同样无需要单独指定。</p></li>
</ul>
<blockquote>
  <p>注意：在 windows 环境开发时需要安装 TDengine 对应的 <a href="https://www.taosdata.com/cn/documentation/connector/#Windows%E5%AE%A2%E6%88%B7%E7%AB%AF%E5%8F%8A%E7%A8%8B%E5%BA%8F%E6%8E%A5%E5%8F%A3">windows 客户端</a>，Linux 服务器安装完 TDengine 之后默认已安装 client，也可以单独安装 <a href="https://www.taosdata.com/cn/getting-started/#%E5%BF%AB%E9%80%9F%E4%B8%8A%E6%89%8B">Linux 客户端</a> 连接远程 TDengine Server。</p>
</blockquote>
<p>TDengine 的 JDBC 驱动实现尽可能的与关系型数据库驱动保持一致，但时序空间数据库与关系对象型数据库服务的对象和技术特征的差异导致 taos-jdbcdriver 并未完全实现 JDBC 标准规范。在使用时需要注意以下几点：</p>
<ul>
<li>TDengine 不提供针对单条数据记录的删除和修改的操作，驱动中也没有支持相关方法。</li>
<li>由于不支持删除和修改，所以也不支持事务操作。</li>
<li>目前不支持表间的 union 操作。</li>
<li>目前不支持嵌套查询(nested query)，对每个 Connection 的实例，至多只能有一个打开的 ResultSet 实例；如果在 ResultSet还没关闭的情况下执行了新的查询，TSDBJDBCDriver 则会自动关闭上一个 ResultSet。</li>
</ul>
<a class='anchor' id='TAOS-JDBCDriver-版本以及支持的-TDengine-版本和-JDK-版本'></a><h2>TAOS-JDBCDriver 版本以及支持的 TDengine 版本和 JDK 版本</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#taos-jdbcdriver-版本以及支持的-tdengine-版本和-jdk-版本' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<figure><table>
<thead>
<tr>
<th>taos-jdbcdriver 版本</th>
<th>TDengine 版本</th>
<th>JDK 版本</th>
</tr>
</thead>
<tbody>
<tr>
<td>1.0.3</td>
<td>1.6.1.x 及以上</td>
<td>1.8.x</td>
</tr>
<tr>
<td>1.0.2</td>
<td>1.6.1.x 及以上</td>
<td>1.8.x</td>
</tr>
<tr>
<td>1.0.1</td>
<td>1.6.1.x 及以上</td>
<td>1.8.x</td>
</tr>
</tbody>
</table></figure>
<a class='anchor' id='TDengine-DataType-和-Java-DataType'></a><h2>TDengine DataType 和 Java DataType</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#tdengine-datatype-和-java-datatype' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine 目前支持时间戳、数字、字符、布尔类型，与 Java 对应类型转换如下：</p>
<figure><table>
<thead>
<tr>
<th>TDengine DataType</th>
<th>Java DataType</th>
</tr>
</thead>
<tbody>
<tr>
<td>TIMESTAMP</td>
<td>java.sql.Timestamp</td>
</tr>
<tr>
<td>INT</td>
<td>java.lang.Integer</td>
</tr>
<tr>
<td>BIGINT</td>
<td>java.lang.Long</td>
</tr>
<tr>
<td>FLOAT</td>
<td>java.lang.Float</td>
</tr>
<tr>
<td>DOUBLE</td>
<td>java.lang.Double</td>
</tr>
<tr>
<td>SMALLINT, TINYINT</td>
<td>java.lang.Short</td>
</tr>
<tr>
<td>BOOL</td>
<td>java.lang.Boolean</td>
</tr>
<tr>
<td>BINARY, NCHAR</td>
<td>java.lang.String</td>
</tr>
</tbody>
</table></figure>
<a class='anchor' id='如何获取-TAOS-JDBCDriver'></a><h2>如何获取 TAOS-JDBCDriver</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#如何获取-taos-jdbcdriver' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='maven-仓库'></a><h3>maven 仓库</h3>
<p>目前 taos-jdbcdriver 已经发布到 <a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">Sonatype Repository</a> 仓库，且各大仓库都已同步。</p>
<ul>
<li><a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">sonatype</a></li>
<li><a href="https://mvnrepository.com/artifact/com.taosdata.jdbc/taos-jdbcdriver">mvnrepository</a></li>
<li><a href="https://maven.aliyun.com/mvn/search">maven.aliyun</a></li>
</ul>
<p>maven 项目中使用如下 pom.xml 配置即可：</p>
<pre><code class="xml language-xml">&lt;dependencies&gt;
    &lt;dependency&gt;
        &lt;groupId&gt;com.taosdata.jdbc&lt;/groupId&gt;
        &lt;artifactId&gt;taos-jdbcdriver&lt;/artifactId&gt;
        &lt;version&gt;1.0.3&lt;/version&gt;
    &lt;/dependency&gt;
&lt;/dependencies&gt;</code></pre>
<a class='anchor' id='源码编译打包'></a><h3>源码编译打包</h3>
<p>下载 <a href="https://github.com/taosdata/TDengine">TDengine</a> 源码之后，进入 taos-jdbcdriver 源码目录 <code>src/connector/jdbc</code> 执行 <code>mvn clean package</code> 即可生成相应 jar 包。</p>
<a class='anchor' id='使用说明'></a><h2>使用说明</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#使用说明' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='获取连接'></a><h3>获取连接</h3>
<p>如下所示配置即可获取 TDengine Connection：</p>
<pre><code class="java language-java">Class.forName("com.taosdata.jdbc.TSDBDriver");
String jdbcUrl = "jdbc:TAOS://127.0.0.1:6030/log?user=root&amp;password=taosdata";
Connection conn = DriverManager.getConnection(jdbcUrl);</code></pre>
<blockquote>
  <p>端口 6030 为默认连接端口，JDBC URL 中的 log 为系统本身的监控数据库。</p>
</blockquote>
<p>TDengine 的 JDBC URL 规范格式为：
<code>jdbc:TSDB://{host_ip}:{port}/[database_name]?[user={user}|&amp;password={password}|&amp;charset={charset}|&amp;cfgdir={config_dir}|&amp;locale={locale}|&amp;timezone={timezone}]</code></p>
<p>其中，<code>{}</code> 中的内容必须，<code>[]</code> 中为可选。配置参数说明如下：</p>
<ul>
<li>user：登录 TDengine 用户名，默认值 root。</li>
<li>password：用户登录密码，默认值 taosdata。</li>
<li>charset：客户端使用的字符集，默认值为系统字符集。</li>
<li>cfgdir：客户端配置文件目录路径，Linux OS 上默认值 /etc/taos ，Windows OS 上默认值 C:/TDengine/cfg。</li>
<li>locale：客户端语言环境，默认值系统当前 locale。</li>
<li>timezone：客户端使用的时区，默认值为系统当前时区。</li>
</ul>
<p>以上参数可以在 3 处配置，<code>优先级由高到低</code>分别如下：</p>
<ol>
<li>JDBC URL 参数
如上所述，可以在 JDBC URL 的参数中指定。</li>
<li>java.sql.DriverManager.getConnection(String jdbcUrl, Properties connProps)</li>
</ol>
<pre><code class="java language-java">public Connection getConn() throws Exception{
  Class.forName("com.taosdata.jdbc.TSDBDriver");
  String jdbcUrl = "jdbc:TAOS://127.0.0.1:0/log?user=root&amp;password=taosdata";
  Properties connProps = new Properties();
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_USER, "root");
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_PASSWORD, "taosdata");
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_CONFIG_DIR, "/etc/taos");
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_CHARSET, "UTF-8");
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_LOCALE, "en_US.UTF-8");
  connProps.setProperty(TSDBDriver.PROPERTY_KEY_TIME_ZONE, "UTC-8");
  Connection conn = DriverManager.getConnection(jdbcUrl, connProps);
  return conn;
}</code></pre>
<ol start="3">
<li><p>客户端配置文件 taos.cfg</p>
<p>linux 系统默认配置文件为 /var/lib/taos/taos.cfg，windows 系统默认配置文件路径为 C:\TDengine\cfg\taos.cfg。</p></li>
</ol>
<pre><code class="properties language-properties"># client default username
# defaultUser           root

# client default password
# defaultPass           taosdata

# default system charset
# charset               UTF-8

# system locale
# locale                en_US.UTF-8</code></pre>
<blockquote>
  <p>更多详细配置请参考<a href="https://www.taosdata.com/cn/documentation/administrator/#%E5%AE%A2%E6%88%B7%E7%AB%AF%E9%85%8D%E7%BD%AE">客户端配置</a></p>
</blockquote>
<a class='anchor' id='创建数据库和表'></a><h3>创建数据库和表</h3>
<pre><code class="java language-java">Statement stmt = conn.createStatement();

// create database
stmt.executeUpdate("create database if not exists db");

// use database
stmt.executeUpdate("use db");

// create table
stmt.executeUpdate("create table if not exists tb (ts timestamp, temperature int, humidity float)");</code></pre>
<blockquote>
  <p>注意：如果不使用 <code>use db</code> 指定数据库，则后续对表的操作都需要增加数据库名称作为前缀，如 db.tb。</p>
</blockquote>
<a class='anchor' id='插入数据'></a><h3>插入数据</h3>
<pre><code class="java language-java">// insert data
int affectedRows = stmt.executeUpdate("insert into tb values(now, 23, 10.3) (now + 1s, 20, 9.3)");

System.out.println("insert " + affectedRows + " rows.");</code></pre>
<blockquote>
  <p>now 为系统内部函数，默认为服务器当前时间。
  <code>now + 1s</code> 代表服务器当前时间往后加 1 秒，数字后面代表时间单位：a(毫秒), s(秒), m(分), h(小时), d(天)，w(周), n(月), y(年)。</p>
</blockquote>
<a class='anchor' id='查询数据'></a><h3>查询数据</h3>
<pre><code class="java language-java">// query data
ResultSet resultSet = stmt.executeQuery("select * from tb");

Timestamp ts = null;
int temperature = 0;
float humidity = 0;
while(resultSet.next()){

    ts = resultSet.getTimestamp(1);
    temperature = resultSet.getInt(2);
    humidity = resultSet.getFloat("humidity");

    System.out.printf("%s, %d, %s\n", ts, temperature, humidity);
}</code></pre>
<blockquote>
  <p>查询和操作关系型数据库一致，使用下标获取返回字段内容时从 1 开始，建议使用字段名称获取。</p>
</blockquote>
<a class='anchor' id='关闭资源'></a><h3>关闭资源</h3>
<pre><code class="java language-java">resultSet.close();
stmt.close();
conn.close();</code></pre>
<blockquote>
  <p><code>注意务必要将 connection 进行关闭</code>，否则会出现连接泄露。</p>
  <a class='anchor' id='与连接池使用'></a><h2>与连接池使用</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#与连接池使用' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
</blockquote>
<p><strong>HikariCP</strong></p>
<ul>
<li>引入相应 HikariCP maven 依赖：</li>
</ul>
<pre><code class="xml language-xml">&lt;dependency&gt;
    &lt;groupId&gt;com.zaxxer&lt;/groupId&gt;
    &lt;artifactId&gt;HikariCP&lt;/artifactId&gt;
    &lt;version&gt;3.4.1&lt;/version&gt;
&lt;/dependency&gt;</code></pre>
<ul>
<li>使用示例如下：</li>
</ul>
<pre><code class="java language-java"> public static void main(String[] args) throws SQLException {
    HikariConfig config = new HikariConfig();
    config.setJdbcUrl("jdbc:TAOS://127.0.0.1:6030/log");
    config.setUsername("root");
    config.setPassword("taosdata");

    config.setMinimumIdle(3);           //minimum number of idle connection
    config.setMaximumPoolSize(10);      //maximum number of connection in the pool
    config.setConnectionTimeout(10000); //maximum wait milliseconds for get connection from pool
    config.setIdleTimeout(60000);       // max idle time for recycle idle connection 
    config.setConnectionTestQuery("describe log.dn"); //validation query
    config.setValidationTimeout(3000);   //validation query timeout

    HikariDataSource ds = new HikariDataSource(config); //create datasource

    Connection  connection = ds.getConnection(); // get connection
    Statement statement = connection.createStatement(); // get statement

    //query or insert 
    // ...

    connection.close(); // put back to conneciton pool
}</code></pre>
<blockquote>
  <p>通过 HikariDataSource.getConnection() 获取连接后，使用完成后需要调用 close() 方法，实际上它并不会关闭连接，只是放回连接池中。
  更多 HikariCP 使用问题请查看<a href="https://github.com/brettwooldridge/HikariCP">官方说明</a></p>
</blockquote>
<p><strong>Druid</strong></p>
<ul>
<li>引入相应 Druid maven 依赖：</li>
</ul>
<pre><code class="xml language-xml">&lt;dependency&gt;
    &lt;groupId&gt;com.alibaba&lt;/groupId&gt;
    &lt;artifactId&gt;druid&lt;/artifactId&gt;
    &lt;version&gt;1.1.20&lt;/version&gt;
&lt;/dependency&gt;</code></pre>
<ul>
<li>使用示例如下：</li>
</ul>
<pre><code class="java language-java">public static void main(String[] args) throws Exception {
    Properties properties = new Properties();
    properties.put("driverClassName","com.taosdata.jdbc.TSDBDriver");
    properties.put("url","jdbc:TAOS://127.0.0.1:6030/log");
    properties.put("username","root");
    properties.put("password","taosdata");

    properties.put("maxActive","10"); //maximum number of connection in the pool
    properties.put("initialSize","3");//initial number of connection
    properties.put("maxWait","10000");//maximum wait milliseconds for get connection from pool
    properties.put("minIdle","3");//minimum number of connection in the pool

    properties.put("timeBetweenEvictionRunsMillis","3000");// the interval milliseconds to test connection

    properties.put("minEvictableIdleTimeMillis","60000");//the minimum milliseconds to keep idle
    properties.put("maxEvictableIdleTimeMillis","90000");//the maximum milliseconds to keep idle

    properties.put("validationQuery","describe log.dn"); //validation query
    properties.put("testWhileIdle","true"); // test connection while idle
    properties.put("testOnBorrow","false"); // don't need while testWhileIdle is true
    properties.put("testOnReturn","false"); // don't need while testWhileIdle is true

    //create druid datasource
    DataSource ds = DruidDataSourceFactory.createDataSource(properties);
    Connection  connection = ds.getConnection(); // get connection
    Statement statement = connection.createStatement(); // get statement

    //query or insert 
    // ...

    connection.close(); // put back to conneciton pool
}</code></pre>
<blockquote>
  <p>更多 druid 使用问题请查看<a href="https://github.com/alibaba/druid">官方说明</a></p>
</blockquote>
<p><strong>注意事项</strong></p>
<ul>
<li>TDengine <code>v1.6.4.1</code> 版本开始提供了一个专门用于心跳检测的函数 <code>select server_status()</code>，所以在使用连接池时推荐使用 <code>select server_status()</code> 进行 Validation Query。</li>
</ul>
<p>如下所示，<code>select server_status()</code> 执行成功会返回 <code>1</code>。</p>
<pre><code class="shell language-shell">taos&gt; select server_status();
server_status()|
================
1              |
Query OK, 1 row(s) in set (0.000141s)</code></pre>
<a class='anchor' id='与框架使用'></a><h2>与框架使用</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#与框架使用' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<ul>
<li>Spring JdbcTemplate 中使用 taos-jdbcdriver，可参考 <a href="https://github.com/taosdata/TDengine/tree/develop/tests/examples/JDBC/SpringJdbcTemplate">SpringJdbcTemplate</a></li>
<li>Springboot + Mybatis 中使用，可参考 <a href="https://github.com/taosdata/TDengine/tree/develop/tests/examples/JDBC/springbootdemo">springbootdemo</a></li>
</ul>
<a class='anchor' id='常见问题'></a><h2>常见问题</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#常见问题' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<ul>
<li><p>java.lang.UnsatisfiedLinkError: no taos in java.library.path</p>
<p><strong>原因</strong>：程序没有找到依赖的本地函数库 taos。</p>
<p><strong>解决方法</strong>：windows 下可以将 C:\TDengine\driver\taos.dll 拷贝到 C:\Windows\System32\ 目录下，linux 下将建立如下软链 <code>ln -s /usr/local/taos/driver/libtaos.so.x.x.x.x /usr/lib/libtaos.so</code> 即可。</p></li>
<li><p>java.lang.UnsatisfiedLinkError: taos.dll Can't load AMD 64 bit on a IA 32-bit platform</p>
<p><strong>原因</strong>：目前 TDengine 只支持 64 位 JDK。</p>
<p><strong>解决方法</strong>：重新安装 64 位 JDK。</p></li>
<li><p>其它问题请参考 <a href="https://github.com/taosdata/TDengine/issues">Issues</a></p></li>
</ul>
<a class='anchor' id='Python-Connector'></a><h2>Python Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#python-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='安装准备'></a><h3>安装准备</h3>
<ul>
<li>已安装TDengine, 如果客户端在Windows上，需要安装Windows 版本的TDengine客户端 <a href="https://www.taosdata.com/cn/documentation/connector/#Windows客户端及程序接口">（Windows TDengine 客户端安装）</a></li>
<li>已安装python 2.7 or &gt;= 3.4</li>
<li>已安装pip</li>
</ul>
<a class='anchor' id='Python客户端安装'></a><h3>Python客户端安装</h3>
<h4>Linux</h4>
<p>用户可以在源代码的src/connector/python文件夹下找到python2和python3的安装包。用户可以通过pip命令安装： </p>
<p>​    <code>pip install src/connector/python/linux/python2/</code></p>
<p>或</p>
<p>​    <code>pip install src/connector/python/linux/python3/</code></p>
<h4>Windows</h4>
<p>在已安装Windows TDengine 客户端的情况下， 将文件"C:\TDengine\driver\taos.dll" 拷贝到 "C:\windows\system32" 目录下, 然后进入Windwos <em>cmd</em> 命令行界面</p>
<pre><code class="cmd language-cmd">cd C:\TDengine\connector\python\windows
pip install python2\</code></pre>
<p>或</p>
<pre><code class="cmd language-cmd">cd C:\TDengine\connector\python\windows
pip install python3\</code></pre>
<p>*如果机器上没有pip命令，用户可将src/connector/python/python3或src/connector/python/python2下的taos文件夹拷贝到应用程序的目录使用。
对于windows 客户端，安装TDengine windows 客户端后，将C:\TDengine\driver\taos.dll拷贝到C:\windows\system32目录下即可。</p>
<a class='anchor' id='使用'></a><h3>使用</h3>
<h4>代码示例</h4>
<ul>
<li>导入TDengine客户端模块</li>
</ul>
<pre><code class="python language-python">import taos </code></pre>
<ul>
<li>获取连接</li>
</ul>
<pre><code class="python language-python">conn = taos.connect(host="127.0.0.1", user="root", password="taosdata", config="/etc/taos")
c1 = conn.cursor()</code></pre>
<p>*<em>host</em> 是TDengine 服务端所有IP, <em>config</em> 为客户端配置文件所在目录</p>
<ul>
<li>写入数据</li>
</ul>
<pre><code class="python language-python">import datetime

# 创建数据库
c1.execute('create database db')
c1.execute('use db')
# 建表
c1.execute('create table tb (ts timestamp, temperature int, humidity float)')
# 插入数据
start_time = datetime.datetime(2019, 11, 1)
affected_rows = c1.execute('insert into tb values (\'%s\', 0, 0.0)' %start_time)
# 批量插入数据
time_interval = datetime.timedelta(seconds=60)
sqlcmd = ['insert into tb values']
for irow in range(1,11):
  start_time += time_interval
  sqlcmd.append('(\'%s\', %d, %f)' %(start_time, irow, irow*1.2))
affected_rows = c1.execute(' '.join(sqlcmd))</code></pre>
<ul>
<li>查询数据</li>
</ul>
<pre><code class="python language-python">c1.execute('select * from tb')
# 拉取查询结果
data = c1.fetchall()
# 返回的结果是一个列表，每一行构成列表的一个元素
numOfRows = c1.rowcount
numOfCols = len(c1.description)
for irow in range(numOfRows):
  print("Row%d: ts=%s, temperature=%d, humidity=%f" %(irow, data[irow][0], data[irow][1],data[irow][2]))

# 直接使用cursor 循环拉取查询结果
c1.execute('select * from tb')
for data in c1:
  print("ts=%s, temperature=%d, humidity=%f" %(data[0], data[1],data[2])</code></pre>
<ul>
<li>创建订阅</li>
</ul>
<pre><code class="python language-python"># 创建一个主题为 'test' 消费周期为1000毫秒的订阅
# 第一个参数为 True 表示重新开始订阅，如为 False 且之前创建过主题为 'test' 的订阅，则表示继续消费此订阅的数据，而不是重新开始消费所有数据
sub = conn.subscribe(True, "test", "select * from meters;", 1000)</code></pre>
<ul>
<li>消费订阅的数据</li>
</ul>
<pre><code class="python language-python">data = sub.consume()
for d in data:
    print(d)</code></pre>
<ul>
<li>取消订阅</li>
</ul>
<pre><code class="python language-python">sub.close()</code></pre>
<ul>
<li>关闭连接</li>
</ul>
<pre><code class="python language-python">c1.close()
conn.close()</code></pre>
<h4>帮助信息</h4>
<p>用户可通过python的帮助信息直接查看模块的使用信息，或者参考code/examples/python中的示例程序。以下为部分常用类和方法：</p>
<ul>
<li><p><em>TDengineConnection</em>类</p>
<p>参考python中help(taos.TDengineConnection)。</p></li>
<li><p><em>TDengineCursor</em>类</p>
<p>参考python中help(taos.TDengineCursor)。</p></li>
<li><p><em>connect</em>方法</p>
<p>用于生成taos.TDengineConnection的实例。</p></li>
</ul>
<a class='anchor' id='RESTful-Connector'></a><h2>RESTful Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#restful-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>为支持各种不同类型平台的开发，TDengine提供符合REST设计标准的API，即RESTful API。为最大程度降低学习成本，不同于其他数据库RESTful API的设计方法，TDengine直接通过HTTP POST 请求BODY中包含的SQL语句来操作数据库，仅需要一个URL。 </p>
<a class='anchor' id='HTTP请求格式'></a><h3>HTTP请求格式</h3>
<pre><code>http://&lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<p>参数说明：</p>
<ul>
<li>IP: 集群中的任一台主机</li>
<li>PORT: 配置文件中httpPort配置项，缺省为6020</li>
</ul>
<p>例如：http://192.168.0.1:6020/rest/sql 是指向IP地址为192.168.0.1的URL. </p>
<p>HTTP请求的Header里需带有身份认证信息，TDengine支持Basic认证与自定义认证两种机制，后续版本将提供标准安全的数字签名机制来做身份验证。</p>
<ul>
<li>自定义身份认证信息如下所示（<token>稍后介绍）</li>
</ul>
<pre><code>Authorization: Taosd &lt;TOKEN&gt;</code></pre>
<ul>
<li>Basic身份认证信息如下所示</li>
</ul>
<pre><code>Authorization: Basic &lt;TOKEN&gt;</code></pre>
<p>HTTP请求的BODY里就是一个完整的SQL语句，SQL语句中的数据表应提供数据库前缀，例如\<db-name>.\<tb-name>。如果表名不带数据库前缀，系统会返回错误。因为HTTP模块只是一个简单的转发，没有当前DB的概念。 </p>
<p>使用curl通过自定义身份认证方式来发起一个HTTP Request, 语法如下：</p>
<pre><code>curl -H 'Authorization: Basic &lt;TOKEN&gt;' -d '&lt;SQL&gt;' &lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<p>或者</p>
<pre><code>curl -u username:password -d '&lt;SQL&gt;' &lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<p>其中，<code>TOKEN</code>为<code>{username}:{password}</code>经过Base64编码之后的字符串, 例如<code>root:taosdata</code>编码后为<code>cm9vdDp0YW9zZGF0YQ==</code></p>
<a class='anchor' id='HTTP返回格式'></a><h3>HTTP返回格式</h3>
<p>返回值为JSON格式，如下:</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2", …],
    "data": [
        ["2017-12-12 23:44:25.730", 1],
        ["2017-12-12 22:44:25.728", 4]
    ],
    "rows": 2
} </code></pre>
<p>说明：</p>
<ul>
<li>status: 告知操作结果是成功还是失败</li>
<li>head: 表的定义，如果不返回结果集，仅有一列“affected_rows”</li>
<li>data: 具体返回的数据，一排一排的呈现,如果不返回结果集，仅[[affected_rows]]</li>
<li>rows: 表明总共多少行数据</li>
</ul>
<a class='anchor' id='自定义授权码'></a><h3>自定义授权码</h3>
<p>HTTP请求中需要带有授权码<code>&lt;TOKEN&gt;</code>, 用于身份识别。授权码通常由管理员提供, 可简单的通过发送<code>HTTP GET</code>请求来获取授权码, 操作如下：</p>
<pre><code>curl http://&lt;ip&gt;:6020/rest/login/&lt;username&gt;/&lt;password&gt;</code></pre>
<p>其中, <code>ip</code>是TDengine数据库的IP地址, <code>username</code>为数据库用户名, <code>password</code>为数据库密码, 返回值为<code>JSON</code>格式, 各字段含义如下：</p>
<ul>
<li><p>status：请求结果的标志位</p></li>
<li><p>code：返回值代码</p></li>
<li><p>desc: 授权码</p></li>
</ul>
<p>获取授权码示例：</p>
<pre><code>curl http://192.168.0.1:6020/rest/login/root/taosdata</code></pre>
<p>返回值：</p>
<pre><code>{
  "status": "succ",
  "code": 0,
  "desc": 
"/KfeAzX/f9na8qdtNZmtONryp201ma04bEl8LcvLUd7a8qdtNZmtONryp201ma04"
}</code></pre>
<a class='anchor' id='使用示例'></a><h3>使用示例</h3>
<ul>
<li>在demo库里查询表t1的所有记录： </li>
</ul>
<pre><code>curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'select * from demo.t1' 192.168.0.1:6020/rest/sql`</code></pre>
<p>返回值：</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2","column3"],
    "data": [
        ["2017-12-12 22:44:25.728",4,5.60000],
        ["2017-12-12 23:44:25.730",1,2.30000]
    ],
    "rows": 2
}</code></pre>
<ul>
<li>创建库demo：</li>
</ul>
<pre><code>curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'create database demo' 192.168.0.1:6020/rest/sql`</code></pre>
<p>返回值：</p>
<pre><code>{
    "status": "succ",
    "head": ["affected_rows"],
    "data": [[1]],
    "rows": 1,
}</code></pre>
<a class='anchor' id='其他用法'></a><h3>其他用法</h3>
<h4>结果集采用Unix时间戳</h4>
<p>HTTP请求URL采用<code>sqlt</code>时，返回结果集的时间戳将采用Unix时间戳格式表示，例如</p>
<pre><code>curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'select * from demo.t1' 192.168.0.1:6020/rest/sqlt</code></pre>
<p>返回值：</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2","column3"],
    "data": [
        [1513089865728,4,5.60000],
        [1513093465730,1,2.30000]
    ],
    "rows": 2
}</code></pre>
<h4>结果集采用UTC时间字符串</h4>
<p>HTTP请求URL采用<code>sqlutc</code>时，返回结果集的时间戳将采用UTC时间字符串表示，例如</p>
<pre><code>  curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'select * from demo.t1' 192.168.0.1:6020/rest/sqlutc</code></pre>
<p>返回值：</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2","column3"],
    "data": [
        ["2017-12-12T22:44:25.728+0800",4,5.60000],
        ["2017-12-12T23:44:25.730+0800",1,2.30000]
    ],
    "rows": 2
}</code></pre>
<a class='anchor' id='重要配置项'></a><h3>重要配置项</h3>
<p>下面仅列出一些与RESTFul接口有关的配置参数，其他系统参数请看配置文件里的说明。注意：配置修改后，需要重启taosd服务才能生效</p>
<ul>
<li>httpIp: 对外提供RESTFul服务的IP地址，默认绑定到0.0.0.0</li>
<li>httpPort: 对外提供RESTFul服务的端口号，默认绑定到6020</li>
<li>httpMaxThreads: 启动的线程数量，默认为2</li>
<li>httpCacheSessions: 缓存连接的数量，并发请求数目需小于此数值的10倍，默认值为100</li>
<li>restfulRowLimit: 返回结果集（JSON格式）的最大条数，默认值为10240</li>
<li>httpEnableCompress: 是否支持压缩，默认不支持，目前TDengine仅支持gzip压缩格式</li>
<li>httpDebugFlag: 日志开关，131：仅错误和报警信息，135：所有，默认131</li>
</ul>
<a class='anchor' id='Go-Connector'></a><h2>Go Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#go-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='linux环境'></a><h3>linux环境</h3>
<h4>安装TDengine</h4>
<p>Go的连接器使用到了 libtaos.so 和taos.h，因此，在使用Go连接器之前，需要在程序运行的机器上安装TDengine以获得相关的驱动文件。</p>
<h4>Go语言引入package</h4>
<p>TDengine提供了GO驱动程序“taosSql”包。taosSql驱动包是基于GO的“database/sql/driver”接口的实现。用户可以通过<code>go get</code>命令来获取驱动包。</p>
<pre><code class="sh language-sh">go get github.com/taosdata/TDengine/src/connector/go/src/taosSql</code></pre>
<p>然后在应用程序中导入驱动包，就可以使用“database/sql”中定义的接口访问TDengine：</p>
<pre><code class="Go language-Go">import (
    "database/sql"
    _ "github.com/taosdata/TDengine/src/connector/go/src/taosSql"
)</code></pre>
<p>taosSql驱动包内采用cgo模式，调用了TDengine的C/C++同步接口，与TDengine进行交互，因此，在数据库操作执行完成之前，客户端应用将处于阻塞状态。单个数据库连接，在同一时刻只能有一个线程调用API。客户应用可以建立多个连接，进行多线程的数据写入或查询处理。</p>
<h4>Go语言使用参考</h4>
<p>在Go程序中使用TDengine写入方法大致可以分为以下几步</p>
<ol>
<li>打开TDengine数据库链接</li>
</ol>
<p>首先需要调用sql包中的Open方法，打开数据库，并获得db对象</p>
<pre><code class="go language-go">  db, err := sql.Open(taosDriverName, dbuser+":"+dbpassword+"@/tcp("+daemonUrl+")/"+dbname)
  if err != nil {
    log.Fatalf("Open database error: %s\n", err)
  }
  defer db.Close()</code></pre>
<p>其中参数为</p>
<ul>
<li>taosDataname: 涛思数据库的名称，其值为字符串"taosSql"</li>
<li>dbuser和dbpassword: 链接TDengine的用户名和密码，缺省为root和taosdata，类型为字符串</li>
<li>daemonUrl: 为TDengine的地址，其形式为<code>ip address:port</code>形式，port填写缺省值0即可。例如："116.118.24.71:0"</li>
<li>dbname：TDengine中的database名称，通过<code>create database</code>创建的数据库。如果为空则在后续的写入和查询操作必须通过”数据库名.超级表名或表名“的方式指定数据库名</li>
</ul>
<ol>
<li>创建数据库</li>
</ol>
<p>打开TDengine数据库连接后，首选需要创建数据库。基本用法和直接在TDengine客户端shell下一样，通过create database + 数据库名的方法来创建。</p>
<pre><code class="go language-go">  db, err := sql.Open(taosDriverName, dbuser+":"+dbpassword+"@/tcp("+daemonUrl+")/")
  if err != nil {
    log.Fatalf("Open database error: %s\n", err)
  }
    defer db.Close()

    //准备创建数据库语句
    sqlcmd := fmt.Sprintf("create database if not exists %s", dbname)

    //执行语句并检查错误
    _, err = db.Exec(sqlcmd)
    if err != nil {
        log.Fatalf("Create database error: %s\n", err)
    }</code></pre>
<ol start="3">
<li>创建表、写入和查询数据</li>
</ol>
<p>在创建好了数据库后，就可以开始创建表和写入查询数据了。这些操作的基本思路都是首先组装SQL语句，然后调用db.Exec执行，并检查错误信息和执行相应的处理。可以参考上面的样例代码。</p>
<a class='anchor' id='windows环境'></a><h3>windows环境</h3>
<p>在windows上使用Go，请参考&nbsp;
<a href="https://www.taosdata.com/blog/2020/01/06/tdengine-go-windows%E9%A9%B1%E5%8A%A8%E7%9A%84%E7%BC%96%E8%AF%91/">TDengine GO windows驱动的编译和使用</a></p>
<a class='anchor' id='Node.js-Connector'></a><h2>Node.js Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#node.js-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine 同时也提供了node.js 的连接器。用户可以通过<a href="https://www.npmjs.com/">npm</a>来进行安装，也可以通过源代码<em>src/connector/nodejs/</em> 来进行安装。<a href="https://github.com/taosdata/tdengine/tree/master/src/connector/nodejs">具体安装步骤如下</a>：</p>
<p>首先，通过<a href="https://www.npmjs.com/">npm</a>安装node.js 连接器.</p>
<pre><code class="cmd language-cmd">npm install td-connector</code></pre>
<p>我们建议用户使用npm 安装node.js连接器。如果您没有安装npm, 可以将<em>src/connector/nodejs/</em>拷贝到您的nodejs 项目目录下</p>
<p>我们使用<a href="https://github.com/nodejs/node-gyp">node-gyp</a>和TDengine服务端进行交互。安装node.js 连接器之前，还需安装以下软件：</p>
<a class='anchor' id='Unix'></a><h3>Unix</h3>
<ul>
<li><code>python</code> (建议<code>v2.7</code> , <code>v3.x.x</code> 目前还不支持)</li>
<li><code>make</code></li>
<li>c语言编译器比如<a href="https://gcc.gnu.org">GCC</a></li>
</ul>
<a class='anchor' id='macOS'></a><h3>macOS</h3>
<ul>
<li><p><code>python</code> (建议<code>v2.7</code> , <code>v3.x.x</code> 目前还不支持)</p></li>
<li><p>Xcode</p></li>
<li><p>然后通过Xcode安装</p>
<pre><code>Command Line Tools</code></pre>
<p>在</p>
<pre><code>Xcode -&gt; Preferences -&gt; Locations</code></pre>
<p>目录下可以找到这个工具。或者在终端里执行</p>
<pre><code>xcode-select --install</code></pre>
<ul>
<li>该步执行后 <code>gcc</code> 和 <code>make</code>就被安装上了</li></ul></li>
</ul>
<a class='anchor' id='Windows'></a><h3>Windows</h3>
<h4>安装方法1</h4>
<p>使用微软的<a href="https://github.com/felixrieseberg/windows-build-tools">windows-build-tools</a>在<code>cmd</code> 命令行界面执行<code>npm install --global --production windows-build-tools</code> 即可安装所有的必备工具</p>
<h4>安装方法2</h4>
<p>手动安装以下工具:</p>
<ul>
<li>安装Visual Studio相关：<a href="https://visualstudio.microsoft.com/thank-you-downloading-visual-studio/?sku=BuildTools">Visual Studio Build 工具</a> 或者 <a href="https://visualstudio.microsoft.com/pl/thank-you-downloading-visual-studio/?sku=Community">Visual Studio 2017 Community</a> </li>
<li>安装 <a href="https://www.python.org/downloads/">Python 2.7</a> (<code>v3.x.x</code> 暂不支持) 并执行 <code>npm config set python python2.7</code> </li>
<li>进入<code>cmd</code>命令行界面, <code>npm config set msvs_version 2017</code></li>
</ul>
<p>如果以上步骤不能成功执行, 可以参考微软的node.js用户手册<a href="https://github.com/Microsoft/nodejs-guidelines/blob/master/windows-environment.md#compiling-native-addon-modules">Microsoft's Node.js Guidelines for Windows</a></p>
<p>如果在Windows 10 ARM 上使用ARM64 Node.js, 还需添加 "Visual C++ compilers and libraries for ARM64" 和 "Visual  C++ ATL for ARM64".</p>
<a class='anchor' id='使用方法'></a><h3>使用方法</h3>
<p>(http://docs.taosdata.com/node)
以下是node.js 连接器的一些基本使用方法，详细的使用方法可参考<a href="http://docs.taosdata.com/node">该文档</a></p>
<h4>连接</h4>
<p>使用node.js连接器时，必须先<em>require</em> <code>td-connector</code>，然后使用 <code>taos.connect</code> 函数。<code>taos.connect</code> 函数必须提供的参数是<code>host</code>，其它参数在没有提供的情况下会使用如下的默认值。最后需要初始化<code>cursor</code> 来和TDengine服务端通信 </p>
<pre><code class="javascript language-javascript">const taos = require('td-connector');
var conn = taos.connect({host:"127.0.0.1", user:"root", password:"taosdata", config:"/etc/taos",port:0})
var cursor = conn.cursor(); // Initializing a new cursor</code></pre>
<p>关闭连接可执行</p>
<pre><code class="javascript language-javascript">conn.close();</code></pre>
<h4>查询</h4>
<p>可通过 <code>cursor.query</code> 函数来查询数据库。</p>
<pre><code class="javascript language-javascript">var query = cursor.query('show databases;')</code></pre>
<p>查询的结果可以通过 <code>query.execute()</code> 函数获取并打印出来</p>
<pre><code class="javascript language-javascript">var promise = query.execute();
promise.then(function(result) {
  result.pretty(); 
});</code></pre>
<p>格式化查询语句还可以使用<code>query</code>的<code>bind</code>方法。如下面的示例：<code>query</code>会自动将提供的数值填入查询语句的<code>?</code>里。</p>
<pre><code class="javascript language-javascript">var query = cursor.query('select * from meterinfo.meters where ts &lt;= ? and areaid = ?;').bind(new Date(), 5);
query.execute().then(function(result) {
  result.pretty();
})</code></pre>
<p>如果在<code>query</code>语句里提供第二个参数并设为<code>true</code>也可以立即获取查询结果。如下：</p>
<pre><code class="javascript language-javascript">var promise = cursor.query('select * from meterinfo.meters where v1 = 30;', true)
promise.then(function(result) {
  result.pretty();
})</code></pre>
<h4>异步函数</h4>
<p>异步查询数据库的操作和上面类似，只需要在<code>cursor.execute</code>, <code>TaosQuery.execute</code>等函数后面加上<code>_a</code>。</p>
<pre><code class="javascript language-javascript">var promise1 = cursor.query('select count(*), avg(v1), avg(v2) from meter1;').execute_a()
var promise2 = cursor.query('select count(*), avg(v1), avg(v2) from meter2;').execute_a();
promise1.then(function(result) {
  result.pretty();
})
promise2.then(function(result) {
  result.pretty();
})</code></pre>
<a class='anchor' id='示例'></a><h3>示例</h3>
<p><a href="https://github.com/taosdata/TDengine/tree/master/tests/examples/nodejs/node-example.js">这里</a>提供了一个使用NodeJS 连接器建表，插入天气数据并查询插入的数据的代码示例</p>
<p><a href="https://github.com/taosdata/TDengine/tree/master/tests/examples/nodejs/node-example-raw.js">这里</a>同样是一个使用NodeJS 连接器建表，插入天气数据并查询插入的数据的代码示例，但和上面不同的是，该示例只使用<code>cursor</code>.</p>
<a class='anchor' id='CSharp-Connector'></a><h2>CSharp Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#csharp-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>在Windows系统上，C#应用程序可以使用TDengine的原生C接口来执行所有数据库操作，后续版本将提供ORM（dapper）框架驱动。</p>
<h4>安装TDengine客户端</h4>
<p>C#连接器需要使用<code>libtaos.so</code>和<code>taos.h</code>。因此，在使用C#连接器之前，需在程序运行的Windows环境安装TDengine的Windows客户端，以便获得相关驱动文件。</p>
<p>安装完成后，在文件夹<code>C:/TDengine/examples/C#</code>中，将会看到两个文件</p>
<ul>
<li>TDengineDriver.cs 调用taos.dll文件的Native C方法</li>
<li>TDengineTest.cs 参考程序示例</li>
</ul>
<p>在文件夹<code>C:\Windows\System32</code>，将会看到<code>taos.dll</code>文件</p>
<h4>使用方法</h4>
<ul>
<li>将C#接口文件TDengineDriver.cs加入到应用程序所在.NET项目中</li>
<li>参考TDengineTest.cs来定义数据库连接参数，及执行数据插入、查询等操作的方法</li>
<li>因为C#接口需要用到<code>taos.dll</code>文件，用户可以将<code>taos.dll</code>文件加入.NET解决方案中</li>
</ul>
<h4>注意事项</h4>
<ul>
<li><code>taos.dll</code>文件使用x64平台编译，所以.NET项目在生成.exe文件时，“解决方案”/“项目”的“平台”请均选择“x64”。</li>
<li>此.NET接口目前已经在Visual Studio 2013/2015/2017中验证过，其它VS版本尚待验证。</li>
</ul>
<h4>第三方驱动</h4>
<p>Maikebing.Data.Taos是一个基于TDengine的RESTful Connector构建的ADO.Net提供器，该开发包由热心贡献者<code>麦壳饼@@maikebing</code>提供，具体请参考</p>
<pre><code>https://gitee.com/maikebing/Maikebing.EntityFrameworkCore.Taos</code></pre>
<a class='anchor' id='Windows客户端及程序接口'></a><h2>Windows客户端及程序接口</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#windows客户端及程序接口' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='客户端安装'></a><a class='anchor' id='客户端安装'></a><h3>客户端安装</h3>
<p>在Windows操作系统下，TDengine提供64位的Windows客户端(<a href="https://www.taosdata.com/cn/all-downloads/#tdengine_win-list">点击下载</a>)，客户端安装程序为.exe文件，运行该文件即可安装，安装路径为C:\TDengine。Windows的客户端可运行在主流的64位Windows平台之上，客户端目录结构如下：</p>
<pre><code>├── cfg
├───└── taos.cfg
├── connector
├───├── go
├───├── grafana
├───├── jdbc
├───└── python
├── driver
├───├── libtaos.dll
├───├── libtaos.dll.a
├───├── taos.dll
├───├── taos.exp
├───└── taos.lib
├── examples
├───├── bash
├───├── c
├───├── C#
├───├── go
├───├── JDBC
├───├── lua
├───├── matlab
├───├── nodejs
├───├── python
├───├── R
├───└── rust
├── include
├───└── taos.h
└── taos.exe</code></pre>
<p>其中，最常用的文件列出如下：</p>
<ul>
<li>Client可执行文件: C:/TDengine/taos.exe </li>
<li>配置文件: C:/TDengine/cfg/taos.cfg</li>
<li>驱动程序目录: C:/TDengine/driver</li>
<li>驱动程序头文件: C:/TDengine/include</li>
<li>JDBC驱动程序目录: C:/TDengine/connector/jdbc</li>
<li>GO驱动程序目录：C:/TDengine/connector/go</li>
<li>Python驱动程序目录：C:/TDengine/connector/python</li>
<li>C#驱动程序及示例代码: C:/TDengine/examples/C#</li>
<li>日志目录（第一次运行程序时生成）：C:/TDengine/log</li>
</ul>
<a class='anchor' id='注意事项'></a><h3>注意事项</h3>
<h4>Shell工具注意事项</h4>
<p>在开始菜单中搜索cmd程序，通过命令行方式执行taos.exe即可打开TDengine的Client程序，如下所示，其中ServerIP为TDengine所在Linux服务器的IP地址</p>
<pre><code>taos -h &lt;ServerIP&gt;</code></pre>
<p>在cmd中对taos的使用与Linux平台没有差别，但需要注意以下几点：</p>
<ul>
<li>确保Windows防火墙或者其他杀毒软件处于关闭状态，TDengine的服务端与客户端通信的端口请参考<code>服务端配置</code>章节</li>
<li>确认客户端连接时指定了正确的服务器IP地址</li>
<li>ping服务器IP，如果没有反应，请检查你的网络</li>
</ul>
<h4>C++接口注意事项</h4>
<p>TDengine在Window系统上提供的API与Linux系统是相同的， 应用程序使用时，需要包含TDengine头文件taos.h，连接时需要链接TDengine库taos.lib，运行时将taos.dll放到可执行文件目录下。</p>
<h4>Go接口注意事项</h4>
<p>TDengine在Window系统上提供的API与Linux系统是相同的， 应用程序使用时，除了需要Go的驱动包（C:\TDengine\connector\go）外，还需要包含TDengine头文件taos.h，连接时需要链接TDengine库libtaos.dll、libtaos.dll.a（C:\TDengine\driver），运行时将libtaos.dll、libtaos.dll.a放到可执行文件目录下。</p>
<p>使用参考请见：</p>
<p><a href="https://www.taosdata.com/blog/2020/01/06/tdengine-go-windows%E9%A9%B1%E5%8A%A8%E7%9A%84%E7%BC%96%E8%AF%91/">TDengine GO windows驱动的编译和使用</a></p>
<h4>JDBC接口注意事项</h4>
<p>在Windows系统上，应用程序可以使用JDBC接口来操纵数据库，使用JDBC接口的注意事项如下：</p>
<ul>
<li><p>将JDBC驱动程序(JDBCDriver-1.0.0-dist.jar)放置到当前的CLASS_PATH中;</p></li>
<li><p>将Windows开发包(taos.dll)放置到system32目录下。</p></li>
</ul>
<h4>python接口注意事项</h4>
<p>在Windows系统上，应用程序可以通过导入taos这个模块来操纵数据库，使用python接口的注意事项如下：</p>
<ul>
<li><p>确定在Windows上安装了TDengine客户端</p></li>
<li><p>将Windows开发包(taos.dll)放置到system32目录下。</p></li>
</ul>
<a class='anchor' id='Mac客户端及程序接口'></a><h2>Mac客户端及程序接口</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/connector-ch.md#mac客户端及程序接口' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<h3>客户端安装</h3>
<p>在Mac操作系统下，TDengine提供64位的Mac客户端(<a href="https://www.taosdata.com/cn/all-downloads/#tdengine_mac-list">2月10日起提供下载</a>)，客户端安装程序为.tar.gz文件，解压并运行其中的install_client.sh后即可完成安装，安装路径为/usr/loca/taos。客户端目录结构如下：</p>
<pre><code>├── cfg
├───└── taos.cfg
├── connector
├───├── go
├───├── grafana
├───├── jdbc
├───└── python
├── driver
├───├── libtaos.1.6.5.1.dylib
├── examples
├───├── bash
├───├── c
├───├── C#
├───├── go
├───├── JDBC
├───├── lua
├───├── matlab
├───├── nodejs
├───├── python
├───├── R
├───└── rust
├── include
├───└── taos.h
└── bin
├───└── taos</code></pre>
<p>其中，最常用的文件列出如下：</p>
<ul>
<li>Client可执行文件: /usr/local/taos/bin/taos 软连接到 /usr/local/bin/taos</li>
<li>配置文件: /usr/local/taos/cfg/taos.cfg 软连接到 /etc/taos/taos.cfg</li>
<li>驱动程序目录: /usr/local/taos/driver/libtaos.1.6.5.1.dylib 软连接到 /usr/local/lib/libtaos.dylib</li>
<li>驱动程序头文件: /usr/local/taos/include/taos.h 软连接到 /usr/local/include/taos.h</li>
<li>日志目录（第一次运行程序时生成）：~/TDengineLog</li>
</ul></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>