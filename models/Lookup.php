<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lookup".
 *
 * @property int $id
 * @property string $name
 * @property int $code
 * @property string $type
 * @property int $position
 */
class Lookup extends \yii\db\ActiveRecord
{
    private static $_items=[];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lookup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'position'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'type' => 'Type',
            'position' => 'Position',
        ];
    }

    public static function items($type)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }

    public static function item($type,$code)
    {
        if(!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    private static function loadItems($type)
    {
        self::$_items[$type]=[];
        $models=self::model()->findAll([
                'condition'=>'type=:type',
                'params'=>array(':type'=>$type),
                'order'=>'position',
        ]);
        foreach($models as $model)
            self::$_items[$type][$model->code]=$model->name;
    }
}
