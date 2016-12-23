<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'repostni.com',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            "enableStrictParsing" => true,
            'rules' => [
//                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '/' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'search' => 'site/search',
                'signup' => 'site/signup',
                'about' => 'site/about',
                'contacts' => 'site/contact',
                'profile' => 'site/profile',
                'help' => 'site/help',
                'updates' => 'site/updates',
                'feedback' => 'site/feedback',
                'defects' => 'site/defects',
                'post/create' => 'advert/create',
                'new-post' => 'advert/new',
                'post/save-image' => 'advert/save-image',
                'post/delete' => 'advert/delete',
                'id<id:\d+>' => 'competition/view',
                'image/<_size:[\w\_]+>/<_p0:[\w]+>/<_p1:[\w]+>/<_p2:[\w]+>/<_path:[\w]+>.<_ext:[\w]+>' => 'image/index',

                'sitemap.xml' => 'export/sitemap',
                
//                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ],
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',

            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '5649405',
                    'clientSecret' => 'lspIXwB9uO9UxUKUO8Nh',
//                    'validateAuthState' => false,
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1102400546515492',
                    'clientSecret' => '0be29f4c7f3d78a5113994685711084e',
//                    'validateAuthState' => false,
                    'attributeNames' => [
                        'name',
                        'email',
                        'link',
                    ],
                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
//                    'validateAuthState' => false,
                    'attributeParams' => [
                        'include_email' => 'true'
                    ],
                    'consumerKey' => 'lkSJpTyhR6L3St4JAmShROoWx',
//                    'consumerKey' => 'LgxjDNd85BlzHTzxtWogm8Hba',
                    'consumerSecret' => '6VqHcDTQPJSmSkrSYMnLSfdpdkf8JZ6XDd23cU9nyZPkydnMrE',
//                    'consumerSecret' => 'gjFnbzUAlpUr1I49M9QHUGzLtCYNQjRoLvKWhoKbJM2zWXapk5',
                ],

                // etc.
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'response' => [
            'formatters' => [
                'urlset' => 'common\components\UrlsetFormatter',
                'yml' => 'common\components\YmlFormatter',
            ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' :         'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
    ],
    'params' => $params,
];
