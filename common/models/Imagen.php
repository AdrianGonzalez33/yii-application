<?php


namespace common\models;
use yii\db\ActiveRecord;

class Imagen extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => 'png, jpg', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, [ 'id' => 'id_category' ]);
    }
    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'file',
                'scenarios' => ['insert', 'update'],
                'path' => '@webroot/upload/docs/{category.id}',
                'url' => '@web/upload/docs/{category.id}',
            ],
        ];
    }
}