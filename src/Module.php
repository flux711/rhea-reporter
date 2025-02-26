<?php

namespace report\src;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
	public $controllerNamespace = 'report\src\controllers';

	public function init()
	{
		parent::init();
		Yii::setAlias('@report_images', __DIR__ . '/images');
		Yii::setAlias('@report_reports', __DIR__ . '/reports');
	}

	public function bootstrap($app)
	{
		$app->getUrlManager()->addRules([
			[
				'class' => 'yii\rest\UrlRule',
				'pluralize' => false,
				'prefix' => 'api/',
				'controller' => [$this->id.'/report'],
				'tokens' => [
					'{productioncode}' => '<productioncode:[\\w\\-\\.]+>',
					'{serialnumber}' => '<serialnumber:[\\w\\-\\.]+>'
				],
				'extraPatterns' => [
					'GET,POST {productioncode}/create' => 'create',
					'GET,POST {serialnumber}/create' => 'create',
				],
				'except' => ['update', 'index', 'delete', 'view'],
			],
		]);
	}
}
