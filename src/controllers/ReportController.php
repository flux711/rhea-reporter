<?php

namespace report\src\controllers;

use report\src\modules\Report;
use Yii;
use yii\rest\Controller;

class ReportController extends Controller
{
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
