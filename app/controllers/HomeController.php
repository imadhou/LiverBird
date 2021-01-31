<?php


class HomeController extends Controller
{
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->view->set_layout('default');
    }

    public function indexAction(){
        $this->view->set_title('EredLearning');

        $db = DB::getInstance();
        $nombreetu = $db->requete("SELECT module.nom, module.id ,COUNT(suivre.id_etudiant) as nbr from suivre join module ON suivre.id_module = module.id GROUP BY module.id;",[])->result();
        $nombreens = $db->requete("SELECT module.nom, module.id, COUNT(cours.id_enseignant) as nbr FROM module JOIN cours on module.id = cours.id_module   GROUP BY module.id",[])->result();
        $modules = $db->requete("SELECT * FROM module",[])->result();
        $this->view->modules = $modules;
        $this->view->render('home/index');
    }
    public function aboutsiteAction(){
        $this->view->set_title('À propos du site');

        $this->view->render('home/a_propos_site');
    }

    public function contactsAction(){
        $this->view->set_title('Contactez nous!');
        $this->view->passer = '';
        if ($_POST){
            $validate = new Validation();
            $validate->check($_POST,[
                'mail'=>[
                    'display'=>'Email',
                    'required'=>true,
                    'valid_email'=>true
                ],
                'subject'=>[
                    'display'=>'Sujet',
                    'required'=>true
                ],
                'text'=>[
                    'display'=>'Sujet',
                    'required'=>true
                ]
            ]);
            if ($validate->passed()){
                $distination = 'admin@eredlearning.atwebpages.com';
                $from = htmlentities($_POST['mail']);
                $sujet = $_POST['subject'];
                $text = $_POST['text'];
                $headers = ['From' => $from, 'Content-type' => 'text/html; charset=iso-8859-1'];
                $bodyParagraphs = [ "Email: {$from}", "Message:", $text];
                $body = join(PHP_EOL, $bodyParagraphs);
                if (mail($distination, $sujet, $body, $headers)){
                    $this->view->passer = '<div class="text-success">Votre mail est bien envoye nous vous repondrons dans les plus brefs delais ! merci.</div>';
                }else{
                    $this->view->passer = '<div class="text-danger">Une erreure est sourvenu lors de l\'envoi de votre email reesseyez plus tard !</div>';
                }
            }else{
                $this->view->passer = $validate->displayErrors();
            }
        }
        $this->view->render('home/contactez_nous');
    }

    public function aboutteamAction(){
        $this->view->set_title('À propos de l\'équipe');

        $this->view->render('home/a_propos_equipe');
    }
}