<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodocumentacao_tipdo".
 *
 * @property string $tipdo_codtipo
 * @property string $tipdo_tipo
 *
 * @property Comunicacaointerna[] $Comunicacaointernas
 * @property ProtocoloPro[] $protocoloPros
 */
class TipodocumentacaoTipdo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipodocumentacao_tipdo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipdo_tipo'], 'required'],
            [['tipdo_tipo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tipdo_codtipo' => 'Tipdo Codtipo',
            'tipdo_tipo' => 'Tipdo Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComunicacaointernas()
    {
        return $this->hasMany(Comunicacaointerna::className(), ['com_codtipo' => 'tipdo_codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProtocoloPros()
    {
        return $this->hasMany(ProtocoloPro::className(), ['pro_codtipo' => 'tipdo_codtipo']);
    }
}
