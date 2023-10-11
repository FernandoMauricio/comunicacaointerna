<?php

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Despachos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despachos-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($despachos, 'deco_despacho')->widget(CKEditor::className(), [
        'options' => ['rows' => 6, 'placeholder' => 'Insira seu Despacho...'],
        'preset' => 'basic'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar Despacho', ['class' => 'btn btn-success btn-lg btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
