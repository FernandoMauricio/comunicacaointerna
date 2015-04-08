<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaointernaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comunicacao-interna-com-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'com_codcomunicacao') ?>

    <?= $form->field($model, 'com_codcolaborador') ?>

    <?= $form->field($model, 'com_codunidade') ?>

    <?= $form->field($model, 'com_datasolicitacao') ?>

    <?= $form->field($model, 'com_titulo') ?>

    <?php // echo $form->field($model, 'com_texto') ?>

    <?php // echo $form->field($model, 'com_codtipo') ?>

    <?php // echo $form->field($model, 'com_codsituacao') ?>

    <?php // echo $form->field($model, 'com_dataautorizacao') ?>

    <?php // echo $form->field($model, 'com_codcolaboradorautorizacao') ?>

    <?php // echo $form->field($model, 'com_codcargoautorizacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
