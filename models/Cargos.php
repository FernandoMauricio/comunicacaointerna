<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cargos_car".
 *
 * @property string $car_codcargo
 * @property string $car_cargo
 *
 * @property ColaboradorCol[] $colaboradorCols
 */
class Cargos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cargos_car';
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
            [['car_cargo'], 'required'],
            [['car_cargo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'car_codcargo' => 'Car Codcargo',
            'car_cargo' => 'Car Cargo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColaboradorCols()
    {
        return $this->hasMany(ColaboradorCol::className(), ['col_codcargo' => 'car_codcargo']);
    }
}
