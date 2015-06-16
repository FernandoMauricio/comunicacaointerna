<?php

namespace app\models;

use Yii;
use yii\db\Expression;


/**
 * This is the model class for table "destinocomunicacao_dest".
 *
 * @property string $dest_coddestino
 * @property string $dest_codcomunicacao
 * @property integer $dest_codcolaborador
 * @property integer $dest_codunidadeenvio
 * @property integer $dest_codunidadedest
 * @property string $dest_data
 * @property string $dest_codtipo
 * @property string $dest_codsituacao
 *
 * @property Comunicacaointerna $destCodcomunicacao
 * @property SituacaodestinoSide $destCodsituacao
 * @property TipodestinoTipde $destCodtipo
 */
class Destinocomunicacao extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destinocomunicacao_dest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dest_codcomunicacao', 'dest_nomeunidadedest'], 'unique', 'targetAttribute' => ['dest_codcomunicacao', 'dest_nomeunidadedest']],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio','dest_codtipo', 'dest_codsituacao', 'dest_nomeunidadedest'], 'required'],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codtipo', 'dest_codsituacao'], 'integer'],
            [['dest_nomeunidadeenvio','dest_nomeunidadedest'],  'string', 'max' => 100 ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dest_coddestino' => 'Código Destino',
            'dest_codcomunicacao' => 'Cód. Comunicação',
            'dest_codcolaborador' => 'Código Colaborador',
            'dest_codunidadeenvio' => 'Código da Unidade',
            'dest_data' => 'Data/Hora',
            'dest_codtipo' => 'Tipo',
            'dest_codsituacao' => 'Situação',
            'dest_nomeunidadeenvio' => 'Unidade Remetente',
            'dest_nomeunidadedest' => 'Destino', 
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunicacaointerna()
    {
        return $this->hasOne(Comunicacaointerna::className(), ['com_codcomunicacao' => 'dest_codcomunicacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestCodsituacao()
    {
        return $this->hasOne(SituacaodestinoSide::className(), ['side_codsituacao' => 'dest_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestCodtipo()
    {
        return $this->hasOne(TipodestinoTipde::className(), ['tipde_codtipo' => 'dest_codtipo']);
    }

    public function getUnidades()
    {
        return $this->hasOne(Unidades::className(),['uni_nomeabreviado' => 'dest_nomeunidadedest']);
    }

    // public function getDespacho()
    // {
    //     return $this->hasOne(Despachos::className(), ['deco_coddespacho' => 'dest_coddespacho']);
    // }
}

