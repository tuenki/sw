<?php
class Index extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //echo "llegue al controladro hola";
    }
    public function index()
    {
        $user = $_SESSION["User"] ?? null;
        if ($user == null) 
        {
            $this->view->render($this,'index');
        } 
        else 
        {
            header("Location:".URL."Principal/principal");
        }
        
        //echo " estoy en el metodo hola";
    }
    public function userLogin()
    {
        if(isset($_POST['user']) && isset($_POST['pass']))
        {
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            //$passEnc=password_hash($pass,PASSWORD_DEFAULT);
            $data = $this->model->userLogin($user,$pass);
            if(is_array($data))
            {
                echo json_encode($data);
            }
            else
            {
                echo $data;
            }
        }
    }
}
?>