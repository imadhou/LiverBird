<?php
class SessionsEtudiant extends Model{
    public $id, $id_etu, $session, $agent;
    public function __construct()
    {
        $table='sessions_etudiant';
        parent::__construct($table);
    }

    public static function getFromCookie(){
        $Session = new self();
        if (Cookies::exists(COOKIE_ETU)){
            $sql = "select * from sessions_etudiant where agent = ? and nom_sess = ?";
            $S = $Session->findFirst($sql,[Sessions::user_agent(),Cookies::get(COOKIE_ETU)]);
            foreach ($S as $key=>$value){
                $Session->$key = $value;
            }
            if (!$S) return false;
            return $Session;
        }

    }

}
