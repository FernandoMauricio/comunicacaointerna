<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use app\models\SituacaodestinoSide;
use app\models\Comunicacaointerna;
use app\models\TipodocumentacaoTipdo;
use app\models\SituacaoComunicacaoSitco;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DestinocomunicacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Pega as mensagens de CONFIRMAÇÃO DE DESPACHO
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}

//Get all flash messages and loop through them
foreach (Yii::$app->session->getAllFlashes() as $message) :; ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : '',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : '',
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
<?php
$unidade = $_SESSION['sess_unidade'];
$this->title = 'Despachos Pendentes ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destinocomunicacao-index">

    <h2><?= Html::encode($this->title) . '<small>Área Gerencial</small>' ?></h2>

    <?php

    $gridColumns = [
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('/comunicacaointerna/pdf2', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style']
        ],

        [
            'attribute' => 'dest_codcomunicacao',
        ],

        [
            'attribute' => 'dest_nomeunidadeenvio',
            'value' => 'comunicacaointerna.unidades.uni_nomeabreviado',
        ],

        [
            'attribute' => 'tipo',
            'vAlign' => 'middle',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->comunicacaointerna->comCodtipo->tipdo_tipo);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(TipodocumentacaoTipdo::find()->orderBy('tipdo_codtipo')->asArray()->all(), 'tipdo_tipo', 'tipdo_tipo'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => '120px'],
            ],
            'filterInputOptions' => ['placeholder' => 'Tipo'],
            'format' => 'raw'
        ],

        [
            'attribute' => 'data_solicitacao',
            'value' => 'comunicacaointerna.com_datasolicitacao',
            'format' => ['datetime', 'php:d/m/Y'],
            'hAlign' => 'center',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'data_solicitacao',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]
            ])
        ],

        [
            'attribute' => 'titulo',
            'value' => 'comunicacaointerna.com_titulo',
        ],

        [
            'attribute' => 'tag',
            'value' => 'comunicacaointerna.com_tag',
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {autoresp} {notificar}',
            'buttons' => [
                //DESPACHAR BUTTON
                'update' => function ($url, $model) {
                    return $model->dest_codtipo != 4 ?  Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                  </svg>', $url, [
                        'title' => Yii::t('app', 'Realizar Despacho'),
                        'class' => 'btn btn-primary btn-sm',

                    ]) : '';
                },

                //RESPONDER "CIENTE" COM UM CLIQUE
                'autoresp' => function ($url, $model) {
                    return $model->dest_codtipo == 4 ? Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                  </svg>', $url, [
                        'class' => 'btn btn-success btn-sm',
                        'title' => Yii::t('app', 'Inserir Resposta Automática'),
                        'data' => [
                            'confirm' => 'Você tem CERTEZA que deseja RESPONDER AUTOMATICAMENTE "Ciente" para essa Comunicação Interna?',
                            'method' => 'post',
                        ],

                    ]) : '';
                },

                //NOTIFICAR EQUIPE
                'notificar' => function ($url, $model) {
                    return $model->comunicacaointerna->com_codtipo != 2 ?  Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                  </svg>', $url, [
                        'class' => 'btn btn-warning btn-sm',
                        'title' => Yii::t('app', 'Notificar equipe'),
                        'data' => [
                            'confirm' => 'Você tem CERTEZA que deseja NOTIFICAR a equipe com os novos despachos?',
                            'method' => 'post',
                        ],

                    ]) : '';
                },

            ],
        ],
    ];


    ?>

    <?php Pjax::begin(['id' => 'w0-pjax']); ?>

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        'beforeHeader' => [
            [
                'columns' => [
                    ['content' => 'Detalhes da Comunicação Interna', 'options' => ['colspan' => 7, 'class' => 'text-center warning']],
                    ['content' => 'Área de Despacho', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
                ],
            ]
        ],

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<h5 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem - ' . $unidade . '</h5>',
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>