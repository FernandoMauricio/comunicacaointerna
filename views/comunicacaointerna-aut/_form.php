<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\markdown\Markdown;
use kartik\markdown\MarkdownEditor;


/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comunicacaointerna-com-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'com_titulo')->textInput(['readonly'=>true, 'maxlength' => 100]) ?>

    <?php echo $form->field($model, 'com_texto')->hiddenInput() ?>


    <?php
echo Markdown::convert($model['com_texto']);

    ?>

 <?php ActiveForm::end(); ?>

</div>
