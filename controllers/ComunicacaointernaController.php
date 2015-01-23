<?php

namespace app\controllers;

use Yii;
use app\models\ComunicacaoInternaCom;
use app\models\ComunicacaointernaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComunicacaointernaController implements the CRUD actions for ComunicacaoInternaCom model.
 */
class ComunicacaointernaController extends Controller
{
    ////////////////////////////TESTANDO A SESSÃO DO USUÁRIO//////////////////////////////////////

    public $sessionUsuario;
    public $sessionNome;
    public $idSuporte;
    public $idUnidade;
    public $nomeUnidade;

        public function __construct(){            

        $sess_codusuario   = isset($_SESSION['sess_codusuario']) ? $sess_codusuario   = $_SESSION['sess_codusuario'] : $sess_codusuario = "";
        $sess_nomeusuario  = isset($_SESSION['sess_nomeusuario']) ? $sess_nomeusuario = $_SESSION['sess_nomeusuario'] : $sess_nomeusuario = "";

        $this->idUnidade   = isset($_SESSION['sess_codunidade']) ? $this->idUnidade   = $_SESSION['sess_codunidade'] : $this->idUnidade = "";
        $this->nomeUnidade = isset($_SESSION['sess_unidade'])  ? $this->nomeUnidade   = $_SESSION['sess_unidade']    : $this->nomeUnidade = "";


    }


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
     * Lists all ComunicacaoInternaCom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComunicacaointernaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComunicacaoInternaCom model.
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
     * Creates a new ComunicacaoInternaCom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComunicacaoInternaCom();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ComunicacaoInternaCom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->com_codcomunicacao]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ComunicacaoInternaCom model.
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
     * Finds the ComunicacaoInternaCom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ComunicacaoInternaCom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComunicacaoInternaCom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
