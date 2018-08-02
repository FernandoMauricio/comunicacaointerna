<?php

use yii\helpers\Html;

?>
<div class="destinocomunicacao-enc-create">

    <?= $this->render('_form', [
        'encaminhamentos' => $encaminhamentos,
    ]) ?>

<!-- Render create form -->    
    <?= $this->render('index', [
        'encaminhamentos' => $encaminhamentos,
        'searchEncModel' => $searchEncModel,
        'dataProvider' => $dataProvider2,
    ]) ?>

</div>
