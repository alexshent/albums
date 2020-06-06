<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Photo".
 *
 * @property int $id
 * @property int $album_id
 * @property string $title
 * @property string $url
 *
 * @property Album $album
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['album_id', 'title', 'url'], 'required'],
            [['album_id'], 'integer'],
            [['title', 'url'], 'string', 'max' => 128],
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['album_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'title' => 'Title',
            'url' => 'Url',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByTitle($title) {
		return static::findOne(['title' => $title]);
	}

    /**
     * Gets query for [[Album]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'album_id']);
    }
}
