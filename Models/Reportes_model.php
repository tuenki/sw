<?php
class Reportes_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }

    function getMaterialFaltante()
    {
        $where=" INNER JOIN alumno 
        ON prestamo.numero_control=alumno.numcontrol 
        INNER JOIN articulo 
        ON prestamo.codigo_barras= articulo.idarticulo
        INNER JOIN categoria
        ON articulo.categoria= categoria.id_categoria
        WHERE articulo.prestado=1 AND prestamo.fecha_entrega IS NULL ";
        $columns ="alumno.nameA,alumno.phone,prestamo.fecha_prestamo,prestamo.fecha_vencido,categoria.name,prestamo.codigo_barras";

        return $this->db->select1($columns,'prestamo',$where,null);
    }

    function getMaterialUbicacion()
    {
        $where=" INNER JOIN categoria ON articulo.categoria = categoria.id_categoria ";
        $columns="categoria.name,articulo.modelo,articulo.num_serie,articulo.idarticulo,articulo.ubicacion,articulo.prestado";
        return $this->db->select1($columns,'articulo',$where,null);
    }
    
    function getOnlyBarCode()
    {
        return $this->db->select1("idarticulo","articulo",null,null);
    }

    

}
?>