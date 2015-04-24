<?php

namespace app\controllers;

use Yii;
use app\models\ComunicacaoInterna;
use app\models\ComunicacaointernaSearch;
use app\models\Destinocomunicacao;
use app\models\AnexosModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;

use mPDF;


/**
 * ComunicacaointernaController implements the CRUD actions for Comunicacaointerna model.
 */
class ComunicacaointernaController extends Controller
{
    ////////////////////////////TESTANDO A SESSÃO DO USUÁRIO//////////////////////////////////////
   /* public $sessionUsuario;
    public $sessionNome;
    public $idSuporte;
    public $idUnidade;
    public $nomeUnidade;

    public function __construct(){

        $sess_codusuario = isset($_SESSION['sess_codusuario']) ? $sess_codusuario = $_SESSION['sess_codusuario'] : $sess_codusuario = "";
        $sess_nomeusuario = isset($_SESSION['sess_nomeusuario']) ? $sess_nomeusuario = $_SESSION['sess_nomeusuario'] : $sess_nomeusuario = "";

        $this->idUnidade            = isset($_SESSION['sess_codunidade']) ? $this->idUnidade = $_SESSION['sess_codunidade'] : $this->idUnidade = "";
        $this->nomeUnidade          = isset($_SESSION['sess_unidade'])  ? $this->nomeUnidade = $_SESSION['sess_unidade']    : $this->nomeUnidade = "";

        $this->session->set_userdata('usuario_id', $sess_codusuario);
        $this->session->set_userdata('login', $sess_nomeusuario);
        $this->sessionLogin = $this->session->userdata('login');
        $this->sessionUsuario =  $this->session->userdata('usuario_id');

    }*/

    

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comunicacaointerna models.
     * @return mixed
     */
    public function actionIndex()

    {

        $searchModel = new ComunicacaointernaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//Confirmação de envio da CI
        /*Yii::$app->session->setFlash('success', 'Comunicação Interna <strong>enviada com sucesso!</strong>');*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Comunicacaointerna model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    /**
     * Creates a new Comunicacaointerna model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comunicacaointerna();
        $anexo = new AnexosModel();

        $session = Yii::$app->session;

        //Coletar a sessão do usuário

        $model->com_codcolaborador= $session['sess_codcolaborador'];
        $model->com_codunidade= $session['sess_codunidade'];

        //Caso NÃO seja gerente, situação fica PARA AUTORIZAÇÃO, se não, fica EM CIRCULAÇÃO
        if ($_SESSION['sess_responsavelsetor'] == 0){

        $model->nomesituacao = 'Para Autorização';
        $model->com_codsituacao = 3;
        
    }else{

        $model->nomesituacao = 'Em Circulação';
        $model->com_codsituacao = 4;
       
    }        

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {

            $session->set('comunicacao', $model);

        //Confirmação de criação da CI
         Yii::$app->session->setFlash('info', 'Comunicação Interna cadastrada com sucesso! Por favor, <strong>selecione o destino abaixo:</strong>');

        //get session comunicacao criada
         $comunicacao = $session->get('comunicacao');

        //Depois de inserido, pega o ID criado 
        return $this->redirect(['update', 'id' => $comunicacao->com_codcomunicacao]);

                      
        } else {
            return $this->render('create', [
                'model' => $model,
                'anexo'=> $anexo,
            ]);
        }
    }

    /**
     * Updates an existing Comunicacaointerna model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $anexo = new AnexosModel();
        $model = $this->findModel($id);

        //Resgatando as sessões da CI
         $session = Yii::$app->session;

        //conexão com os bancos
         $connection = Yii::$app->db;
         $connection = Yii::$app->db_base;

        //get session comunicacao criada
         $comunicacao = $session->get('comunicacao');
         $anexos = $session->get('anexos');

        //Coletar a sessão do usuário e da tabela anexo

        $model->com_codcolaborador = $session['sess_codcolaborador'];
        $model->com_codunidade = $session['sess_codunidade'];


            //VERIFICAR PARA PUXAR OS ANEXOS
/*        $anexo->ane_codcomunicacao = $comunicacao->com_codcomunicacao;
        $anexo->ane_arquivo = $anexos->ane_arquivo;*/



        //Caso NÃO seja gerente, situação fica PARA AUTORIZAÇÃO, se não, fica EM CIRCULAÇÃO
        if ($_SESSION['sess_responsavelsetor'] == 0){

        $model->nomesituacao = 'Para Autorização';
        $model->com_codsituacao = 2;
        
    }else{

        $model->nomesituacao = 'Em Circulação';
        $model->com_codsituacao = 4;
       
    } 

        if ($model->load(Yii::$app->request->post()) && $anexo->load(Yii::$app->request->post())) {

            $model->save();

              return $this->redirect('index.php?r=comunicacaointerna%2Findex');
            //return $this->redirect(['view', 'id' => $model->com_codcomunicacao]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'anexo'=> $anexo,
            ]);
        }
    }

    /**
     * Deletes an existing Comunicacaointerna model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', 'Exclusão realizada com sucesso!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Comunicacaointerna model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comunicacaointerna the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comunicacaointerna::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAguardandoAut($id)
    {

        if(['com_codsituacao'] == 3 && ['com_codunidade'] == ['sess_codunidade'])
        {
       return $this->render(['view', 'id' => $model->com_codcomunicacao, [
            'model' => $this->findModel($id),
        ]]);

        }

 


    }




// Privacy statement output demo
public function actionPdf() {
    $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
        'content' => $this->renderPartial('pdf'),
        'options' => [
            'title' => 'Comunicação Interna - Senac AM',
            'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
        ],
        'methods' => [
            'SetHeader' => ['DOCUMENTAÇÃO ELETRÔNICA - SENAC AM||Gerado em: ' . date("d/m/Y - H:i:s")],
            'SetFooter' => ['Gerência de Informática Corporativa - GIC||Página {PAGENO}'],
        ]
    ]);
    return $pdf->render();
}



}
