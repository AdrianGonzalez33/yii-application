<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language'=> 'es-ES',
    'components' => [
        'notifications' => [
            'class' => '\dvamigos\Yii2\Notifications\NotificationManager',
            'types' => [
                'new_user' => [
                    'text' => [
                        'title' => 'New user created!',
                        'message' => 'New user {username} is created.'
                    ],
                    'default' => [
                        'username' => ''
                    ]
                ]
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'tuCorreo@gmail.com',
                'password' => 'tuContraseña',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV2' => '6LcFb-0UAAAAAF8g1oB-SUjQ1HxndKtxdcWRQ8_p',
            'secretV2' => '6LcFb-0UAAAAAGTEZRv30i9uXAJ2DsrkyUyQ7SSv',
            'siteKeyV3' => 'your siteKey v3',
            'secretV3' => 'your secret key v3',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                '<controller>/<action>/<id>' => '<controller>/<action>',

                '<controller>/<action>/<categoria>' => '<controller>/<action>',

                '<controller:\w+>/<id_articulo:\d+>' => '<controller>/view',

                '<controller:\w+>/<action:\w+>/<id_articulo:\d+>' => '<controller>/<action>',

                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
