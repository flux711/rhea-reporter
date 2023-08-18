<?php

namespace rhea\report\controllers;

use PhpLatex_Parser;
use PhpLatex_Renderer_Html;
use rhea\report\models\Report;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class ReportController extends Controller
{
	/**
	 * Rest Description: Create a new report. Provide a serial number, production code or run id.
	 * Rest Fields: ['input'].
	 * Rest Filters: [].
	 * Rest Expand: [].
	 */
	public function actionView()
	{
		Yii::$app->response->format = Response::FORMAT_HTML;
		$request = Yii::$app->request;

		$latex = Report::add_first_page();

		$parser = new PhpLatex_Parser();
		$parsedTree = $parser->parse(
			$latex
		);

		// render parsed LaTeX code to HTML
		$htmlRenderer = new PhpLatex_Renderer_Html();
		$html = $htmlRenderer->render($parsedTree);

		return $this->renderContent($html);
	}

}
