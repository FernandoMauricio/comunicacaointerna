<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunicacaointerna_com".
 *
 * @property string $com_codcomunicacao
 * @property integer $com_codcolaborador
 * @property integer $com_codunidade
 * @property string $com_datasolicitacao
 * @property string $com_ip
 * @property string $com_titulo
 * @property string $com_texto
 * @property string $com_codtipo
 * @property string $com_codsituacao
 * @property string $com_dataautorizacao
 * @property integer $com_codcolaboradorautorizacao
 * @property integer $com_codcargoautorizacao
 *
 * @property AnexocomunicacaoAne[] $anexocomunicacaoAnes
 * @property TipodocumentacaoTipdo $comCodtipo
 * @property SituacaocomunicacaoSitco $comCodsituacao
 * @property DespachocomunicacaoDeco[] $despachocomunicacaoDecos
 * @property DestinocomunicacaoDest[] $destinocomunicacaoDests
 */
class ComunicacaointernaCom extends \yii\db\ActiveRecord
{
    
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
            [['com_codcolaborador', 'com_codunidade', 'com_codtipo', 'com_codsituacao', 'com_codcolaboradorautorizacao', 'com_codcargoautorizacao'], 'integer'],
            [['com_dataautorizacao'], 'safe'],
            [['com_datasolicitacao'], 'date'],
            [['com_texto'], 'string'],
            [['com_titulo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'com_codcomunicacao' => 'Código',
            'com_codcolaborador' => 'Colaborador',
            'com_codunidade' => 'Unidade',
            'com_datasolicitacao' => 'Data Solicitação',
            'com_titulo' => 'Título',
            'com_texto' => 'Texto Despacho',
            'com_codtipo' => 'Tipo de Documento',
            'com_codsituacao' => 'Situação',
            'com_dataautorizacao' => 'Data Autorização',
            'com_codcolaboradorautorizacao' => 'Autorizado Por:',
        ];
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
    public function getComCodtipo()
    {
        return $this->hasOne(TipodocumentacaoTipdo::className(), ['tipdo_codtipo' => 'com_codtipo']);
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
}
