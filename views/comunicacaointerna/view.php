<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ComunicacaoInternaCom */

$this->title = $model->com_codcomunicacao;
$this->params['breadcrumbs'][] = ['label' => 'Comunicação Interna', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comunicacao-interna-com-view">

    <h1><?= Html::encode($this->title) ?></h1>
        <?php //Mensagem confirmação de alteração de CI
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
            echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
            } ?>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->com_codcomunicacao], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->com_codcomunicacao], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'com_codcomunicacao',

            //Tipo
            //'com_codtipo',
            [
            'label' => 'Tipo',
            'value' => $model->comCodtipo->tipdo_tipo
            ],
                      
            //Colaborador
            //'com_codcolaborador',
            [
            'label' => 'Colaborador',
            'value' => $model->com_codcolaborador= $_SESSION['sess_nomeusuario']
            ],

            //Unidade
            //'com_codunidade',
            [
            'label' => 'Unidade',
            'value' => $model->com_codunidade= $_SESSION['sess_unidade']
            ],
            
            [
                'attribute' => 'com_datasolicitacao',
                'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            ],
            'com_titulo',
            'com_texto:ntext',

            //Situação da CI
            //'com_codsituacao',
            [
            'label' => 'Situação',
            'value' => $model->comCodsituacao->sitco_situacao1
            ],

            [
                'attribute' => 'com_dataautorizacao',
                'format' => ['datetime', 'dd/MM/yyyy HH:mm:ss']
            ],
            'com_codcolaboradorautorizacao',
            'com_codcargoautorizacao',            
        ],
    ]) ?>

</div>
