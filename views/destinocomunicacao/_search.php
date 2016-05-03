<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'dest_coddestino') ?>

    <?= $form->field($model, 'dest_codcomunicacao') ?>

    <?= $form->field($model, 'dest_codcolaborador') ?>

    <?= $form->field($model, 'dest_codunidadeenvio') ?>

    <?= $form->field($model, 'dest_codunidadedest') ?>

    <?php // echo $form->field($model, 'dest_data') ?>

    <?php // echo $form->field($model, 'dest_codtipo') ?>

    <?php // echo $form->field($model, 'dest_codsituacao') ?>

    <?php // echo $form->field($model, 'dest_coddespacho') ?>

    <?php // echo $form->field($model, 'dest_nomeunidadeenvio') ?>

    <?php // echo $form->field($model, 'dest_nomeunidadedest') ?>

    <?php // echo $form->field($model, 'dest_anexo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
