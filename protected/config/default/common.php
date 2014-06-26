<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Survey',
    'preload' => array(
        'log',
    ),
    'sourceLanguage' => '00',
    'language' => 'fi',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules' => array(
    ),
    // application components
    'components' => array(
        'widgetFactory' => array(
            'widgets' => array(
                'CLinkPager' => array(
                    'header' => false,
                    'footer' => false,
                    'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                    'selectedPageCssClass' => 'active',
                    'hiddenPageCssClass' => 'disabled',
                    'htmlOptions' => array(
                        'class' => 'pagination',
                    ),
                    'cssFile' => false,
                ),
                'CGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive bordered'
                    ),
                    'pagerCssClass' => 'yiiPager',
                    'cssFile' => false,
                    'itemsCssClass' => 'table table-striped table-condensed',
                ),
            )
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
        ),
        'cache' => array(
            'class' => 'CApcCache',
        ),
        'session' => array(
            'timeout' => 60 * 60 * 8,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            'showScriptName' => false,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dbname',
            'emulatePrepare' => true,
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    'params' => array(
        'authentication' => array(
            'required' => false,
        ),
        'etuma' => array(
            'accessKey' => '',
            'secretKey' => '',
            'subsignalformid' => '',
        ),
        'apiLogLevel' => 'all',
        'categoryAttribute' => '', //The html attribute used to match the surveys
        'comScore' => array(
            'baseUrl' => '',
        )
    ),
);