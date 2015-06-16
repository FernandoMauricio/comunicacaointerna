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

    <?= $form->field($destinocomunicacao, 'dest_coddestino') ?>

    <?= $form->field($destinocomunicacao, 'dest_codcomunicacao') ?>

    <?= $form->field($destinocomunicacao, 'dest_codcolaborador') ?>

    <?= $form->field($destinocomunicacao, 'dest_codunidadeenvio') ?>

    <?= $form->field($destinocomunicacao, 'dest_codunidadedest') ?>

    <?php // echo $form->field($model, 'dest_data') ?>

    <?php // echo $form->field($model, 'dest_codtipo') ?>

    <?php // echo $form->field($model, 'dest_codsituacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
