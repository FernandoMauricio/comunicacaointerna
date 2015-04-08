<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DespachocomunicacaoDecoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despachocomunicacao-deco-search">

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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
