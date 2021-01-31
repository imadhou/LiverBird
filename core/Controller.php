<?php


class Controller
{
    protected $_controller, $_action;
    public $view;
    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View();
    }
    protected function load_model($model){
        if (class_exists($model)){
            $this->{$model.'Model'} = new $model(strtolower($model));
        }
    }
    public function sanitize($dirty){
        return htmlentities($dirty,ENT_QUOTES,'UTF-8');
    }

    public function jsonResponse($response){
        header("Access-Control-Allow-Origin:*");
        header("Content-Type: Application/json; charset=UTF-8");
        http_response_code(200);
        echo json_encode($response);
        exit;
    }
}