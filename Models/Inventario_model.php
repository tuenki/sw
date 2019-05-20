<?php
class Inventario_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }
//////////////////////////////////////////////////Alumnos//////////////////////////////////////////

    //obtiene los alumnos
    function getAlumnos($filter,$page,$model)
    { 
        $where = " INNER JOIN carrera ON alumno.career = carrera.idcarrera WHERE alumno.numcontrol LIKE :numcontrol OR alumno.nameA LIKE :nameA";
        $array=array('numcontrol'=>'%'.$filter.'%','nameA'=>'%'.$filter.'%');
        $columns="alumno.numcontrol, alumno.nameA, carrera.short_name, alumno.phone";
        return $model->paginador($columns,"alumno","Alumno",$page,$where,$array);
    }

    //obtiene las carreras
    function getCarreras()
    {
        return $response=$this->db->select1(" idcarrera,short_name ","carrera",null,null);
    }

    //inserta alumno
    function insertAlumno($alumno)
    {
        $where=" WHERE numcontrol = :numcontrol";
        $param=array('numcontrol'=>$alumno['numcontrol']);
        $response=$this->db->select1("*","alumno",$where,$param);
        if(is_array($response))
        {
            $response=$response['result'];
            if (count($response)==0) 
            { 
                $value="(numcontrol,nameA,career,phone) VALUES (:numcontrol,:nameA,:career,:phone)";         
                $data=$this->db->insert1("alumno",$alumno,$value);
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

    //actualizar alumnos
    function updateAlumno($alumno,$ncontrol)
    {
        $where = "WHERE numcontrol = '$ncontrol'"; 
        $value = "numcontrol = :numcontrol, nameA = :nameA, career = :career, phone = :phone ";

        $response = $this->db->update('alumno',$alumno,$value,$where);       
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

    function deleteAlumno($id)
    {
        $array = array("numcontrol"=>$id);
        $where = " WHERE numcontrol = :numcontrol";
        $d=$this->db->delete("alumno",$array,$where);
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

///////////////////////////////////////////Articulos/////////////////////////////////////

    //obtiene los materiales
    function getMateriales($filter,$page,$model)
    { 
        $where = " INNER JOIN categoria  on articulo.categoria=categoria.id_categoria WHERE articulo.bar_code LIKE :barcode OR articulo.modelo LIKE :modelo OR categoria.name LIKE :nameM";
        $array=array('barcode'=>'%'.$filter.'%','modelo'=>'%'.$filter.'%','nameM'=>'%'.$filter.'%');
        $columns="articulo.idarticulo,articulo.num_serie,articulo.num_itap,articulo.num_rm,articulo.bar_code,articulo.modelo, categoria.name,articulo.ubicacion,articulo.prestado";
        return $model->paginador($columns,"articulo","Articulo",$page,$where,$array);
    }

    //obtiene las categorias
    function getCategorias()
    {
        return $response=$this->db->select1("*","categoria",null,null);
    }

    //inserta alumno
    function insertArticulo($articulo,$c)
    {
        $where=" WHERE num_serie = :num_serie";
        $param=array('num_serie'=>$articulo['num_serie']);
        $response=$this->db->select1("*","articulo",$where,$param);
        if(is_array($response))
        {
            $response=$response['result'];
            if (count($response)==0) 
            { 
                if($c==1)
                {
                    $value=" (num_serie,num_itap,num_rm,bar_code,modelo,photo,categoria,ubicacion,prestado) VALUES (:num_serie,:num_itap,:num_rm,:bar_code,:modelo,:photo,:categoria,:ubicacion,0)";         
                }
                else
                {
                    $value=" (num_serie,num_itap,num_rm,bar_code,modelo,photo,categoria,ubicacion,prestado) VALUES (:num_serie,:num_itap,:num_rm,:bar_code,:modelo,null,:categoria,:ubicacion,0)";         
                }
                $data=$this->db->insert1("articulo",$articulo,$value);
                if(is_bool($data))
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

    //actualizar articulo
    function updateArticulo($articulo,$idA, $photo)
    {
        $where = "WHERE idarticulo = '$idA'";
        if($photo==1)
        {
            $value = "num_serie = :num_serie, num_itap = :num_itap, num_rm = :num_rm, bar_code = :bar_code, modelo = :modelo, photo = :photo, categoria = :categoria, ubicacion = :ubicacion ";
        }
        else
        {
            $value = "num_serie = :num_serie, num_itap = :num_itap, num_rm = :num_rm, bar_code = :bar_code, modelo = :modelo, categoria = :categoria, ubicacion = :ubicacion ";
        } 

        $response = $this->db->update('articulo',$articulo,$value,$where);       
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

    function deleteArticulo($id)
    {
        $array = array("idarticulo"=>$id);
        $where = " WHERE idarticulo = :idarticulo";
        $d=$this->db->delete("articulo",$array,$where);
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

    /////////////////////PRESTAMOS//////////////////////
    function insertPrestamo($prestamo)
    {
        $where=" WHERE numcontrol = :numcontrol";
        $param=array('numcontrol'=>$prestamo['numero_control']);
        $response=$this->db->select1("*","alumno",$where,$param);
        if(is_array($response))
        {
            $response=$response['result'];
            if (count($response)==0) 
            { 
                return 1;
            } 
            else 
            {
                $where2=" WHERE idarticulo = :idarticulo";
                $param2=array('idarticulo'=>$prestamo['codigo_barras']);
                $response2=$this->db->select1("prestado","articulo",$where2,$param2);
                if(is_array($response2))
                {
                    $array=$response2['result'];
                    if(count($response2)>0)
                    {
                        foreach ($array as $key => $array) {
                            foreach ($array as $keys => $value) {
                              $v=$value;
                            }
                        }
                        if($v==0)
                        {
                            $value=" (id_usuario,id_usuario_recibe,numero_control,codigo_barras,fecha_prestamo,fecha_vencido,fecha_entrega,comentario_prestamo,comentario_entrega) VALUES (:id_usuario,null,:numero_control,:codigo_barras,:fecha_prestamo,:fecha_vencido,null,:comentario_prestamo,null) ";
                            $data2=$this->db->insert1("prestamo",$prestamo,$value);
                            if(is_bool($data2))
                            {
                                if($data2)
                                {
                                    
                                    $param2['prestado']=1;
                                    $value=" prestado = :prestado ";
                                    $response3 = $this->db->update('articulo',$param2,$value,$where2);
                                    if(is_bool($response3))
                                    {
                                        if($response3)
                                        {
                                            echo 0;
                                        }
                                        else
                                        {
                                            echo $response3;
                                        }
                                    }
                                    else
                                    {
                                        echo $response3;
                                    }
                                }
                                else
                                {
                                    return $data2;
                                }
                            }
                            else
                            {
                                return $data2;
                            }
                        }
                        else
                        {
                            return 2;
                        }
                       
                    }
                    else
                    {
                        return 2;
                    }
                }
                else
                {
                    echo $response2;
                }
            }
            
        }
        else
        {
            return $response;
        }
    }

    //actualizar articulo
    function updatePrestamo($articulo,$idA,$cdp)
    {
        $where = "WHERE id = '$idA'";
        $value = "id_usuario_recibe = :id_usuario_recibe, fecha_entrega = :fecha_entrega, comentario_entrega = :comentario_entrega ";
        $response = $this->db->update('prestamo',$articulo,$value,$where);       
        if(is_bool($response))
        {
            if($response)
            {
                $where2=" WHERE idarticulo = :idarticulo";
                $param2=array('idarticulo'=>$cdp);
                $value=" prestado=0 ";
                $response3 = $this->db->update('articulo',$param2,$value,$where2);
                echo 0;
            }
        }
        else
        {
            echo $response;
        }
    }

    function selectPrestamo()
    {
        return $response=$this->db->select1(" numero_control,codigo_barras,comentario_prestamo ","prestamo",null,null);
    }
}
?>