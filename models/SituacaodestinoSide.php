<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "situacaodestino_side".
 *
 * @property string $side_codsituacao
 * @property string $side_situacao
 *
 * @property DestinocomunicacaoDest[] $destinocomunicacaoDests
 * @property DestinoprotocoloDepro[] $destinoprotocoloDepros
 */
class SituacaodestinoSide extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'situacaodestino_side';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['side_situacao'], 'required'],
            [['side_situacao'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'side_codsituacao' => 'Side Codsituacao',
            'side_situacao' => 'Side Situacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinocomunicacaoDests()
    {
        return $this->hasMany(DestinocomunicacaoDest::className(), ['dest_codsituacao' => 'side_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinoprotocoloDepros()
    {
        return $this->hasMany(DestinoprotocoloDepro::className(), ['depro_codsituacao' => 'side_codsituacao']);
    }
}
