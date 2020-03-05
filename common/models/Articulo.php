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
 * @property int $creado
 * @property int $modificado
 */
class Articulo extends ActiveRecord{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName(){
        return 'articulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(){
        return [
            [['titulo', 'contenido', 'autor', 'imagen', 'categoria'], 'required'],
            [['id_articulo'], 'integer'],
            [['titulo', 'autor', 'categoria'], 'string', 'max' => 50],
            [['imagen'], 'string', 'max' => 250],
            [['contenido'], 'string'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['titulo', 'contenido', 'autor', 'imagen', 'categoria'], 'safe'],

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
            'file'=> 'Imagen',
            'categoria' => 'Categoria',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
        ];
    }

    /**
     * @property int $id_articulo
     */
    public function getId(){
        return $this->getPrimaryKey();
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
            ->andFilterWhere(['like', 'modificado', $this->modificado]);

        return $dataProvider;
    }
}
