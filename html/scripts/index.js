

var excludedLangs = allSiteLangs;
excludedLangs = excludedLangs.filter(function (lang) {
  if (lang != siteLang) {
    return true;
  }

  return false;
}).map(function (a) {
  return siteLangMap[a];
});
var excludedLangsArr = excludedLangs;
excludedLangs = excludedLangs.join(",");

function objectToParams(a) {
  var keys = Object.keys(a);
  keys.sort();
  var str = "";
  keys.forEach(function (key) {
    if (a[key]) {
      str += "&" + key + "=" + a[key];
    }
  });
  return str.substring(1);
}

var cachemethod = "default";
var c0 = 'wp-json/wp/v2/posts?categories_exclude=' + excludedLangs + '&categories=' + featuredCategory + '&page=1&per_page=100'; //Check if either the / or /blog/ directry was cached...

if (cacheable['/' + c0] || cacheable['/blog/' + c0]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}

var featuredPostsPromise = fetch('/blog/index.php/' + c0, {
  cache: cachemethod
}).then(function (r) {
  return r.json();
});
var c1 = 'wp-json/wp/v2/categories'; //Check if either the / or /blog/ directry was cached...

if (cacheable['/' + c1] || cacheable['/blog/' + c1]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}

var catsPromise = fetch('/blog/index.php/wp-json/wp/v2/categories', {
  cache: cachemethod
}).then(function (r) {
  return r.json();
});
var cats = {};
var featuredPosts = [];
var added = {};
var featuredPostsPromiseArr = [];
var authors = {};


var paramsPost = {
  categories: externalNewsCategory,
  per_page: '9',
  _embed:"a",
};
var c3 = 'wp-json/wp/v2/posts?' + objectToParams(paramsPost);

if (cacheable['/' + c3] || cacheable['/blog/' + c3]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}
var ha = new Headers();
ha.append('Cache-Control', 'public, max-age=1200');
newsPostsPromise = fetch(wp_endpoint + c3, {
  headers: ha
}).then(function (r) {
  var postHeaders = r.headers;
  totalPages = parseInt(postHeaders.get('X-WP-TotalPages'));

  return r.json();
});
var newsposts = {};
$(document).ready(function(){
  Promise.all([newsPostsPromise, catsPromise]).then(function(values){
    newsposts = [values[0][0],values[0][1],values[0][2]];
    values[1].forEach(function(cat){
      cats[cat.id] = cat;
    })
  }).then(function(){
    newsposts.forEach(function(post){
        post.categories.forEach(function(cat) {
          if (cat == externalNewsCategory) {
            addNews(post);
          }
        })
    });
  });
});
function addNews(post) {
  var link = post.link;
  var postCats = post.categories;
  var date = post.date;
  var parsedDate = new Date(date).toDateString(); //'June 12, 2019';
var titleContent = post.title.rendered;
  var dateArr = parsedDate.split(' ').splice(1);
  parsedDate = dateArr[0] + ' ' + dateArr[1] + ', ' + dateArr[2];
  var heroImageUrl = "";
  if (post._embedded["wp:featuredmedia"]){
    heroImageUrl = post._embedded["wp:featuredmedia"][0].source_url;
  }
  $(".recent-news-wrapper").append("<a class='news-wrapper col-xl-4' href='" +link +"'><div class='news-box' id='news-" + post.id +"'><div class='news-title'>" + titleContent+"</div></div></a>")
  $("#news-" + post.id).css("background","linear-gradient(0deg, rgba(52, 73, 94, 0.40), rgba(52, 73, 94, 0.40)),url("+heroImageUrl+")");
}


$(document).ready(function () {
  Promise.all([featuredPostsPromise, catsPromise]).then(function (values) {
    featuredPosts = values[0];
    values[1].forEach(function (cat) {
      cats[cat.id] = cat;
    });
  }).then(function (a) {
    featuredPosts.forEach(function (fp) {
      added[fp.id] = false;

      if (!authors.hasOwnProperty(fp.author)) {
        var c2 = 'wp-json/wp/v2/users/' + fp.author; //Check if either the / or /blog/ directry was cached...

        if (cacheable['/' + c2] || cacheable['/blog/' + c1]) {
          cachemethod = 'force-cache';
        } else {
          cachemethod = "default";
        }

        fetch(wp_endpoint + 'wp-json/wp/v2/users/' + fp.author, {
          cache: cachemethod
        }).then(function (r) {
          return r.json();
        }).then(function (b) {
          authors[fp.author] = b;

          if (added[fp.id] == false) {
            addPost(fp);
            added[fp.id] = true;
            $('.blank-placeholder-posts').css('display', 'none');
          }
        });
      } else {
        if (added[fp.id] == false) {
          addPost(fp);
          added[fp.id] = true;
        }
      }
    });
  });
  
  $("#join-github").on("click", function(){
    gtag('event', "Click", {
      'event_category': "Button",
      'event_label': "Join us on GitHub",
      'value':"none"
    });
  });
});

function addPost(post, options) {
  //addPost(post.title.rendered, "content", authors[post.author], post.date, post.excerpt.rendered, post.link, post.tags, {sticky:true});
  var link = post.link;
  var postCats = post.categories;
  var author = authors[post.author];
  var date = post.date;
  var parsedDate = new Date(date).toDateString(); //'June 12, 2019';

  var dateArr = parsedDate.split(' ').splice(1);
  var authorName = author.name;
  parsedDate = dateArr[0] + ' ' + dateArr[1] + ', ' + dateArr[2];
  var catsHTML = "";
  postCats.forEach(function (cat) {
    if (cat != 1 && cat != chineseCategory && cat != englishCategory && cat != featuredCategory) {
      catsHTML += "<a href='blog/?categories=" + cat + "' l>" + cats[cat].name + "</a>, ";
    }
  });

  if (author.avatar_urls[96] == 'http://0.gravatar.com/avatar/cbf3ae80bfffa54eade6fba665324a26?s=92&d=mm&r=g' || author.avatar_urls[96] == 'https://secure.gravatar.com/avatar/8a2233e4af05d90078be153329a99004?s=96&d=mm&r=g') {
    author.avatar_urls[96] = '/assets/images/defaultavatar.jpg';
  }

  var finalstr = "<div class='col-md-6'><div class='post'><a href='" + link + "' class='post-title-wrapper'><h2 class='post-title'>" + post.title.rendered + "</h2></a><img src='" + author.avatar_urls[96] + "' class='post-author-avatar' alt='" + authorName + "&#39;s Avatar'><div class='post-meta'><cite class='post-author'><span>" + authorName + "</span></cite><br><time class='post-time'>" + parsedDate + "</time><span class='post-slash'> / </span><h3 class='post-tags'>" + catsHTML.substring(0, catsHTML.length - 2) + "</h3><time class='post-time'></time></div><div class='post-desc'>" + post.excerpt.rendered + "</div>";
  var socialMediaStr = "<div class='social-media'><a href='https://twitter.com/share?url=" + link + "' target='_blank'><ion-icon name='logo-twitter'></ion-icon></a><a href='#' target='_blank'><ion-icon name='logo-reddit'></ion-icon></a><a href='https://www.facebook.com/sharer.php?u=" + link + "' target='_blank'><ion-icon name='logo-facebook'></ion-icon></a><a href='#'></a></div>";
  finalstr += socialMediaStr;
  finalstr += "</div></div>"; //read more button
  //<a href='" + link + "'><button class='btn btn-primary'>Read More</button></a></div>"

  $("#content-5").append(finalstr);
}