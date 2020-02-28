<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "articulo".
 *
 * @property int $id_articulo
 * @property string $titulo
 * @property string $contenido
 * @property string $autor
 */
class Articulo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'contenido', 'autor'], 'required'],
            [['titulo', 'autor'], 'string', 'max' => 50],
            [['contenido'], 'string', 'max' => 250],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_articulo' => 'Id Articulo',
            'titulo' => 'Titulo',
            'contenido' => 'Contenido',
            'autor' => 'Autor',
        ];
    }
}
