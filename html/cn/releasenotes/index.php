<!DOCTYPE html>
<html lang="cn">

<head>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?>
  <title>Release Notes | 涛思数据</title>
  <meta name="description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。">
  <meta name="keywords" content="大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，涛思数据，TAOS Data, TDengine">
  <meta property="og:site_name" content="涛思数据 | TDengine"/>
  <meta name="title" content="Release Notes | 涛思数据">
  <meta property="og:site_name" content="涛思数据 | TDengine" />
  <meta property="og:title" content="Release Notes | 涛思数据" />
  <meta property="og:type" content="article" />
  <meta property="og:url" content="https://www.taosdata.com/<?php echo $lang; ?>/releasenotes" />
  <meta property="og:description" content="TDengine是涛思数据推出的一款开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。" />
  <link rel="canonical" href="https://www.taosdata.com/<?php echo $lang; ?>/releasenotes" />
  <?php $s=$_SERVER['DOCUMENT_ROOT']."/$lang";include($s.'/head.php');?>
  <link href="/styles/releasenotes/index.min.css" rel="stylesheet">
</head>

<body>
  <?php include($s.'/header.php'); ?>
  <script>
    $("#releasenotes-href").addClass('active');
  </script>
  <div class='container-fluid'>
    <main class='content-wrapper'>
      <section id='intro'>
        <h1 id='intro-title' style='text-align:left;margin-left:0;'>Release Notes</h1>
        <h2 b>ver-1.6.6.1-beta</h2>
        <details>
            <summary>Fix bugs and refactor code:</summary>
                <ol>
                <li>Avoid the retry efforts to consume too many CPU time in getting first available cache slot.</li>
                <li>Fix invalid free bug.</li> 
                <li>Fix sub/pub bug in returning data to client.</li>
                <li>Filter only sliding query.</li>
                <li>Fix the crash when skey is less than ekey.</li> 
                <li>Fix bugs founded in regression test(reverse scan failed).</li>
                <li>Fix __compar_fn_t build issue on Mac.</li>
                <li>Fix invalid write when assign the ip address at the client side.</li>
                <li>Refactor code for sliding query processing.</li> 
                <li>Refactor extbuffer model.</li>
                <li>Refactor code for query intermeidate buffer.</li>
                <li>Remove redundant codes.</li> 
                <li>Fix bugs in regression test.</li>
                <li>Fix query bugs.</li>
                <li>Fix bugs found in regression test.</li>
                <li>Modify default value of memory for aarch32 version.</li> 
                <li>Modify compile scripts.</li>
                <li>Fix pHeader->tranId use the wrong method when assigning.</li>
                <li>Fix tpercentile link issue on Mac (and Windows).</li> 
                <li>Add description in the document: the time range that the database allows to insert records</li>
                <li>Docker compile modify and doc modify.</li>
                <li>Refactor subscribe feature, and update corresponding documents.</li>
                <li>Modified the format of query result for Grafana plugin, seperate the data into divided arrays,one result array per table, with the tags as the label.Therefor "select * from super-table-name" will work well in the Grafana query.</li> 
                <li>Fix bug: describing super table causes crash, when add one tag and the data type of tag is wrong.</li>
                <li>Fix bug: the error result of show databases for no root user.</li>
                <li>Fix bug: Add additional check when super table uid is 0, Compatible with the case of super table with uid 0.</li> 
                <li>Fix a typo.</li>
                <li>Fix the crash when ctrl+c is triggered when querying super table.</li>
            </ol>
        </details>
        <details>
            <summary>New feature:</summary>
            <ol>
                <li>Add six new functions for supporting rate/irate/sum_rat/sum_irate/avg_rate/avg_irate.</li>
            </ol>
        </details>
        </br>

    <h2 b>ver-1.6.5.6</h2>
        <details>
            <summary>Fix bugs and refactor code:</summary>
                <ol>
                <li>Describing super table causes crash, when add one tag and the data type of tag is wrong.</li>
                <li>The error result of show databases for no root user.</li> 
                <li>Add additional check when super table uid is 0.</li>
                <li>Fix a typo.</li>
                <li>Compatible with the case of super table with uid 0.</li> 
                <li>Fix the crash when ctrl+c is triggered when querying super table.</li>
                <li>Support input 'nan' or '-nan' for double/float.</li>
                <li>Modified the format of query result for Grafana plugin, seperate the data into divided arrays, one result array per table, with the tags as the label. Therefor "select * from super-table-name" will work well in the Grafana query.</li>
                </ol>
        </details>
        </br>
    <h2 b>ver-1.6.5.5-fnk</h2>
        <p>Release this version to fanake for compatible.</p>
    </br>
    <h2 b>ver-1.6.6.0-beta</h2>
        <details>
            <summary>Fix bugs:</summary>
                <ol>
                <li>Kill connection failed.</li>
                <li>Fix memroy leaks.</li> 
                </ol>
        </details>
        <details>
            <summary>New feature:</summary>
            <ol>
                <li>Support aarch32.</li>
                <li>Add union.</li>
            </ol>
        </details>
        </br>
    <h2 b>ver-1.6.5.5-update</h2>
        <p>Modify package name.</p>
    </br>
    <h2 b>ver-1.6.5.4</h2>
        <p>Add an option to control the meaning of affected rows.</p>
    </br>
    <h2 b>ver-1.6.4.6</h2>
        <details>
            <summary>Fix bugs:</summary>
                <ol>
                <li>Add column and import cause " TDengine Error: others".</li>
                <li>Data file corruption during multi-copy synchronization.</li> 
                </ol>
        </details>
        <details>
            <summary>Enhancements:</summary>
            <ol>
                <li>Enhanced security permissions.</li>
            </ol>
        </details>
        </br>
    <h2 b>ver-1.6.5.3-beta</h2>
        <details>
            <summary>Enhancements:</summary>
            <ol>
                <li>In the query of super tables, all subquery objects are prepared before lauching and some checks for global status check are added.</li>
                <li>Failed login information would be store in the 'log' database and the access to this database has be limited.</li>
            </ol>
        </details>
    </br>
    <h2 b>ver-1.6.5.2-beta</h2>
        <details>
            <summary>Fix bugs:</summary>
                <ol>
                <li>Query results could be incorrect when sorting the results by descending timestamp and using offset/limit.</li>
                <li>Query of last record could lead to server crash.</li> 
                <li>The display could be incorrect when show vnodes [dnodeIp].</li>
                <li>Group by normal column may result in server crash.</li>
                </ol>
        </details>
        <details>
            <summary>Enhancements:</summary>
                <ol>
                <li>Add support for customized template variable for query alias in the grafana.</li>
                <li>Add support for Alpine Linux.</li> 
                <li>Avoid repetitively parsing the same table when inserting records into multiple tables in a batch.</li>
                <li>Accelerate the speed of writing into a database with multiple replicas by redirecting the request to the master vnode.</li>
                <li>Allow dropping database and inserting data to be concurrently executed.</li>
                </ol>
        </details>
        </br>
    <h2 b>ver-1.6.4.5</h2>
        <details>
            <summary>Fix bugs:</summary>
                <ol>
                <li>In the windows query results from grouping by a nchar column could be inconsistent with that from taos cliEnt shell in the linux.</li>
                <li>Query of last record could lead to server crash.</li> 
                <li>Both inserting data and creating dropped tables would fail if setting 'tables' option to 1.</li>
                </ol>
        </details>
        <details>
            <summary>Enhancements:</summary>
                <ol>
                <li>Avoid repetitively parsing the same table when inserting records into multiple tables in a batch.</li>
                <li>Accelerate the speed of writing into a database with multiple replicas by redirecting the request to the master vnode.</li> 
                <li>Clarify the error message when importing multiple files.</li>
                </ol>
        </details>
        </br>
    <h2 b>ver-1.6.5.1-beta</h2>
        <p>Merge pull request <a href="https://github.com/taosdata/TDengine/pull/979">#979</a> from taosdata/feature/grafana_plugin.</p>
    </br>
    <h2 b>ver-1.6.4.4</h2>
        <details>
            <summary>Fix bugs:</summary>
                <ol>
                <li><a href="https://github.com/taosdata/TDengine/issues/952">#952</a> Logical error when setting read and write permissions for the users.</li>
                <li><a href="https://github.com/taosdata/TDengine/issues/949">#949</a> SQL statement `show connections` may cause crash.</li> 
                <li><a href="https://github.com/taosdata/TDengine/issues/946">#946</a> Filter on all NULL value cause the server crashed.</li>
                <li><a href="https://github.com/taosdata/TDengine/issues/928">#928</a> Use multi-threading to import all SQL files in the directory separately.</li>
                <li>Asynchronous query loop too many times when pulling cache.</li>
                </ol>
        </br>
      </section>
    </main>
  </div>
  <?php include($s.'/footer.php'); ?>
</body>

</html>
