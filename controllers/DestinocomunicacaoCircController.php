<?php

namespace app\controllers;

use Yii;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoEnc;
use app\models\DestinocomunicacaoEncSearch;
use app\models\DestinocomunicacaoSearch;
use app\models\DestinocomunicacaoCircSearch;
use app\models\DestinocomunicacaoPendenteCircSearch;
use app\models\Despachos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinocomunicacaoCircController implements the CRUD actions for Destinocomunicacao model.
 */
class DestinocomunicacaoCircController extends Controller
{
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
     * Lists all Destinocomunicacao models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new DestinocomunicacaoCircSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Destinocomunicacao model.
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
     * Creates a new Destinocomunicacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DestinocomunicacaoEnc();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dest_coddestino]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Destinocomunicacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //Resgatando o código da CI para sql no banco
        $session = Yii::$app->session;
        $session->set('sess_comunicacao', $model->dest_codcomunicacao);
        $session->set('sess_destino', $model->dest_coddestino);
        $session->close();

            //BUSCA NO BANCO OS NOVOS DESTINOS (ENCAMINHAMENTOS)
            $searchEncModel = new DestinocomunicacaoEncSearch();
            $dataProvider2 = $searchEncModel->search(Yii::$app->request->queryParams); 

            //BUSCA NO BANCO OS DESTINOS QUE ESTÃO PENDENTES PARA DESPACHO
            $searchModel = new DestinocomunicacaoPendenteCircSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            //instancia novos encaminhamentos para o desapacho
            $encaminhamentos = new DestinocomunicacaoEnc();
            $encaminhamentos->dest_codcomunicacao = $model->comunicacaointerna->com_codcomunicacao;
            $encaminhamentos->dest_codcolaborador = $model->comunicacaointerna->com_codcolaborador;
            $encaminhamentos->dest_codunidadeenvio = $model->comunicacaointerna->com_codunidade;
            $encaminhamentos->dest_nomeunidadeenvio = $session['sess_unidade'];
            $encaminhamentos->dest_codtipo = 3; //TIPO = ENCAMINHADO PARA
            $encaminhamentos->dest_codsituacao = 1; // AGUARDANDO ABERTURA
            $encaminhamentos->dest_coddespacho = 0; // AGUARDANDO DESPACHO
            $encaminhamentos->dest_data = date('Y-m-d h:m:s');

         if ($encaminhamentos->load(Yii::$app->request->post()) && $encaminhamentos->save())
         {
            //REALIZA O LOOP DE 1 OU MAIS INSERÇÕES
            $encaminhamentos = new DestinocomunicacaoEnc();
            $encaminhamentos->dest_codcomunicacao = $model->com_codcomunicacao;
            $encaminhamentos->dest_codcolaborador = $model->com_codcolaborador;
            $encaminhamentos->dest_codunidadeenvio = $model->com_codunidade;
            $encaminhamentos->dest_nomeunidadeenvio = $session['sess_unidade'];
            $encaminhamentos->dest_data = date('Y-m-d h:m:s');

         }

            //instacia um novo despacho
            $despachos = new Despachos();
            $despachos->deco_codcomunicacao = $model->dest_codcomunicacao;
            $despachos->deco_codcolaborador = $session['sess_codcolaborador'];
            $despachos->deco_codunidade = $session['sess_codunidade'];
            $despachos->deco_codcargo = $session['sess_codcargo'];
            $despachos->deco_data = date('Y-m-d h:m:s');
            $despachos->deco_codsituacao = $model->dest_codsituacao;
            $despachos->deco_nomeunidade = $session['sess_unidade'];
            $despachos->deco_nomeusuario = $session['sess_nomeusuario'];
            $despachos->deco_cargo = $session['sess_cargo'];

         if ($despachos->load(Yii::$app->request->post()) && $despachos->save()) 
        {
            $model->dest_coddespacho = $despachos->deco_coddespacho;
            $encaminhamentos->dest_coddespacho = $model->dest_coddespacho;

                    //Atualiza a situação do DESTINO para "ABERTO"(cód 3) e insere o código de despacho para poder realizar a filtragem e enviar o e-mail"
                    $connection = Yii::$app->db;
                    $command = $connection->createCommand(
                    "UPDATE `db_ci`.`destinocomunicacao_dest` SET `dest_codsituacao` = '3' WHERE `dest_coddestino` = '".$model->dest_coddestino."' AND `dest_codcomunicacao` =" . $session['sess_comunicacao']);
                    $command->execute();

                    //Atualiza a situação do ENCAMINHAMENTO para "ABERTO"(cód 2), CASO HAJA ALGUM ENCAMINHAMENTO"
                    $command = $connection->createCommand(
                    "UPDATE destinocomunicacao_dest SET dest_codsituacao = '2', `dest_coddespacho` = '".$model->dest_coddespacho."' WHERE dest_codcomunicacao = '".$session['sess_comunicacao']."' AND dest_nomeunidadeenvio = '".$session['sess_unidade']."' AND dest_codsituacao = 1");  
                    $command->execute();

             return $this->redirect(['view', 'id' => $model->dest_coddestino]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'despachos' => $despachos,
                'encaminhamentos' => $encaminhamentos,
                'searchModel' => $searchModel,
                'searchEncModel' => $searchEncModel,
                'dataProvider' => $dataProvider,
                'dataProvider2' => $dataProvider2,
            ]);
        }
        
    }

    /**
     * Deletes an existing Destinocomunicacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

                //BUSCA NO BANCO SE EXISTE DESTINOS PARA A CI
             $checar_destino = Destinocomunicacao::find()
                ->where(['dest_codcomunicacao' => $_GET])
                ->count();

                        if($model = DestinocomunicacaoEnc::findOne($id)){
                     
                      if($model->delete()) {

                          Yii::$app->getSession()->setFlash('danger', [
                               'type' => 'danger',
                               'duration' => 5000,
                               'icon' => 'glyphicon glyphicon-info-sign',
                               'message' => 'Encaminhamento excluido com sucesso!',
                               'title' => 'Exclusão',
                               'positonY' => 'top',
                               'positonX' => 'right'
                           ]);
                            $session = Yii::$app->session;
                             return $this->redirect(['update', 'id' => $session['sess_destino']]);       
                        }                          
                }

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Destinocomunicacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Destinocomunicacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destinocomunicacao::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
