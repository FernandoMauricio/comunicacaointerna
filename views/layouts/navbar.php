<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

?>
<header>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../web/css/senac.css" rel="stylesheet">
    <?php
    $session = Yii::$app->session;


    NavBar::begin([
        'brandLabel' => 'Senac AM',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-senac fixed-top',
        ],
    ]);


    if ($session['sess_responsavelsetor'] == 1) {

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Home', 'url' => 'index.php'],
                ['label' => 'Criadas pelo Setor', 'url' => ['/comunicacaointerna/index']],
                ['label' => 'Recebidas pelo Setor', 'url' => ['/destinocomunicacao-receb/index']],
                [
                    'label' => 'Despachos/Autorizações',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Despachos Pendentes', 'url' => ['/destinocomunicacao-circ/index']],
                        ['label' => 'Autorizações Pendentes', 'url' => ['/comunicacaointerna-aut/index']],
                    ],
                ],
                [
                    'label' => 'Usuário (' . ucwords(strtolower($session['sess_nomeusuario'])) . ')',
                    'items' => [
                        ['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                        ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/web/index.php?r=site/modulos&unidade='.$session['sess_codunidade'].''],

                    ],
                ],
            ],
        ]);
    } else {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Home', 'url' => 'index.php'],
                ['label' => 'Criadas pelo Setor', 'url' => ['/comunicacaointerna/index']],
                ['label' => 'Recebidas pelo Setor', 'url' => ['/destinocomunicacao-receb/index']],
                [
                    'label' => 'Usuário (' . ucwords(strtolower($session['sess_nomeusuario'])) . ')',
                    'items' => [
                        ['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                        ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/web/index.php?r=site/modulos&unidade='.$session['sess_codunidade'].''],

                    ],
                ],
            ],
        ]);
    }
    NavBar::end();
    ?>
</header>