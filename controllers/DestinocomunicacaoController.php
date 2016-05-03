<?php

namespace app\controllers;

use Yii;
use app\models\Destinocomunicacao;
use app\models\Comunicacaointerna;
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
           $session = Yii::$app->session;

            $model = new Destinocomunicacao();

            $comunicacaointerna = new Comunicacaointerna();

            $model->dest_codcomunicacao = 1371;
            $model->dest_codcolaborador = 310;
            $model->dest_codunidadeenvio = 1;
            $model->dest_data = date('Y-m-d H:i:s');
            $model->dest_codtipo = 3; //TIPO = ENCAMINHADO PARA
            $model->dest_codsituacao = 1; // AGUARDANDO ABERTURA
            $model->dest_coddespacho = 0; // AGUARDANDO DESPACHO
            $model->dest_nomeunidadeenvio = $session['sess_unidade'];
            
             if ($model->load(Yii::$app->request->post())) {


                $destinos = array();
                if (isset($_POST['Comunicacaointerna']))
                {
                        $valid = true;
                        $comunicacaointerna->attributes = $_POST['Comunicacaointerna'];
                        $valid = $comunicacaointerna->validate() && $valid;
                        if (!empty($_POST['Destinocomunicacao']))
                        {
                                // Validate each destino row and store in the $destinos array
                                foreach ($_POST['Destinocomunicacao'] as $key => $destinoPost)
                                {
                                        $destino = new Destinocomunicacao;
                                        $destino->attributes = $destinoPost;
                                        $valid = $destino->validate() && $valid;
                                        $destinos[$key] = $destino;
                                }
                                if ($valid)
                                {
                                        if ($comunicacaointerna->save(false))
                                        {
                                                // Loop through all destinos and save each one
                                                foreach ($destinos as $destino)
                                                {
                                                        $destino->save(false);
                                                }
                                        }
                                }
                        }
                }
            return $this->redirect(['index']);
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
