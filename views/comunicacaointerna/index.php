<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\TipodocumentacaoTipdo;
use app\models\SituacaocomunicacaoSitco;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ComunicacaointernaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;
$unidade = $session['sess_unidade'];


//Pega as mensagens de EXCLUSÃO DE CI
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
}

$this->title = 'Comunicações Internas ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comunicacao-interna-com-index">

    <h2><?= Html::encode($this->title) . '<small>Criadas pelo Setor</small>' ?></h2>

    <br>
    <p>
        <?= Html::a('Nova Comunicacao Interna', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'w0-pjax']); ?>

    <?php

    $gridColumns = [
        [
            'attribute' => 'com_codcomunicacao',
        ],

        [
            'attribute' => 'com_codtipo',
            'vAlign' => 'middle',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->comCodtipo->tipdo_tipo);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(TipodocumentacaoTipdo::find()->orderBy('tipdo_codtipo')->asArray()->all(), 'tipdo_tipo', 'tipdo_tipo'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => '100px'],
            ],
            'filterInputOptions' => ['placeholder' => 'Tipo'],
            'format' => 'raw'
        ],

        [
            'attribute' => 'com_titulo',
            'value' => function ($data) {
                if ($data->com_codtipo == '1') {
                    return $data->com_titulo;
                } else {
                    return '****CONFIDENCIAL****';
                }
            },
        ],

        [
            'attribute' => 'com_tag',
        ],

        [
            'attribute' => 'data_solicitacao',
            'value' => 'com_datasolicitacao',
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
            'attribute' => 'situacaocomunicacao',
            'vAlign' => 'middle',
            'value' => function ($model, $key, $index, $widget) {
                return Html::a($model->situacao->sitco_situacao1);
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => ArrayHelper::map(SituacaocomunicacaoSitco::find()->orderBy('sitco_codsituacao')->asArray()->all(), 'sitco_situacao1', 'sitco_situacao1'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true, 'width' => '100px'],
            ],
            'filterInputOptions' => ['placeholder' => 'Situação'],
            'format' => 'raw'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {encerrar} {delete} ',
            'options' => ['width' => '8%'],
            'buttons' => [

                //FINALIZAR CI
                'encerrar' => function ($url, $model) {
                    return Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                  </svg>', $url, [
                        'title' => Yii::t('app', 'Finalizar CI'),
                        'data' => [
                            'confirm' => 'Você tem CERTEZA que deseja ENCERRAR essa Comunicação Interna?',
                            'method' => 'post',
                        ],
                    ]);
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
        'rowOptions' => function ($model) {
            if ($model->com_codsituacao == '5') {

                return ['class' => 'danger'];
            }
        },
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        'condensed' => true,
        'hover' => true,
        'beforeHeader' => [
            [
                'columns' => [
                    ['content' => 'Detalhes da Comunicação Interna - Criadas pelo Setor', 'options' => ['colspan' => 6, 'class' => 'text-center warning']],
                    ['content' => 'Ações', 'options' => ['colspan' => 2, 'class' => 'text-center warning']],
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