## 📂 Folder Structure
```
root/
│── assets/
│   ├── images/
│   ├── css/
│   │   ├── app.css
│   ├── js/
│   │   ├── app.js
│── components/
│── views/
│── env.example
│── index.php
│── template.php
```

## 🛠 Setting Up Environment Variables

To use environment variables, create an env.php file and define your variables like this:

```php
putenv("APPNAME=Squad International");
putenv("STYLESHEETDIR=assets/css/");
```

You can add multiple variables by calling putenv() for each one.

## ❓ Why use env.php instead of .env?

Currently, .env files are not loading properly in some cases. Until this issue is resolved, env.php is used as a workaround.

If you prefer .env, you can manually load it using phpdotenv.

## 📌 View File Format

By default, views use .html files.
However, you can use .php or any other format by modifying index.php.

## 🚀 Stack

Currently this uses just plain html, css and php because it was designed to be very light weight while being helpfull in cases where you dont want redundant html like header and footer. So instead of putting header and footer on each page this helps create a template file which you can design. This also takes care of routing for you. Since having a url like ``` xyz.com/about-us.html  ``` dosent give a good look. So this comes with dynamic routing to remove extension names from the url. Also the css files get loaded for each page automatically. If you name the file the same as the filename other than view/index since it by defaults loads home.css orhter than that the view/filename should be the file name for css/filename

## 🔮 Future

This is currenctly in development and will be managed by me. Features will be added according to real-world senarios that I come accross in projects while using this framework