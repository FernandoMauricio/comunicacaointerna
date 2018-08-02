<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
        
        $session = Yii::$app->session;
            NavBar::begin([
                'brandLabel' => '<img src="css/img/logo_senac_topo.png"/>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            if($session['sess_responsavelsetor']==1){

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => 'index.php'],
                    ['label' => 'Criadas pelo Setor', 'url' => ['/comunicacaointerna/index']],
                    ['label' => 'Recebidas pelo Setor', 'url' => ['/destinocomunicacao-receb/index']],
                    
                    ['label' => 'Despachos/Autorizações',
                'items' => [
                 '<li class="dropdown-header">Área Gerencial</li>',
                 ['label' => 'Despachos Pendentes', 'url' => ['/destinocomunicacao-circ/index']],
                 ['label' => 'Autorizações Pendentes', 'url' => ['/comunicacaointerna-aut/index']],
                           ],
        ],
                

                    ['label' => 'Usuário (' . ucwords(strtolower($session['sess_nomeusuario'])) . ')',
                'items' => [
                 '<li class="dropdown-header">Área Usuário</li>',
                    ['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                    ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                    ['label' => 'Sair', 'url' => 'http://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                           ],
                    ],
                ],
            ]);
}else
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => 'index.php'],
                    ['label' => 'Criadas pelo Setor', 'url' => ['/comunicacaointerna/index']],
                    ['label' => 'Recebidas pelo Setor', 'url' => ['/destinocomunicacao-receb/index']],
                    ['label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
                'items' => [
                 '<li class="dropdown-header">Área Usuário</li>',
                    ['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                    ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                    ['label' => 'Sair', 'url' => 'http://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                           ],
                    ],
                ],
            ]);

    NavBar::end();
?>