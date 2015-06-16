<?php

use yii\helpers\Html;

?>
<div class="destinocomunicacao-create">

<!-- Render create form -->    
    <?= $this->render('_form', [
        'destinocomunicacao' => $destinocomunicacao,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'destinocomunicacao' => $destinocomunicacao,
    ]) ?>

<!-- Render create form -->    
    <?= $this->render('index', [
        'destinocomunicacao' => $destinocomunicacao,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'destinocomunicacao' => $destinocomunicacao,
    ]) ?>
</div>
