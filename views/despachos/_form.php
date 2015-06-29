<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Despachos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despachos-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //echo $form->field($despachos, 'deco_codcomunicacao')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($despachos, 'deco_codcolaborador')->textInput() ?>

    <?php //echo $form->field($despachos, 'deco_codunidade')->textInput() ?>

    <?php //echo $form->field($despachos, 'deco_codcargo')->textInput() ?>

    <?php //echo $form->field($despachos, 'deco_data')->textInput() ?>

    <?= $form->field($despachos, 'deco_despacho')->widget(CKEditor::className(), [
        'options' => ['rows' => 6, 'placeholder' => 'Insira seu Despacho...'],
        'preset' => 'basic'
    ]) ?>

    <?php //echo $form->field($despachos, 'file[]')->fileInput(['multiple' => true]) ?>

    <?php //echo $form->field($despachos, 'deco_codsituacao')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($despachos, 'deco_nomeunidade')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($despachos, 'deco_nomeusuario')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar Despacho', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
