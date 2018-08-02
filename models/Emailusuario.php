<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "emailusuario_emus".
 *
 * @property string $emus_codusuario
 * @property string $emus_email
 *
 * @property UsuarioUsu $emusCodusuario
 */
class Emailusuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'emailusuario_emus';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_base');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emus_codusuario', 'emus_email'], 'required'],
            [['emus_codusuario'], 'integer'],
            [['emus_email'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emus_codusuario' => 'Emus Codusuario',
            'emus_email' => 'Emus Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmusCodusuario()
    {
        return $this->hasOne(UsuarioUsu::className(), ['usu_codusuario' => 'emus_codusuario']);
    }
}
