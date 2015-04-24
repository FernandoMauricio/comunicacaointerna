<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "comunicacaointerna_com".
 *
 * @property string $com_codcomunicacao
 * @property integer $com_codcolaborador
 * @property integer $com_codunidade
 * @property string $com_datasolicitacao
 * @property string $com_titulo
 * @property string $com_texto
 * @property string $com_codtipo
 * @property string $com_codsituacao
 * @property string $com_dataautorizacao
 * @property integer $com_codcolaboradorautorizacao
 * @property integer $com_codcargoautorizacao
 *
 * @property AnexocomunicacaoAne[] $anexocomunicacaoAnes
 * @property SituacaocomunicacaoSitco $comCodsituacao
 * @property TipodocumentacaoTipdo $comCodtipo
 * @property DespachocomunicacaoDeco[] $despachocomunicacaoDecos
 * @property DestinocomunicacaoDest[] $destinocomunicacaoDests
 */
class Comunicacaointerna extends \yii\db\ActiveRecord
{

    public $nomesituacao;
    
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
            [['com_codcolaborador', 'com_codunidade', 'com_titulo', 'com_texto', 'com_codtipo', 'com_codsituacao'], 'required'],
            [['com_codtipo', 'com_codsituacao', 'com_codcolaboradorautorizacao', 'com_codcargoautorizacao'], 'integer'],
            [['com_datasolicitacao', 'com_dataautorizacao'], 'safe'],
            [['com_codtipo'], 'validarTipo'],
            [['com_texto'], 'string'],
            [['com_titulo'], 'string', 'max' => 100],

        ];
    }
        /*Rules Personalizadas para a criação de CI relacionadas ao Tipo
        */


    public function validarTipo($com_codtipo, $params){

                //Coletar a sessão do usuário
  /*      $session = Yii::$app->session;*/

                if($this->com_codtipo == 2 && $_SESSION['sess_responsavelsetor'] == 0) {

                    $this->addError($com_codtipo, 'Somente o Responsável pela Unidade/Setor poderá gerar uma Comunicação Interna Confidencial.');        
                    }
                }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'com_codcomunicacao' => 'Cód. Comunicação',
            'com_codcolaborador' => 'Colaborador',
            'com_codunidade' => 'Unidade',
            'com_datasolicitacao' => 'Data/Hora Solicitação',
            'com_titulo' => 'Título',
            'com_texto' => 'Texto',
            'com_codtipo' => 'Tipo',
            'nomesituacao' => 'Situação',
            'com_codsituacao' => 'Situação',
            'com_dataautorizacao' => 'Data/Hora Autorização',
            'com_codcolaboradorautorizacao' => 'Autorizado por:',
            'com_codcargoautorizacao' => 'Cargo',
        ];
    }

    public function beforeSave($insert){
                if (parent::beforeSave($insert)) {
                if($insert){ 
                // Código a ser executado se for um insert
                $this->com_datasolicitacao = new Expression('current_timestamp');
                }
                // Código irá ser executado se for um insert ou update
                /*$this->com_dataautorizacao = new Expression('current_timestamp');*/
                return true;
                } else {
                return false;
                }
            }


    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getAnexocomunicacaoAne()
    {
        return $this->hasMany(AnexocomunicacaoAne::className(), ['ane_codcomunicacao' => 'com_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComCodsituacao()
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
    public function getDestinocomunicacaoDests()
    {
        return $this->hasMany(DestinocomunicacaoDest::className(), ['dest_codcomunicacao' => 'com_codcomunicacao']);
    }

    public function getUnidade()
    {
        return $this->hasOne(Unidade_uni::className(), ['uni_codunidade' => 'com_codunidade']);
    }

    public function getCargo()
    {
        return $this->hasOne(Cargos::className(), ['car_codcargo' => 'com_codcargoautorizacao']);
    }

    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'com_codcolaborador']);
    }

  public function getColaboradorAutorizacao()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'com_codcolaboradorautorizacao']);
    }  
}