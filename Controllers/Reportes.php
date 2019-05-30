<?php
require_once $_SERVER['DOCUMENT_ROOT']."/inventario/Libraries/vendor/autoload.php";
class Reportes extends Controllers
{
    function __construct()
    {
        parent::__construct();
    }
    public function reporte()
    {
        if (Session::getSession("User") != null) 
        {
            $id=Session::getSession("User");
            if($id['priv']==1)
            {
                $this->view->render($this,'reporte');
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

    public function materialFaltante()
    {
        $response=$this->model->getMaterialFaltante();
        $this->myHtml(1,$response);      
    }
    public function materialUbicacion()
    {
        $response=$this->model->getMaterialUbicacion();
        $this->myHtml(2,$response);   
    }

    public function codeBar()
    {
        $html="";
        $url="http://localhost/inventario/Libraries/php-barcode-master/barcode.php";
        $response = $this->model->getOnlyBarCode();
        $array=$response['result'];
        foreach ($array as $key => $value) 
        {
            $html.='<img src="'.$url.'?text='.$value['idarticulo'].'&size=50&print=true&sizefactor=2">';
        }
        echo $html;
    }

    public function myHtml($op,$response)
    {
        $tr="";
        if($op==1)
        {
            $title="Material Faltante";
            $total="TOTAL FALTANTE";
            $th='<th class="service">Alumno</th>
            <th class="desc">Telefono</th>
            <th>Fecha_Prestamo</th>
            <th>Fecha_Vencimiento</th>
            <th>Material</th>
            <th>Cod_Bar</th>';
            $array=$response["result"];
            foreach ($array as $key => $value) 
            {
                $tr.="
                <tr>
                    <td>".$value["nameA"]."</td>
                    <td>".$value["phone"]."</td>
                    <td>".$value["fecha_prestamo"]."</td>
                    <td>".$value["fecha_vencido"]."</td>
                    <td>".$value["name"]."</td>
                    <td>".$value["codigo_barras"]."</td>
                </tr>";
            }
            $cont = count($array);
        }
        else
        {
            $title="Ubicacion Material";
            $total="MATERIAL TOTAL";
            $th='<th class="service">Nombre</th>
            <th class="desc">Modelo</th>
            <th>#Serie</th>
            <th>Cod_bar</th>
            <th>Ubicacion</th>
            <th>Estado</th>';
            $array=$response["result"];
            foreach ($array as $key => $value) 
            {
                if($value["prestado"]==1)
                {
                    $prestado="Prestado";
                }
                else
                {
                    $prestado="Almacén";
                }
                $tr.="
                <tr>
                    <td>".$value["name"]."</td>
                    <td>".$value["modelo"]."</td>
                    <td>".$value["num_serie"]."</td>
                    <td>".$value["idarticulo"]."</td>
                    <td>".$value["ubicacion"]."</td>
                    <td>".$prestado."</td>
                </tr>";
            }
            $cont = count($array);
        }
        $style=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/inventario/Resources/plantillaparaReporte/example3/style.css');
        $html='<body>
        <main>
          <h1  class="clearfix">'.$title.'</h1>
          <table>
            <thead>
              <tr>
               '.$th.'
              </tr>
            </thead>
            <tbody>'.$tr.'
              <tr>
                <td></td>
                <td colspan="4" class="grand total">'.$total.':</td>
                <td class="grand total">'.$cont.'</td>
              </tr>
            </tbody>
          </table>
        </main>
        <footer>
          Intituto Tecnologico de Agua Prieta/Tecnologico Nacional de Mexico
        </footer>
      </body>';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($style,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output();
      //return $html;
    }
}
?>