<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property string $tags
 * @property string $create_time
 * @property string $update_time
 * @property int $author_id
 *
 * @property Comment[] $comments
 * @property User $author
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT=1;
    const STATUS_PUBLISHED=2;
    const STATUS_ARCHIVED=3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status'], 'required'],
            [['title'], 'string', 'max' => 128],
            [['status'], 'in', 'range' => [1,2,3]],
            [['tags'], 'match', 'pattern' => '/^[\w\s,]+$/', 'message' => 'В тегах можно использовать только буквы.'],
            [['title, status'], 'safe', 'on'=>'search'],
            [['tags'], 'normalizeTags'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'tags' => 'Tags',
        ];
    }

    public function normalizeTags($tags)
    {
        $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getUrl()
    {
        return Url::to('post/view', [
                'id'=>$this->id,
                'title'=>$this->title,
        ]);
    }

    /**
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        } else {
            if($this->isNewRecord)
            {
                $this->create_time=$this->update_time=date('Y-m-d');
                $this->author_id=Yii::$app->user->id;
            }
            else
                $this->update_time=date('Y-m-d');
            return true;
        }

    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        (new Tag)->updateFrequency($this->_oldTags, $this->tags);
    }

    private $_oldTags;

    public function afterFind()
    {
        parent::afterFind();
        $this->_oldTags=$this->tags;
    }

    public function commentCount()
    {
        return count($this->comments);
    }
}
