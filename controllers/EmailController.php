<?php

namespace app\controllers;

use Yii;
use app\models\Comunicacaointerna;
use app\models\ComunicacaointernaSearch;
use app\models\Destinocomunicacao;
use app\models\Emailusuario;
use app\models\DestinocomunicacaoSearch;
use app\models\DestinocomunicacaoPendenteEnvioSearch;
use app\models\UploadForm;
use app\models\Unidades;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;

use mPDF;


/**
 * ComunicacaointernaController implements the CRUD actions for Comunicacaointerna model.
 */
class EmailController extends Controller
{
  
    public function actionIndex()

    {

Yii::$app->mailer->compose()
     ->setFrom('fernando.mauricio@am.senac.br')
     ->setTo('fernando.mauricio@am.senac.br')
     ->setSubject('Email sent from Yii2-Swiftmailer')
     ->send();


        return $this->render('index');
        
}
}