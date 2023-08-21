<?php

namespace rhea\report;

class Report
{
	static function getReport()
	{
		$document = '
			\documentclass{article}
			\usepackage{graphicx}
			\begin{document}
			'.self::getFirstPage().'
			\end{document}
		';
		return $document;
	}

	static function getFirstPage()
	{
		$minipage = '
			\begin{minipage}{0.49\textwidth}
			'.self::getLogo().'
			\end{minipage}
		';
		return $minipage;
	}

	static function getLogo()
	{
		$file_path = dirname(dirname(dirname(__FILE__)))."/data/logo_PHYTEC_large.png";

		$logo = '
			\includegraphics[width=190px, height=30px]{'.$file_path.'}
		';
		return $logo;
	}
}
