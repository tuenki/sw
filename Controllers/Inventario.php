<?php
class Inventario extends Controllers
{
    function __construct()
    {
        parent::__construct();
    }
    public function inventario()
    {
        if (Session::getSession("User") != null) 
        {
            $this->view->render($this,'inventario');
        } 
        else 
        {
            header("Location:".URL);
        }
        
    }


    ////////////////////////////Seccion de alumnos/////
    //Imprime tabla alumnos
    public function getAlumnos()
    {
        $dataFilter = null;
        $count=0;
        $table="";
        $data = $this->model->getAlumnos($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) 
        {
            $array=$data["results"];
            foreach ($array as $key => $value) 
            {
                $datauser=json_encode($array[$count]);
                $table.="
                <tr>
                    <td>".$value["numcontrol"]."</td>
                    <td>".$value["nameA"]."</td>
                    <td>".$value["short_name"]."</td>
                    <td>".$value["phone"]."</td>
                    <td>
                        <button title='Modificación' onclick='dataAlumno(".$datauser.");' class='btn-floating yellow darken-3 waves-effect waves-light modal-trigger' href='#modal1'><i class='material-icons'>edit</i></button>
                        <button title='Eliminar' onclick='deleteAlumno(".$datauser.");' class='btn-floating deep-orange accent-4 waves-effect waves-light modal-trigger' href='#modal3'><i class='material-icons'>clear</i></button>
                    </td>
                </tr>
                               
                ";
                $count++;
            }
            $paginador= "<p>Resultados".$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode(array("dataFilter"=>$table,"paginador"=>$paginador));         
        } 
        else 
        {
            echo $data;    
        }
        
    }
    //Obtiene Carreras
    public function getCarreras()
    {
        $data=$this->model->getCarreras();
        if(is_array($data))
        {
            echo json_encode($data);
        }
        else
        {
            echo $data;
        }
    }

    //insertar alumno
    public function insertAlumno()
    {
        $array=array(
            "numcontrol"=>$_POST['numcontrol'],
            "nameA"=>$_POST['nameA'],
            "career"=>$_POST['career'],
            "phone"=>$_POST['phone']
        );
        
        $data=$this->model->insertAlumno($array);
        if($data==0)
        {
            echo 0;
        }
        else
        {
            echo $data;
        }
    }

    //actualizar alumno
    public function updateAlumno(){
        $array=array(
            "numcontrol"=>$_POST['numcontrol'],
            "nameA"=>$_POST['nameA'],
            "career"=>$_POST['career'],
            "phone"=>$_POST['phone']
        );
        $data=$this->model->updateAlumno($array,$_POST['numcontrol']);
        if($data==0)
        {
            echo 0;
        }
        else
        {
            echo $data;
        }
    }

    //eliminar alumno
    public function deleteAlumno(){
        echo $this->model->deleteAlumno($_POST['idData']);
        
    } 
    
    ////////////////////////////Seccion de materiales/////
    //Imprime tabla materiales
    public function getMateriales()
    {
        $dataFilter = null;
        $count=0;
        $table="";
        $data = $this->model->getMateriales($_POST["filter"],$_POST["page"],$this->page);
        $data2= $this->model->selectPrestamo();
        if (is_array($data)) 
        {
            $array=$data["results"];
            foreach ($array as $key => $value) 
            {
                $datauser=json_encode($array[$count]);
                if($value['prestado']=="0")
                {
                    $alert='<span class="new badge blue darken-3" data-badge-caption="Si"></span>';
                }
                else
                {
                    $alert='<span class="new badge red" data-badge-caption="No"></span>';
                }
                $table.="
                <tr>
                    <td>".$value["idarticulo"]."</td>
                    <td>".$value["modelo"]."</td>
                    <td>".$value["name"]."</td>
                    <td>".$alert."</td>
                    <td>
                    <button id='dataNewPrestamo' title='Prestar' onclick='dataNewPrestamo(".$datauser.");' class='btn-floating blue waves-effect waves-light modal-trigger' href='#modal4'><i class='material-icons'>insert_drive_file</i></button>
                        <button id='dataMaterial' title='Modificación' onclick='dataMaterial(".$datauser.");' class='btn-floating yellow darken-3 waves-effect waves-light modal-trigger' href='#modal2'><i class='material-icons'>edit</i></button>
                        <button id='ElM' title='Eliminar' onclick='deleteMaterial(".$datauser.");' class='btn-floating deep-orange accent-4 waves-effect waves-light modal-trigger' href='#modal7'><i class='material-icons'>clear</i></button>
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
    //Obtiene Categorias
    public function getCategorias()
    {
        $data=$this->model->getCategorias();
        if(is_array($data))
        {
            echo json_encode($data);
        }
        else
        {
            echo $data;
        }
    }

    
    //insertar articulo
    public function insertArticulo()
    {
        $c=0;
        $array=array(
            "num_serie"=>$_POST['num_serie'],
            "num_itap"=>$_POST['num_itap'],
            "num_rm"=>$_POST['num_rm'],
            "modelo"=>$_POST['modelo'],
            "categoria"=>$_POST['categoria'],
            "bar_code"=>$_POST['bar_code'],
            "ubicacion"=>$_POST['ubicacion']
        );
        if(isset($_FILES['photo']['tmp_name']))
        {
            $imagen =file_get_contents($_FILES['photo']['tmp_name']);
            $array['photo']=$imagen;
            $c=1;
        }
        
        $data=$this->model->insertArticulo($array,$c);
        if($data==0)
        {
            echo 0;
        }
        else
        {
            echo $data;
        }
    }

    //actualizar alumno
    public function updateArticulo(){
        $c=0;
        $array=array(
            "num_serie"=>$_POST['num_serie'],
            "num_itap"=>$_POST['num_itap'],
            "num_rm"=>$_POST['num_rm'],
            "modelo"=>$_POST['modelo'],
            "categoria"=>$_POST['categoria'],
            "bar_code"=>$_POST['bar_code'],
            "ubicacion"=>$_POST['ubicacion']
        );
        if(isset($_FILES['photo']['tmp_name']))
        {
            $imagen =file_get_contents($_FILES['photo']['tmp_name']);
            $array['photo']=$imagen;
            $c=1;
        }
        $data=$this->model->updateArticulo($array,$_POST['idarticulo'],$c);
        if($data==0)
        {
            echo 0;
        }
        else
        {
            echo $data;
        }
    }

    //eliminar alumno
    public function deleteArticulo(){
        echo $this->model->deleteArticulo($_POST['idData']);
        
    }
    
    ///////////////////////////////////PRESTAMOS///////////////////////////////
    //insertar prestamo
    public function insertPrestamo()
    {
        $id=Session::getSession("User");
        $array=array(
            "id_usuario"=>$id['iduser'],
            "numero_control"=>$_POST['numero_control'],
            "codigo_barras"=>$_POST['codigo_barras'],
            "fecha_prestamo"=>$_POST["fecha_prestamo"],
            "fecha_vencido"=>$_POST['fecha_vencido'],
            "comentario_prestamo"=>$_POST['comentario_prestamo']
        );
        $response = $this->model->insertPrestamo($array);
        echo $response;
    }

    //update prestamo
    public function updatePrestamo()
    {
        $id=Session::getSession("User");
        $array=array(
            "id_usuario_recibe"=>$id['iduser'],
            "comentario_entrega"=>$_POST['comentario_entrega'],
            "fecha_entrega"=>$_POST['fecha_entrega'],

        );
        $response = $this->model->updatePrestamo($array,$_POST['id'],$_POST['codigo_barras']);
        echo $response;
    }
    
}
?>