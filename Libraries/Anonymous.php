<?php
class Anonymous
{
    public function userClass($array)
    {
        return new class($array)
        {
            public $name;
            public $user;
            public $pass;
            public $privilegio;
            function __construct($array)
            {   
                if(sizeof($array)>3)
                {
                    $this->name=$array[0];
                    $this->user=$array[1];
                    $this->pass=$array[2];
                    $this->privilegio=$array[3];
                }
                else
                {
                    $this->name=$array[0];
                    $this->user=$array[1];
                    $this->privilegio=$array[2];
                }
                
            }
        };
    }
}
?>