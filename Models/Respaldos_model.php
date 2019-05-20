<?php
class Respaldos_model extends Conexion
{
    function __construct()
    {
        parent::__construct();
    }

    function backUp()
    {
      $this->db->backup2();
    }

    function restore($location)
    {
        return $this->db->restore($location);
    }
}
?>