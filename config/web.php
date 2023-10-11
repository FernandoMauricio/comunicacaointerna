<?php
use kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language'=>'pt-BR',
    'timeZone' => 'America/Manaus',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
        'modules' => [
                   'datecontrol' =>  [
                    'class' => 'kartik\datecontrol\Module',
             
                    // format settings for displaying each date attribute (ICU format example)
                    'displaySettings' => [
                        Module::FORMAT_DATE => 'dd/MM/yyyy',
                        Module::FORMAT_TIME => 'hh:mm:ss a',
                        Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a', 
                    ],
                    
                    // format settings for saving each date attribute (PHP format example)
                    'saveSettings' => [
                        Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                        Module::FORMAT_TIME => 'php:H:i:s',
                        Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
                    ],
                     // set your display timezone
                    'displayTimezone' => 'America/Manaus',

                    // set your timezone for date saved to db
                    'saveTimezone' => 'UTC',
                    
                    // automatically use kartik\widgets for each of the above formats
                    'autoWidget' => true,
             
                    // default settings for each widget from kartik\widgets used when autoWidget is true
                    'autoWidgetSettings' => [
                        Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
                        Module::FORMAT_DATETIME => [], // setup if needed
                        Module::FORMAT_TIME => [], // setup if needed
                    ],

                    'widgetSettings' => [
                                Module::FORMAT_DATE => [
                                    'class' => 'yii\jui\DatePicker', // example
                                    'options' => [
                                        'dateFormat' => 'php:d-M-Y',
                                        'options' => ['class'=>'form-control'],
                                    ]
                                ]
                            ],
                    ],
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
        ],

         'view' => [
         'theme' => [
             'pathMap' => [
               '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-basic-app'
             ],
         ],
        */

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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.office365.com',
                'username' => 'gde@am.senac.br',
                'password' => 'senac@2017',
                'port' => 587,
                'encryption' => 'tls',
                ],
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
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
