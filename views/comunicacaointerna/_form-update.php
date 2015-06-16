<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveField;
use yii\helpers\ArrayHelper;
use app\models\AnexosModel;
use app\models\SituacaocomunicacaoSitco;
use app\models\TipodocumentacaoTipdo;
use app\models\Comunicacaointerna;
use app\models\SituacaodestinoSide;
use app\models\Destinocomunicacao;
use app\models\Tipodestino;
use app\models\Unidades;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\select2\Select2;
use dosamigos\ckeditor\CKEditor;



use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Comunicacaointerna */
/* @var $form yii\widgets\ActiveForm */

$dest_codunidadeenvio =  $_SESSION['sess_codunidade'];
$dest_codcolaborador = $_SESSION['sess_codcolaborador'];

?>

<?php 

//Get all flash messages and loop through them
foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) :'',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) :'',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : '',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : '',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
 
<!-- Render create form -->    
   <?= $this->render('/destinocomunicacao/create', [
        'destinocomunicacao' => $destinocomunicacao,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

<div class="comunicacao-interna-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>          

    <?php
                 
                $rows = TipodocumentacaoTipdo::find()->all();
                $data = ArrayHelper::map($rows, 'tipdo_codtipo', 'tipdo_tipo');
                echo $form->field($model, 'com_codtipo')->radiolist($data);

    ?> 

    <?= $form->field($model, 'com_titulo')->textInput(['maxlength' => 100, 'placeholder' => 'Insira o Título...'])?>

        <?= $form->field($model, 'com_texto')->widget(CKEditor::className(), [
        'options' => ['rows' => 6, 'placeholder' => 'Insira seu Despacho...'],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'nomesituacao')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'com_codsituacao')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>


    <div class="form-group">
        
        <?= Html::submitButton('Enviar Comunicação Interna', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
