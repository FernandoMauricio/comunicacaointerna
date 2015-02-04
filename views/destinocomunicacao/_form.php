<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\SituacaodestinoSide;
use app\models\Destinocomunicacao;
use app\models\ComunicacaointernaCom;
use app\models\Tipodestino;
use app\models\Unidade_uni;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Destinocomunicacao */
/* @var $form yii\widgets\ActiveForm */
?>
<?php //Mensagem confirmação de cadastro de CI
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
            }

?>
<div class="destinocomunicacao-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'dest_codcomunicacao')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'dest_codcolaborador')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'dest_codunidadeenvio')->textInput(['readonly'=>true]) ?>



    <?php 
                // DropdownList Tipo de Destino da comunicação para o envio
                $rows = Tipodestino::find()->all();
                $data_tipo = ArrayHelper::map($rows, 'tipde_codtipo', 'tipde_descricao');
                echo $form->field($model, 'dest_codtipo')->widget(Select2::classname(), [
                        'data' => array_merge(["" => ""], $data_tipo),
                        'options' => ['placeholder' => 'Selecione o Tipo de Envio...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);

    ?>    


    <?php 
                // DropdownList Situação da comunicação para o envio e despacho
                $rows = SituacaodestinoSide::find()->all();
                $data_situacao = ArrayHelper::map($rows, 'side_codsituacao', 'side_situacao');
                echo $form->field($model, 'dest_codsituacao')->widget(Select2::classname(), [
                        'data' => array_merge(["" => ""], $data_situacao),
                        'options' => ['placeholder' => 'Selecione a Situação...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    ?> 

        <?php

                    $rows = Unidade_uni::find()->all();
                    $data_unidades = ArrayHelper::map($rows, 'uni_codunidade', 'uni_nomeabreviado');
                    echo $form->field($model, 'dest_codunidadedest')->widget(Select2::classname(), [
                        'data' => array_merge(["" => ""], $data_unidades),
                        'options' => ['placeholder' => 'Selecione uma Unidade...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);



    ?>


    <?php

                    // Envio com cópia para as unidades
                echo '<label class="control-label">Com cópia para:</label>';
                echo Select2::widget([
                    'name' => 'unidades', 
                    'data' => $data_unidades,
                    'options' => [
                        'placeholder' => 'Selecione as Unidades...', 
                        'multiple' => true
                    ],
                ]);

    ?> 
<br />
<?php

Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => [Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])],
]);

echo 'Say hello...';

Modal::end();

?>


    <br /><br />


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
