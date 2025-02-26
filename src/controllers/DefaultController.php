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

		return $this->render('view', [
			"model" => $model
		]);
	}

}
