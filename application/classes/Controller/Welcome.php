<?php

defined('SYSPATH') or die('No direct script access.');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Controller_Welcome extends Controller_Template {

    /**
     * Main template to load
     * @var string
     */
    public $template = "index.tpl";

    /**
     * Contains session
     * @var null
     */
    private $session = NULL;

    /**
     * Every request goes over here
     * @throws View_Exception
     */
    public function action_index() {
        // Init the session
        $this->session = Session::instance();

        // Init the micro
        Micro::init($this->request, $this->response);

        // Get view
        $view = View::factory(Micro::getTemplate());

        // Get template object
        $templateObject = Micro::getTemplateObject();


        $templateObject::setTemplateVariable('version', '1234');

        // Iterate template vars
        foreach($templateObject::getAllTemplateVariables() as $key => $variable) {
            // Add into variable container for the render
            View::set_global($key, $variable);
        }
        
        // Render the assigned stuff
        $this->template->content = $view->render();
    }

}
