<?php

use report\src\modules\ReportModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ReportModel */


$this->title = "Create Report";

?>

<h1 class="text-center d-block"><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<div class="container">
	<div class="col-lg-6 col-lg-offset-3">
		<p>Create a PDF report.</p>
		<?= $form->field($model, 'serial_number') ?>
		<div class="form-group">
			<?= Html::submitButton('Generate', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>
</div>

<?php ActiveForm::end(); ?>
