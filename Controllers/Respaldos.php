<?php
class Respaldos extends Controllers
{
    function __construct()
    {
        parent::__construct();
    }
    public function respaldo()
    {
        if (Session::getSession("User") != null) 
        {
            $id=Session::getSession("User");
            if($id['priv']==1)
            {
                $this->view->render($this,'respaldo'); 
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
    
    public function backUp()
    {
        $this->model->backUp();    
    }

    public function restore()
    {
        $filename =$_FILES['myfile']['tmp_name'];
        $name = $_FILES['myfile']['name'];
        move_uploaded_file($filename,"Backups/".$name);
        $file_location = "Backups/".$name;
        $r=$this->model->restore($file_location);

        if($r==false)
        {
            echo 0;
        }
        else
        {
            echo $r['message'];
        }
        
    }
}
?>