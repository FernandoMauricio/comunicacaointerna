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
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

$this->title = 'Comunicações Internas ';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comunicacao-interna-com-index">

   sdadadsa
</div>
