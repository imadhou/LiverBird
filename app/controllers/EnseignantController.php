<?php


class EnseignantController extends Controller
{
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->view->set_layout('default');
        $this->load_model('Enseignant');
    }

    public function indexAction(){
        $this->view->set_title('Enseignant');
        $db = DB::getInstance();
        $e = Enseignant::currentLoggedInTeacher();
        $this->view->ens = $e;
        if ($_POST){
            $module = htmlentities($_POST['enregistrer']);
            $objectif = htmlentities($_POST['objectif']);
            $prerequis = htmlentities($_POST['prerequis']);
            $description = htmlentities($_POST['description']);
            $sql1 = "insert into cours values(?,?,?,?,?)";
            $db->requete($sql1,[$objectif,$prerequis,$description,$e->id,$module]);
            Router::redirect('/enseignant/mescours/'.$_POST['lien']);
        }
        $sql = "SELECT * FROM module where module.id NOT IN (SELECT id_module FROM cours WHERE id_enseignant =?); ";
        $this->view->res = $db->requete($sql, [$e->id])->result();
        $this->view->render('/enseignant/index');
    }


    public function mescoursAction($param = ''){

        $this->view->set_title('Mes cours');
        $ensegnant = Enseignant::currentLoggedInTeacher();
        $db = DB::getInstance();

        if ($param == ''){
            $crs = $db->requete("select * from cours where id_enseignant = ?",[$ensegnant->id])->result();
            $i = 0;
            foreach ($crs as $cour){
                $crs = (array)$crs;
                $crs[$i]->nom = $db->requete("select nom from module where id = ?",[$cour->id_module])->first()->nom;
                $crs[$i]->lien = $db->requete("select lien from module where id = ?",[$cour->id_module])->first()->lien;
                $i++;
            }
            $this->view->cours = $crs;
            $this->view->render('/enseignant/mescours');
        }
        else{
            $mod = explode('_',$param);
            $module = '';
            foreach ($mod as $m){
                $module .= ucfirst($m).' ';
            }
            $module = trim($module);
            $this->view->set_title($module);
            $id_module = $db->requete("select id from module where nom = ?",[$module])->first();
            $this->view->error = [];

            if ($_POST){

                if (isset($_POST['sect-name'])){
                    $db->requete("insert into section (intitule,texte,id_module, id_enseignant) values(?,?,?,?)",[$_POST['sect-name'],$_POST['description'],$id_module->id,$ensegnant->id]);
                    $section = $db->requete("select max(id) as m from section where id_module = ? and id_enseignant = ?",[$id_module->id,$ensegnant->id])->result()[0];
                    if ($_POST['event-name'] !=''){
                        $db->requete("insert into evenement(intitule,description, date_limite, id_section) values(?,?,?,?)",[$_POST['event-name'],$_POST['event-desc'],$_POST['event-date'],$section->m]);
                    }
                    foreach ($_POST as $p=>$v){
                        if (strpos($p,'tab') === 0){
                            $arr[$p]= $v;
                        }
                    }
                    if (!empty($arr)){
                        foreach ($arr as $k=>$v){
                            $db->requete("insert into ressourceytb(lien, id_section) values (?,?)",[$v,$section->m]);
                        }
                    }


                    if ($_FILES['fichier']['name'][0]!=""){
                        $file = $_FILES;
                        $n = sizeof($file['fichier']['name']);
                        for ($i = 0; $i<$n; $i++) {
                            $name = $file['fichier']['name'][$i];
                            $tmp_name = $file['fichier']['tmp_name'][$i];
                            $type = $file['fichier']['type'][$i];
                            $size = $file['fichier']['size'][$i];
                            if ($type != "application/pdf" && $type != 'application/txt' && $type != 'application/doc' && $type != 'application/odt') {
                                $this->view->error[] = 'Erreur lors de l\'import de vos fichier  Le format doit etre: .txt/.odt/.pdf/.doc ! ';
                            }
                            if ($size > 10000000) {
                                $this->view->error[] = 'La taille des fichier ne doit pas dépasser 10MO chaqu\'un';
                            }
                            if (file_exists("/cours/enseignant/".$ensegnant->id.$name)){
                                $this->view->error[] = "Le fichier existe déja, rennommer le et reesseyer";
                            }

                            if (empty($this->view->error)) {
                                if (move_uploaded_file($tmp_name, ROOTE . '/cours/enseignant/'.$ensegnant->id .'/'. $name)) {
                                    $db->requete("insert into fichier (lien,id_section) values (?,?)",[$name,$section->m]);
                                }
                            }
                        }
                    }
                }
                Router::redirect("/enseignant/mescours/$param");
            }
            $this->view->module = $param;
            $module_sections = $db->requete("select id, intitule, texte from section where id_module = ? and id_enseignant = ?",[$id_module->id,$ensegnant->id])->result();
            $sects = [];
            foreach ($module_sections as $course){
                $events = $db->requete("select * from evenement where id_section = ?",[$course->id])->result();
                $fichiers = $db->requete("select * from fichier where id_section = ?",[$course->id])->result();
                $youtubes = $db->requete("select * from ressourceytb where id_section = ?",[$course->id])->result();
                $course->events = $events;
                $course->fichiers = $fichiers;
                $course->youtubes = $youtubes;
            }
            $this->view->sections = $module_sections;
            $this->view->ens = $ensegnant->id;
            $this->view->render('/enseignant/cour');

        }
    }
    public function profileAction(){
        $db = DB::getInstance();
        $enseignant = Enseignant::currentLoggedInTeacher();
        $this->view->enseignant = $enseignant;
        $this->view->set_title('Mon profile');
        $this->view->h = [];
        if ($_POST){
            if ($_POST['pass1'] == "" || $_POST['pass2'] == "" || $_POST['pass3'] == ""){
                $h = "Tous les champs doivent être remplis!" ;
            }else{
                if ($pass1 = password_verify($_POST['pass1'],$enseignant->password)){
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
                            'display'=>'confirmation du nouveau mot de pase',
                            'required'=>true,
                            'min'=>8,
                            'matches'=>'pass2'
                        ]
                    ]);
                    if ($validation->passed()){
                        $pass2 = $_POST['pass2'];
                        $password = password_hash($pass2,PASSWORD_DEFAULT);
                        $enseignant->password = $password;
                        $enseignant->save();
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
        $this->view->render('enseignant/profile');
    }

    public function eventsAction(){
        $this->view->set_title("Evenements");
        $db = DB::getInstance();
        $enseignant = Enseignant::currentLoggedInTeacher();
        $cours = $db->requete("select * from module where id in(select id_module from cours where id_enseignant = ?)",[$enseignant->id])->result();
        $this->view->courses = $cours;
        $this->view->teacher = $enseignant->id;

        if ($_POST){
            $reponses = $db->requete("SELECT etudiant.id, etudiant.nom, etudiant.prenom,etudiant.numero_etudiant, reponse_evenement.lien_fichier, reponse_evenement.note FROM etudiant JOIN reponse_evenement on etudiant.id = reponse_evenement.id_etudiant JOIN evenement ON reponse_evenement.id_event = evenement.id JOIN section ON evenement.id_section = section.id WHERE evenement.id = ? AND section.id_module = ? AND section.id_enseignant = ? ",[$_POST['event'],$_POST['module'],$enseignant->id])->result();
            $this->view->responses = $reponses;
            $this->view->resevent = $_POST['event'];
        }
        $this->view->render('/enseignant/events');
    }

    public function listevAction(){
        $db = DB::getInstance();
        $enseignant = Enseignant::currentLoggedInTeacher();
        if ($_POST){
            $evs = $db->requete("select ev.id, ev.intitule as even ,sec.intitule as secti FROM evenement ev JOIN section sec on ev.id_section = sec.id where id_module =  ? and id_enseignant = ?",[$_POST['module'],$enseignant->id])->result();
            $this->jsonResponse($evs);
        }
    }

    public function noterAction(){
        if ($_POST){
            if (isset($_POST['id']) && isset($_POST['value']) && isset($_POST['evn'])){
                $db = DB::getInstance();
                $db->requete("update reponse_evenement set note = ? where id_etudiant = ? and id_event = ?",[$_POST['value'],$_POST['id'],$_POST['evn']]);
                echo json_encode(["success" => true]);
            }
        }
    }
    
}