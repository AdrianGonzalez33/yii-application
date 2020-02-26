<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormArticulo extends model{

    public $id_articulo;
    public $titulo;
    public $contenido;

    public function rules(){
        return [ ['id_articulo', 'integer', 'message' => 'Id incorrecto'],
            ['titulo', 'required', 'message' => 'Campo requerido'],
            ['titulo', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
            ['titulo', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
            ['contenido', 'required', 'message' => 'Campo requerido'],
        ];
    }
    public function attributeLabels(){
       return ['titulo'=>'Titulo','contenido'=>'Contenido',];
    }
}