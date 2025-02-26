<?php

namespace report\src\controllers;

use report\src\modules\Report;
use Yii;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReportController extends Controller
{
	public function actionCreate()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$request = Yii::$app->request();

		// Beispiel-Daten
		$data = [
			'run' => [
				'status' => 'passed',
				'steps' => [
					[
						'test_name' => 'Test Step 1',
						'status' => 'passed',
						'duration' => 1.25,
						'run_id' => '12345'
					],
					[
						'test_name' => 'Test Step 2',
						'status' => 'failed',
						'duration' => 2.50
					],
				],
				'run_type' => 'Regression'
			],
			'version' => ['version' => '1.0.0']
		];
		if (!$request->post('parent_device_id'))
			throw new BadRequestHttpException("Parent device id is missing!");


		// Ziel-Dateiname
		$outputFilename = Yii::getAlias('@report_reports/test_report.pdf');

		// Bericht generieren
		$report = new Report();
		$report->generate($data, $outputFilename);

		$downloadUrl = Url::to($outputFilename, true);
		return ["download_url" => $downloadUrl];
	}

	public function actionDownload($filename)
	{
		$path = Yii::getAlias('@report_reports/'.$filename);
		if (file_exists($path)) {
			return Yii::$app->response->sendFile($path);
		} else {
			throw new NotFoundHttpException("File $filename not found");
		}
	}
}
