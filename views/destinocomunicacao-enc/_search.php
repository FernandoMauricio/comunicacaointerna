<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoEncSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-enc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($encaminhamentos, 'dest_coddestino') ?>

    <?= $form->field($encaminhamentos, 'dest_codcomunicacao') ?>

    <?= $form->field($encaminhamentos, 'dest_codcolaborador') ?>

    <?= $form->field($encaminhamentos, 'dest_codunidadeenvio') ?>

    <?= $form->field($encaminhamentos, 'dest_data') ?>

    <?php // echo $form->field($model, 'dest_codtipo') ?>

    <?php // echo $form->field($model, 'dest_codsituacao') ?>

    <?php // echo $form->field($model, 'dest_coddespacho') ?>

    <?php // echo $form->field($model, 'dest_nomeunidadeenvio') ?>

    <?php // echo $form->field($model, 'dest_nomeunidadedest') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
