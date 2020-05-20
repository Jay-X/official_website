"use strict";

var post;
var posts = {}; //var postsChrono = [];

var authors = {};
var cats = {};
var catsPromise, authorPromise, postsPromise;
var ha = new Headers();
ha.append('Cache-Control', 'public, max-age=12000');
catsPromise = fetch(wp_endpoint + 'wp-json/wp/v2/categories', {
  headers: ha
}).then(function (r) {
  return r.json();
});
postsPromise = fetch(wp_endpoint + 'wp-json/wp/v2/posts/' + postID, {
  headers: ha
}).then(function (r) {
  return r.json();
}).then(function (post) {
  //authorPromise = 
  console.log("Author prom set");
  return post;
});
$(document).ready(function () {
  $("#long-email").on('focus', function () {
    $(document).off("keyup");
    $(document).keyup(function (e) {
      if (e.which == 'Enter') {
        $("#long-form-submit").click();
        return false;
      }
    });
  });
  $("#searchKey").on('focus', function () {
    $(document).off("keyup");
    $(document).keyup(function (e) {
      if (e.which == 'Enter') {
        search();
        return false;
      }
    });
  });
  var externalNews = false;
  Promise.all([catsPromise, postsPromise, authorPromise]).then(function (values) {
    values[0].forEach(function (cat) {
      cats[cat.id] = cat;
      addTag(cat.id);
    }); //posts = values[1]; //in canonical order
    //postsChrono = values[1];

    posts[values[1].id] = values[1]; //values[1].forEach(post => posts[post.id] = post);
  }).then(function (r) {
    post = posts[postID];
    post.categories.forEach(function(a){
      if (a == externalNewsCategory) {
        externalNews = true;
      }
    });
    fetch(wp_endpoint + 'wp-json/wp/v2/users/' + post.author, {
      headers: ha
    }).then(function (r) {
      return r.json();
    }).then(function (author) {
      authors[author.id] = author;
      return author;
    }).then(function (r) {
      $('.blank-entry').html("");
      $(".real-entry").css('display', 'block');
      $(".blank-placeholder-posts").css('display', 'none');
      $("#post-title").html(post.title.rendered);
      $("#post-content").html(post.content.rendered);
      if (externalNews == false) {
        $("#post-author").html("<span>" + authors[post.author].name+"</span>");
        var parsedDate = new Date(post.date).toDateString();
        var dateArr = parsedDate.split(' ').splice(1);
        parsedDate = dateArr[0] + ' ' + dateArr[1] + ', ' + dateArr[2];
        $("#post-time").html(parsedDate);
           //$(".post-author-avatar-link").attr('href', authors[post.author].link);
        $(".post-author-avatar-link").css('cursor','default');
        if (authors[post.author].avatar_urls[96] == 'https://secure.gravatar.com/avatar/8a2233e4af05d90078be153329a99004?s=96&d=mm&r=g' || authors[post.author].avatar_urls[96] == 'http://0.gravatar.com/avatar/cbf3ae80bfffa54eade6fba665324a26?s=92&d=mm&r=g') {
        authors[post.author].avatar_urls[96] = '/assets/images/defaultavatar.jpg';
        }
        $(".post-author-avatar-link img").attr('src',authors[post.author].avatar_urls[96]);
        $(".post-author-avatar-link img").attr('alt',authors[post.author].name + "'s Avatar");
      }
      else {
        $(".post-author-avatar-link").remove();
        $(".post-meta").remove();
      }

      var catsHTML = "";
      post.categories.forEach(function (cat) {
        for (var i = 0; i < allSiteLangs.length; i++) {
          if (siteLangMap[allSiteLangs[i]] == cat || cat == externalNewsCategory || cat == announcementCategory) {
            return;
          }
        }

        catsHTML += "<a href=" + siteRoot + "blog/?categories=" + cat + " l>" + cats[cat].name + "</a>, ";
      });
      $("#post-tags").append(catsHTML.substr(0, catsHTML.length - 2));
      $("pre").removeClass('wp-block-preformatted');
      $("pre").addClass('prettyprint linenums');
      PR.prettyPrint();
      /*
      postsChrono.forEach(function(post){
        addPost(post);
      });
      */
    });
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
      console.log("Invalid email");
      document.getElementById('long-email').setCustomValidity('Invalid email');
      $('#long-email').addClass('invalid-input');
      document.getElementById('long-email').reportValidity();
    } //play animation while email result comes back;


    return false;
  });
  $("#long-email").on('keydown', function () {
    document.getElementById('long-email').setCustomValidity('');
  });
});