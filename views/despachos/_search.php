<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DespachosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despachos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'deco_coddespacho') ?>

    <?= $form->field($model, 'deco_codcomunicacao') ?>

    <?= $form->field($model, 'deco_codcolaborador') ?>

    <?= $form->field($model, 'deco_codunidade') ?>

    <?= $form->field($model, 'deco_codcargo') ?>

    <?php // echo $form->field($model, 'deco_data') ?>

    <?php // echo $form->field($model, 'deco_despacho') ?>

    <?php // echo $form->field($model, 'deco_codsituacao') ?>

    <?php // echo $form->field($model, 'deco_nomeunidade') ?>

    <?php // echo $form->field($model, 'deco_nomeusuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
