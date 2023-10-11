<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnidadeUniSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidade-uni-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uni_codunidade') ?>

    <?= $form->field($model, 'uni_nomecompleto') ?>

    <?= $form->field($model, 'uni_nomeabreviado') ?>

    <?= $form->field($model, 'uni_cnpj') ?>

    <?= $form->field($model, 'uni_cep') ?>

    <?php // echo $form->field($model, 'uni_logradouro') ?>

    <?php // echo $form->field($model, 'uni_bairro') ?>

    <?php // echo $form->field($model, 'uni_cidade') ?>

    <?php // echo $form->field($model, 'uni_estado') ?>

    <?php // echo $form->field($model, 'uni_coddisp') ?>

    <?php // echo $form->field($model, 'uni_codtipo') ?>

    <?php // echo $form->field($model, 'uni_codsituacao') ?>

    <?php // echo $form->field($model, 'uni_codtipres') ?>

    <?php // echo $form->field($model, 'uni_permitirmodeloa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
