<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnidadeUni */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unidade-uni-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uni_nomecompleto')->textInput(['maxlength' => 150]) ?>

    <?= $form->field($model, 'uni_nomeabreviado')->textInput(['maxlength' => 60]) ?>

    <?= $form->field($model, 'uni_cnpj')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'uni_cep')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'uni_logradouro')->textInput(['maxlength' => 90]) ?>

    <?= $form->field($model, 'uni_bairro')->textInput(['maxlength' => 80]) ?>

    <?= $form->field($model, 'uni_cidade')->textInput(['maxlength' => 70]) ?>

    <?= $form->field($model, 'uni_estado')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'uni_coddisp')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uni_codtipo')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uni_codsituacao')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uni_codtipres')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uni_permitirmodeloa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
