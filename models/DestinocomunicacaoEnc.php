<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "destinocomunicacao_dest".
 *
 * @property string $dest_coddestino
 * @property string $dest_codcomunicacao
 * @property integer $dest_codcolaborador
 * @property integer $dest_codunidadeenvio
 * @property string $dest_data
 * @property string $dest_codtipo
 * @property string $dest_codsituacao
 * @property string $dest_coddespacho
 * @property string $dest_nomeunidadeenvio
 * @property string $dest_nomeunidadedest
 *
 * @property ComunicacaointernaCom $destCodcomunicacao
 * @property SituacaodestinoSide $destCodsituacao
 * @property TipodestinoTipde $destCodtipo
 */
class DestinocomunicacaoEnc extends \yii\db\ActiveRecord
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
            [['dest_codcomunicacao', 'dest_nomeunidadedest','dest_codsituacao','dest_coddespacho'], 'unique', 'targetAttribute' => ['dest_codcomunicacao', 'dest_nomeunidadedest', 'dest_codsituacao', 'dest_coddespacho']],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio','dest_codtipo', 'dest_codsituacao'], 'required'],
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
            'dest_coddestino' => 'Dest Coddestino',
            'dest_codcomunicacao' => 'Dest Codcomunicacao',
            'dest_codcolaborador' => 'Dest Codcolaborador',
            'dest_codunidadeenvio' => 'Dest Codunidadeenvio',
            'dest_data' => 'Dest Data',
            'dest_codtipo' => 'Dest Codtipo',
            'dest_codsituacao' => 'Dest Codsituacao',
            'dest_coddespacho' => 'Dest Coddespacho',
            'dest_nomeunidadeenvio' => 'Dest Nomeunidadeenvio',
            'dest_nomeunidadedest' => 'Encaminhar Para:',
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
}
