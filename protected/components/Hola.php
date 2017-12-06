<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Hola extends CComponent
{
    public function nombre($nombre = '')
    {
        echo 'Hola '.$nombre;
    }
}