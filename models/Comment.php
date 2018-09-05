<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $author
 * @property string $email
 * @property string $content
 * @property int $status
 * @property string $url
 * @property string $create_time
 * @property int $post_id
 *
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'author', 'email'], 'required'],
            [['author', 'email', 'url'], 'string', 'max'=>128],
            ['email','email'],
            [['status', 'post_id'], 'integer'],
            [['create_time'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'email' => 'Email',
            'content' => 'Content',
            'status' => 'Status',
            'url' => 'Url',
            'create_time' => 'Create Time',
            'post_id' => 'Post',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        } else {
            if ($this->isNewRecord) {
                $this->create_time=date('Y-m-d');
            }
            return true;
        }

    }
}
