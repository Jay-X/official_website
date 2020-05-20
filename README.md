# TaosData/TDengine Official Website
This is the repository including all source codes of https://www.taosdata.com/.
## Architecture

There are three main modules in the web site as shown in Picture 1. 

![Architecture](https://user-gold-cdn.xitu.io/2020/5/19/1722a9a3ae0a6d24?w=826&h=612&f=png&s=34319)

- Apache WebServer: Provide http/https access function.
- PHP, WordPress, Node.js: 
  - The website is developed with PHP. 
  - WordPress is used to publish blogs and media reports.
  - If a change to the documentation is made on GitHub, to forcibly refresh the content displayed on the website, with Node.js.
- MySQL：The website data is saved with a MySQL database.

## Website Directory

- The website deployment directory is /html.
- All Chinese webpages are found in /html/cn.
- All English webpages are found in /html/en.
- All website CSS is stored in /html/styles.
- Documentation CSS is in /html/lib/docs.