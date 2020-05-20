"use strict";

var posts = {};
var authors = {};
var tags = {};
var cats = {};
var js_tagsArr = [];
var js_catsArr = [];
var tagsPromise, authorPromise, postsPromise;
var tagquery,
    categoryquery,
    searchquery = "";
var pageQuery = "";
var filterCategories = [];

if (js_tags !== "") {
  tagquery = js_tags;
  js_tagsArr = js_tags.split(',');
}

if (js_categories !== "") {
  categoryquery = js_categories;
}

if (js_searchKey !== "") {
  searchquery = js_searchKey;
}

if (js_page !== "") {
  pageQuery = js_page;
} //var postHeaders;


var totalPages;
var page = 1;
var searchedTags = js_tags.split(","); //turns object to params for GET request, keys in sorted order.

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
var c0 = 'wp-json/wp/v2/categories'; //Check if either the / or /blog/ directry was cached...

if (cacheable['/' + c0] || cacheable['/blog/' + c0]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}

var ha = new Headers();
ha.append('Cache-Control', 'public, max-age=1200');
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

var paramsStickyPost = {
  categories_exclude: excludedLangs + "," + externalNewsCategory + "," + announcementCategory,
  categories: categoryquery,
  tags: tagquery,
  search: searchquery,
  per_page: '5',
  sticky: 'true'
};
var c1 = 'wp-json/wp/v2/posts?' + objectToParams(paramsStickyPost);

if (cacheable['/' + c1] || cacheable['/blog/' + c1]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}

var stickyPostsPromise = fetch(wp_endpoint + c1, {
  headers: ha
}).then(function (r) {
  return r.json();
});
var paramsPost = {
  categories_exclude: excludedLangs + "," + externalNewsCategory + "," + announcementCategory,
  categories: categoryquery,
  tags: tagquery,
  search: searchquery,
  per_page: '5',
  page: pageQuery
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

  if (js_page !== "") {
    page = parseInt(js_page);
  }

  return r.json();
});
var c3 = 'wp-json/wp/v2/users';

if (cacheable['/' + c3] || cacheable['/blog/' + c3]) {
  cachemethod = 'force-cache';
} else {
  cachemethod = "default";
}
/*
authorsPromise = fetch(wp_endpoint + c3, {
    headers: ha
  })
  .then(r => r.json());*/


$(document).ready(function () {
  $("#blog-href").addClass('active');
  $("#long-email").on('focus', function () {
    $(document).off("keypress");
    $(document).keypress(function (e) {
      if (e.which == 13) {
        $("#long-form-submit").click();
        return false;
      }
    });
  });
  $("#searchKey").on('focus', function () {
    $(document).off("keypress");
    $(document).keypress(function (e) {
      if (e.which == 13) {
        search();
        return false;
      }
    });
  });
  /*
  js_posts.forEach(function(post){
    addPostPHP(post);
  });
  */

  var allPromisesForPosts = [catsPromise, postsPromise, stickyPostsPromise];
  Promise.all(allPromisesForPosts).then(function (values) {
    var splitcats = js_categories.split(",");
    values[0].forEach(function (cat) {
      cats[cat.id] = cat;
      var selected = false;

      for (var k = 0; k < splitcats.length; k++) {
        if (cat.id == parseInt(splitcats[k])) {
          selected = true;
          break;
        }
      }

      addTag(cat.id, selected);
    });
    splitcats.forEach(function (cat) {
      $("#tag-" + cat).addClass("selected");
    });
    posts = values[1]; //in canonical order

    var stickyPosts = values[2];

    if (stickyPosts == undefined) {
      stickyPosts = [];
    }
    /*
    stickyPosts.forEach(function (post) {
      if (!authors[post.author]) {
        fetch(wp_endpoint + c3 + '/' + post.author, {
          headers: ha
        }).then(r => r.json()).then(author => {
          authors[author.id] = author;
        }).then(r => {
          addPost(post, {
            sticky: true
          })
          $('.blank-placeholder-posts').css('display', 'none');
        });
      } else {
        addPost(post, {
          sticky: true
        })
        $('.blank-placeholder-posts').css('display', 'none');
      }
    });
    */


    if (isNaN(totalPages)) {
      $('.blank-placeholder-posts').css('display', 'none');
      $("#posts-list").append("<h3>没有帖子。点击<a l href='../blog'>这里</a>回博客主页</h3>");
      return;
    }

    var postsAuthorQueue = 0;

    if (posts.length > 0) {
      posts.forEach(function (post) {
        if (!authors[post.author]) {
          fetch(wp_endpoint + c3 + '/' + post.author, {
            headers: ha
          }).then(function (r) {
            return r.json();
          }).then(function (author) {
            return authors[author.id] = author;
          }).then(function (a) {
            postsAuthorQueue += 1;

            if (postsAuthorQueue == posts.length) {
              posts.forEach(function (queuedpost) {
                addPost(queuedpost);
              });
              $('.blank-placeholder-posts').css('display', 'none');
            }
          });
        } else {
          postsAuthorQueue += 1;

          if (postsAuthorQueue == posts.length) {
            posts.forEach(function (queuedpost) {
              addPost(queuedpost);
            });
            $('.blank-placeholder-posts').css('display', 'none');
          }
        }
      });
      /*Pagination work*/

      if (page > 1 && totalPages != 1) {
        var addPageParams = {
          categories: categoryquery,
          tags: tagquery,
          search: searchquery,
          per_page: '5',
          sticky: 'true',
          page: page - 1
        };
        $("#pagination").append("<a class='page-num' id='page-" + (page - 1) + "' href='?" + objectToParams(addPageParams) + "'><button class='btn btn-primary'>上</button></a>");
      }

      if (totalPages <= 7) {
        for (var i = 1; i < totalPages + 1; i++) {
          addPageNum(i);
        }
      } else {
        if (page == totalPages) {
          addPageNum(1);
          addPageNum(2);
          $("#pagination").append("<a class='ellipsis'>...</a>");

          for (var _i = totalPages - 3; _i <= totalPages; _i++) {
            addPageNum(_i);
          }
        } else if (page < totalPages - 3 && page > 3) {
          addPageNum(1);
          addPageNum(2);
          $("#pagination").append("<a class='ellipsis'>...</a>");

          for (var _i2 = page - 1; _i2 <= page + 1; _i2++) {
            addPageNum(_i2);
          }

          $("#pagination").append("<a class='ellipsis'>...</a>");
          addPageNum(totalPages - 1);
          addPageNum(totalPages);
        } else if (page >= totalPages - 3) {
          addPageNum(1);
          addPageNum(2);
          $("#pagination").append("<a class='ellipsis'>...</a>");

          for (var _i3 = totalPages - (totalPages - page + 1); _i3 <= totalPages; _i3++) {
            addPageNum(_i3);
          }
        } else if (page <= 3) {
          for (var _i4 = 1; _i4 <= page + 1; _i4++) {
            addPageNum(_i4);
          }

          $("#pagination").append("<a class='ellipsis'>...</a>");
          addPageNum(totalPages - 1);
          addPageNum(totalPages);
        }
      }

      if (page < totalPages && totalPages != 1) {
        var _addPageParams = {
          categories: categoryquery,
          tags: tagquery,
          search: searchquery,
          per_page: '5',
          sticky: 'true',
          page: page + 1
        };
        $("#pagination").append("<a class='page-num' id='page-" + (page + 1) + "' href='?" + objectToParams(_addPageParams) + "'><button class='btn btn-primary'>下</button></a>");
      }

      $("#page-" + page + " button").removeClass('btn-primary');
      $("#page-" + page + " button").addClass('btn-filled');
    } else {
      $('.blank-placeholder-posts').css('display', 'none');
      $("#posts-list").append("<h3>没有帖子。点击<a l href='../blog'>这里</a>回博客主页</h3>");
    }
  });
  $("#long-form-submit").on('click', function (e) {
    e.preventDefault(); //parse email. check for validity;

    var email = $("#long-email").val(); //what if they turn off javascript? lmao our site doesn't work then

    if (validateEmail(email)) {
      var res = subscribeEmail(email, 'long-email-subscribe-form');
      $('#long-email').removeClass('invalid-input');
      $('#long-email').addClass('valid-input');
      document.getElementById('long-email').setCustomValidity('');
    } else {
      document.getElementById('long-email').setCustomValidity('电子邮件不正确');
      $('#long-email').addClass('invalid-input');
      document.getElementById('long-email').reportValidity();
    } //play animation while email result comes back;


    return false;
  });
  $("#long-email").on('keydown', function () {
    document.getElementById('long-email').setCustomValidity('');
  });
});

function addPageNum(num) {
  var addPageParams = {
    categories: categoryquery,
    tags: tagquery,
    search: searchquery,
    per_page: '5',
    sticky: 'true',
    page: num
  };
  $("#pagination").append("<a class='page-num' id='page-" + num + "' href='?" + objectToParams(addPageParams) + "'><button class='btn btn-primary'>" + num + "</button></a>");
}