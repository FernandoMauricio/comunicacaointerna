<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "comunicacaointerna_com".
 *
 * @property integer $com_codcomunicacao
 * @property integer $com_codcolaborador
 * @property integer $com_codunidade
 * @property string $com_datasolicitacao
 * @property string $com_ip
 * @property string $com_titulo
 * @property string $com_texto
 * @property integer $com_codtipo
 * @property integer $com_codsituacao
 * @property string $com_dataautorizacao
 * @property string $com_ipautorizacao
 * @property integer $com_codcolaboradorautorizacao
 * @property integer $com_codcargoautorizacao
 *
 * @property AnexocomunicacaoAne[] $anexocomunicacaoAnes
 * @property SituacaocomunicacaoSitco $comCodsituacao
 * @property TipodocumentacaoTipdo $comCodtipo
 * @property DespachocomunicacaoDeco[] $despachocomunicacaoDecos
 * @property DestinocomunicacaoDest[] $destinocomunicacaoDests
 */

 
class ComunicacaointernaAut extends \yii\db\ActiveRecord
{

          public $nomesituacao;
          public $file; 

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comunicacaointerna_com';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_codcolaborador', 'com_codunidade', 'com_datasolicitacao', 'com_titulo', 'com_texto', 'com_codtipo', 'com_codsituacao'], 'required'],
            [['com_codcolaborador', 'com_codunidade', 'com_codtipo', 'com_codsituacao', 'com_codcolaboradorautorizacao', 'com_codcargoautorizacao'], 'integer'],
            [['com_datasolicitacao'], 'safe'],
            [['com_texto'], 'string'],
            [['com_titulo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'com_codcomunicacao' => 'Comunicação',
            'com_codcolaborador' => 'Solicitante',
            'com_codunidade' => 'Unidade',
            'com_datasolicitacao' => 'Data Solicitação',
            'com_titulo' => 'Título',
            'com_texto' => 'Texto',
            'com_codtipo' => 'Com Codtipo',
            'com_codsituacao' => 'Autorizações Pendentes',
            'com_dataautorizacao' => 'Com Dataautorizacao',
            'com_codcolaboradorautorizacao' => 'Com Codcolaboradorautorizacao',
            'com_codcargoautorizacao' => 'Com Codcargoautorizacao',
        ];
    }



    public function beforeSave($update){
                if (parent::beforeSave($update)) {

                // $session = Yii::$app->session;
                // // Autorizar Requisicao
                // $this->com_dataautorizacao = new Expression('current_timestamp');
                // $this->com_codcolaboradorautorizacao = $session['sess_codcolaborador'];
                // $this->com_codcargoautorizacao = $session['sess_codcargo'];
                return true;
                } else {
                return false;
                }

            }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnexocomunicacaoAnes()
    {
        return $this->hasMany(AnexocomunicacaoAne::className(), ['ane_codcomunicacao' => 'com_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacao()
    {
        return $this->hasOne(SituacaocomunicacaoSitco::className(), ['sitco_codsituacao' => 'com_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComCodtipo()
    {
        return $this->hasOne(TipodocumentacaoTipdo::className(), ['tipdo_codtipo' => 'com_codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDespachocomunicacaoDecos()
    {
        return $this->hasMany(DespachocomunicacaoDeco::className(), ['deco_codcomunicacao' => 'com_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinocomunicacao()
    {
        return $this->hasMany(Destinocomunicacao::className(), ['dest_codcomunicacao' => 'com_codcomunicacao']);
    }
    
    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'com_codcolaborador']);
    }

    public function getUnidades()
    {
        return $this->hasOne(Unidade_uni::className(), ['uni_codunidade' => 'com_codunidade']);
    }

}
