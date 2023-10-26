<?php

use yii\helpers\Html;
use yii\bootstrap4\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsu */

$this->title = $model->usu_codusuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Usus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-usu-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->usu_codusuario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->usu_codusuario], [
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
            'usu_codusuario',
            'usu_loginusuario',
            'usu_senhausuario',
            'usu_nomeusuario',
            'usu_codtipo',
            'usu_codsituacao',
        ],
    ]) ?>

</div>
