<?php
class Principal_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }
    //obtiene los alumnos con material sin entregar
    function getPrincipal($filter,$page,$model)
    { 
        $where = " INNER JOIN alumno on prestamo.numero_control=alumno.numcontrol 
        INNER JOIN articulo ON prestamo.codigo_barras=articulo.idarticulo
        INNER JOIN categoria ON categoria.id_categoria= articulo.categoria 
        WHERE prestamo.fecha_entrega is null and  prestamo.codigo_barras LIKE :id ";

        $array=array('id'=>'%'.$filter.'%');
        $columns="prestamo.id,prestamo.codigo_barras,alumno.nameA, alumno.phone, categoria.name, prestamo.fecha_prestamo ,prestamo.fecha_vencido";
        return $model->paginador($columns,"prestamo","Principal",$page,$where,$array);
    }
}
?>