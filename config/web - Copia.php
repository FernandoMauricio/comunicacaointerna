<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language'=>'pt-BR',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'America/Manaus',
    'bootstrap' => ['log'],

        'modules' => [
                'gridview' =>  [
                'class' => '\kartik\grid\Module'
                               ],
                'dynagrid'=> [
                        'class'=>'\kartik\dynagrid\Module',
                        // other module settings
                    ],
                'markdown' => [
                'class' => 'kartik\markdown\Module',
                            ],
                     ],
                     
    'components' =>  [
 
        /*'urlManager' =>[
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],*/

       /* 'view' => [
         'theme' => [
             'pathMap' => [
               '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-basic-app'
             ],
         ],*/
        // 'formatter' => [
        //        'defaultTimeZone' => 'UTC',
        //        'timeZone' => 'America/Manaus',
        // ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5VVJQwSeEHABFEuhUqSWI-habT7nPrbY',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            // 'transport' => [
            //     'class' => 'Swift_SmtpTransport',
            //     'host' => '177.10.176.8',
            //     'username' => 'gde@am.senac.br',
            //     'password' => 'Fat@320',
            //     'port' => 465,
            //     'encryption' => 'ssl',
            //     ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'db_base' => require(__DIR__ . '/db_base.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
