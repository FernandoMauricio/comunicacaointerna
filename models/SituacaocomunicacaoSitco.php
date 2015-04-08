<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "situacaocomunicacao_sitco".
 *
 * @property string $sitco_codsituacao
 * @property string $sitco_situacao1
 * @property string $sitco_situacao2
 *
 * @property ComunicacaointernaCom[] $comunicacaointernaComs
 */
class SituacaocomunicacaoSitco extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'situacaocomunicacao_sitco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sitco_situacao1', 'sitco_situacao2'], 'required'],
            [['sitco_situacao1', 'sitco_situacao2'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sitco_codsituacao' => 'Sitco Codsituacao',
            'sitco_situacao1' => 'Sitco Situacao1',
            'sitco_situacao2' => 'Sitco Situacao2',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunicacaointernaComs()
    {
        return $this->hasMany(ComunicacaointernaCom::className(), ['com_codsituacao' => 'sitco_codsituacao']);
    }
}
