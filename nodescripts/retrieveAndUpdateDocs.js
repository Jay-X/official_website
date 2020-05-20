const path = require('path');
const fs = require('fs');
const request = require('request');
const mkdirp = require('mkdirp');

var timeoption = 'false';
process.argv.forEach(function (val, index, array) {
  //console.log(index + ': ' + val);
  //console.log(val.slice(2,5));
  if (val.slice(2, 7) == 'force') {
    timeoption = val.slice(8);

  }
});

var allFilesEn = [];

var overrides = {
  titles: {
    "STable: Super Table": "Super Table"
  }
}
mkdirp('/var/www/html/en/documentation');
mkdirp('/var/www/html/cn/documentation');

var mainfilepath = "";
let filepromises = [];
var directoryPath = path.join(__dirname, mainfilepath);

let warningsList = [];

const showdown = require('showdown');
const converter = new showdown.Converter();
converter.setOption('tables', 'true');
converter.setOption('noHeaderId', 'true');
converter.setOption('smartIndentationFix', 'true')
converter.setOption('literalMidWordUnderscores', 'true');

//Parses a markdown document from a string of data, and writes to the directory documentation-en/name-of-markdown
async function parseMDtoHTML(data, filename, title, lang = "en", linkToGitHub) {
  return new Promise(function (resolve, reject) {

    filename2 = filename.substr(0, filename.length - 3) + '.php';
    //let htmlData = md.render(data);

    //get rid of tabs, and replace with standard double space
    data = data.replace(/\t/g, "  ");
    let htmlData = converter.makeHtml(data);
    if (lang == "en") {

      mkdirp('/var/www/html/en/doc-test/' + filename.substr(0, filename.length - 3).toLowerCase().replace(/ /g, "-"));
      let dirname = filename.substr(0, filename.length - 3).toLowerCase().replace(/ /g, "-")
      console.log("FILENAME", dirname);

    } else if (lang == "cn") {
      mkdirp('/var/www/html/cn/doc-test/' + filename.substr(0, filename.length - 6).toLowerCase().replace(/ /g, "-"));
      let dirname = filename.substr(0, filename.length - 6).toLowerCase().replace(/ /g, "-")

    }
    convertdoc(htmlData, filename.substr(0, filename.length - 3), filename, lang, linkToGitHub).then(function () {
      resolve(true);
    })
  });
}

async function convertdoc(string, title, filename, lang = "en", linkToGitHub) {

  var str = string;
  var arr = [];
  var arr3 = [];
  arr = string.match(/<h2>(.*?)\<\/h2\>/g); //returns array with h2 and </h2> on either side, strip it
  arr3 = string.match(/<h3>(.*?)\<\/h3\>/g);
  if (arr == null) {
    arr = [];
  }
  if (arr3 == null) {
    arr3 = [];
  }
  let doctitle = "";
  if (title != "") {
    doctitle = title;
  } else {
    var arrh1 = string.match(/<h1>(.*?)\<\/h1\>/g); //returns array with h1 tags
    if (arrh1 == null) {
      warningsList.push("Missing Title! For " + filename);
    } else {
      doctitle = arrh1[0].substring(4, arrh1[0].length - 5)
    }
  }
  if (overrides.titles[filename]) {
    doctitle = overrides.titles[filename];
  }

  doctitle = doctitle.toLowerCase().replace(/ /g, "-");
  var arrKeys = {};
  arrKeys.h2 = [];
  arrKeys.h3 = [];
  if (arr.length) {
    arrKeys.h2 = arr.map(part => {
      return part.substring(4, part.length - 5)
    });
  }
  if (arr3.length) {
    arrKeys.h3 = arr3.map(part => {
      return part.substring(4, part.length - 5)
    });
  }

  console.log("Document Title: " + doctitle);
  console.log("Found " + arrKeys.h2.length + " linkable headers-2 (H2)");
  console.log("Found " + arrKeys.h3.length + " linkable headers-3 (H3)");
  for (let i = 0; i < arr.length; i++) {
    //console.log(arr[i],"REPLACE:" + arrKeys[i]);
    str = str.replace(arr[i], "<a class='anchor' id='" + arrKeys.h2[i].replace(/ /g, "-") + "'></a>" + "<h2>" + arrKeys.h2[i] + "</h2><a href='" + linkToGitHub + "#" + arrKeys.h2[i].toLowerCase().replace(/ /g, "-") + "' class='edit-link'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='24' height='24'><path d='M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z'/></svg></a>");
  }
  for (let i = 0; i < arr3.length; i++) {
    str = str.replace(arr3[i], "<a class='anchor' id='" + arrKeys.h3[i].replace(/ /g, "-") + "'></a>" + "<h3>" + arrKeys.h3[i] + "</h3>");
  }
  //str = str.replace(/\n/g,"");
  str = str.replace(/\n<\/code>/g, "</code>");
  str = str.replace(/<table>/g, "<figure><table>")
  str = str.replace(/<\/table>/g, "</table></figure>");
  let finalPrepend = "";
  if (lang == "en") {
    if (doctitle == 'getting-started') {
      finalPrepend = "<!DOCTYPE html><html lang='en'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?><title>Getting Started | TAOS Data</title><meta name='description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.'><meta name='keywords' content='TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Documentation, programming, coding, syntax, frequently asked questions, questions, faq'><meta name='title' content='Getting Started | TAOS Data'><meta property='og:site_name' content='TAOS Data'/><meta property='og:title' content='Getting Started | TAOS Data'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><meta property='og:description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.' /><?php $s=$_SERVER['DOCUMENT_ROOT']." + '"/$lang"' + ";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script><script>$(document).ready(function(){loadScript('scripts/index.js?v=2', function(){});});</script></head><body><?php include($s.'/header.php'); ?><script>$('#getting-started-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'>"
    } else {
      finalPrepend = "<!DOCTYPE html><html lang='en'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/en/lang.php') ?><title>Documentation | TAOS Data</title><meta name='description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.'><meta name='keywords' content='TDengine, Big Data, Open Source, IoT, Connected Cars, Industrial IoT, time-series database, caching, stream computing, message queuing, IT infrastructure monitoring, application performance monitoring, Internet of Things,TAOS Data, Documentation, programming, coding, syntax, frequently asked questions, questions, faq'><meta name='title' content='Documentation | TAOS Data'><meta property='og:site_name' content='TAOS Data'/><meta property='og:title' content='Documentation | TAOS Data'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/" + doctitle + "/index.php'/><meta property='og:description' content='TDengine is an open-source big data platform for IoT. Along with a 10x faster time-series database, it provides caching, stream computing, message queuing, and other functionalities. It is designed and optimized for Internet of Things, Connected Cars, and Industrial IoT. Read the documentation for TDengine here to get started right away.' /><?php $s=$_SERVER['DOCUMENT_ROOT']." + '"/$lang"' + ";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/" + doctitle + "/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'>";
    }
  } else if (lang == 'cn') {
    if (doctitle == 'getting-started-ch') {
      finalPrepend = "<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>快速上手 | 涛思数据</title><meta name='description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine'><meta name='title' content='快速上手 | 涛思数据'><meta property='og:site_name' content='涛思数据'/><meta property='og:title' content='快速上手 | 涛思数据'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><meta property='og:description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']." + '"/$lang"' + ";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/getting-started'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script><script>$(document).ready(function(){loadScript('scripts/index.js?v=2', function(){});});</script></head><body><?php include($s.'/header.php'); ?><script>$('#getting-started-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'>";
    } else {
      finalPrepend = "<!DOCTYPE html><html lang='cn'><head><?php include($_SERVER['DOCUMENT_ROOT'] . '/cn/lang.php') ?><title>文档 | 涛思数据</title><meta name='description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。'><meta name='keywords' content='大数据，Big Data，开源，物联网，车联网，工业互联网，IT运维, 时序数据库，缓存，数据订阅，消息队列，流式计算，开源，涛思数据，TAOS Data, TDengine'><meta name='title' content='文档 | 涛思数据'><meta property='og:site_name' content='涛思数据'/><meta property='og:title' content='文档 | 涛思数据'/><meta property='og:type' content='article'/><meta property='og:url' content='https://www.taosdata.com/<?php echo $lang; ?>/documentation/" + doctitle + "/index.php'/><meta property='og:description' content='TDengine是一个开源的专为物联网、车联网、工业互联网、IT运维等设计和优化的大数据平台。除核心的快10倍以上的时序数据库功能外，还提供缓存、数据订阅、流式计算等功能，最大程度减少研发和运维的工作量。' /><?php $s=$_SERVER['DOCUMENT_ROOT']." + '"/$lang"' + ";include($s.'/head.php');?><link rel='canonical' href='https://www.taosdata.com/<?php echo $lang; ?>/documentation/" + doctitle + "/index.php'/><link rel='stylesheet' href='/lib/docs/taosdataprettify.css'><link rel='stylesheet' href='/lib/docs/docs.css?v=2'><script src='/lib/docs/prettify.js'></script><script src='/lib/docs/prettyprint-sql.js'></script></head><body><?php include($s.'/header.php'); ?><script>$('#documentation-href').addClass('active')</script><div class='container-fluid'><main class='content-wrapper'><section class='documentation'>";
    }
  }
  let finalString = finalPrepend + str + append;
  if (lang == "cn") {
    doctitle = doctitle.substring(0, doctitle.length - 3);
  }
  let newFilename = '/var/www/html/' + lang + '/documentation/' + doctitle + '/index.php';
  return new Promise(function (resolve, reject) {
    fs.writeFile(newFilename, finalString, async (err) => {
      if (err) throw err;
      else {
        console.log('New document saved as ' + newFilename + '\n');
        resolve(true);
      }

    });
  });
}

var currentTime = new Date(new Date - 600000).toGMTString();
if (timeoption == 'true') {
  currentTime = (new Date(0)).toGMTString();
}
console.log(currentTime);
//*doc prepends*//
var append = "</section></main></div><?php include($s.'/footer.php'); ?><script>$('pre').addClass('prettyprint linenums');PR.prettyPrint()</script><script src='/lib/docs/liner.js'></script></body></html>";


var ignore = {
  faq: 1,
  contributor_license_agreement: 1,
  gettingstarted: 1,
};

async function retrieveAllFilesFromDir(url, rel, arr) {
  //console.log("READING", dir);
  var dirleft = 0;
  return new Promise(async function (resolve, reject) {
    request({
      url: url,
      headers: {
        'User-Agent': 'StoneT2000',
        'Authorization': 'token ad91d0c8c5e34072b08d4e7b75c71e50ca18ed90',
        'If-Modified-Since': currentTime,
      }
    }, (err, res, body) => {
      //handling error
      if (err) {
        return console.log('Unable to scan directory: ' + err);
      }
      //listing all files using forEach
      let filesLookedAt = 0;
      if (body.length > 0) {
        let files = JSON.parse(body);
        files.forEach(async function (file) {
          console.log(rel + "/" + file.name);
          if (ignore[file.name.replace("-", "")] == 1) {
            filesLookedAt += 1;
            //console.log(file, filesLookedAt ,files.length);
            if (filesLookedAt == files.length) {
              if (dirleft == 0) {
                resolve(true);
              }
            }
          } else {
            console.log("Dir Left: ", dirleft, "Files looked at", filesLookedAt, 'Files left', files.length - filesLookedAt);
            if (file.type == 'dir') {
              //dirleft += 1;
              await retrieveAllFilesFromDir(url + "/" + file.name, rel + "/" + file.name, arr);
            } else if (file.type == 'file') {
              //console.log("FILE FOUND: ", rel+file);
              arr.push({
                rel: rel + "/" + file.name,
                url: file.download_url,
                name: file.name,
                html_url: file.html_url
              });
            }
            filesLookedAt += 1;
            //console.log(file, filesLookedAt, files.length, "DIRLEFT: " + dirleft);
            if (filesLookedAt == files.length) {
              if (dirleft == 0) {
                resolve(true);
              }
            }
          }


        });
      }
    });
  });
}
retrieveAllFilesFromDir('https://api.github.com/repositories/196353673/contents/documentation/webdocs/markdowndocs', '/var/www/html/docs-test/documentation', allFilesEn).then(function () {
  console.log(allFilesEn);
  //convertDirectoryDocs();
  allFilesEn.forEach(function (fileData) {
    console.log(fileData);
    let name = fileData.name;
    request({
      uri: fileData.url,
      headers: {
        'User-Agent': 'StoneT2000',
        'Authorization': 'token ad91d0c8c5e34072b08d4e7b75c71e50ca18ed90',
        'If-Modified-Since': currentTime
      }
    }, (err, res, body) => {
      if (err) console.log(err);
      console.log("Parsing", name, fileData.rel);
      if (name.substring(name.length - 3, name.length) == ".md") {
        let lang = "en";
        if (name.substring(name.length - 5, name.length) == "ch.md") {
          lang = "cn";
        }
        //no documentation hoem page should be allowed to parse.
        //faq, getting-started also not allowed
        filepromises.push(parseMDtoHTML(body, name, "", lang, fileData.html_url));
      }
    });
  });
});