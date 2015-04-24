<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anexocomunicacao_ane".
 *
 * @property string $ane_codanexo
 * @property string $ane_codcomunicacao
 * @property string $ane_arquivo
 *
 * @property Comunicacaointerna $aneCodcomunicacao
 */
class AnexosModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anexocomunicacao_ane';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ane_codcomunicacao', 'ane_arquivo'], 'required'],
            [['ane_codcomunicacao'], 'integer'],
            [['ane_arquivo'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ane_codanexo' => 'Ane Codanexo',
            'ane_codcomunicacao' => 'Ane Codcomunicacao',
            'ane_arquivo' => 'Ane Arquivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAneCodcomunicacao()
    {
        return $this->hasOne(Comunicacaointerna::className(), ['com_codcomunicacao' => 'ane_codcomunicacao']);
    }
}
