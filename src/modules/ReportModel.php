<?php

namespace report\src\modules;

use api\modules\rhea\models\SerialNumber;
use http\Client\Response;
use Yii;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class ReportModel extends Model
{
	public $serial_number;

	public function rules()
	{
		return [
			['serial_number', 'required'],
			['serial_number', 'string'],
			['serial_number', 'trim'],
			['serial_number', 'exist', 'targetClass' => SerialNumber::class, 'targetAttribute' => 'serial_number']
		];
	}

	public function create()
	{
		$client = new Client();

		// Die URL, die das PDF generiert
		$reporter_config = Yii::$app->reporter;
		$url = "http://{$reporter_config['host']}:{$reporter_config['port']}/report/$this->serial_number";

		$response = $client->createRequest()
			->setMethod('GET')
			->setUrl($url)
			->send();

		if ($response->isOk) {
			$content = $response->content;

			// Prepare Yii response
			$yiiResponse = Yii::$app->response;
			$yiiResponse->format = Response::FORMAT_RAW;
			$headers = $yiiResponse->headers;

			// Set headers for pdf download
			$headers->add('Content-Type', 'application/pdf');
			$headers->add('Content-Disposition', "attachment; filename=$this->serial_number.pdf");
			$headers->add('Content-Length', strlen($content));

			// Set the response content
			$yiiResponse->content = $content;

			return $yiiResponse;
		}
		throw new BadRequestHttpException("Unable to create and download PDF report for serial number $this->serial_number");
	}

}
