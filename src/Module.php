<?php

namespace report\src;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
	public $controllerNamespace = 'report\commands';

	public function init()
	{
		parent::init();
		Yii::setAlias('@report_images', __DIR__ . '/report_images');
		Yii::setAlias('@report_reports', __DIR__ . '/reports');
	}

	public function bootstrap($app)
	{
		$app->getUrlManager()->addRules([
			[
				'pattern' => 'report',
				'route' => 'report/view'
			],
			[
				'pattern' => 'report/<productioncode:[0-9]*>/create',
				'route' => 'report/view'
			],
		]);
	}
}
