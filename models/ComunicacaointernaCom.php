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
            [['com_datasolicitacao', 'com_dataautorizacao'], 'safe'],
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
            'com_codcomunicacao' => 'Com Codcomunicacao',
            'com_codcolaborador' => 'Com Codcolaborador',
            'com_codunidade' => 'Com Codunidade',
            'com_datasolicitacao' => 'Com Datasolicitacao',
            'com_titulo' => 'Com Titulo',
            'com_texto' => 'Com Texto',
            'com_codtipo' => 'Com Codtipo',
            'com_codsituacao' => 'Com Codsituacao',
            'com_dataautorizacao' => 'Com Dataautorizacao',
            'com_codcolaboradorautorizacao' => 'Com Codcolaboradorautorizacao',
            'com_codcargoautorizacao' => 'Com Codcargoautorizacao',
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
}
