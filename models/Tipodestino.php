<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodestino_tipde".
 *
 * @property string $tipde_codtipo
 * @property string $tipde_descricao
 *
 * @property DestinocomunicacaoDest[] $destinocomunicacaoDests
 */
class Tipodestino extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipodestino_tipde';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipde_descricao'], 'required'],
            [['tipde_descricao'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tipde_codtipo' => 'Tipde Codtipo',
            'tipde_descricao' => 'Tipde Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinocomunicacaoDests()
    {
        return $this->hasMany(DestinocomunicacaoDest::className(), ['dest_codtipo' => 'tipde_codtipo']);
    }
}
