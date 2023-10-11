<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use app\models\Unidades;
use kartik\select2\Select2;
use nex\chosen\Chosen;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?php
                    $rows = Unidades::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_nomecompleto', 'uni_nomecompleto');
                    echo $form->field($model, 'dest_nomeunidadedest')->widget(Select2::classname(), [
                        'data' =>  $data_unidades,
                        'options' => ['placeholder' => 'Selecione uma Unidade...', 'multiple'=>true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);                    
 


     // $form->field($model, 'dest_nomeunidadedest')->widget(
     //        Chosen::className(), [
     //            'items' => $data_unidades,
     //            'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
     //            'clientOptions' => [
     //                'search_contains' => true,
     //                'single_backstroke_delete' => false,
     //            ],
     //    ]);

        ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
