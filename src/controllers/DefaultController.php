<?php

namespace report\src\controllers;

use Exception;
use report\src\modules\ReportModel;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		Yii::$app->response->format = Response::FORMAT_HTML;
		$request = Yii::$app->request;

		$report = new ReportModel();
		if ($report->load($request->post()) && $report->validate()) {
			try {
				$report->create();
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', $e->getMessage());
			}
		}

		return $this->render('view', [
			"report" => $report
		]);
	}

}
