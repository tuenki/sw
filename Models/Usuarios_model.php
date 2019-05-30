<?php
class Usuarios_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }
    function getRoles()
    {
        return $response=$this->db->select1("*","privilegio",null,null);
    }
    function getUsers($filter,$page,$model)
    { 
        $where = " INNER JOIN privilegio pri ON us.privilegio = pri.idp WHERE name LIKE :name OR user LIKE :user";
        $array=array('name'=>'%'.$filter.'%','user'=>'%'.$filter.'%');
        $columns="us.iduser,us.name,us.user,pri.privilegio";
        return $model->paginador($columns,"usuario us","Users",$page,$where,$array);

    }
    function insertUser($user)
    {
        $where=" WHERE user = :user";
        $param=array('user'=>$user->user);
        $response=$this->db->select1("*","usuario",$where,$param);
        if(is_array($response))
        {
            $response=$response['result'];
            if (count($response)==0) 
            { 
                $value="(name,user,pass,privilegio) VALUES (:name,:user,:pass,:privilegio)";
                //$paramV=array('name'=>$user->name,'user'=>$user->user,'pass'=>$user->pass,'privilegio'=>$user->privilegio);          
                $data=$this->db->insert1("usuario",$user,$value);
                if($data)
                {
                    return 0;
                }
                else
                {
                    return $data;
                }
            } 
            else 
            {
               return 1;
            }
            
        }
        else
        {
            return $response;
        }
    }

    function editUser($v,$user,$iduser)
    {
        $where = "WHERE iduser = '$iduser'";
        if($v == 1)
        {  
            $value = "name = :name, user = :user, privilegio = :privilegio ";
        }
        else
        {
            $value = "name = :name, user = :user, pass = :pass, privilegio = :privilegio ";
        }
        $response = $this->db->update('usuario',$user,$value,$where);       
        if(is_bool($response))
        {
            if($response)
            {
                echo 0;
            }
        }
        else
        {
            echo $response;
        }
    }

    function deleteUser($id)
    {       
        $array = array("iduser"=>$id);
        $where = " WHERE iduser = :iduser";
        $d=$this->db->delete("usuario",$array,$where);
        if(is_bool($d))
        {
            if($d)
            {
                echo 0;
            }
        }
        else
        {
            echo $d;
        }

    }
}
?>