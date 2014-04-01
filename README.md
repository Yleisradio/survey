# Survey


## Requirements
- Yii Framework 1.1.14 ( http://www.yiiframework.com/download/ )
- PHP 5.4 or newer
- php5-curl
- MySQL-database
- Apache mod_rewrite plugin

## Installation
- git clone ssh://git@github.com/Yleisradio/survey.git
- run the following commands:

```
cd survey/protected
chmod o+x deploy.sh
./deploy.sh
```

- Modify the yii framework path in shared/config/bootstrap.php line 10
- Create MySQL priviledges and a database
- Add the database connection information to shared/config/common.php lines 37-41
- Add the RSS feeds where you want pages to be harvested from in order to be automatically tracked to shared/config/console.php line 48
- run the following command:

```
./deploy.sh
php5 yiic.php migrate
```

- Test it by browsing to for example http://localhost/survey (depends on your server configuration)
- When everything is working fine change the application to production mode by commenting out line 7 and removing comments on line 8 in shared/config/bootstrap.php
- run the following command:

```
./deploy.sh
```

## Update
- run the following commands:

```
git reset --hard
git pull ssh://git@github.com/Yleisradio/survey.git
cd survey/protected
./deploy.sh
```
