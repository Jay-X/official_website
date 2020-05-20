var posts = {};
var cats = {};
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
var ha = new Headers();
ha.append('Cache-Control', 'public, max-age=1200');
var cachemethod = "default";
var c0 = 'wp-json/wp/v2/categories'; //Check if either the / or /blog/ directry was cached...

if (cacheable['/' + c0] || cacheable['/blog/' + c0]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}
var catsPromise = fetch(wp_endpoint + c0, {
  headers: ha
}).then(function (r) {
  return r.json();
});
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
excludedLangs = excludedLangs.join(","); //check for cacheable links

var paramsPost = {
  categories_exclude: excludedLangs,
  categories: externalNewsCategory + "," + featuredCategory,
  per_page: '100',
  _embed:"a",
};
var c2 = 'wp-json/wp/v2/posts?' + objectToParams(paramsPost);

if (cacheable['/' + c2] || cacheable['/blog/' + c2]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}
postsPromise = fetch(wp_endpoint + c2, {
  headers: ha
}).then(function (r) {
  var postHeaders = r.headers;
  totalPages = parseInt(postHeaders.get('X-WP-TotalPages'));

  return r.json();
});

$(document).ready(function(){
  Promise.all([postsPromise, catsPromise]).then(function(values){
    posts = values[0];
    values[1].forEach(function(cat){
      cats[cat.id] = cat;
    })
  }).then(function(){
    posts.forEach(function(post){
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
  $(".recent-news-wrapper").append("<a class='news-wrapper' href='" +link +"'><div class='news-box' id='news-" + post.id +"'><div class='news-title'>" + titleContent+"</div></div><div class='news-date'>" + parsedDate + "</div></a>")
  $("#news-" + post.id).css("background","linear-gradient(0deg, rgba(52, 73, 94, 0.40), rgba(52, 73, 94, 0.40)),url("+heroImageUrl+")");
}