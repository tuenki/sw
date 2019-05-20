<?php
class Controllers extends Anonymous
{
    public function __construct()
    {
        Session::star();
        $this->view=new Views();
        $this->page=new Paginador();
        $this->loadClassmodels();
    }

    //carda de modelos invocados
    function loadClassmodels()
    {
        $model = get_class($this).'_model';
        $path = 'Models/'.$model.'.php';
        if(file_exists($path))
        {
            require_once $path;
            $this->model = new $model();
        }
    }
}

?>