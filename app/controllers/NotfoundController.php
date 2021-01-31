<?php
class NotfoundController extends Controller{
    public function __construct($controller,$action)
    {
        parent::__construct($controller, $action);
        $this->view->set_layout('default');
    }

    public function indexAction(){
        $this->view->render('notfound/index');
    }
}