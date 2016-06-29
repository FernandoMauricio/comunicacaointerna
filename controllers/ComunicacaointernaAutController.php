<?php

namespace app\controllers;

use Yii;
use app\models\Emailusuario;
use app\models\Destinocomunicacao;
use app\models\ComunicacaointernaAut;
use app\models\ComunicacaointernaAutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComunicacaointernaAutController implements the CRUD actions for ComunicacaointernaAut model.
 */
class ComunicacaointernaAutController extends Controller
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
     * Lists all ComunicacaointernaAut models.
     * @return mixed
     */
    public function actionIndex()
    {
                        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('http://portalsenac.am.senac.br');
        }

        $searchModel = new ComunicacaointernaAutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAprovar($id)
    {
        $model = $this->findModel($id);

            $session = Yii::$app->session;
            $model->com_dataautorizacao = date('Y-m-d H:i:s');
            $model->com_codcolaboradorautorizacao = $session['sess_codcolaborador'];
            $model->com_codcargoautorizacao = $session['sess_codcargo'];

            //-------altera a CI para EM CIRULAÇÃO (cód 4) / atualizando data da autorização / colaborador que autorizou / cargo de quem autorizou
            Yii::$app->db->createCommand('UPDATE `comunicacaointerna_com` SET `com_codsituacao` = 4, `com_dataautorizacao`= "'. $model->com_dataautorizacao.'", `com_codcolaboradorautorizacao` = '.$model->com_codcolaboradorautorizacao.', `com_codcargoautorizacao` = '.$model->com_codcargoautorizacao.' WHERE `com_codcomunicacao` = '.$model->com_codcomunicacao.'')
            ->execute();

            //-------altera os destino da CI para realizar a fitlragem por e-mail e liberar o despacho (cód 2)
            Yii::$app->db->createCommand('UPDATE `destinocomunicacao_dest` SET `dest_codsituacao` = 2 WHERE `dest_codcomunicacao` = '.$model->com_codcomunicacao.'')
            ->execute();

         //ENVIA EMAIL PARA TODAS AS UNIDADES QUE FORAM INSERIDAS NO DESTINO DA CI
         //CRIANDO ARRAY COM SETORES PARTICIPANTES DA CI....
         //
         //

         $model->com_codsituacao = 4;
         if($model->com_codsituacao == 4){

          $manda_email = 0;
          $unidade_destino = "";
          $sql_unidade_destino = "SELECT dest_codunidadedest,dest_nomeunidadedest,dest_nomeunidadedestCopia FROM destinocomunicacao_dest WHERE dest_codcomunicacao = ".$model->com_codcomunicacao;

          $unidades = Destinocomunicacao::findBySql($sql_unidade_destino)->all();
                 foreach ($unidades as $unidade)
                    {
                     $unidade_destino  = $unidade["dest_codunidadedest"];
                     $nomeunidade_destino  = $unidade["dest_nomeunidadedest"];
                     $nomeunidade_destinoCopia  = $unidade["dest_nomeunidadedestCopia"];
                   

          $sql_email_unidade = "SELECT `db_base`.`emailusuario_emus`.`emus_email` FROM `db_base`.`usuario_usu`, `db_base`.`emailusuario_emus`, `db_base`.`responsavelambiente_ream`, `db_base`.`colaborador_col` WHERE ream_codunidade = '".$unidade_destino."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = usu_codusuario and usu_codusuario = emus_codusuario";  
      
                          $email_unidades = Emailusuario::findBySql($sql_email_unidade)->all(); 
                          foreach ($email_unidades as $email_unidade)
                                       {
                                         $email_unidade_gerente  = $email_unidade["emus_email"];

                                                Yii::$app->mailer->compose()
                                                ->setFrom(['gde@am.senac.br' => 'Documentação Eletrônica'])
                                                ->setTo($email_unidade_gerente)
                                                ->setSubject('CI '.$id. ' Aguardando Despacho - ' .$nomeunidade_destino .$nomeunidade_destinoCopia)
                                                ->setTextBody('Existe uma CI de código: '.$id.' aguardando seu despacho')
                                                ->setHtmlBody('<p>Prezado(a)&nbsp;Gerente,</p>

                                                <p>Existe uma Comunica&ccedil;&atilde;o Interna <span style="color:#337AB7">'.$id.' </span>aguardando seu despacho. Abaixo, segue algumas informa&ccedil;&otilde;es; :</p>

                                                <p><strong>T&iacute;tulo: </strong><span style="color:#337AB7">'. $model->com_titulo .'</span></p>

                                                <p><strong>Autorizado Por: </strong><span style="color:#337AB7">'. $model->colaborador->usuario->usu_nomeusuario .'</span></p>

                                                <p><strong>Data/Hora</strong>:&nbsp;<span style="color:#337AB7">'. date('d/m/Y H:i', strtotime($model->com_dataautorizacao)) .'</span></p>

                                                ')
                                                ->send();

                                       }
                $manda_email++;
            }
        }

            //mensagem de confirmação
            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Comunicação interna aprovada com sucesso!');
     
             return $this->redirect(['index']);
    }

    public function actionReprovar($id)
    {
        $model = $this->findModel($id);

            //-------altera a CI para EM ELABORAÇÃO (cód 1)
            Yii::$app->db->createCommand('UPDATE `comunicacaointerna_com` SET `com_codsituacao`= 1 WHERE `com_codcomunicacao` = '.$model->com_codcomunicacao.'')
            ->execute();
            //-------exclui os destinos da CI 
            Yii::$app->db->createCommand('DELETE FROM `destinocomunicacao_dest` WHERE `dest_codcomunicacao` = '.$model->com_codcomunicacao.'')
            ->execute();

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Comunicação interna reprovada com sucesso!');
     
             return $this->redirect(['index']);
    }

   
    /**
     * Deletes an existing ComunicacaointernaAut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ComunicacaointernaAut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComunicacaointernaAut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComunicacaointernaAut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
