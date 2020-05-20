var posts = {};
var authors = {};
var cats = {};
var js_tagsArr = [];
var catsPromise, authorPromise, postsPromise;
var query = "";
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

$(document).ready(function () {
var paramsPost = {
  categories_exclude: excludedLangs + "," + externalNewsCategory,
  per_page: '5'
};
catsPromise = fetch(wp_endpoint + 'wp-json/wp/v2/categories')
  .then(r => r.json());


postsPromise = fetch(wp_endpoint + 'wp-json/wp/v2/posts?' + objectToParams(paramsPost))
  .then(r => r.json());
authorsPromise = fetch(wp_endpoint + 'wp-json/wp/v2/users')
  .then(r => r.json());
  Promise.all([catsPromise, postsPromise, authorsPromise]).then(function (values) {
    console.log(values);
    values[0].forEach(cat =>{ 
      cats[cat.id] = cat;
      addTag(cat.id);
    });
    posts = values[1]; //in canonical order
    values[2].forEach(author => authors[author.id] = author);
    posts.forEach(function (post) {
      addPost(post);
    });
    $('.blank-placeholder-posts').css('display','none');
  });
});

