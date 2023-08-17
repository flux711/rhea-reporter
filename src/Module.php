<?php

namespace rhea\facility\src;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
	public $controllerNamespace = 'rhea\facility\controllers';
	public function bootstrap($app)
	{
		$app->getUrlManager()->addRules([
			[
				'class' => 'yii\rest\UrlRule',
				'pluralize' => false,
				'prefix' => 'api/',
				'controller' => ['report'],
				'tokens' => [
					'{serial_number}' => '<serial_number:[\\w\\-\\.]+>',
				],
				'except' => ['index', 'update', 'view', 'delete'],
			],
		]);
	}

}
