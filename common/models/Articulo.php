<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "articulo".
 *
 * @property int $id_articulo
 * @property string $titulo
 * @property string $contenido
 * @property string $autor
 * @property string $imagen
 * @property string $categoria
 * @property boolean $popular
 * @property int $creado
 * @property int $modificado
 */
class Articulo extends ActiveRecord{
    public $archivo;
    /**
     * {@inheritdoc}
     */
    public static function tableName(){
        return 'articulo';
    }

    public static function getDb(){
        return Yii::$app->db;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(){
        return [
            [['titulo', 'contenido', 'autor', 'archivo','categoria'], 'required'],
            [['id_articulo'], 'integer'],
            [['archivo'], 'file'],
            [['titulo'], 'string', 'max' => 250],
            [['autor', 'categoria'], 'string', 'max' => 50],
            [['imagen'], 'string', 'max' => 250],
            [['contenido'], 'string'],
            [['popular'], 'boolean'],
            [['archivo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxSize' => 1024*1024*10, 'tooBig' => 'El límite son 10MB'],
            [['titulo', 'contenido', 'autor', 'archivo', 'categoria'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(){
        return [
            'id_articulo' => 'Id Articulo',
            'titulo' => 'Titulo',
            'contenido' => 'Contenido',
            'autor' => 'Autor',
            'imagen'=> 'Imagen',
            'categoria' => 'Categoria',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
            'popular' => 'Popular',
        ];
    }

    /**
     * @property int $id_articulo
     */
    public function getId(){
        return $this->getPrimaryKey();
    }

    /**
     * @property String $titulo
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * @property String $contenido
     */
    public function getContenido(){
        return $this->contenido;
    }

    /**
     * @property String $autor
     */
    public function getAutor(){
        return $this->autor;
    }

    /**
     * @property String $imagen
     */
    public function getImagen(){
        return $this->imagen;
    }

    /**
     * @property String $categoria
     */
    public function getCategoria(){
        return $this->categoria;
    }

    /**
     * @property boolean $popular
     */
    public function getPopular(){
        return $this->popular;
    }

    /**
     * @property int $creado
     */
    public function getCreado(){
        return $this->creado;
    }
    /**
     * @property int $modificado
     */
    public function getModificado(){
        return $this->modificado;
    }

    public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params){
        $query = Articulo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider(['query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_articulo' => $this->id_articulo,
        ]);


        $query->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'contenido', $this->contenido])
            ->andFilterWhere(['like', 'autor', $this->autor])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'categoria', $this->categoria])
            ->andFilterWhere(['like', 'creado', $this->creado])
            ->andFilterWhere(['like', 'modificado', $this->modificado])
            ->andFilterWhere(['like', 'popular', $this->popular]);

        return $dataProvider;
    }
}
