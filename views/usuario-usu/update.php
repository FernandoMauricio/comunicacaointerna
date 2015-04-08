<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsu */

$this->title = 'Update Usuario Usu: ' . ' ' . $model->usu_codusuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Usus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usu_codusuario, 'url' => ['view', 'id' => $model->usu_codusuario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-usu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
