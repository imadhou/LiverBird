<?php
class SessionsEnseignant extends Model{
    public $id, $id_etu, $session, $agent;
    public function __construct()
    {
        $table='sessions_enseignant';
        parent::__construct($table);
    }

    public static function getFromCookie(){
        $Session = new self();
        if (Cookies::exists(COOKIE_ENS)){
            $sql = "select * from sessions_enseignant where agent = ? and nom_sess = ?";
            $S = $Session->findFirst($sql,[Sessions::user_agent(),Cookies::get(COOKIE_ENS)]);
            foreach ($S as $key=>$value){
                $Session->$key = $value;
            }
            if (!$S) return false;
            return $Session;
        }

    }
}