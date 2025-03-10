<?php

namespace report\src\modules;

use api\modules\rhea\models\SerialNumber;
use Yii;
use yii\base\Model;

class ReportModel extends Model
{
	public $serial_number;

	public function rules()
	{
		return [
			['serial_number', 'required'],
			['serial_number', 'string'],
			['serial_number', 'trim'],
			['serial_number', 'exist', 'targetClass' => SerialNumber::class]
		];
	}

	public function create()
	{
		return Yii::$app->getResponse()->redirect("localhost:9080/report/$this->serial_number");
	}

}
