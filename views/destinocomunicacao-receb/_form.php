<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dest_codcomunicacao')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'dest_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'dest_codunidadeenvio')->textInput() ?>

    <?= $form->field($model, 'dest_codunidadedest')->textInput() ?>

    <?= $form->field($model, 'dest_codtipo')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'dest_codsituacao')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
