<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AnexosModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="anexos-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ane_codcomunicacao')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'ane_arquivo')->textInput(['maxlength' => 80]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
