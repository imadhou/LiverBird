<?php
class Enseignant extends Model{
    private $_session, $_cookie;
    public $id, $nom, $prenom, $email, $password, $date_naissance, $numero_enseignant;
    public static $currentLoggedInTeacher = null;
    public function __construct($id = '')
    {

        $table = 'enseignant';
        parent::__construct($table);
        $this->_session = SESSION_ENS;
        $this->_cookie = COOKIE_ENS;


        if ($id != ''){
            $etu = $this->_db->findFirst("select * from enseignant where id = ?",[$id]);
            if ($etu != null){
                foreach ($etu as $key=>$value){
                    $this->$key = $value;
                }
            }
        }
    }

    public function findByEmail($email){
        return $this->_db->findFirst("select * from enseignant where email = ?",[$email]);
    }

    public function findByid($id){
        $this->_db->findFirst("select * from enseignant where id = ?",[$id]);
    }

    public function registerNewTeacher($params){
        $this->assign($params);
        $pass1 = $this->password;
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        $this->save();
        $id = DB::getInstance()->requete("select id from enseignant where email = ?",[$this->email])->result()[0];
        mkdir(ROOTE."/cours/enseignant/$id->id/");

        $distination =$this->email ;
        $from = 'admin@eredlearning.atwebpages.com';
        $sujet = "Votre mot de passe eredlearning";
        $text = "Rendez vous sur http://eredlearning.atwebpages.com vous trouvez ci-joint votre mot de passe: $pass1";
        $headers = ['From' => $from, 'Content-type' => 'text/html; charset=iso-8859-1'];
        $bodyParagraphs = [ "Email: {$from}", "Message:", $text];
        $body = join(PHP_EOL, $bodyParagraphs);
        mail($this->email, $sujet, $body, $headers);



    }

    public function login($remember = false){
        Sessions::set($this->_session,$this->id);
        if ($remember) {
            $hash = md5($this->_cookie . rand(1, 100));
            $user_agent = Sessions::user_agent();
            $time = time() + COOKIE_EXPIRY;
            Cookies::set($this->_cookie, $hash, $time);
            $fields = [$user_agent, $this->id, $hash];
            $h = $this->_db->requete('delete from sessions_enseignant where id = ? and agent =?', [$this->id, $user_agent]);
            $this->_db->requete("insert into sessions_enseignant (agent,id,nom_sess) values (?,?,?)",$fields);
        }
    }


    public function logout(){
        $Session = SessionsEnseignant::getFromCookie();
        if ($Session) {
            $sq = "delete from sessions_enseignant where id = ?";
            $this->_db->requete($sq,[$this->id]);
        }
        Sessions::delete(SESSION_ENS);
        if (Cookies::exists(COOKIE_ENS)){
            Cookies::delete(COOKIE_ENS);
        }
        self::$currentLoggedInTeacher = null;
        return true;
    }

    public static function loginFromCookie(){
        $Session = SessionsEnseignant::getFromCookie();
        if ($Session){
            if ($Session->id != ''){
                $user = new self((int)$Session->id);
                if ($user) {
                    $user->login();

                }
                return $user;
            }
        }


    }

    public static function currentLoggedInTeacher(){
        if (!isset(self::$currentLoggedInTeacher) && Sessions::exists(SESSION_ENS)){
            $U = new Enseignant((int)Sessions::get(SESSION_ENS));
            self::$currentLoggedInTeacher = $U;
        }
        return self::$currentLoggedInTeacher;
    }
}