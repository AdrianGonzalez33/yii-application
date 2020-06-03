<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id_categoria
 * @property string $nombre_categoria
 * @property string $imagen
 */
class Categoria extends ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName(){
        return 'categoria';
    }
    public static function getDb(){
        return Yii::$app->db;
    }

    /**
     * {@inheritdoc}
     */

    public function rules() {
        return [
            [['nombre_categoria','imagen'], 'required'],
            [['id_categoria'], 'integer'],
            [['nombre_categoria','imagen'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(){
        return [
            'id_categoria' => 'Id categoria',
            'nombre_categoria' => 'Nombre de la categoria',
            'imagen'=> 'Imagen URL',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    /**
     * @property int $id_categoria
     */
    public function getId(){
        return $this->getPrimaryKey();
    }

    public function getNombreCategoria(){
        return $this->nombre_categoria;
    }

    public function getImagen(){
        return $this->imagen;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params){
        $query = Categoria::find();

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
            'id_categoria' => $this->id_categoria,
        ]);


        // grid filtering conditions
        $query->andFilterWhere(['like', 'nombre_categoria', $this->nombre_categoria])
            ->andFilterWhere(['like', 'imagen', $this->imagen]);

        return $dataProvider;
    }
}