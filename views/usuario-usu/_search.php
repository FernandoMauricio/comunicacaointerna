<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-usu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usu_codusuario') ?>

    <?= $form->field($model, 'usu_loginusuario') ?>

    <?= $form->field($model, 'usu_senhausuario') ?>

    <?= $form->field($model, 'usu_nomeusuario') ?>

    <?= $form->field($model, 'usu_codtipo') ?>

    <?php // echo $form->field($model, 'usu_codsituacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
