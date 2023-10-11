<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-usu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usu_loginusuario')->textInput(['readonly'=>true,'maxlength' => true]) ?>

    <?= $form->field($model, 'usu_senhausuario')->input('password') ?>

    <?= $form->field($model, 'passwordConfirm')->input('password') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Atualizar Senha', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
