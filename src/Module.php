<?php

namespace rhea\report\src;

use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
	public $controllerNamespace = 'rhea\report\controllers';

	public function bootstrap($app)
	{
		$app->getUrlManager()->addRules([
			[
				'pattern' => 'report',
				'route' => 'report/view'
			],
		]);
	}
}
