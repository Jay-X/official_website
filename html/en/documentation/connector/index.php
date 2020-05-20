<!DOCTYPE html><html lang='en'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?><title>Documentation | TAOS Data</title><meta name='description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.'><meta name='keywords' content='TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Documentation, programming, coding, syntax, frequently asked questions, questions, faq'><meta name='title' content='Documentation | TAOS Data'><meta property='og:site_name' content='TAOS Data'/><meta property='og:title' content='Documentation | TAOS Data'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connector/index.php'/><meta property='og:description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/connector/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>TDengine connectors</h1>
<p>TDengine provides many connectors for development, including C/C++, JAVA, Python, RESTful, Go, Node.JS, etc.</p>
<a class='anchor' id='C/C++-API'></a><h2>C/C++ API</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#c/c++-api' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>C/C++ APIs are similar to the MySQL APIs. Applications should include TDengine head file <em>taos.h</em> to use C/C++ APIs by adding the following line in code:</p>
<pre><code class="C language-C">#include &lt;taos.h&gt;</code></pre>
<p>Make sure TDengine library <em>libtaos.so</em> is installed and use <em>-ltaos</em> option to link the library when compiling. In most cases, if the return value of an API is integer, it return <em>0</em> for success and other values as an error code for failure; if the return value is pointer, then <em>NULL</em> is used for failure.</p>
<a class='anchor' id='C/C++-sync-API'></a><h3>C/C++ sync API</h3>
<p>Sync APIs are those APIs waiting for responses from the server after sending a request. TDengine has the following sync APIs:</p>
<ul>
<li><p><code>TAOS *taos_connect(char *ip, char *user, char *pass, char *db, int port)</code></p>
<p>Open a connection to a TDengine server. The parameters are <em>ip</em> (IP address of the server), <em>user</em> (username to login), <em>pass</em> (password to login), <em>db</em> (database to use after connection) and <em>port</em> (port number to connect). The parameter <em>db</em> can be NULL for no database to use after connection. Otherwise, the database should exist before connection or a connection error is reported. The handle returned by this API should be kept for future use.</p></li>
<li><p><code>void taos_close(TAOS *taos)</code></p>
<p>Close a connection to a TDengine server by the handle returned by <em>taos_connect</em>`</p></li>
<li><p><code>int taos_query(TAOS *taos, char *sqlstr)</code></p>
<p>The API used to run a SQL command. The command can be DQL or DML. The parameter <em>taos</em> is the handle returned by <em>taos_connect</em>. Return value <em>-1</em> means failure.</p></li>
<li><p><code>TAOS_RES *taos_use_result(TAOS *taos)</code></p>
<p>Use the result after running <em>taos_query</em>. The handle returned should be kept for future fetch.</p></li>
<li><p><code>TAOS_ROW taos_fetch_row(TAOS_RES *res)</code></p>
<p>Fetch a row of return results through <em>res</em>, the handle returned by <em>taos_use_result</em>.</p></li>
<li><p><code>int taos_num_fields(TAOS_RES *res)</code></p>
<p>Get the number of fields in the return result.</p></li>
<li><p><code>TAOS_FIELD *taos_fetch_fields(TAOS_RES *res)</code></p>
<p>Fetch the description of each field. The description includes the property of data type, field name, and bytes. The API should be used with <em>taos_num_fields</em> to fetch a row of data.</p></li>
<li><p><code>void taos_free_result(TAOS_RES *res)</code></p>
<p>Free the resources used by a result set. Make sure to call this API after fetching results or memory leak would happen.</p></li>
<li><p><code>void taos_init()</code></p>
<p>Initialize the environment variable used by TDengine client. The API is not necessary since it is called int <em>taos_connect</em> by default.</p></li>
<li><p><code>char *taos_errstr(TAOS *taos)</code></p>
<p>Return the reason of the last API call failure. The return value is a string.</p></li>
<li><p><code>int *taos_errno(TAOS *taos)</code></p>
<p>Return the error code of the last API call failure. The return value is an integer.</p></li>
<li><p><code>int taos_options(TSDB_OPTION option, const void * arg, ...)</code></p>
<p>Set client options. The parameter <em>option</em> supports values of <em>TSDB_OPTION_CONFIGDIR</em> (configuration directory), <em>TSDB_OPTION_SHELL_ACTIVITY_TIMER</em>, <em>TSDB_OPTION_LOCALE</em> (client locale) and <em>TSDB_OPTION_TIMEZONE</em> (client timezone).</p></li>
</ul>
<p>The 12 APIs are the most important APIs frequently used. Users can check <em>taos.h</em> file for more API information.</p>
<p><strong>Note</strong>: The connection to a TDengine server is not multi-thread safe. So a connection can only be used by one thread.</p>
<a class='anchor' id='C/C++-parameter-binding-API'></a><h3>C/C++ parameter binding API</h3>
<p>TDengine also provides parameter binding APIs, like MySQL, only question mark <code>?</code> can be used to represent a parameter in these APIs.</p>
<ul>
<li><p><code>TAOS_STMT* taos_stmt_init(TAOS *taos)</code></p>
<p>Create a TAOS_STMT to represent the prepared statement for other APIs.</p></li>
<li><p><code>int taos_stmt_prepare(TAOS_STMT *stmt, const char *sql, unsigned long length)</code></p>
<p>Parse SQL statement <em>sql</em> and bind result to <em>stmt</em> , if <em>length</em> larger than 0, its value is used to determine the length of <em>sql</em>, the API auto detects the actual length of <em>sql</em> otherwise.</p></li>
<li><p><code>int taos_stmt_bind_param(TAOS_STMT *stmt, TAOS_BIND *bind)</code></p>
<p>Bind values to parameters. <em>bind</em> points to an array, the element count and sequence of the array must be identical as the parameters of the SQL statement. The usage of <em>TAOS_BIND</em> is same as <em>MYSQL_BIND</em> in MySQL, its definition is as below:</p></li>
</ul>
<pre><code class="c language-c">  typedef struct TAOS_BIND {
    int            buffer_type;
    void *         buffer;
    unsigned long  buffer_length;  // not used in TDengine
    unsigned long *length;
    int *          is_null;
    int            is_unsigned;    // not used in TDengine
    int *          error;          // not used in TDengine
  } TAOS_BIND;</code></pre>
<ul>
<li><p><code>int taos_stmt_add_batch(TAOS_STMT *stmt)</code></p>
<p>Add bound parameters to batch, client can call <code>taos_stmt_bind_param</code> again after calling this API. Note this API only support <em>insert</em> / <em>import</em> statements, it returns an error in other cases.</p></li>
<li><p><code>int taos_stmt_execute(TAOS_STMT *stmt)</code></p>
<p>Execute the prepared statement. This API can only be called once for a statement at present.</p></li>
<li><p><code>TAOS_RES* taos_stmt_use_result(TAOS_STMT *stmt)</code></p>
<p>Acquire the result set of an executed statement. The usage of the result is same as <code>taos_use_result</code>, <code>taos_free_result</code> must be called after one you are done with the result set to release resources.</p></li>
<li><p><code>int taos_stmt_close(TAOS_STMT *stmt)</code></p>
<p>Close the statement, release all resources.</p></li>
</ul>
<a class='anchor' id='C/C++-async-API'></a><h3>C/C++ async API</h3>
<p>In addition to sync APIs, TDengine also provides async APIs, which are more efficient. Async APIs are returned right away without waiting for a response from the server, allowing the application to continute with other tasks without blocking. So async APIs are more efficient, especially useful when in a poor network.</p>
<p>All async APIs require callback functions. The callback functions have the format:</p>
<pre><code class="C language-C">void fp(void *param, TAOS_RES * res, TYPE param3)</code></pre>
<p>The first two parameters of the callback function are the same for all async APIs. The third parameter is different for different APIs. Generally, the first parameter is the handle provided to the API for action. The second parameter is a result handle.</p>
<ul>
<li><p><code>void taos_query_a(TAOS *taos, char *sqlstr, void (*fp)(void *param, TAOS_RES *, int code), void *param);</code></p>
<p>The async query interface. <em>taos</em> is the handle returned by <em>taos_connect</em> interface. <em>sqlstr</em> is the SQL command to run. <em>fp</em> is the callback function. <em>param</em> is the parameter required by the callback function. The third parameter of the callback function <em>code</em> is <em>0</em> (for success) or a negative number (for failure, call taos_errstr to get the error as a string).  Applications mainly handle with the second parameter, the returned result set.</p></li>
<li><p><code>void taos_fetch_rows_a(TAOS_RES *res, void (*fp)(void *param, TAOS_RES *, int numOfRows), void *param);</code></p>
<p>The async API to fetch a batch of rows, which should only be used with a <em>taos_query_a</em> call. The parameter <em>res</em> is the result handle returned by <em>taos_query_a</em>. <em>fp</em> is the callback function. <em>param</em> is a user-defined structure to pass to <em>fp</em>. The parameter <em>numOfRows</em> is the number of result rows in the current fetch cycle. In the callback function, applications should call <em>taos_fetch_row</em> to get records from the result handle. After getting a batch of results, applications should continue to call <em>taos_fetch_rows_a</em> API to handle the next batch, until the <em>numOfRows</em> is <em>0</em> (for no more data to fetch) or <em>-1</em> (for failure).</p></li>
<li><p><code>void taos_fetch_row_a(TAOS_RES *res, void (*fp)(void *param, TAOS_RES *, TAOS_ROW row), void *param);</code></p>
<p>The async API to fetch a result row. <em>res</em> is the result handle. <em>fp</em> is the callback function. <em>param</em> is a user-defined structure to pass to <em>fp</em>. The third parameter of the callback function is a single result row, which is different from that of <em>taos_fetch_rows_a</em> API. With this API, it is not necessary to call <em>taos_fetch_row</em> to retrieve each result row, which is handier than <em>taos_fetch_rows_a</em> but less efficient.</p></li>
</ul>
<p>Applications may apply operations on multiple tables. However, <strong>it is important to make sure the operations on the same table are serialized</strong>. That means after sending an insert request in a table to the server, no operations on the table are allowed before a response is received.</p>
<a class='anchor' id='C/C++-continuous-query-interface'></a><h3>C/C++ continuous query interface</h3>
<p>TDengine provides APIs for continuous query driven by time, which run queries periodically in the background. There are only two APIs:</p>
<ul>
<li><p><code>TAOS_STREAM *taos_open_stream(TAOS *taos, char *sqlstr, void (*fp)(void *param, TAOS_RES *, TAOS_ROW row), int64_t stime, void *param, void (*callback)(void *));</code></p>
<p>The API is used to create a continuous query.</p></li>
<li><p><em>taos</em>: the connection handle returned by <em>taos_connect</em>.</p></li>
<li><p><em>sqlstr</em>: the SQL string to run. Only query commands are allowed.</p></li>
<li><p><em>fp</em>: the callback function to run after a query</p></li>
<li><p><em>param</em>: a parameter passed to <em>fp</em></p></li>
<li><p><em>stime</em>: the time of the stream starts in the form of epoch milliseconds. If <em>0</em> is given, the start time is set as the current time.</p></li>
<li><p><em>callback</em>: a callback function to run when the continuous query stops automatically.</p>
<p>The API is expected to return a handle for success. Otherwise, a NULL pointer is returned.</p></li>
<li><p><code>void taos_close_stream (TAOS_STREAM *tstr)</code></p>
<p>Close the continuous query by the handle returned by <em>taos_open_stream</em>. Make sure to call this API when the continuous query is not needed anymore.</p></li>
</ul>
<a class='anchor' id='C/C++-subscription-API'></a><h3>C/C++ subscription API</h3>
<p>For the time being, TDengine supports subscription on one or multiple tables. It is implemented through periodic pulling from a TDengine server. </p>
<ul>
<li><p><code>TAOS_SUB *taos_subscribe(TAOS* taos, int restart, const char* topic, const char *sql, TAOS_SUBSCRIBE_CALLBACK fp, void *param, int interval)</code></p>
<p>The API is used to start a subscription session, it returns the subscription object on success and <code>NULL</code> in case of failure, the parameters are:</p></li>
<li><p><strong>taos</strong>: The database connnection, which must be established already.</p></li>
<li><p><strong>restart</strong>: <code>Zero</code> to continue a subscription if it already exits, other value to start from the beginning.</p></li>
<li><p><strong>topic</strong>: The unique identifier of a subscription.</p></li>
<li><p><strong>sql</strong>: A sql statement for data query, it can only be a <code>select</code> statement, can only query for raw data, and can only query data in ascending order of the timestamp field.</p></li>
<li><p><strong>fp</strong>: A callback function to receive query result, only used in asynchronization mode and should be <code>NULL</code> in synchronization mode, please refer below for its prototype.</p></li>
<li><p><strong>param</strong>: User provided additional parameter for the callback function.</p></li>
<li><p><strong>interval</strong>: Pulling interval in millisecond. Under asynchronization mode, API will call the callback function <code>fp</code> in this interval, system performance will be impacted if this interval is too short. Under synchronization mode, if the duration between two call to <code>taos_consume</code> is less than this interval, the second call blocks until the duration exceed this interval.</p></li>
<li><p><code>typedef void (*TAOS_SUBSCRIBE_CALLBACK)(TAOS_SUB* tsub, TAOS_RES *res, void* param, int code)</code></p>
<p>Prototype of the callback function, the parameters are:</p></li>
<li><p>tsub: The subscription object.</p></li>
<li><p>res: The query result.</p></li>
<li><p>param: User provided additional parameter when calling <code>taos_subscribe</code>.</p></li>
<li><p>code: Error code in case of failures.</p></li>
<li><p><code>TAOS_RES *taos_consume(TAOS_SUB *tsub)</code></p>
<p>The API used to get the new data from a TDengine server. It should be put in an loop. The parameter <code>tsub</code> is the handle returned by <code>taos_subscribe</code>. This API should only be called in synchronization mode. If the duration between two call to <code>taos_consume</code> is less than pulling interval, the second call blocks until the duration exceed the interval. The API returns the new rows if new data arrives, or empty rowset otherwise, and if there's an error, it returns <code>NULL</code>.</p></li>
<li><p><code>void taos_unsubscribe(TAOS_SUB *tsub, int keepProgress)</code></p>
<p>Stop a subscription session by the handle returned by <code>taos_subscribe</code>. If <code>keepProgress</code> is <strong>not</strong> zero, the subscription progress information is kept and can be reused in later call to <code>taos_subscribe</code>, the information is removed otherwise.</p></li>
</ul>
<a class='anchor' id='Java-Connector'></a><h2>Java Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#java-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>To Java delevopers, TDengine provides <code>taos-jdbcdriver</code> according to the JDBC(3.0) API. Users can find and download it through <a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">Sonatype Repository</a>.</p>
<p>Since the native language of TDengine is C, the necessary TDengine library should be checked before using the taos-jdbcdriver:</p>
<ul>
<li><p>libtaos.so (Linux)
After TDengine is installed successfully, the library <code>libtaos.so</code> will be automatically copied to the <code>/usr/lib/</code>, which is the system's default search path. </p></li>
<li><p>taos.dll (Windows)
After TDengine client is installed, the library <code>taos.dll</code> will be automatically copied to the <code>C:/Windows/System32</code>, which is the system's default search path. </p></li>
</ul>
<blockquote>
  <p>Note: Please make sure that <a href="https://www.taosdata.com/cn/documentation/connector/#Windows%E5%AE%A2%E6%88%B7%E7%AB%AF%E5%8F%8A%E7%A8%8B%E5%BA%8F%E6%8E%A5%E5%8F%A3">TDengine Windows client</a> has been installed if developing on Windows. Now although TDengine client would be defaultly installed together with TDengine server, it can also be installed <a href="https://www.taosdata.com/cn/getting-started/#%E5%BF%AB%E9%80%9F%E4%B8%8A%E6%89%8B">alone</a>.</p>
</blockquote>
<p>Since TDengine is time-series database, there are still some differences compared with traditional databases in using TDengine JDBC driver: </p>
<ul>
<li>TDengine doesn't allow to delete/modify a single record, and thus JDBC driver also has no such method. </li>
<li>No support for transaction</li>
<li>No support for union between tables</li>
<li>No support for nested query，<code>There is at most one open ResultSet for each Connection. Thus, TSDB JDBC Driver will close current ResultSet if it is not closed and a new query begins</code>.</li>
</ul>
<a class='anchor' id='Version-list-of-TAOS-JDBCDriver-and-required-TDengine-and-JDK'></a><h2>Version list of TAOS-JDBCDriver and required TDengine and JDK</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#version-list-of-taos-jdbcdriver-and-required-tdengine-and-jdk' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<figure><table>
<thead>
<tr>
<th>taos-jdbcdriver</th>
<th>TDengine</th>
<th>JDK</th>
</tr>
</thead>
<tbody>
<tr>
<td>1.0.3</td>
<td>1.6.1.x or higher</td>
<td>1.8.x</td>
</tr>
<tr>
<td>1.0.2</td>
<td>1.6.1.x or higher</td>
<td>1.8.x</td>
</tr>
<tr>
<td>1.0.1</td>
<td>1.6.1.x or higher</td>
<td>1.8.x</td>
</tr>
</tbody>
</table></figure>
<a class='anchor' id='DataType-in-TDengine-and-Java'></a><h2>DataType in TDengine and Java</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#datatype-in-tdengine-and-java' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>The datatypes in TDengine include timestamp, number, string and boolean, which are converted as follows in Java:</p>
<figure><table>
<thead>
<tr>
<th>TDengine</th>
<th>Java</th>
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
<a class='anchor' id='How-to-get-TAOS-JDBC-Driver'></a><h2>How to get TAOS-JDBC Driver</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#how-to-get-taos-jdbc-driver' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='maven-repository'></a><h3>maven repository</h3>
<p>taos-jdbcdriver has been published to <a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">Sonatype Repository</a>:</p>
<ul>
<li><a href="https://search.maven.org/artifact/com.taosdata.jdbc/taos-jdbcdriver">sonatype</a></li>
<li><a href="https://mvnrepository.com/artifact/com.taosdata.jdbc/taos-jdbcdriver">mvnrepository</a></li>
<li><a href="https://maven.aliyun.com/mvn/search">maven.aliyun</a></li>
</ul>
<p>Using the following pom.xml for maven projects</p>
<pre><code class="xml language-xml">&lt;dependencies&gt;
    &lt;dependency&gt;
        &lt;groupId&gt;com.taosdata.jdbc&lt;/groupId&gt;
        &lt;artifactId&gt;taos-jdbcdriver&lt;/artifactId&gt;
        &lt;version&gt;1.0.3&lt;/version&gt;
    &lt;/dependency&gt;
&lt;/dependencies&gt;</code></pre>
<a class='anchor' id='JAR-file-from-the-source-code'></a><h3>JAR file from the source code</h3>
<p>After downloading the <a href="https://github.com/taosdata/TDengine">TDengine</a> source code, execute <code>mvn clean package</code> in the directory <code>src/connector/jdbc</code> and then the corresponding jar file is generated.</p>
<a class='anchor' id='Usage'></a><h2>Usage</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#usage' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='get-the-connection'></a><h3>get the connection</h3>
<pre><code class="java language-java">Class.forName("com.taosdata.jdbc.TSDBDriver");
String jdbcUrl = "jdbc:TAOS://127.0.0.1:6030/log?user=root&amp;password=taosdata";
Connection conn = DriverManager.getConnection(jdbcUrl);</code></pre>
<blockquote>
  <p><code>6030</code> is the default port and <code>log</code> is the default database for system monitor.</p>
</blockquote>
<p>A normal JDBC URL looks as follows:
<code>jdbc:TSDB://{host_ip}:{port}/[database_name]?[user={user}|&amp;password={password}|&amp;charset={charset}|&amp;cfgdir={config_dir}|&amp;locale={locale}|&amp;timezone={timezone}]</code></p>
<p>values in <code>{}</code> are necessary while values in <code>[]</code> are optional。Each option in the above URL denotes:</p>
<ul>
<li>user：user name for login, defaultly root。</li>
<li>password：password for login，defaultly taosdata。</li>
<li>charset：charset for client，defaultly system charset</li>
<li>cfgdir：log directory for client, defaultly <em>/etc/taos/</em> on Linux and <em>C:/TDengine/cfg</em> on Windows。</li>
<li>locale：language for client，defaultly system locale。</li>
<li>timezone：timezone for client，defaultly system timezone。</li>
</ul>
<p>The options above can be configures (<code>ordered by priority</code>):</p>
<ol>
<li><p>JDBC URL </p>
<p>As explained above.</p></li>
<li><p>java.sql.DriverManager.getConnection(String jdbcUrl, Properties connProps)</p></li>
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
<li><p>Configuration file (taos.cfg)</p>
<p>Default configuration file is <em>/var/lib/taos/taos.cfg</em> On Linux and <em>C:\TDengine\cfg\taos.cfg</em> on Windows</p></li>
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
  <p>More options can refer to <a href="https://www.taosdata.com/cn/documentation/administrator/#%E5%AE%A2%E6%88%B7%E7%AB%AF%E9%85%8D%E7%BD%AE">client configuration</a></p>
</blockquote>
<a class='anchor' id='Create-databases-and-tables'></a><h3>Create databases and tables</h3>
<pre><code class="java language-java">Statement stmt = conn.createStatement();

// create database
stmt.executeUpdate("create database if not exists db");

// use database
stmt.executeUpdate("use db");

// create table
stmt.executeUpdate("create table if not exists tb (ts timestamp, temperature int, humidity float)");</code></pre>
<blockquote>
  <p>Note: if no step like <code>use db</code>, the name of database must be added as prefix like <em>db.tb</em> when operating on tables </p>
</blockquote>
<a class='anchor' id='Insert-data'></a><h3>Insert data</h3>
<pre><code class="java language-java">// insert data
int affectedRows = stmt.executeUpdate("insert into tb values(now, 23, 10.3) (now + 1s, 20, 9.3)");

System.out.println("insert " + affectedRows + " rows.");</code></pre>
<blockquote>
  <p><em>now</em> is the server time.
  <em>now+1s</em> is 1 second later than current server time. The time unit includes: <em>a</em>(millisecond), <em>s</em>(second), <em>m</em>(minute), <em>h</em>(hour), <em>d</em>(day), <em>w</em>(week), <em>n</em>(month), <em>y</em>(year).</p>
</blockquote>
<a class='anchor' id='Query-database'></a><h3>Query database</h3>
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
  <p>query is consistent with relational database. The subscript start with 1 when retrieving return results. It is recommended to use the column name to retrieve results.</p>
</blockquote>
<a class='anchor' id='Close-all'></a><h3>Close all</h3>
<pre><code class="java language-java">resultSet.close();
stmt.close();
conn.close();</code></pre>
<blockquote>
  <p><code>please make sure the connection is closed to avoid the error like connection leakage</code></p>
</blockquote>
<a class='anchor' id='Using-connection-pool'></a><h2>Using connection pool</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#using-connection-pool' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p><strong>HikariCP</strong></p>
<ul>
<li>dependence in pom.xml：</li>
</ul>
<pre><code class="xml language-xml">&lt;dependency&gt;
    &lt;groupId&gt;com.zaxxer&lt;/groupId&gt;
    &lt;artifactId&gt;HikariCP&lt;/artifactId&gt;
    &lt;version&gt;3.4.1&lt;/version&gt;
&lt;/dependency&gt;</code></pre>
<ul>
<li>Examples：</li>
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
  <p>The close() method will not close the connection from HikariDataSource.getConnection(). Instead, the connection is put back to the connection pool. 
  More instructions can refer to <a href="https://github.com/brettwooldridge/HikariCP">User Guide</a></p>
</blockquote>
<p><strong>Druid</strong></p>
<ul>
<li>dependency in pom.xml：</li>
</ul>
<pre><code class="xml language-xml">&lt;dependency&gt;
    &lt;groupId&gt;com.alibaba&lt;/groupId&gt;
    &lt;artifactId&gt;druid&lt;/artifactId&gt;
    &lt;version&gt;1.1.20&lt;/version&gt;
&lt;/dependency&gt;</code></pre>
<ul>
<li>Examples：</li>
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
  <p>More instructions can refer to <a href="https://github.com/alibaba/druid">User Guide</a></p>
</blockquote>
<p><strong>Notice</strong></p>
<ul>
<li>TDengine <code>v1.6.4.1</code> provides a function <code>select server_status()</code> to check heartbeat. It is highly recommended to use this function for <code>Validation Query</code>.</li>
</ul>
<p>As follows，<code>1</code> will be returned if <code>select server_status()</code> is successfully executed。</p>
<pre><code class="shell language-shell">taos&gt; select server_status();
server_status()|
================
1              |
Query OK, 1 row(s) in set (0.000141s)</code></pre>
<a class='anchor' id='Integrated-with-framework'></a><h2>Integrated with framework</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#integrated-with-framework' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<ul>
<li>Please refer to <a href="https://github.com/taosdata/TDengine/tree/develop/tests/examples/JDBC/SpringJdbcTemplate">SpringJdbcTemplate</a> if using taos-jdbcdriver in Spring JdbcTemplate</li>
<li>Please refer to <a href="https://github.com/taosdata/TDengine/tree/develop/tests/examples/JDBC/springbootdemo">springbootdemo</a> if using taos-jdbcdriver in Spring JdbcTemplate</li>
</ul>
<a class='anchor' id='FAQ'></a><h2>FAQ</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#faq' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<ul>
<li><p>java.lang.UnsatisfiedLinkError: no taos in java.library.path</p>
<p><strong>Cause</strong>：The application program cannot find Library function <em>taos</em></p>
<p><strong>Answer</strong>：Copy <code>C:\TDengine\driver\taos.dll</code> to <code>C:\Windows\System32\</code> on Windows and make a soft link through <code>ln -s /usr/local/taos/driver/libtaos.so.x.x.x.x /usr/lib/libtaos.so</code> on Linux.</p></li>
<li><p>java.lang.UnsatisfiedLinkError: taos.dll Can't load AMD 64 bit on a IA 32-bit platform</p>
<p><strong>Cause</strong>：Currently TDengine only support 64bit JDK</p>
<p><strong>Answer</strong>：re-install 64bit JDK.</p></li>
<li><p>For other questions, please refer to <a href="https://github.com/taosdata/TDengine/issues">Issues</a></p></li>
</ul>
<a class='anchor' id='Python-Connector'></a><h2>Python Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#python-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='Pre-requirement'></a><h3>Pre-requirement</h3>
<ul>
<li>TDengine installed, TDengine-client installed if on Windows <a href="https://www.taosdata.com/cn/documentation/connector/#Windows客户端及程序接口">(Windows TDengine client installation)</a></li>
<li>python 2.7 or &gt;= 3.4</li>
<li>pip installed</li>
</ul>
<a class='anchor' id='Installation'></a><h3>Installation</h3>
<h4>Linux</h4>
<p>Users can find python client packages in our source code directory <em>src/connector/python</em>. There are two directories corresponding to two python versions. Please choose the correct package to install. Users can use <em>pip</em> command to install:</p>
<pre><code class="cmd language-cmd">pip install src/connector/python/linux/python3/</code></pre>
<p>or</p>
<pre><code>pip install src/connector/python/linux/python2/</code></pre>
<h4>Windows</h4>
<p>Assumed the Windows TDengine client has been installed , copy the file "C:\TDengine\driver\taos.dll" to the folder "C:\windows\system32", and then enter the <em>cmd</em> Windows command interface</p>
<pre><code>cd C:\TDengine\connector\python\windows
pip install python3\</code></pre>
<p>or</p>
<pre><code>cd C:\TDengine\connector\python\windows
pip install python2\</code></pre>
<p>*If <em>pip</em> command is not installed on the system, users can choose to install pip or just copy the <em>taos</em> directory in the python client directory to the application directory to use.</p>
<a class='anchor' id='Usage'></a><a class='anchor' id='Usage'></a><h3>Usage</h3>
<h4>Examples</h4>
<ul>
<li>import TDengine module</li>
</ul>
<pre><code class="python language-python">import taos </code></pre>
<ul>
<li>get the connection</li>
</ul>
<pre><code class="python language-python">conn = taos.connect(host="127.0.0.1", user="root", password="taosdata", config="/etc/taos")
c1 = conn.cursor()</code></pre>
<p>*<em>host</em> is the IP of TDengine server, and <em>config</em> is the directory where exists the TDengine client configure file</p>
<ul>
<li>insert records into the database</li>
</ul>
<pre><code class="python language-python">import datetime

# create a database
c1.execute('create database db')
c1.execute('use db')
# create a table
c1.execute('create table tb (ts timestamp, temperature int, humidity float)')
# insert a record
start_time = datetime.datetime(2019, 11, 1)
affected_rows = c1.execute('insert into tb values (\'%s\', 0, 0.0)' %start_time)
# insert multiple records in a batch
time_interval = datetime.timedelta(seconds=60)
sqlcmd = ['insert into tb values']
for irow in range(1,11):
  start_time += time_interval
  sqlcmd.append('(\'%s\', %d, %f)' %(start_time, irow, irow*1.2))
affected_rows = c1.execute(' '.join(sqlcmd))</code></pre>
<ul>
<li>query the database</li>
</ul>
<pre><code class="python language-python">c1.execute('select * from tb')
# fetch all returned results
data = c1.fetchall()
# data is a list of returned rows with each row being a tuple
numOfRows = c1.rowcount
numOfCols = len(c1.description)
for irow in range(numOfRows):
  print("Row%d: ts=%s, temperature=%d, humidity=%f" %(irow, data[irow][0], data[irow][1],data[irow][2]))

# use the cursor as an iterator to retrieve all returned results
c1.execute('select * from tb')
for data in c1:
  print("ts=%s, temperature=%d, humidity=%f" %(data[0], data[1],data[2])</code></pre>
<ul>
<li>create a subscription</li>
</ul>
<pre><code class="python language-python"># Create a subscription with topic 'test' and consumption interval 1000ms.
# The first argument is True means to restart the subscription;
# if the subscription with topic 'test' has already been created, then pass
# False to this argument means to continue the existing subscription.
sub = conn.subscribe(True, "test", "select * from meters;", 1000)</code></pre>
<ul>
<li>consume a subscription</li>
</ul>
<pre><code class="python language-python">data = sub.consume()
for d in data:
    print(d)</code></pre>
<ul>
<li>close the subscription</li>
</ul>
<pre><code class="python language-python">sub.close()</code></pre>
<ul>
<li>close the connection</li>
</ul>
<pre><code class="python language-python">c1.close()
conn.close()</code></pre>
<h4>Help information</h4>
<p>Users can get module information from Python help interface or refer to our [python code example](). We list the main classes and methods below:</p>
<ul>
<li><p><em>TDengineConnection</em> class</p>
<p>Run <code>help(taos.TDengineConnection)</code> in python terminal for details.</p></li>
<li><p><em>TDengineCursor</em> class</p>
<p>Run <code>help(taos.TDengineCursor)</code> in python terminal for details.</p></li>
<li><p>connect method</p>
<p>Open a connection. Run <code>help(taos.connect)</code> in python terminal for details.</p></li>
</ul>
<a class='anchor' id='RESTful-Connector'></a><h2>RESTful Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#restful-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine also provides RESTful API to satisfy developing on different platforms. Unlike other databases, TDengine RESTful API applies operations to the database through the SQL command in the body of HTTP POST request. What users are required to provide is just a URL.</p>
<p>For the time being, TDengine RESTful API uses a <em>\<TOKEN></em> generated from username and password for identification. Safer identification methods will be provided in the future.</p>
<a class='anchor' id='HTTP-URL-encoding'></a><h3>HTTP URL encoding</h3>
<p>To use TDengine RESTful API, the URL should have the following encoding format:</p>
<pre><code>http://&lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<ul>
<li><em>ip</em>: IP address of any node in a TDengine cluster</li>
<li><em>PORT</em>: TDengine HTTP service port. It is 6020 by default.</li>
</ul>
<p>For example, the URL encoding <em>http://192.168.0.1:6020/rest/sql</em> used to send HTTP request to a TDengine server with IP address as 192.168.0.1.</p>
<p>It is required to add a token in an HTTP request header for identification.</p>
<pre><code>Authorization: Basic &lt;TOKEN&gt;</code></pre>
<p>The HTTP request body contains the SQL command to run. If the SQL command contains a table name, it should also provide the database name it belongs to in the form of <code>&lt;db_name&gt;.&lt;tb_name&gt;</code>. Otherwise, an error code is returned.</p>
<p>For example, use <em>curl</em> command to send a HTTP request:</p>
<pre><code>curl -H 'Authorization: Basic &lt;TOKEN&gt;' -d '&lt;SQL&gt;' &lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<p>or use</p>
<pre><code>curl -u username:password -d '&lt;SQL&gt;' &lt;ip&gt;:&lt;PORT&gt;/rest/sql</code></pre>
<p>where <code>TOKEN</code> is the encryted string of <code>{username}:{password}</code> using the Base64 algorithm, e.g. <code>root:taosdata</code> will be encoded as <code>cm9vdDp0YW9zZGF0YQ==</code></p>
<a class='anchor' id='HTTP-response'></a><h3>HTTP response</h3>
<p>The HTTP resonse is in JSON format as below:</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2", …],
    "data": [
        ["2017-12-12 23:44:25.730", 1],
        ["2017-12-12 22:44:25.728", 4]
    ],
    "rows": 2
} </code></pre>
<p>Specifically,</p>
<ul>
<li><em>status</em>: the result of the operation, success or failure</li>
<li><em>head</em>: description of returned result columns</li>
<li><em>data</em>: the returned data array. If no data is returned, only an <em>affected_rows</em> field is listed</li>
<li><em>rows</em>: the number of rows returned</li>
</ul>
<a class='anchor' id='Example'></a><a class='anchor' id='Example'></a><h3>Example</h3>
<ul>
<li><p>Use <em>curl</em> command to query all the data in table <em>t1</em> of database <em>demo</em>:</p>
<p><code>curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'select * from demo.t1' 192.168.0.1:6020/rest/sql</code></p></li>
</ul>
<p>The return value is like:</p>
<pre><code>{
    "status": "succ",
    "head": ["column1","column2","column3"],
    "data": [
        ["2017-12-12 23:44:25.730", 1, 2.3],
        ["2017-12-12 22:44:25.728", 4, 5.6]
    ],
    "rows": 2
}</code></pre>
<ul>
<li><p>Use HTTP to create a database：</p>
<p><code>curl -H 'Authorization: Basic cm9vdDp0YW9zZGF0YQ==' -d 'create database demo' 192.168.0.1:6020/rest/sql</code></p>
<p>The return value should be:</p></li>
</ul>
<pre><code>{
    "status": "succ",
    "head": ["affected_rows"],
    "data": [[1]],
    "rows": 1,
}</code></pre>
<a class='anchor' id='Go-Connector'></a><h2>Go Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#go-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine also provides a Go client package named <em>taosSql</em> for users to access TDengine with Go. The package is in <em>/usr/local/taos/connector/go/src/taosSql</em> by default if you installed TDengine. Users can copy the directory <em>/usr/local/taos/connector/go/src/taosSql</em> to the <em>src</em> directory of your project and import the package in the source code for use.</p>
<pre><code class="Go language-Go">import (
    "database/sql"
    _ "taosSql"
)</code></pre>
<p>The <em>taosSql</em> package is in <em>cgo</em> form, which calls TDengine C/C++ sync interfaces. So a connection is allowed to be used by one thread at the same time. Users can open multiple connections for multi-thread operations.</p>
<p>Please refer the the demo code in the package for more information.</p>
<a class='anchor' id='Node.js-Connector'></a><h2>Node.js Connector</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Connector.md#node.js-connector' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine also provides a node.js connector package that is installable through <a href="https://www.npmjs.com/">npm</a>. The package is also in our source code at <em>src/connector/nodejs/</em>. The following instructions are also available <a href="https://github.com/taosdata/tdengine/tree/master/src/connector/nodejs">here</a></p>
<p>To get started, just type in the following to install the connector through <a href="https://www.npmjs.com/">npm</a>.</p>
<pre><code class="cmd language-cmd">npm install td-connector</code></pre>
<p>It is highly suggested you use npm. If you don't have it installed, you can also just copy the nodejs folder from <em>src/connector/nodejs/</em> into your node project folder.</p>
<p>To interact with TDengine, we make use of the <a href="https://github.com/nodejs/node-gyp">node-gyp</a> library. To install, you will need to install the following depending on platform (the following instructions are quoted from node-gyp)</p>
<a class='anchor' id='On-Unix'></a><h3>On Unix</h3>
<ul>
<li><code>python</code> (<code>v2.7</code> recommended, <code>v3.x.x</code> is <strong>not</strong> supported)</li>
<li><code>make</code></li>
<li>A proper C/C++ compiler toolchain, like <a href="https://gcc.gnu.org">GCC</a></li>
</ul>
<a class='anchor' id='On-macOS'></a><h3>On macOS</h3>
<ul>
<li><p><code>python</code> (<code>v2.7</code> recommended, <code>v3.x.x</code> is <strong>not</strong> supported) (already installed on macOS)</p></li>
<li><p>Xcode</p></li>
<li><p>You also need to install the </p>
<pre><code>Command Line Tools</code></pre>
<p>via Xcode. You can find this under the menu </p>
<pre><code>Xcode -&gt; Preferences -&gt; Locations</code></pre>
<p>(or by running </p>
<pre><code>xcode-select --install</code></pre>
<p>in your Terminal) </p>
<ul>
<li>This step will install <code>gcc</code> and the related toolchain containing <code>make</code></li></ul></li>
</ul>
<a class='anchor' id='On-Windows'></a><h3>On Windows</h3>
<h4>Option 1</h4>
<p>Install all the required tools and configurations using Microsoft's <a href="https://github.com/felixrieseberg/windows-build-tools">windows-build-tools</a> using <code>npm install --global --production windows-build-tools</code> from an elevated PowerShell or CMD.exe (run as Administrator).</p>
<h4>Option 2</h4>
<p>Install tools and configuration manually:</p>
<ul>
<li>Install Visual C++ Build Environment: <a href="https://visualstudio.microsoft.com/thank-you-downloading-visual-studio/?sku=BuildTools">Visual Studio Build Tools</a> (using "Visual C++ build tools" workload) or <a href="https://visualstudio.microsoft.com/pl/thank-you-downloading-visual-studio/?sku=Community">Visual Studio 2017 Community</a> (using the "Desktop development with C++" workload)</li>
<li>Install <a href="https://www.python.org/downloads/">Python 2.7</a> (<code>v3.x.x</code> is not supported), and run <code>npm config set python python2.7</code> (or see below for further instructions on specifying the proper Python version and path.)</li>
<li>Launch cmd, <code>npm config set msvs_version 2017</code></li>
</ul>
<p>If the above steps didn't work for you, please visit <a href="https://github.com/Microsoft/nodejs-guidelines/blob/master/windows-environment.md#compiling-native-addon-modules">Microsoft's Node.js Guidelines for Windows</a> for additional tips.</p>
<p>To target native ARM64 Node.js on Windows 10 on ARM, add the  components "Visual C++ compilers and libraries for ARM64" and "Visual  C++ ATL for ARM64".</p>
<h3>Usage</h3>
<p>The following is a short summary of the basic usage of the connector, the  full api and documentation can be found <a href="http://docs.taosdata.com/node">here</a></p>
<h4>Connection</h4>
<p>To use the connector, first require the library <code>td-connector</code>. Running the function <code>taos.connect</code> with the connection options passed in as an object will return a TDengine connection object. The required connection option is <code>host</code>, other options if not set, will be the default values as shown below.</p>
<p>A cursor also needs to be initialized in order to interact with TDengine from Node.js.</p>
<pre><code class="javascript language-javascript">const taos = require('td-connector');
var conn = taos.connect({host:"127.0.0.1", user:"root", password:"taosdata", config:"/etc/taos",port:0})
var cursor = conn.cursor(); // Initializing a new cursor</code></pre>
<p>To close a connection, run</p>
<pre><code class="javascript language-javascript">conn.close();</code></pre>
<h4>Queries</h4>
<p>We can now start executing simple queries through the <code>cursor.query</code> function, which returns a TaosQuery object.</p>
<pre><code class="javascript language-javascript">var query = cursor.query('show databases;')</code></pre>
<p>We can get the results of the queries through the <code>query.execute()</code> function, which returns a promise that resolves with a TaosResult object, which contains the raw data and additional functionalities such as pretty printing the results.</p>
<pre><code class="javascript language-javascript">var promise = query.execute();
promise.then(function(result) {
  result.pretty(); //logs the results to the console as if you were in the taos shell
});</code></pre>
<p>You can also query by binding parameters to a query by filling in the question marks in a string as so. The query will automatically parse what was binded and convert it to the proper format for use with TDengine</p>
<pre><code class="javascript language-javascript">var query = cursor.query('select * from meterinfo.meters where ts &lt;= ? and areaid = ?;').bind(new Date(), 5);
query.execute().then(function(result) {
  result.pretty();
})</code></pre>
<p>The TaosQuery object can also be immediately executed upon creation by passing true as the second argument, returning a promise instead of a TaosQuery.</p>
<pre><code class="javascript language-javascript">var promise = cursor.query('select * from meterinfo.meters where v1 = 30;', true)
promise.then(function(result) {
  result.pretty();
})</code></pre>
<h4>Async functionality</h4>
<p>Async queries can be performed using the same functions such as <code>cursor.execute</code>, <code>TaosQuery.execute</code>, but now with <code>_a</code> appended to them.</p>
<p>Say you want to execute an two async query on two seperate tables, using <code>cursor.query</code>, you can do that and get a TaosQuery object, which upon executing with the <code>execute_a</code> function, returns a promise that resolves with a TaosResult object.</p>
<pre><code class="javascript language-javascript">var promise1 = cursor.query('select count(*), avg(v1), avg(v2) from meter1;').execute_a()
var promise2 = cursor.query('select count(*), avg(v1), avg(v2) from meter2;').execute_a();
promise1.then(function(result) {
  result.pretty();
})
promise2.then(function(result) {
  result.pretty();
})</code></pre>
<h3>Example</h3>
<p>An example of using the NodeJS connector to create a table with weather data and create and execute queries can be found <a href="https://github.com/taosdata/TDengine/tree/master/tests/examples/nodejs/node-example.js">here</a> (The preferred method for using the connector)</p>
<p>An example of using the NodeJS connector to achieve the same things but without all the object wrappers that wrap around the data returned to achieve higher functionality can be found <a href="https://github.com/taosdata/TDengine/tree/master/tests/examples/nodejs/node-example-raw.js">here</a></p></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>