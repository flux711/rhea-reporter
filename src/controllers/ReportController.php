<?php

namespace report\controllers;

use Exception;
use report\src\modules\Report;
use report\src\modules\ReportModel;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ReportController extends Controller
{
	public function actionView()
	{
		Yii::$app->response->format = Response::FORMAT_HTML;
		$request = Yii::$app->request;

		$model = new ReportModel();
		if ($model->load($request->post())) {
			$verification = $model->verify();
			if ($verification) {
				Yii::$app->session->setFlash('error', $verification);
			} else {
				try {
					$model->createReport();
				} catch (Exception $e) {
					Yii::$app->session->setFlash('error', $e->getMessage());
				}
			}
		}
	}

	public function actionCreate()
	{
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

		// Ziel-Dateiname
		$outputFilename = Yii::getAlias('@report_reports/test_report.pdf');

		// Bericht generieren
		$report = new Report();
		$report->generate($data, $outputFilename);

		return "PDF-Bericht wurde erstellt: $outputFilename";
	}
}
