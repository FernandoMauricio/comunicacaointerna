<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioUsu */

$this->title = 'Atualizar Senha: ' . ' ' . $model->usu_nomeusuario;
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="usuario-usu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
