<!DOCTYPE html><html lang='en'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?><title>Documentation | TAOS Data</title><meta name='description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.'><meta name='keywords' content='TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Documentation, programming, coding, syntax, frequently asked questions, questions, faq'><meta name='title' content='Documentation | TAOS Data'><meta property='og:site_name' content='TAOS Data'/><meta property='og:title' content='Documentation | TAOS Data'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/data-model-and-architecture/index.php'/><meta property='og:description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.' /><?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/data-model-and-architecture/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'><h1>Data Model and Architecture</h1>
<a class='anchor' id='Data-Model'></a><h2>Data Model</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Data%20model%20and%20architecture.md#data-model' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<a class='anchor' id='A-Typical-IoT-Scenario'></a><h3>A Typical IoT Scenario</h3>
<p>In a typical IoT scenario, there are many types of devices. Each device is collecting one or multiple metrics. For a specific type of device, the collected data could look like the table below: </p>
<figure><table>
<thead>
<tr>
<th style="text-align:center;">Device ID</th>
<th style="text-align:center;">Time Stamp</th>
<th style="text-align:center;">Value 1</th>
<th style="text-align:center;">Value 2</th>
<th style="text-align:center;">Value 3</th>
<th style="text-align:center;">Tag 1</th>
<th style="text-align:center;">Tag 2</th>
</tr>
</thead>
<tbody>
<tr>
<td style="text-align:center;">D1001</td>
<td style="text-align:center;">1538548685000</td>
<td style="text-align:center;">10.3</td>
<td style="text-align:center;">219</td>
<td style="text-align:center;">0.31</td>
<td style="text-align:center;">Red</td>
<td style="text-align:center;">Tesla</td>
</tr>
<tr>
<td style="text-align:center;">D1002</td>
<td style="text-align:center;">1538548684000</td>
<td style="text-align:center;">10.2</td>
<td style="text-align:center;">220</td>
<td style="text-align:center;">0.23</td>
<td style="text-align:center;">Blue</td>
<td style="text-align:center;">BMW</td>
</tr>
<tr>
<td style="text-align:center;">D1003</td>
<td style="text-align:center;">1538548686500</td>
<td style="text-align:center;">11.5</td>
<td style="text-align:center;">221</td>
<td style="text-align:center;">0.35</td>
<td style="text-align:center;">Black</td>
<td style="text-align:center;">Honda</td>
</tr>
<tr>
<td style="text-align:center;">D1004</td>
<td style="text-align:center;">1538548685500</td>
<td style="text-align:center;">13.4</td>
<td style="text-align:center;">223</td>
<td style="text-align:center;">0.29</td>
<td style="text-align:center;">Red</td>
<td style="text-align:center;">Volvo</td>
</tr>
<tr>
<td style="text-align:center;">D1001</td>
<td style="text-align:center;">1538548695000</td>
<td style="text-align:center;">12.6</td>
<td style="text-align:center;">218</td>
<td style="text-align:center;">0.33</td>
<td style="text-align:center;">Red</td>
<td style="text-align:center;">Tesla</td>
</tr>
<tr>
<td style="text-align:center;">D1004</td>
<td style="text-align:center;">1538548696600</td>
<td style="text-align:center;">11.8</td>
<td style="text-align:center;">221</td>
<td style="text-align:center;">0.28</td>
<td style="text-align:center;">Black</td>
<td style="text-align:center;">Honda</td>
</tr>
</tbody>
</table></figure>
<p>Each data record contains the device ID, timestamp, collected metrics, and static tags associated with the device. Each device generates a data record in a pre-defined timer or triggered by an event. It is a sequence of data points like a stream. </p>
<a class='anchor' id='Data-Characteristics'></a><h3>Data Characteristics</h3>
<p>As the data points are a series of data points over time, the data points generated by devices, sensors, servers, and/or applications have some strong common characteristics: </p>
<ol>
<li>metrics are always structured data; </li>
<li>there are rarely delete/update operations on collected data; </li>
<li>there is only one single data source for one device or sensor; </li>
<li>ratio of read/write is much lower than typical Internet applications; </li>
<li>the user pays attention to the trend of data, not a specific value at a specific time; </li>
<li>there is always a data retention policy; </li>
<li>the data query is always executed in a given time range and a subset of devices; </li>
<li>real-time aggregation or analytics is mandatory; </li>
<li>traffic is predictable based on the number of devices and sampling frequency; </li>
<li>data volume is huge, a system may generate 10 billion data points in a day.    </li>
</ol>
<p>By utilizing the above characteristics, TDengine designs the storage and computing engine in a special and optimized way for time-series data, resulting in massive improvements in system efficiency.</p>
<a class='anchor' id='Relational-Database-Model'></a><h3>Relational Database Model</h3>
<p>Since time-series data is most likely to be structured data, TDengine adopts the traditional relational database model to process them. You need to create a database, create tables with schema definitions, then insert data points and execute queries to explore the data. Standard SQL is used, making it easy for anyone to get started and eliminating any learning curve.</p>
<a class='anchor' id='One-Table-for-One-Device'></a><h3>One Table for One Device</h3>
<p>Due to different network latencies, the data points from different devices may arrive to the server out of order. But for the same device, data points will arrive to the server in order if the system is designed well. To utilize this special feature, TDengine requires the user to create a table for each device (time-stream). For example, if there are over 10,000 smart meters, 10,000 tables shall be created. For the table above, 4 tables shall be created for device D1001, D1002, D1003, and D1004 to store the data collected. </p>
<p>This strong requirement can guarantee that all data points from a device can be saved in a continuous memory/hard disk space block by block. If queries are applied only on one device in a time range, this design will reduce the read latency significantly since a whole block is owned by one single device. Additionally, write latency can be significantly reduced too as the data points generated by the same device will arrive in order, the new data point will be simply appended to a block. Cache block size and the rows of records in a file block can be configured to fit different scenarios for optimal efficiency.</p>
<a class='anchor' id='Best-Practices'></a><h3>Best Practices</h3>
<p><strong>Table</strong>: TDengine suggests to use device ID as the table name (like D1001 in the above diagram). Each device may collect one or more metrics (like value1, value2, value3 in the diagram). Each metric has a column in the table, the metric name can be used as the column name. The data type for a column can be int, float, double, tinyint, bigint, bool or binary. Sometimes, a device may have multiple metric groups, each group containing different sampling periods, so for best practice you should create a table for each group for each device. The first column in the table must be a time stamp. TDengine uses the time stamp as the index, and won’t build the index on any metrics stored.</p>
<p><strong>Tags:</strong> To support aggregation over multiple tables efficiently, the <a href="../super-table">STable(Super Table)</a> concept is introduced by TDengine. A STable is used to represent the same type of device. The schema is used to define the collected metrics (like value1, value2, value3 in the diagram), and tags are used to define the static attributes for each table or device (like tag1, tag2 in the diagram). A table is created via STable with a specific tag value. All or a subset of tables in a STable can be aggregated by filtering tag values.  </p>
<p><strong>Database:</strong> Different types of devices may generate data points in different patterns and should be processed differently. For example, sampling frequency, data retention policy, replication number, cache size, record size, the compression algorithm may be different. To make the system more efficient, TDengine suggests creating a different database with unique configurations for different scenarios.</p>
<p><strong>Schemaless vs Schema:</strong> Compared with NoSQL databases, since a table with schema definitions must be created before the data points can be inserted, flexibilities are not that good, especially when the schema is changed. But in most IoT scenarios, the schema is well defined and is rarely changed, the loss of flexibility won't pose any impact to developers or administrators. TDengine allows the application to change the schema in a second even there is a huge amount of historical data when schema has to be changed. </p>
<p>TDengine does not impose a limitation on the number of tables, <a href="../super-table">STables</a>, or databases. You can create any number of STable or databases to fit different scenarios.   </p>
<a class='anchor' id='Architecture'></a><h2>Architecture</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Data%20model%20and%20architecture.md#architecture' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>There are two main modules in TDengine server as shown in Picture 1: <strong>Management Module (MGMT)</strong> and <strong>Data Module(DNODE)</strong>. The whole TDengine architecture also includes a <strong>TDengine Client Module</strong>.</p>
<p><center> <img src="../assets/structure.png"> </center>
<center> Picture 1 TDengine Architecture  </center></p>
<a class='anchor' id='MGMT-Module'></a><h3>MGMT Module</h3>
<p>The MGMT module deals with the storage and querying on metadata, which includes information about users, databases, and tables. Applications will connect to the MGMT module at first when connecting the TDengine server. When creating/dropping databases/tables, The request is sent to the MGMT module at first to create/delete metadata. Then the MGMT module will send requests to the data module to allocate/free resources required. In the case of writing or querying, applications still need to visit the MGMT module to get meta data, according to which, then access the DNODE module.</p>
<a class='anchor' id='DNODE-Module'></a><h3>DNODE Module</h3>
<p>The DNODE module is responsible for storing and querying data. For the sake of future scaling and high-efficient resource usage, TDengine applies virtualization on resources it uses. TDengine introduces the concept of a virtual node (vnode), which is the unit of storage, resource allocation and data replication (enterprise edition). As is shown in Picture 2, TDengine treats each data node as an aggregation of vnodes. </p>
<p>When a DB is created, the system will allocate a vnode. Each vnode contains multiple tables, but a table belongs to only one vnode. Each DB has one or mode vnodes, but one vnode belongs to only one DB. Each vnode contains all the data in a set of tables. Vnodes have their own cache and directory to store data. Resources between different vnodes are exclusive with each other, no matter cache or file directory. However, resources in the same vnode are shared between all the tables in it. Through virtualization, TDengine can distribute resources reasonably to each vnode and improve resource usage and concurrency. The number of vnodes on a dnode is configurable according to its hardware resources.</p>
<p><center> <img src="../assets/vnode.png">  </center>
<center> Picture 2 TDengine Virtualization  </center> </p>
<a class='anchor' id='Client-Module'></a><h3>Client Module</h3>
<p>TDengine client module accepts requests (mainly in SQL form) from applications and converts the requests to internal representations and sends to the server side. TDengine supports multiple interfaces, which are all built on top of TDengine client module. </p>
<p>For the communication between client and MGMT module, TCP/UDP is used, the port is set by the parameter <code>mgmtShellPort</code> in system configuration file <code>taos.cfg</code>, default is 6030. For communication between the client and the DNODE module, TCP/UDP is used, the port is set by the parameter <code>vnodeShellPort</code> in the system configuration file, default is 6035. </p>
<a class='anchor' id='Writing-Process'></a><h2>Writing Process</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Data%20model%20and%20architecture.md#writing-process' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>Picture 3 shows the full writing process of TDengine. TDengine uses the <a href="http://en.wikipedia.org/wiki/Write-ahead_logging">Writing Ahead Log</a> strategy to assure data security and integrity. Data received from the client is written to the commit log at first. When TDengine recovers from crashes caused by power loss or other situations, the commit log is used to recover data. After writting to the commit log, data will be wrtten to the corresponding vnode cache, then an acknowledgment is sent to the application. There are two mechanisms that can flush data in cache to disk for persistent storage:</p>
<ol>
<li><strong>Flush driven by timer</strong>: There is a backend timer which flushes data in cache periodically to disks. The period is configurable via parameter commitTime in system configuration file taos.cfg.</li>
<li><strong>Flush driven by data</strong>: Data in the cache is also flushed to disks when the left buffer size is below a threshold. Flush driven by data can reset the timer of flush driven by the timer.</li>
</ol>
<p><center> <img src="../assets/write_process.png">  </center>
<center> Picture 3 TDengine Writting Process  </center></p>
<p>New commit log files will be opened when the committing process begins. When the committing process finishes, the old commit file will be removed.</p>
<a class='anchor' id='Data-Storage'></a><h2>Data Storage</h2><a href='https://github.com/taosdata/TDengine/blob/develop/documentation/webdocs/markdowndocs/Data%20model%20and%20architecture.md#data-storage' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>
<p>TDengine data are saved in <em>/var/lib/taos</em> directory by default. It can be changed to other directories by setting the parameter <code>dataDir</code> in system configuration file taos.cfg.</p>
<p>TDengine's metadata includes the database, table, user, super table and tag information. To reduce the latency, metadata are all buffered in the cache.</p>
<p>Data records saved in tables are sharded according to the time range. Data from tables in the same vnode in a certain time range are saved in the same file group. This sharding strategy can effectively improve data search speed. By default, one group of files contain data in 10 days, which can be configured by <code>daysPerFile</code> in the configuration file or by the <em>DAYS</em> keyword in <em>CREATE DATABASE</em> clause. </p>
<p>Data records are removed automatically once their lifetime is passed. The lifetime is configurable via parameter daysToKeep in the system configuration file. The default value is 3650 days. </p>
<p>Data in files are blockwise. A data block only contains one table's data. Records in the same data block are sorted according to the primary timestamp. To improve the compression ratio, records are stored column by column, and different compression algorithms are applied based on each column's data type. </p></section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>