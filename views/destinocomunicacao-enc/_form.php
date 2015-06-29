<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Unidades;
use kartik\select2\Select2;
use nirvana\showloading\ShowLoadingAsset;


/* @var $this yii\web\View */
/* @var $model app\models\DestinocomunicacaoEnc */
/* @var $form yii\widgets\ActiveForm */
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
<div class="destinocomunicacao-enc-form">

<?php
  ShowLoadingAsset::register($this);
  $this->registerJs(
   '$("document").ready(function(){
        $("#novo_destino_enc").on("pjax:start", function() { $("#novo_destino_enc").showLoading();});
        $("#novo_destino_enc").on("pjax:end", function() {$.pjax.reload({container:"#destinocomunicacaoEncGrid", timeout: 3000});  //Reload GridView
        $("#novo_destino_enc").hideLoading();
        });
    });
  '
);
?>
 <br>
    <?php yii\widgets\Pjax::begin(['id' => 'novo_destino_enc']) ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

        <?php
                    $rows = Unidades::find()->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_nomeabreviado', 'uni_nomeabreviado');
                    echo $form->field($encaminhamentos, 'dest_nomeunidadedest')->widget(Select2::classname(), [
                        'data' => array_merge(["" => ""], $data_unidades),
                        'options' => ['placeholder' => 'Selecione uma Unidade...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);                    
    ?> 

    <div class="form-group">
        <?= Html::submitButton('Inserir Unidade', ['class' =>  'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>


</div>
