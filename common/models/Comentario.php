<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id_comentario
 * @property int $id_articulo
 * @property int $id_user
 * @property int|null $id_padre
 * @property boolean $verificado
 * @property string $contenido_comentario
 * @property int|null $creado
 * @property int|null $modificado
 */
class Comentario extends \yii\db\ActiveRecord {
    public $reCaptcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'comentario';
    }
    public static function getDb()
    {
        return Yii::$app->db;
    }

    /**
     * {@inheritdoc}
     */

    public function rules() {
        return [
            [['id_articulo', 'id_user', 'contenido_comentario'], 'required'],
            [['id_comentario', 'id_articulo', 'id_user', 'id_padre', 'creado', 'modificado'], 'integer'],
            [['contenido_comentario'], 'safe'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::className(),
                'secret' => '6LcFb-0UAAAAAGTEZRv30i9uXAJ2DsrkyUyQ7SSv', // unnecessary if reСaptcha is already configured
                'uncheckedMessage' => 'Please confirm that you are not a bot.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(){
        return [
            'id_comentario' => 'Id Comentario',
            'id_articulo' => 'Id Articulo',
            'id_user' => 'Id User',
            'id_padre' => 'Id Padre',
            'verificado'=> 'Verificado',
            'contenido_comentario' => 'Contenido Comentario',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function getIdUser(){
            return $this->id_user;
    }
    public function getConenido(){
        return $this->contenido_comentario;
    }
    public function getPadre(){
        return $this->id_padre;
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
            'id_comentario' => $this->id_comentario,
            'id_articulo' => $this->id_articulo,
            'id_user' => $this->id_user,
            'id_padre' => $this->id_padre,
            'creado' => $this->creado,
            'modificado' => $this->modificado,
        ]);

        $query->andFilterWhere(['like', 'contenido_comentario', $this->contenido_comentario]);

        return $dataProvider;
    }
}
