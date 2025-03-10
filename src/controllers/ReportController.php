<?php

namespace report\src\controllers;

use api\modules\rhea\models\SerialNumber;
use report\src\modules\ReportModel;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ReportController extends Controller
{
	/*
	* Rest Description: Create a pdf report for a test run.
	* Rest Fields: ['serial_number'].
	* Rest Filters: [].
	* Rest Expand: [].
	*/
	public function actionCreate()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$request = Yii::$app->request();

		if (!$request->post('serial_number')) {
			throw new BadRequestHttpException("Serial number is missing!");
		}

		$serial_number = SerialNumber::getBySerialNumber($request->post('serial_number'));
		if (!$serial_number) {
			throw new BadRequestHttpException("Serial number {$request->post('serial_number')} does not exist");
		}

		// Bericht generieren
		$report = new ReportModel();
		$report->load(["serial_number" => $request->post('serial_number')], "");
		if ($report->validate()) {
			return $report->create();
		}

		foreach ($report->firstErrors as $error) {
			throw new BadRequestHttpException($error);
		}
	}
}
