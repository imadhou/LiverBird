<?php


class EtudiantController extends Controller
{
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->view->set_layout('default');

    }

    public function indexAction($param = ''){
        $this->view->set_title('Etudiant');
        $db = DB::getInstance();
        $e = Etudiant::currentLoggedInStudent();
        if ($param == ''){
            $modules = $db->requete("select * from module ",[])->result();
            $this->view->modules = $modules;
            $this->view->render('/etudiant/index');
        }else{
            $mod = explode('_',$param);
            $module = '';
            foreach ($mod as $m){
                $module .= ucfirst($m).' ';
            }
            $module = trim($module);
            $this->view->set_title($module);


            $id_module = $db->requete("select id from module where nom = ?",[$module])->result();
            $cour = $db->requete("SELECT cours.id_enseignant,cours.id_module,cours.objectif, cours.prerequis, cours.description, enseignant.nom, enseignant.prenom FROM cours JOIN enseignant ON cours.id_enseignant = enseignant.id WHERE  cours.id_enseignant NOT IN (SELECT id_enseignant FROM suivre WHERE id_etudiant = ? and id_module = ?) AND cours.id_module = ?",[$e->id,$id_module[0]->id,$id_module[0]->id])->result();
            $this->view->cours = $cour;
            $this->view->module_name = $module;


            $this->view->render('/etudiant/cours_module');
        }

    }

    public function mescoursAction($cours=''){
        if ($cours == '') {
            $this->view->set_title('Mes cours');

            $db = DB::getInstance();
            $e = Etudiant::currentLoggedInStudent();
            $sql = "select module.nom as nom_module,cours.objectif, cours.prerequis, cours.id_module, cours.id_enseignant, cours.description, enseignant.nom, enseignant.prenom FROM cours JOIN suivre ON cours.id_enseignant = suivre.id_enseignant and cours.id_module = suivre.id_module JOIN module on suivre.id_module = module.id JOIN enseignant ON suivre.id_enseignant = enseignant.id AND suivre.id_etudiant = ?";
            $this->view->res = $db->requete($sql, [$e->id])->result();
            $this->view->id_etu = $e->id;
            $this->view->render('/etudiant/mescours');
        }
        else
        {
            $this->view->set_title('Mes cours');
            $e = Etudiant::currentLoggedInStudent();
            $db = DB::getInstance();
            $pieces = explode("_", $cours);
            $id_ensei = $pieces[0];
            $id_etu = $pieces[1];
            $id_modu = $pieces[2];

            $sect = $db->requete("select * from section where id_module = ? and id_enseignant = ? ",[$id_modu,$id_ensei])->result();
            $sectst = [];
            foreach ($sect as $value){
                $sections = [];
                $ev = $db->requete("select * from evenement where id_section = ?",[$value->id])->result();
                $ytb = $db->requete("select * from ressourceytb where id_section = ?",[$value->id])->result();
                $fch = $db->requete("select * from fichier where id_section = ?",[$value->id])->result();
                $sections[$value->intitule][] = $value->texte;
                $sections[$value->intitule][] = $ev;
                $sections[$value->intitule][] = $ytb;
                $sections[$value->intitule][] = $fch;
                $sectst[] = $sections;
            }
            $this->view->les_sections = $sectst;
            $this->view->ens = $id_ensei;
            $this->view->render('/etudiant/cour');
        }

    }
    public function inscrireAction(){
        if ($_POST){
            $a = explode('_',$_POST['ok']);
            $b = $a[0];
            $c = $a[1];
            $db = DB::getInstance();
            $etudiant = Etudiant::currentLoggedInStudent();
            $db->requete("insert into suivre values(?,?,?)",[$etudiant->id,$b,$c]);
            Router::redirect('/etudiant/index');

        }
    }
    public function profileAction(){
        $db = DB::getInstance();
        $etudiant = Etudiant::currentLoggedInStudent();
        $this->view->etudiant = $etudiant;
        $this->view->set_title('Profile');
        $this->view->h = [];
        if ($_POST){
            if ($_POST['pass1'] == "" || $_POST['pass2'] == "" || $_POST['pass3'] == ""){
                $h = "Tous les champs doivent être remplis!" ;
            }else{
                if ($pass1 = password_verify($_POST['pass1'],$etudiant->password)){
                    $validation = new Validation();
                    $validation->check($_POST,[
                        'pass1'=>[
                            'display'=>'Mot de passe actuel',
                            'required'=>true,
                            'password'=>true,
                            'min'=>8
                        ],
                        'pass2'=>[
                            'display'=>'Nouveau mot de passe',
                            'required'=>true,
                            'password'=>true,
                            'min'=>8
                        ],
                        'pass3'=>[
                            'display'=>'confirmation du nouveau mot de passe',
                            'required'=>true,
                            'min'=>8,
                            'matches'=>'pass2'
                        ]
                    ]);
                    if ($validation->passed()){
                        $pass2 = $_POST['pass2'];
                        $password = password_hash($pass2,PASSWORD_DEFAULT);
                        $etudiant->password = $password;
                        $etudiant->save();
                        $h ="La modification est faite avec succes!";
                    }else{
                        $h = $validation->displayErrors();
                    }
                }else{
                    $h = "Vuillez introduire votre mot de passe actuel, sinon contactez votre admin!";
                }
            }
            $this->view->h[] = $h;
        }
        $this->view->render('etudiant/profile');
    }


    public function eventsAction(){
        $this->view->etudiant = Etudiant::currentLoggedInStudent();
        $this->view->set_title('Mes Evenements');
        $db = DB::getInstance();
        $etudiant = Etudiant::currentLoggedInStudent();

        if ($_POST){
            $t = [];
            if (isset($_POST['module'])){
                $events = $db->requete("SELECT evenement.id ,evenement.intitule,evenement.description, enseignant.nom, enseignant.prenom, module.nom FROM evenement JOIN section ON evenement.id_section = section.id JOIN suivre ON section.id_module = suivre.id_module AND section.id_enseignant = suivre.id_enseignant JOIN enseignant ON suivre.id_enseignant = enseignant.id JOIN module ON module.id = suivre.id_module WHERE suivre.id_etudiant = ? and suivre.id_module = ? AND evenement.date_limite >= CURDATE()",[$etudiant->id,$_POST['module']])->result();
                foreach ($events as $event){
                    $rep = $db->requete("select lien_fichier from reponse_evenement where id_event = ? and id_etudiant = ?",[$event->id,$etudiant->id])->result();
                    if (!empty($rep)){
                        array_shift($events);
                    }
                }
                $notes = $db->requete("SELECT DISTINCT evenement.intitule, module.nom as module , enseignant.nom, enseignant.prenom, reponse_evenement.note, reponse_evenement.lien_fichier, reponse_evenement.id FROM reponse_evenement JOIN evenement ON reponse_evenement.id_event = evenement.id JOIN section ON evenement.id_section = section.id JOIN suivre ON section.id_enseignant = suivre.id_enseignant JOIN enseignant ON suivre.id_enseignant= enseignant.id JOIN module ON module.id = suivre.id_module WHERE reponse_evenement.id_etudiant = ? AND section.id_module = ? AND reponse_evenement.lien_fichier !='' GROUP by  evenement.intitule ",[$etudiant->id,$_POST['module']])->result();
                $this->view->notes = $notes;
                $this->view->events = $events;
            }
            $this->view->error= [];
            if (isset($_POST['ok'])){
                if (isset($_FILES)){
                    $name = $_FILES['fichier']['name'];
                    $tmp_name = $_FILES['fichier']['tmp_name'];
                    $size = $_FILES['fichier']['size'];
                    $type = $_FILES['fichier']['type'];

                    if ($type != "application/pdf" && $type != 'application/txt' && $type != 'application/doc' && $type != 'application/odt') {
                        $this->view->error[] = 'Erreur lors de l\'import de vos fichier  Le format doit etre: .txt/.odt/.pdf/.doc ! ';
                    }
                    if ($size > 10000000) {
                        $this->view->error[] = 'La taille des fichier ne doit pas dépasser 10MO chaqu\'un';
                    }
                    if (empty($this->view->error)) {
                        if (move_uploaded_file($tmp_name, ROOTE . '/cours/etudiant/'.$etudiant->id .'/'. $name)) {
                            $db->requete("insert into reponse_evenement (lien_fichier,id_event,id_etudiant) values (?,?,?)",[$name,$_POST['ok'],$etudiant->id]);
                        }
                        $this->view->error = ["Enregistrer avec succés"];
                    }else{
                        $this->view->error [] = "Une erreure est produite, réesseyer plus tard";
                    }
                }
            }
        }



        $modules = $db->requete("SELECT DISTINCT module.nom, module.id FROM module JOIN suivre on module.id = suivre.id_module AND suivre.id_etudiant = ?",[$etudiant->id])->result();
        $this->view->modules = $modules;
        $this->view->render('etudiant/events');
    }



}