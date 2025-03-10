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
					'{serial_number}' => '<serial_number:[\\w\\-\\.]+>'
				],
				'extraPatterns' => [
					'POST,HEAD {serial_number}/create' => 'create-report',
				],
				'except' => ['update', 'delete', 'view', 'index', 'create'],
			],
		]);
	}
}
