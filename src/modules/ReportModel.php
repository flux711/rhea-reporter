<?php

namespace report\src\modules;

use api\modules\rhea\models\ProductionCode;
use Yii;
use yii\base\Model;

class ReportModel extends Model
{
	public $productioncode;

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'productioncode' => 'Production code',
		]);
	}

	public function rules()
	{
		return [
			['productioncode', 'required'],
			['productioncode', 'string'],
			['produtioncode', 'exist', 'targetClass' => ProductionCode::class]
		];
	}

	public function verify()
	{
		if (!$this->validate()) {
			foreach($this->firstErrors as $error) {
				return $error;
			}
		}
		return null;
	}

	public function createReport()
	{
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
	}

}
