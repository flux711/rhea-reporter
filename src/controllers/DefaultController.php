<?php

namespace rhea\report\controllers;

use yii\rest\Controller;

class DefaultController extends Controller
{
	/**
	 * Rest Description: Create a new report. Provide a serial number, production code or run id.
	 * Rest Fields: [].
	 * Rest Filters: [].
	 * Rest Expand: [].
	 */
	public function actionCreate()
	{
		return 'hello world';
	}

}
