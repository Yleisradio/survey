# Survey
Shows a standard questionnaire form to randomly picked website visitors. Analyzes textual responses by using Etuma API. Visualizes responses on a dashboard. Supports multiple separate web services.

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
- Add possible Etuma, ComScore and other configuration in shared/config/common.php 
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

## Usage
- Install the application to a publicly accessible web server
- Add <script type="text/javascript" src="http://address-to-survey-server.com/form/surveys"></script> before the ending body tag to all of the pages you want the survey to appear in. Replace the address with the correct address.
- Configure visit motives in http://data.yle.fi/kysely/motive
- Configure surveys in http://address-to-survey-server.com/survey
- Optionally add previously configure html attribute to your existing web services
