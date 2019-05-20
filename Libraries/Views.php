<?php
class Views
{
    function render($controller,$view)
    {
        $controllers=get_class($controller);
        if($view=="index")
        {
            require_once VIEW.DFT.'headerI.html';
            require_once VIEW.$controllers.'/'.$view.'.html';
            require_once VIEW.DFT.'footerI.html';
        }
        else
        {
            require_once VIEW.DFT.'header.html';
            require_once VIEW.$controllers.'/'.$view.'.html';
            require_once VIEW.DFT.'footer.html';
        }
    }
}
?>