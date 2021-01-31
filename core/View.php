<?php


class view
{
    protected $_head, $_body, $_siteTitle, $_outputBuffer, $_layout = DEFAULT_LAYOUT;
    public function __construct()
    {

    }

    public function render($view){
        $viewS = explode('/',$view);
        $view = implode(DS,$viewS);
        if (file_exists(ROOTE.DS.'app'.DS.'views'.DS.$view.'.php')){
            include(ROOTE.DS.'app'.DS.'views'.DS.$view.'.php');
            include(ROOTE.DS.'app'.DS.'views'.DS.'layouts'.DS.$this->_layout.'.php');
        }else{
            die(' l\'affichage' .$view. 'n\'existe pas');
        }
    }

    public function content($type){
        if ($type == 'head'){
            return $this->_head;
        }elseif ($type == 'body'){
            return $this->_body;
        }else{
            return false;
        }
    }

    public function start($type){
        $this->_outputBuffer = $type;
        ob_start();
    }

    public function end(){
        if ($this->_outputBuffer == 'head'){
            $this->_head = ob_get_clean();
        }elseif($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean();
        }else{
            die('vous n\'avez pas défini le début du contenu');
        }
    }

    public function set_title($titre){
        $this->_siteTitle = $titre;
    }

    public function set_layout($layout){
        $this->_layout = $layout;
    }
    public function site_title(){
        return $this->_siteTitle;
    }
}