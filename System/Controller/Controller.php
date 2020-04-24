<?php
namespace System\Controller;

use System\View\View;

class Controller
{
    private $objectView;
 
    public function __construct()
    {
        $this->objectView = new View();
    }
    
    /**
	 * This method is used to set the layout name
	 * @return Void
	*/
    public function view(String $viewName, $withLayout = false, $data = false)
    {
       $this->objectView->view($viewName, $withLayout, $data);
    }
}