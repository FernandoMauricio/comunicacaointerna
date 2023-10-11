<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DespachocomunicacaoDeco */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despachocomunicacao-deco-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deco_codcomunicacao')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'deco_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'deco_codunidade')->textInput() ?>

    <?= $form->field($model, 'deco_codcargo')->textInput() ?>

    <?= $form->field($model, 'deco_data')->textInput() ?>

    <?= $form->field($model, 'deco_despacho')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'deco_codsituacao')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
