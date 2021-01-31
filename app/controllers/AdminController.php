<?php
class AdminController extends Controller{
    public function __construct($controller, $action)
    {
        parent::__construct($controller,$action);
        $this->view->set_layout('admin_layout');
    }


    public function indexAction(){

        $this->view->set_title('AdminPanel');
        $valid = new Validation();
        if ($_POST){
            $valid->check($_POST,[
                'admin'=>[
                    'display'=>'Nom d\'Utilisateur',
                    'required'=>true,
                    'admin'=>$_POST['admin']
                ],
                'adminpasswd'=>[
                    'display'=>'Mot de pass',
                    'required'=>true,
                    'adminpasswd'=>$_POST['adminpasswd']
                ]
            ]);

            if ($valid->passed()){
                Sessions::set('admin',$_POST['admin']);
                Router::redirect('/admin/gestion');
            }

        }
        $this->view->displayErrors = $valid->displayErrors();
        $this->view->render('/admin/index');
    }

    public function updateAction(){
        $this->view->set_title('Mise à jour');
        $db = DB::getInstance();
        $this->view->ensarr = $db->requete("select * from enseignant",[])->result();
        $this->view->render('/admin/update');

    }

    public function gestionAction(){
        $this->view->set_title('Gestion des profiles');



        $valid = new Validation();
        if ($_POST){
            $valid->check($_POST,[
                'nom'=>[
                    'display'=>'Nom',
                    'required'=>true
                ],
                'prenom'=>[
                    'display'=>'Prenom',
                    'required'=>true
                ],
                'email'=>[
                    'display'=>'Email',
                    'required'=>'true',
                    'unique'=>'enseignant',
                    'valid_email'=>true
                ],
                'password'=>[
                    'display'=>'Mot de pase',
                    'required'=>true,
                    'min'=>8,
                    'password'=>true
                ],
                'confirmer'=>[
                    'display'=>'Confirmer votre mot de passe',
                    'required'=>true,
                    'matches'=>'password'
                ]
            ]);
            if ($valid->passed()){
                $ens = new Enseignant();
                $ens->registerNewTeacher($_POST);
                Router::redirect('/admin/gestion');
            }
        }
        $this->view->displayErrors = $valid->displayErrors();
        $this->view->render('/admin/gestion');
    }

    public function logoutAction(){
        Sessions::delete('admin');
        Router::redirect('/home/index');
    }

    public function autoupdateAction(){

        $db = DB::getInstance();

        $response = false;
        if ($_POST){
            $p = $_POST;
            if (isset($p["id"]) && isset($p["field"])){
                $table = 'enseignant';
                $id = $this->sanitize($p['id']);
                $field = $this->sanitize($p['field']);
                $value = $this->sanitize($p['value']);
                if ($field == 'password'){
                    $value = password_hash($value,PASSWORD_DEFAULT);
                }
                $db->requete("update enseignant set {$field} = ? where id = ?",[$value,$id]);
                $response = ['success'=>true];

            }
        }
        echo json_encode($response);
    }

    
}
