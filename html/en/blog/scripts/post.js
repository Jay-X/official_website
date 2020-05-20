"use strict";

var svgs = {
  twitter: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" height="18"><path d="M492 109.5c-17.4 7.7-36 12.9-55.6 15.3 20-12 35.4-31 42.6-53.6-18.7 11.1-39.4 19.2-61.5 23.5C399.8 75.8 374.6 64 346.8 64c-53.5 0-96.8 43.4-96.8 96.9 0 7.6.8 15 2.5 22.1-80.5-4-151.9-42.6-199.6-101.3-8.3 14.3-13.1 31-13.1 48.7 0 33.6 17.2 63.3 43.2 80.7-16-.4-31-4.8-44-12.1v1.2c0 47 33.4 86.1 77.7 95-8.1 2.2-16.7 3.4-25.5 3.4-6.2 0-12.3-.6-18.2-1.8 12.3 38.5 48.1 66.5 90.5 67.3-33.1 26-74.9 41.5-120.3 41.5-7.8 0-15.5-.5-23.1-1.4C62.8 432 113.7 448 168.3 448 346.6 448 444 300.3 444 172.2c0-4.2-.1-8.4-.3-12.5C462.6 146 479 129 492 109.5z"/></svg>',
  facebook: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18" height="18"><path d="M426.8 64H85.2C73.5 64 64 73.5 64 85.2v341.6c0 11.7 9.5 21.2 21.2 21.2H256V296h-45.9v-56H256v-41.4c0-49.6 34.4-76.6 78.7-76.6 21.2 0 44 1.6 49.3 2.3v51.8h-35.3c-24.1 0-28.7 11.4-28.7 28.2V240h57.4l-7.5 56H320v152h106.8c11.7 0 21.2-9.5 21.2-21.2V85.2c0-11.7-9.5-21.2-21.2-21.2z"/></svg>'
};

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
      catsHTML += "<a href='" + siteRoot + "blog?categories=" + cat + "'>" + cats[cat].name + "</a>, ";
    }
  });
  var titleContent = post.title.rendered;

  if (options && options.sticky == true) {
    titleContent += " " + pinSVG;
  }

  if (author.avatar_urls[96] == 'https://secure.gravatar.com/avatar/8a2233e4af05d90078be153329a99004?s=96&d=mm&r=g') {
    author.avatar_urls[96] = '/assets/images/defaultavatar.jpg';
  }

  var finalstr = "<div class='post'><a href='" + link + "' class='post-title-wrapper'><h2 class='post-title'>" + titleContent + "</h2></a><br><img src='" + author.avatar_urls[96] + "' class='post-author-avatar' alt='" + authorName + "&#39;s Avatar'><div class='post-meta'><cite class='post-author'><span>" + authorName + "</span></cite><br><time class='post-time'>" + parsedDate + "</time><span class='post-slash'> / </span><h3 class='post-tags'>" + catsHTML.substring(0, catsHTML.length - 2) + "</h3><time class='post-time'></time></div><div class='post-desc'>" + post.excerpt.rendered + "</div>";
  var socialMediaStr = "<div class='social-media'><a href='https://twitter.com/share?url=" + link + "' target='_blank'>" + svgs.twitter + "</a></div>";
  finalstr += socialMediaStr;
  finalstr += "</div>";
  $("#posts-list").append(finalstr);
}

function search() {
  var key = $("#searchKey").val();
  window.location = siteRoot + 'blog?search=' + key;
}

function addTag(id) {
  var selected = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  if (id !== 1 && id !== chineseCategory && id !== englishCategory && id !== externalNewsCategory && id !== announcementCategory) {
    var link = siteRoot + "blog/?categories=" + id;
    if (selected == true) {
      link = siteRoot + "blog/"
    }
    $(".tags-list").append("<a l class='tag' id='tag-" + id + "' href='" + link + "'> " + cats[id].name + "</a>");
    $(".tags-list").append("<br>");
  }
}

var pinSVG = "<svg xmlns='http://www.w3.org/2000/svg' viewbox='0 0 24 24' width='24' style='filter: saturate(0.8);'><path d='M18.266 4.29l-9.192 9.193.707.707 4.53 4.53c.357-1.2.483-2.487.278-3.682l5.657-5.657c.86.012 1.79-.19 2.638-.473l-3.91-3.91-.708-.708z' fill='#c0392b'/><path d='M9.074 13.483L7.66 14.897 4.83 17.725 3.417 19.14l-.707 2.122 1.414-1.414 4.243-4.243L9.78 14.19l-.707-.707z' fill='#bdc3c7'/><path d='M9.781 14.19l-1.414 1.414-2.829 2.828-1.414 1.415L2.71 21.26l2.121-.707 1.414-1.415 2.829-2.828 1.414-1.414-.707-.707z' fill='#7f8c8d'/><path d='M15.062 1.086c-.282.849-.484 1.778-.473 2.638L8.932 9.381c-1.194-.205-2.482-.078-3.68.279l4.529 4.53 9.192-9.193-3.91-3.91z' fill='#e74c3c'/></svg>";