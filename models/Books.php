<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property int $year
 * @property string|null $annotation
 * @property string|null $photo
 *
 * @property Authors[] $authors
 */
class Books extends \yii\db\ActiveRecord
{

    public ?UploadedFile $photoImage = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['annotation', 'photo'], 'default', 'value' => null],
            [['title', 'isbn', 'year'], 'required'],
            [['year'], 'integer'],
            [['annotation'], 'string'],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
            [['photoImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif',  'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'isbn' => Yii::t('app', 'Isbn'),
            'year' => Yii::t('app', 'Year'),
            'annotation' => Yii::t('app', 'Annotation'),
            'photo' => Yii::t('app', 'Photo'),
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Authors::class, ['id' => 'author_id'])->viaTable('books_authors', ['book_id' => 'id'])->orderBy(['surname' => SORT_ASC]);
    }

}
