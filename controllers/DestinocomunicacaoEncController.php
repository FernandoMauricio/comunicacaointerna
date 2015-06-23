<?php

namespace app\controllers;

use Yii;
use app\models\DestinocomunicacaoEnc;
use app\models\DestinocomunicacaoEncSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DestinocomunicacaoEncController implements the CRUD actions for DestinocomunicacaoEnc model.
 */
class DestinocomunicacaoEncController extends Controller
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
     * Lists all DestinocomunicacaoEnc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchEncModel = new DestinocomunicacaoEncSearch();
        $dataProvider2 = $searchEncModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            '$searchEncModel' => $searchEncModel,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Displays a single DestinocomunicacaoEnc model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'encaminhamentos' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DestinocomunicacaoEnc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $encaminhamentos = new DestinocomunicacaoEnc();

        if ($encaminhamentos->load(Yii::$app->request->post()) && $encaminhamentos->save()) {
            return $this->redirect(['view', 'id' => $encaminhamentos->dest_coddestino]);
        } else {
            return $this->render('create', [
                'encaminhamentos' => $encaminhamentos,
            ]);
        }
    }

    /**
     * Updates an existing DestinocomunicacaoEnc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $encaminhamentos = $this->findModel($id);

        if ($encaminhamentos->load(Yii::$app->request->post()) && $encaminhamentos->save()) {
            return $this->redirect(['view', 'id' => $encaminhamentos->dest_coddestino]);
        } else {
            return $this->render('update', [
                'encaminhamentos' => $encaminhamentos,
            ]);
        }
    }

    /**
     * Deletes an existing DestinocomunicacaoEnc model.
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
     * Finds the DestinocomunicacaoEnc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DestinocomunicacaoEnc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($encaminhamentos = DestinocomunicacaoEnc::findOne($id)) !== null) {
            return $encaminhamentos;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
