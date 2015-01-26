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
 * @property integer $dest_codunidadedest
 * @property string $dest_data
 * @property string $dest_hora
 * @property string $dest_codtipo
 * @property string $dest_codsituacao
 *
 * @property ComunicacaointernaCom $destCodcomunicacao
 * @property SituacaodestinoSide $destCodsituacao
 * @property TipodestinoTipde $destCodtipo
 */
class DestinocomunicacaoDest extends \yii\db\ActiveRecord
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
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codunidadedest', 'dest_data', 'dest_hora', 'dest_codtipo', 'dest_codsituacao'], 'required'],
            [['dest_codcomunicacao', 'dest_codcolaborador', 'dest_codunidadeenvio', 'dest_codunidadedest', 'dest_codtipo', 'dest_codsituacao'], 'integer'],
            [['dest_data'], 'safe'],
            [['dest_hora'], 'string', 'max' => 12]
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
            'dest_codunidadedest' => 'Dest Codunidadedest',
            'dest_data' => 'Dest Data',
            'dest_hora' => 'Dest Hora',
            'dest_codtipo' => 'Dest Codtipo',
            'dest_codsituacao' => 'Dest Codsituacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestCodcomunicacao()
    {
        return $this->hasOne(ComunicacaointernaCom::className(), ['com_codcomunicacao' => 'dest_codcomunicacao']);
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
