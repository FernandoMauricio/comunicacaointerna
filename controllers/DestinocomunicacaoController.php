<?php

namespace app\controllers;

use Yii;
use app\models\Destinocomunicacao;
use app\models\DestinocomunicacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * DestinocomunicacaoController implements the CRUD actions for Destinocomunicacao model.
 */
class DestinocomunicacaoController extends Controller
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
        $searchModel = new DestinocomunicacaoSearch();
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
        $model = new Destinocomunicacao();

        //Resgatando as sessões da CI
         $session = Yii::$app->session;
        
        //conexão com os bancos
         $connection = Yii::$app->db;
         $connection = Yii::$app->db_base;
        
        //coletar os dados da CI
        $comunicacao = $session->get('comunicacao');

        //Coletar id, nome e unidade da CI
        $model->dest_codcomunicacao=$comunicacao->com_codcomunicacao;        
        $model->dest_codcolaborador=$comunicacao->com_codcolaborador;
        $model->dest_codunidadeenvio=$comunicacao->com_codunidade;

        //Confirmação de criação da CI
        Yii::$app->session->setFlash('success', 'Comunicação Interna cadastrada com sucesso! Por favor, <strong>selecione o destino abaixo:</strong>');

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dest_coddestino]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
