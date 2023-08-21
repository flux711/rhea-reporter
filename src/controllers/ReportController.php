<?php

namespace rhea\report\controllers;

use PhpLatex_Parser;
use PhpLatex_Renderer_Html;
use rhea\report\Report;
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

		$latexContent = Report::getReport();

		$latexFilePath = '/opt/packages/rhea-packages/rhea-reporter/tmp/file.tex';
		file_put_contents($latexFilePath, $latexContent);

		$command = "pdflatex -output-directory /opt/packages/rhea-packages/rhea-reporter/tmp $latexFilePath";
		shell_exec($command);

		$pdfFilePath = '/opt/packages/rhea-packages/rhea-reporter/tmp/file.pdf';
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="downloaded_file.pdf"');
		readfile($pdfFilePath);

		unlink($latexFilePath);
		unlink($pdfFilePath);

		$parser = new PhpLatex_Parser();
		$parsedTree = $parser->parse(
			$latexContent
		);

		// render parsed LaTeX code to HTML
		$htmlRenderer = new PhpLatex_Renderer_Html();
		$html = $htmlRenderer->render($parsedTree);

		return $this->renderContent($html);
	}

}
