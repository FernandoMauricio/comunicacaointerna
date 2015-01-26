<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "despachocomunicacao_deco".
 *
 * @property string $deco_coddespacho
 * @property string $deco_codcomunicacao
 * @property integer $deco_codcolaborador
 * @property integer $deco_codunidade
 * @property integer $deco_codcargo
 * @property string $deco_data
 * @property string $deco_despacho
 * @property string $deco_codsituacao
 *
 * @property ComunicacaointernaCom $decoCodcomunicacao
 * @property SituacaodespachoSicho $decoCodsituacao
 */
class DespachocomunicacaoDeco extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'despachocomunicacao_deco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deco_codcomunicacao', 'deco_codcolaborador', 'deco_codunidade', 'deco_codcargo', 'deco_data', 'deco_codsituacao'], 'required'],
            [['deco_codcomunicacao', 'deco_codcolaborador', 'deco_codunidade', 'deco_codcargo', 'deco_codsituacao'], 'integer'],
            [['deco_data'], 'safe'],
            [['deco_despacho'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'deco_coddespacho' => 'Cód. Despacho',
            'deco_codcomunicacao' => 'Cód. Comunicação',
            'deco_codcolaborador' => 'Colaborador',
            'deco_codunidade' => 'Unidade/Setor',
            'deco_codcargo' => 'Cargo',
            'deco_data' => 'Data',
            'deco_despacho' => 'Despacho',
            'deco_codsituacao' => 'Situação',
            'com_titulo' => 'Título',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecoCodcomunicacao()
    {
        return $this->hasOne(ComunicacaointernaCom::className(), ['com_codcomunicacao' => 'deco_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecoCodsituacao()
    {
        return $this->hasOne(SituacaodespachoSicho::className(), ['sicho_codsituacao' => 'deco_codsituacao']);
    }
}
