<?php
class Principal extends Controllers
{
    function __construct()
    {
        parent::__construct();
    }
    public function principal()
    {
        if (Session::getSession("User") != null) 
        {
            $this->view->render($this,'principal');
        } 
        else 
        {
            header("Location:".URL);
        }
        
    }

    //Imprime tabla principal
    public function getPrincipal()
    {
        $dataFilter = null;
        $count=0;
        $table="";
        $data = $this->model->getPrincipal($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) 
        {
            $array=$data["results"];
            foreach ($array as $key => $value) 
            {
                $datauser=json_encode($array[$count]);
                $table.="
                <tr>
                    <td>".$value["nameA"]."</td>
                    <td>".$value["phone"]."</td>
                    <td>".$value["name"]."</td>
                    <td>".$value["fecha_vencido"]."</td>
                    <td>
                        <button onclick='dataPrestamo(".$datauser.");' class='btn-floating green darken-3 waves-effect waves-light modal-trigger' href='#modal10'><i class='material-icons'>check</i></button>
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
}
?>