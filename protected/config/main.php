<?php

//Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

$a = array(
	'basePath'       => __DIR__ . '/..',
	'name'           => 'Kreddy',

	'sourceLanguage' => 'ru',
	'language'       => 'ru',

	'preload'        => array(
		'log',
		'bootstrap'
	),

	'import'         => array(
		'application.models.*',
		'application.models.forms.*',
		'application.models.account.*',
		'application.controllers.*',
		'application.components.*',
		'application.components.crypt.*',
		'application.components.utils.*',
		'application.extensions.behaviors.*',
		'application.extensions.image.*',
		'application.extensions.sms.*',
	),

	'modules'        => array(
		'admin'    => array(
			'ipFilters' => array('127.0.0.1', '::1'),
		),
		'account'  => array(),
		'identify' => array(
			'preload'    => array('identifyApi'),
			'components' => array(
				'identifyApi' => array(
					'class' => 'application.modules.identify.components.IdentifyApiComponent',
				),
			)
		),
	),

	'params'         => array(),

	'theme'          => 'classic',

	'components'     => array(
		'cache'            => array(
			'class' => 'CMemCache',
		),
		'clientForm'       => array(
			'class' => 'application.components.ClientFormComponent',
		),
		'adminKreddyApi'   => array(
			'class'       => 'application.components.AdminKreddyApiComponent',
			'sApiUrl'     => 'https://admin.kreddy.ru:8081/siteApi/',
			'sTestApiUrl' => 'http://admin.kreddy.popov/siteApi/'
		),
		'antiBot'          => array(
			'class' => 'application.components.AntiBotComponent',
		),
		'productsChannels' => array(
			'class' => 'application.components.ProductsChannelsComponent',
		),
		'siteParams'       => array(
			'class' => 'application.components.SiteParams',
		),
		'bootstrap'        => array(
			'class'           => 'ext.bootstrap.components.Bootstrap',
			'tooltipSelector' => '[rel=tooltip]',
			'responsiveCss'   => false,
		),
		'image'            => array(
			'class'  => 'application.extensions.image.CImageComponent',
			'driver' => 'GD',
		),
		'user'             => array(
			'class'          => 'application.components.User',
			'allowAutoLogin' => true,
			'loginUrl'       => array('account/login'),
		),

		'urlManager'       => array(
			'urlFormat'      => 'path',
			'showScriptName' => false,
			'rules'          => array(
				//''                                                  => 'form/index',

				'contact'                                           => 'site/contact',
				'contactUs'                                         => 'site/contactUs',

				'gii'                                               => 'gii',
				'gii/<controller:\w+>'                              => 'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'                 => 'gii/<controller>/<action>',

				'admin'                                             => 'admin',
				'admin/login'                                       => 'admin/default/login',
				'admin/logout'                                      => 'admin/default/logout',
				'admin/<controller:\w+>'                            => 'admin/<controller>',
				'admin/<controller:\w+>/<action:\w+>/<id:\d+>'      => 'admin/<controller>/<action>',
				'admin/<controller:\w+>/<action:\w+>/<name:\w+>'    => 'admin/<controller>/<action>',
				'admin/<controller:\w+>/<action:\w+>'               => 'admin/<controller>/<action>',

				'identify'                                          => 'identify/default/index',
				'identify/<action:\w+>'                             => 'identify/default/<action>',
				'identify/<controller:\w+>'                         => 'identify/<controller>',
				'identify/<controller:\w+>/<action:\w+>/<id:\d+>'   => 'identify/<controller>/<action>',
				'identify/<controller:\w+>/<action:\w+>/<name:\w+>' => 'identify/<controller>/<action>',
				'identify/<controller:\w+>/<action:\w+>'            => 'identify/<controller>/<action>',

				'account'                                           => 'account/default/index',
				'account/<action:\w+>'                              => 'account/default/<action>',
				'account/<controller:\w+>'                          => 'account/<controller>',
				'account/<controller:\w+>/<action:\w+>/<id:\d+>'    => 'account/<controller>/<action>',
				'account/<controller:\w+>/<action:\w+>/<name:\w+>'  => 'account/<controller>/<action>',
				'account/<controller:\w+>/<action:\w+>'             => 'account/<controller>/<action>',

				'form/<step:\d+>'                                   => 'form/step',
				'form/ajaxForm/<step:\d+>'                          => 'form/ajaxStep',

				'<controller:\w+>/<action:\w+>/<id:\d+>'            => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<name:\w+>'          => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>'                     => '<controller>/<action>',
				'<controller:\w+>'                                  => '<controller>',
			),
		),

		'db'               => array(
			'connectionString' => 'mysql:host=localhost;dbname=kreddy',
			'emulatePrepare'   => true,
			'username'         => 'kreddy',
			'password'         => '159753',
			'charset'          => 'utf8',
		),

		'errorHandler'     => array(
			'errorAction' => 'site/error',
		),

		'log'              => array(),

		'session'          => array(
			'timeout'     => 60 * 60 * 2,
			'sessionName' => 'st',
		),

		'request'          => array(
			'class'                       => 'HttpRequest',
			'enableCsrfValidation'        => true,
			'enableCookieValidation'      => true,
			'csrfTokenName'               => 'stcs',
			'aIgnoreCsrfValidationRoutes' => array(
				'identify/default/index',
			),
		),
	),

);

$a['components'] = CMap::mergeArray($a['components'], require(__DIR__ . '/custom/db.php'));
$a['components'] = CMap::mergeArray($a['components'], require(__DIR__ . '/custom/session.php'));
$a['modules'] = CMap::mergeArray($a['modules'], require(__DIR__ . '/custom/modules.php'));
$a['params'] = CMap::mergeArray($a['params'], require(__DIR__ . '/custom/params.php'));
$a['components']['log'] = CMap::mergeArray($a['components']['log'], require(__DIR__ . '/custom/log.php'));

return $a;
