<!DOCTYPE html>
<html lang='en'>

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?>
  <title>Documentation | TDengine</title>
  <meta name='description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.'>
  <meta name='keywords' content='TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Documentation, programming, coding, syntax, frequently asked questions, questions, faq'>
  <meta name='title' content='Documentation | TAOS Data'>
  <meta property='og:site_name' content='TAOS Data' />
  <meta property='og:title' content='Documentation | TAOS Data' />
  <meta property='og:type' content='article' />
  <meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation' />
  <meta property='og:description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.' />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation' />
  <link rel='stylesheet' href='/lib/docs/taosdataprettify.css'>
  <link rel='stylesheet' href='/lib/docs/docs.css'>
  <link rel='stylesheet' href='/styles/documentation/index.min.css'>
  <script src='/lib/docs/prettify.js'></script>
  <script src='/lib/docs/prettyprint-sql.js'></script>
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
    $('#documentation-href').addClass('active')
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <section class='documentation'>
        <h1>Documentation</h1>
        <p>TDengine is a highly efficient platform to store, query, and analyze time-series data. It works like a relational database, but you are strongly suggested to read through the following documentation before you experience it.</p><a href='../getting-started'>
          <h2>Getting Started</h2>
        </a>
        <ul>
          <li><a href='../getting-started/#Quick-Start'>Quick Start</a>: download, install and experience TDengine in a few seconds</li>
          <li><a href='../getting-started/#TDengine-Shell'>TDengine Shell</a>: command-line interface to access TDengine server</li>
          <li><a href='../getting-started/#Experience-10x-faster-insertion/query-speed'>Experience 10x Faster Speed</a>: running a demo to experience 10x faster speed</li> 
          <li><a href='../getting-started/#Major-Features'>Major Features</a>: insert/query, aggregation, cache, pub/sub, continuous query </li>
        </ul><a href='data-model-and-architecture'>
          <h2>Data Model and Architecture</h2>
        </a>
        <ul>
          <li><a href='data-model-and-architecture/#Data-Model'>Data Model</a>: relational database model, but one table for one device with static tags</li>
          <li><a href='data-model-and-architecture/#Architecture'>Architecture</a>: Management Module, Data Module, Client Module</li>
          <li><a href='data-model-and-architecture/#Writing-Process'>Writing Process</a>: records recieved are written to WAL, cache, then ack is sent back to client</li>
          <li><a href='data-model-and-architecture/#Data-Storage'>Data Storage</a>: records are sharded in the time range, and stored column by column </li>
        </ul><a href='taos-sql'>
          <h2>TAOS SQL</h2>
        </a>
        <ul>
          <li><a href='taos-sql/#Data-Types'>Data Types</a>: support timestamp, int, float, double, binary, nchar, bool, and other types</li>
          <li><a href='taos-sql/#Database-Management'>Database Management</a>: add, drop, check databases</li>
          <li><a href='taos-sql/#Table-Management'>Table Management</a>: add, drop, check, alter tables</li>
          <li><a href='taos-sql/#Inserting-Records'>Inserting Records</a>: insert one or more records into tables, historical records can be imported</li>
          <li><a href='taos-sql/#Data-Query'>Data Query</a>: query data with time range and filter conditions, support limit/offset</li>
          <li><a href='taos-sql/#SQL-Functions'>SQL Functions</a>: support aggregation, selector, transformation functions</li>
          <li><a href='taos-sql/#Downsampling'>Downsampling</a>: aggregate data in successive time windows, support interpolation</li>
        </ul><a href='super-table'>
          <h2>Super Table</h2>
        </a>
        <ul>
          <li><a href='super-table/#What-is-a-Super-Table'>What is a Super Table</a>: an innovated way to aggregate tables</li>
          <li><a href='super-table/#Create-a-STable'>Create a STable</a>: it is like creating a standard table, but with tags defined</li>
          <li><a href='super-table/#Create-a-Table-via-STable'>Create a Table via STable</a>: use STable as the template, with tags specified</li>
          <li><a href='super-table/#Aggregate-Tables-via-STable'>Aggregate Tables via STable</a>: group tables together by specifying the tags filter condition</li>
          <li><a href='super-table/#Create-Table-Automatically'>Create Table Automatically</a>: create tables automatically with a STable as a template</li>
          <li><a href='super-table/#Management-of-STables'>Management of STables</a>: create/delete/alter super table just like standard tables</li>
          <li><a href='super-table/#Management-of-Tags'>Management of Tags</a>: add/delete/alter tags on super tables or tables </li>
        </ul><a href='advanced-features'>
          <h2>Advanced Features</h2>
        </a>
        <ul>
          <li><a href='advanced-features/#Continuous-Query'>Continuous Query</a>: query executed by TDengine periodically with a sliding window</li>
          <li><a href='advanced-features/#Publisher/Subscriber'>Publisher/Subscriber</a>: subscribe to the newly arrived data like a typical messaging system </li>
          <li><a href='advanced-features/#Caching'>Caching</a>: the newly arrived data of each device/table will always be cached</li>
        </ul><a href='connector'>
          <h2>Connector</h2>
        </a>
        <ul>
          <li><a href='connector/#C/C++-Connector'>C/C++ Connector</a>: primary method to connect to the server through libtaos client library</li>
          <li><a href='connector/#Java-Connector'>Java Connector</a>: driver for connecting to the server from Java applications using the JDBC API</li>
          <li><a href='connector/#Python-Connector'>Python Connector</a>: driver for connecting to the server from Python applications </li>
          <li><a href='connector/#RESTful-Connector'>RESTful Connector</a>: a simple way to interact with TDengine via HTTP</li>
          <li><a href='connector/#Go-Connector'>Go Connector</a>: driver for connecting to the server from Go applications</li>
          <li><a href='connector/#Node.js-Connector'>Node.js Connector</a>: driver for connecting to the server from node applications</li>
        </ul><a href='connections-with-other-tools'>
          <h2>Connections with Other Tools</h2>
        </a>
        <ul>
          <li><a href='connections-with-other-tools/#Telegraf'>Telegraf</a>: pass the collected DevOps metrics to TDengine </li>
          <li><a href='connections-with-other-tools/#Grafana'>Grafana</a>: query the data saved in TDengine and visualize them </li>
          <li><a href='connections-with-other-tools/#Matlab'>Matlab</a>: access TDengine server from Matlab via JDBC</li>
          <li><a href='connections-with-other-tools/#R'>R</a>: access TDengine server from R via JDBC </li>
        </ul><a href='administrator'>
          <h2>Administrator</h2>
        </a>
        <ul>
          <li><a href='administrator/#Directory-and-Files'>Directory and Files</a>: files and directories related with TDengine</li>
          <li><a href='administrator/#Configuration-on-Server'>Configuration on Server</a>: customize IP port, cache size, file block size and other settings</li>
          <li><a href='administrator/#Configuration-on-Client'>Configuration on Client</a>: customize locale, default user and others </li>
          <li><a href='administrator/#User-Management'>User Management</a>: add/delete users, change passwords</li>
          <li><a href='administrator/#Import-Data'>Import Data</a>: import data into TDengine from either script or CSV file</li>
          <li><a href='administrator/#Export-Data'>Export Data</a>: export data either from TDengine shell or from tool taosdump</li>
          <li><a href='administrator/#Management-of-Connections,-Streams,-Queries'>Management of Connections, Streams, Queries</a>: check or kill the connections, queries</li>
          <li><a href='administrator/#System-Monitor'>System Monitor</a>: collect the system metric, and log important operations</li>
        </ul><a href='more-on-system-architecture'>
          <h2>More on System Architecture</h2>
        </a>
        <ul>
          <li><a href='more-on-system-architecture/#Storage-Design'>Storage Design</a>: column-based storage with optimization on time-series data </li>
          <li><a href='more-on-system-architecture/#Query-Design'>Query Design</a>: an efficient way to query time-series data</li>
          <li><a href='../blog/?categories=3'>Technical blogs</a> to delve into the inside of TDengine</li>
        </ul>
<h2>Performance: TDengine vs others</h2>
        </a>
        <ul>
          <li><a href='blog/2019/09/12/performance-tdengine-vs-opentsdb/'>Performance: TDengine vs OpenTSDB</li>
          <li><a href='blog/2019/09/12/performance-tdengine-vs-cassandra/'>Performance: TDengine vs Cassandra</li>
          <li><a href='blog/2019/09/12/performance-tdengine-vs-influxdb/'>Performance: TDengine vs InfluxDB</li>
          <li><a href="/downloads/TDengine%20Performance%20Comparison.pdf" l id='download-report'>Download the full testing report</a>
             </ul>
        <h2>More on IoT Big Data</h2>
<ul>
<li><a href='https://www.taosdata.com/blog/2019/07/09/characteristics-of-iot-big-data/'>Characteristics of IoT Big Data</a></li>
<li><a href='https://www.taosdata.com/blog/2019/07/09/why-does-the-general-big-data-platform-not-fit-iot-data-processing/'>Why don’t General Big Data Platforms Fit IoT Scenarios?</a></li>
<li><a href='https://www.taosdata.com/blog/2019/07/09/why-tdengine-is-the-best-choice-for-iot-big-data-processing/'>Why TDengine is the Best Choice for IoT Big Data Processing?</a></li>

</ul>
        <a href='../faq'>
          <h2>Tutorials &amp; FAQ</h2>
        </a>
        <ul>
          <li><a href='https://www.taosdata.com/en/faq'>FAQ</a>: a list of frequently asked questions and answers </li>
          <li><a href='https://www.taosdata.com/en/blog/?categories=4'>Use cases</a>: a few typical cases to explain how to use TDengine in IoT platform</li>
        </ul>
      </section>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
  <script>
    $('pre').addClass('prettyprint linenums');
    PR.prettyPrint()
  </script>
  <script src='/lib/docs/liner.js'></script>
</body>

</html>
