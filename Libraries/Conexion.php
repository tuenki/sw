<?php
class Conexion
{
    function __construct()
    {
        $server="db5000080023.hosting-data.io";
        $user="dbu36365";
        $pass ="CH2019.ig*";
        $db="dbs74769";
        $this->db=new QueryManager($server,$user,$pass,$db);
    }
}

?>