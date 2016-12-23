<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
//        'migrationTable' => 'mg_migration',
            'templateFile' => '@console/views/system/migration.php'
        ],
        'giix'    => [
            'class'          => 'schmunk42\giiant\commands\BatchController',
            'modelNamespace' => 'common\models',
            'modelQueryNamespace' => 'common\models\query',
            'overwrite'      => true,
            'defaultAction'  => 'models',
            'interactive'    => false
        ],

    ],

    'params' => $params,
];
