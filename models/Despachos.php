<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "despachocomunicacao_deco".
 *
 * @property integer $deco_coddespacho
 * @property integer $deco_codcomunicacao
 * @property integer $deco_codcolaborador
 * @property integer $deco_codunidade
 * @property integer $deco_codcargo
 * @property string $deco_data
 * @property string $deco_hora
 * @property string $deco_despacho
 * @property integer $deco_codsituacao
 * @property string $deco_nomeunidade
 * @property string $deco_nomeusuario
 *
 * @property AnexodespachoAnde[] $anexodespachoAndes
 * @property ComunicacaointernaCom $decoCodcomunicacao
 * @property SituacaodespachoSicho $decoCodsituacao
 */
class Despachos extends \yii\db\ActiveRecord
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
            [['deco_despacho'], 'string'],
            [['deco_nomeunidade', 'deco_nomeusuario', 'deco_cargo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deco_coddespacho' => 'Cód. Despacho',
            'deco_codcomunicacao' => 'Cód. Comunicação',
            'deco_codcolaborador' => 'Cód. Colaborador',
            'deco_codunidade' => 'Cód. Unidade',
            'deco_codcargo' => 'Cargo',
            'deco_data' => 'Data',
            'deco_despacho' => 'Despacho',
            'deco_codsituacao' => 'Situação',
            'deco_nomeunidade' => 'Nome Unidade',
            'deco_nomeusuario' => 'Nome Usuário',
            'deco_cargo' => 'Cargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnexodespachoAndes()
    {
        return $this->hasMany(AnexodespachoAnde::className(), ['ande_coddespacho' => 'deco_coddespacho']);
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
