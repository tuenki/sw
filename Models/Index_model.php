<?php
class Index_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }
    function userLogin($user,$pass)
    {
        $where = " WHERE user = :user";
        $param = array('user'=>$user);
        $response = $this->db->select1("*",'usuario',$where,$param);
        if(is_array($response))
        {
            $response=$response['result'];
            if (password_verify($pass,$response[0]['pass'])) 
            {
                //password_verify($pass,$response[0]['pass'])||
                $data=array(
                    "iduser"=>$response[0]["iduser"],
                    "name"=>$response[0]["name"],
                    "user"=>$response[0]["user"],
                    "pass"=>$response[0]["pass"],
                    "priv"=>$response[0]["privilegio"]
                );
                Session::setSession("User",$data);
                return $data;
            } 
            else 
            {
                $data = array("iduser"=>0);
                return $data;
            }
            
        }
        else
        {
            return $response;
        }
        
    }
}
?>