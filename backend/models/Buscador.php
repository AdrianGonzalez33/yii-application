<?php
namespace app\models;
use yii\base\model;

class Buscador extends model{
    public $busqueda;

    public function rules()
    {
        return [
            ["busqueda", "match", "pattern" => "/^[0-9a-záéíóúñ\s]+$/i", "message" => "Sólo se aceptan letras y números"]
        ];
    }

    public function attributeLabels()
    {
        return [
            'busqueda' => "Buscar:",
        ];
    }
}