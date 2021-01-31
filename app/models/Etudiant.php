<?php
class Etudiant extends Model{
    private $_session, $_cookie;
    public $id, $nom, $prenom, $email, $password, $date_naissance, $numero_etudiant;
    public static $currentLoggedInStudent = null;
    public function __construct($id = '')
    {

        $table = 'etudiant';
        parent::__construct($table);
        $this->_session = SESSION_ETU;
        $this->_cookie = COOKIE_ETU;


        if ($id != ''){
            $etu = $this->_db->findFirst("select * from etudiant where id = ?",[$id]);
            if ($etu != null){
                foreach ($etu as $key=>$value){
                    $this->$key = $value;
                }
            }
        }
    }
    
    public function findByid($id){
       $this->_db->findFirst("select * from etudiant where id = ?",[$id]);
    }

    public function findByEmail($email){
        return $this->findFirst("select * from etudiant where email = ?",[$email]);
    }

    public function registerNewStudent($params){
        $this->assign($params);
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        $this->save();
        $id = DB::getInstance()->requete("select id from etudiant where email = ?",[$this->email])->result()[0];
        mkdir(ROOTE."/cours/etudiant/$id->id/");
    }

    public function login($remember = false){
        Sessions::set($this->_session,$this->id);
        if ($remember) {
            $hash = md5($this->_cookie . rand(1, 100));
            $user_agent = Sessions::user_agent();
            $time = time() + COOKIE_EXPIRY;
            Cookies::set($this->_cookie, $hash, $time);
            $fields = [$user_agent, $this->id, $hash];
            $h = $this->_db->requete('delete from sessions_etudiant where id = ? and agent =?', [$this->id, $user_agent]);
            $this->_db->requete("insert into sessions_etudiant (agent,id,nom_sess) values (?,?,?)",$fields);
        }
    }


    public function logout(){
        $Session = SessionsEtudiant::getFromCookie();
        if ($Session) {
            $sq = "delete from sessions_etudiant where id = ?";
            $this->_db->requete($sq,[$this->id]);
        }
        Sessions::delete(SESSION_ETU);
        if (Cookies::exists(COOKIE_ETU)){
            Cookies::delete(COOKIE_ETU);
        }
        self::$currentLoggedInStudent = null;
        return true;
    }

    public static function loginFromCookie(){
        $Session = SessionsEtudiant::getFromCookie();
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

    public static function currentLoggedInStudent(){
        if (!isset(self::$currentLoggedInStudent) && Sessions::exists(SESSION_ETU)){
            $U = new Etudiant((int)Sessions::get(SESSION_ETU));
            self::$currentLoggedInStudent = $U;
        }
        return self::$currentLoggedInStudent;
    }


    public function acls(){
        if (empty($this->acls)) return [];
        return json_decode($this->acls ,true);
    }
}