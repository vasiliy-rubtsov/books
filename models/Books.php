<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use voskobovich\linker\LinkerBehavior;

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
 * @property Authors[] $authorsWithId
 */
class Books extends \yii\db\ActiveRecord
{

    public UploadedFile|string|null $photoImage = null;

    public function behaviors()
    {
        return [
            [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'authorIds' => 'authors',
                ],
            ],
        ];
    }

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
            [['photoImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif',  'maxSize' => 1024 * 1024 * 1],
            [['authorIds'], 'each', 'rule' => ['integer']],
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
        return $this->hasMany(
        Authors::class,
            ['id' => 'author_id']
        )->viaTable(
        'books_authors',
            ['book_id' => 'id']
        )->orderBy(['surname' => SORT_ASC]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // Выносим валидацию отдельно
        if ($runValidation && !$this->validate()) {
            return false;
        }

        if ($this->photoImage) {
            $filePath = Yii::getAlias('@webroot/uploads');
            $fileName = sprintf('%s.%s', uniqid('img_'), $this->photoImage->extension);
            $this->photo = $fileName;
            if (
                !(
                    BaseFileHelper::createDirectory($filePath)
                    && $this->photoImage->saveAs(sprintf('%s/%s', $filePath, $fileName))
                )
            ) {
                return false;
            }
        }

        return parent::save(false, $attributeNames);
    }

    /**
     * @return Authors[]
     */
    public function getAuthorsWithId(): array
    {
        $result = [];
        foreach ($this->authors as $author) {
            $result[$author->id] = $author;
        }

        return $result;
    }
}
