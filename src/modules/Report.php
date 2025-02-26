<?php

namespace report\src\modules;

use FPDF;

class Report
{
	/**
	 * Hauptfunktion: Generiert einen PDF-Bericht
	 *
	 * @param array $data Die JSON-Daten für den Bericht
	 * @param string $outputFilename Der Zielname der PDF-Datei
	 */
	public function generate(array $data, $outputFilename)
	{
		$pdf = new FPDF();
		$pdf->SetFont('Arial', '', 12);

		// Erste Seite hinzufügen
		$pdf->AddPage();

		// Kopfzeile
		$this->addFirstPage($pdf);

		// Test-Metadaten
		$this->addTestMeta($pdf, $data['run']);

		// Dokument-Metadaten
		$this->addDocMeta($pdf, $data['version']);

		// Test-Ergebnisse mit Schritten
		$this->addTestsWithResults($pdf, $data['run']);

		// Download der PDF-Datei
		$pdf->Output('D', $outputFilename);
	}

	private function addFirstPage(&$pdf)
	{
		// Logo
		$logoPath = '@reprot_images/logo_PHYTEC_large.png'; // Anpassen an deinen Pfad
		if (file_exists($logoPath)) {
			$pdf->Image($logoPath, 10, 10, 50);  // (x, y, Breite)
		}

		// Titel und Firmeninformationen
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 10, 'Test Report - PHYTEC GmbH', 0, 1, 'C');
		$pdf->Ln(20);

		$firmInfo = <<<TEXT
PHYTEC Messtechnik GmbH
Barcelona-Allee 1 · D-55129 Mainz
Telefon: +49-(0)6131/9221-0
Internet: http://www.phytec.de
TEXT;

		$pdf->SetFont('Arial', '', 12);
		$pdf->MultiCell(0, 10, $firmInfo, 0, 'L');
		$pdf->Ln(10);
	}

	private function addTestMeta(&$pdf, $testData)
	{
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, 'Test Metadata:', 0, 1, 'L');
		$pdf->Ln(5);

		$pdf->SetFont('Arial', '', 12);

		$pdf->Cell(50, 10, 'Status:', 0, 0, 'L');
		$statusColor = $testData['status'] === 'passed' ? '0,128,0' : '255,0,0';
		$this->setTextColorRGB($pdf, $statusColor);
		$pdf->Cell(50, 10, ucfirst($testData['status']), 0, 1, 'L');
		$this->setTextColorRGB($pdf, '0,0,0');

		$pdf->Cell(50, 10, 'Run ID:', 0, 0, 'L');
		$pdf->Cell(50, 10, $testData['steps'][0]['run_id'], 0, 1, 'L');

		$pdf->Cell(50, 10, 'Run Type:', 0, 0, 'L');
		$pdf->Cell(50, 10, $testData['run_type'], 0, 1, 'L');

		$pdf->Ln(10);
	}

	private function addDocMeta(&$pdf, $versionData)
	{
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, 'Document Metadata:', 0, 1, 'L');
		$pdf->Ln(5);

		$pdf->SetFont('Arial', '', 12);

		$pdf->Cell(50, 10, 'Created:', 0, 0, 'L');
		$pdf->Cell(50, 10, date('Y-m-d H:i:s'), 0, 1, 'L');

		$pdf->Cell(50, 10, 'Version:', 0, 0, 'L');
		$pdf->Cell(50, 10, $versionData['version'], 0, 1, 'L');

		$pdf->Ln(10);
	}

	private function addTestsWithResults(&$pdf, $testRun)
	{
		$pdf->SetFont('Arial', 'B', 14);
		$pdf->Cell(0, 10, 'Test Results:', 0, 1, 'L');
		$pdf->Ln(5);

		foreach ($testRun['steps'] as $step) {
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(0, 10, "Step: " . ucfirst($step['test_name']), 0, 1, 'L');
			$pdf->Ln(2);

			$pdf->SetFont('Arial', '', 12);

			// Status
			$pdf->Cell(50, 10, 'Status:', 0, 0, 'L');
			$statusColor = $step['status'] === 'passed' ? '0,128,0' :
				($step['status'] === 'failed' ? '255,0,0' : '255,165,0');
			$this->setTextColorRGB($pdf, $statusColor);
			$pdf->Cell(50, 10, ucfirst($step['status']), 0, 1, 'L');
			$this->setTextColorRGB($pdf, '0,0,0');

			// Dauer
			$pdf->Cell(50, 10, 'Duration:', 0, 0, 'L');
			$pdf->Cell(50, 10, $step['duration'] . " sec", 0, 1, 'L');
			$pdf->Ln(5);
		}
	}

	private function setTextColorRGB(&$pdf, $rgb)
	{
		[$r, $g, $b] = sscanf($rgb, "%d,%d,%d");
		$pdf->SetTextColor($r, $g, $b);
	}
}
