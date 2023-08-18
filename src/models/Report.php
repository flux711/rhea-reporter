<?php

namespace rhea\report\models;

class Report
{

	static function add_first_page()
	{
		$minipage = "\\begin{minipage}{\\textwidth}";
		return $minipage;
	}
}
