<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tags)
    {
        return preg_split('/[\s,]+/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
        return implode(', ',$tags);
    }

    public function updateFrequency($oldTags, $newTags)
    {
        $oldTags=self::string2array($oldTags);
        $newTags=self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags,$oldTags)));
        $this->removeTags(array_values(array_diff($oldTags,$newTags)));
    }

    public function addTags($tags)
    {
        foreach($tags as $name) {
            if($tag = Tag::findOne(['name' => $name])) {
                $tag->updateCounters(['frequency' => 1]);
            } else {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
        }
    }
    public function removeTags($tags)
    {
        if(empty($tags))
            return;
        foreach($tags as $name) {
            $tag = Tag::findOne(['name' => $name]);
            $tag->updateCounters(['frequency' => -1]);
            $tag->deleteAll('frequency<=0');
        }
    }
}
