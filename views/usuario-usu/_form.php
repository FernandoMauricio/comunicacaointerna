<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-usu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usu_loginusuario')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'usu_senhausuario')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'usu_nomeusuario')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'usu_codtipo')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'usu_codsituacao')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
