<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comunicacaointerna-com-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'com_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'com_codunidade')->textInput() ?>

    <?= $form->field($model, 'com_datasolicitacao')->textInput() ?>

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'com_texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'com_codtipo')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'com_codsituacao')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'com_dataautorizacao')->textInput() ?>

    <?= $form->field($model, 'com_codcolaboradorautorizacao')->textInput() ?>

    <?= $form->field($model, 'com_codcargoautorizacao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
