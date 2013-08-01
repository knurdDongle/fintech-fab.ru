<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

$a = array(
	'basePath' => __DIR__ . '/..',
	'name' => 'Kreddy',

	'sourceLanguage'    => 'ru',
	'language'          => 'ru',

	'preload'=>array('log'),

	'import'=>array(
		'application.models.*',
		'application.models.forms.*',
		'application.controllers.*',
		'application.components.*',
		'application.components.crypt.*',
		'application.components.utils.*',
		'application.extensions.behaviors.*',
		'application.extensions.image.*',
	),

	'modules' => array(

	),

	'components'=>array(
		'clientForm'=>array(
			'class'=>'application.components.ClientForm',
		),
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
		'image' => array(
			'class'     =>  'application.extensions.image.CImageComponent',
			'driver'    =>  'GD',
		),
		'user' => array(
			'allowAutoLogin' => true,
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'gii'=>'gii',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'form/<step:\d+>'=>'form/step',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<name:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=kreddy',
			'emulatePrepare' => true,
			'username' => 'kreddy',
			'password' => '159753',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),

		'session'=>array(
			'timeout'=>60*15,
		),

		'request' => array(
			'class' => 'HttpRequest',
			'enableCsrfValidation' => true,
			'enableCookieValidation' => true,
			'aIgnoreCsrfValidationRoutes' => array(
				'api/clientsNew',
				'api/markProcessed',
			),
		),
	),

);

$a['components'] = CMap::mergeArray( $a['components'], require( __DIR__ . '/custom/db.php' ));
$a['modules'] = CMap::mergeArray( $a['modules'], require( __DIR__ . '/custom/modules.php' ));

return $a;