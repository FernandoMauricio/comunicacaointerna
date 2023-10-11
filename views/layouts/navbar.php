<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

?>
<header>
    <?php
    $session = Yii::$app->session;


    NavBar::begin([
        'brandLabel' => 'Senac AM',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
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
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],

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
                        ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],

                    ],
                ],
            ],
        ]);
    }
    NavBar::end();
    ?>
</header>