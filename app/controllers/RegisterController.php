<?php


class RegisterController extends Controller
{
    public $error = '', $db;

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->view->set_layout('default');
        $this->db = DB::getInstance();
        $this->load_model('Etudiant');
        $this->load_model('Enseignant');

    }

    public function loginAction()
    {
        $this->view->set_title('Connectez vous');
        $az = '';
        $valide = new Validation();
        if ($_POST) {
            $valide->check($_POST,[
                'email'=>[
                    'display'=>'Email',
                    'required'=>'true',
                    'valid_email'=>true
                ],
                'password'=>[
                    'display'=>'Mot de pase',
                    'required'=>true,
                    'password'=>true,
                    'min'=>8
                ],
                'usertype'=>[
                    'display'=>'Type d\'utilisateur',
                    'required'=>true
                ]
            ]);

            if ($valide->passed()){


                $email = $this->sanitize($_POST['email']);
                $typeU = (isset($_POST['usertype'])) ? $this->sanitize($_POST['usertype']) : '';
                $table = strtolower($typeU);

                //voir si le clent a un compte ou pas

                switch ($table){
                    case 'etudiant':
                        $etudiant = $this->EtudiantModel->findByEmail($email);
                        if ($etudiant){
                            if (password_verify($_POST['password'],$etudiant->password)){
                                $remember = isset($_POST['se_souvenir_de_moi']) && $_POST['se_souvenir_de_moi']== 'se_souvenir';
                                $etudiant = new Etudiant($etudiant->id);
                                $etudiant->login($remember);
                                $h = 1 ;
                            }else{
                                $h = 0;
                                $az = "<ul><li class='text-danger'> Verifiez bien vos identifiant! </li></ul>";
                            }
                            if ($h == 1){
                                Router::redirect('/etudiant/index');
                            }
                        }
                        break;
                    case 'enseignant':
                        $enseignant = $this->EnseignantModel->findByEmail($email);
                        if ($enseignant){
                            if (password_verify($_POST['password'],$enseignant->password)){
                                $remember = isset($_POST['se_souvenir_de_moi'] )&& $_POST['se_souvenir_de_moi'] == 'se_souvenir';
                                $enseignant = new Enseignant($enseignant->id);
                                $enseignant->login($remember);
                                $h = 1 ;
                            }else{
                                $h = 0;
                                $az = "<ul><li class='text-danger'> Verifiez bien vos identifiant! </li></ul>";
                            }
                            if ($h == 1){
                                Router::redirect('/enseignant/index');
                            }
                        }
                        break;
                }
            }
        }
        $this->view->displayErrors = $valide->displayErrors();
        if ($az != ''){
            $this->view->displayErrors = $az;
        }
        $this->view->render('register/login');
    }

    public function registerAction()
    {
        $this->view->set_title('Eregistrez vous');
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
                    'unique'=>'etudiant',
                    'valid_email'=>true
                ],
                'password'=>[
                    'display'=>'Mot de pase',
                    'required'=>true,
                    'password'=>true,
                    'min'=>8
                ],
                'confirmer'=>[
                    'display'=>'Confirmer votre mot de passe',
                    'required'=>true,
                    'matches'=>'password'
                ]
            ]);
            if ($valid->passed()){
                $etu = new Etudiant();
                $etu->registerNewStudent($_POST);
                Router::redirect('/register/login');
            }

        }
        $this->view->displayErrors = $valid->displayErrors();
        $this->view->render('register/register');
    }

    public function logoutAction()
    {
        
        if (Etudiant::currentLoggedInStudent()) {
        Etudiant::currentLoggedInStudent()->logout();
        }else{
            Enseignant::currentLoggedInTeacher()->logout();
        }
        Router::redirect('/');
        
    }
}