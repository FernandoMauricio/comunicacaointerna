<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

$session = Yii::$app->session;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        $session = Yii::$app->session;
            NavBar::begin([
                //'brandLabel' => 'Senac AM',
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
            ['label' => 'Sair', 'url' => 'http://localhost/senac/portal_senac_old/control_base_vermodulos/control_base_vermodulos.php'],
                    // Yii::$app->user->isGuest ?
                    //     ['label' => 'Login', 'url' => ['/site/login']] :
                    //     ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    //         'url' => ['/site/logout'],
                    //         'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
}else
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => 'index.php'],
                    ['label' => 'Criadas pelo Setor', 'url' => ['/comunicacaointerna/index']],
                    ['label' => 'Recebidas pelo Setor', 'url' => ['/destinocomunicacao-receb/index']],
                    
            ['label' => 'Sair', 'url' => 'http://localhost/senac/portal_senac_old/control_base_vermodulos/control_base_vermodulos.php'],
                ],
            ]);

            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy;Gerência de Informática Corporativa - GIC <?= date('Y') ?></p>
            <p class="pull-right"></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
