<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id_categoria
 * @property string $nombre_categoria
 */
class Categoria extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
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
            [['nombre_categoria'], 'required'],
            [['id_categoria'], 'integer'],
            [['nombre_categoria'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(){
        return [
            'id_categoria' => 'Id categoria',
            'nombre_categoria' => 'Nombre de la categoria',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function getNombreCategoria(){
        return $this->nombre_categoria;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params){
        $query = Comentario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_comentario' => $this->id_categoria,
        ]);

        $query->andFilterWhere(['like', 'contenido_comentario', $this->nombre_categoria]);

        return $dataProvider;
    }
}