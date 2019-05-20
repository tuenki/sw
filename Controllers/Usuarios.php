<?php
class Usuarios extends Controllers
{
    function __cunstruct()
    {
        parent::__construct();
    }
    public function usuario()
    {
        if (Session::getSession("User") != null) 
        {
            $id=Session::getSession("User");
            if($id['priv']==1)
            {
                $this->view->render($this,'usuario');
            }
            else
            {
                header("Location:".URL."Principal/principal");
            }
        } 
        else 
        {
            header("Location:".URL);
        }
        
    }
    function getRoles()
    {
        $data=$this->model->getRoles();
        if(is_array($data))
        {
            echo json_encode($data);
        }
        else
        {
            echo $data;
        }
    }
    public function getUsers()
    {
        $dataFilter = null;
        $count=0;
        $table="";
        $data = $this->model->getUsers($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) 
        {
            $array=$data["results"];
            foreach ($array as $key => $value) 
            {
                $datauser=json_encode($array[$count]);
                $table.="
                <tr>
                    <td>".$value["name"]."</td>
                    <td>".$value["user"]."</td>
                    <td>".$value["privilegio"]."</td>
                    <td>
                        <button onclick='dataUser(".$datauser.");' class='btn-floating yellow darken-3 waves-effect waves-light modal-trigger' href='#modal1'><i class='material-icons'>edit</i></button>
                        <button onclick='deleteUser(".$datauser.");' class='btn-floating deep-orange accent-4 waves-effect waves-light modal-trigger' href='#modal3'><i class='material-icons'>clear</i></button>
                    </td>
                </tr>
                               
                ";
                $count++;
            }
            $paginador= "<p>Resiltados".$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode(array("dataFilter"=>$table,"paginador"=>$paginador));         
        } 
        else 
        {
            echo $data;    
        }
        
    }

    //funcion para insertar usuario
    function insertUser()
    {
        /* 
        if(isset($_FILES['file'])){
            $tipo=$_FILES['files']["type"];
            $archivo=$_FILES['file']["tmp_name"];
        }
        */
        //para obtener imagen: addslashes(file_get_contents($_FILES['imagen']['tmp_name']))
        $pass=password_hash($_POST['pass'],PASSWORD_DEFAULT);
            $array=array(
                $_POST['nombre'],
                $_POST['user'],
                $pass,
                $_POST['priv']
            );
        $data=$this->model->insertUser($this->userClass($array));
        if($data==0)
        {
            echo 0;
        }
        else
        {
            echo $data;
        }
    }

    //funcion para editar usuario
    function editUser()
    {
        if($_POST['pass']=="")
        {
            $v=1;
            $array=array(
               "name" => $_POST['nombre'],
               "user" => $_POST['user'],
               "privilegio" =>$_POST['priv']
            );   
        }
        else
        {
            $pass=password_hash($_POST['pass'],PASSWORD_DEFAULT);
            $v=2;
            $array=array(
                $_POST['nombre'],
                $_POST['user'],
                $pass,
                $_POST['priv']
            );   
        }
        if($v==1)
        {
            $response=$this->model->editUser($v,$array,$_POST['idU']);
        }
        else
        {
            $response=$this->model->editUser($v,$this->userClass($array),$_POST['idU']);
        }        
        if($response==0)
        {
            echo 0;
        }
        else
        {
            echo $response;
        }       
        // ejecuta modelo edit
    }

    //funcion para eliminar usuario
    public function deleteUser()
    {
        echo $this->model->deleteUser($_POST['idUser']);
    }

    //destruye sesiones
    public function destroySession()
    {
        Session::destroy();
        header("Location:".URL);
    }
}
?>