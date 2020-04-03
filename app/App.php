<?php

namespace JamInvites;

class App
{
    private $controller = null;
    private ?string $action = null;
    private ?array $params = null;

    function __construct()
    {
        $this->controller = "InviteController";
        /*Get Query Parameters and pass to respective controller*/
        if ( isset($_SERVER['REQUEST_URI']) ) {
            $parts = parse_url( $_SERVER['REQUEST_URI'] );

            if (isset($parts['action'])) {
                parse_str($parts['action'], $action);
                $this->params = $action;
            }
        }

        $body = file_get_contents('php://input');
        if(!empty($body)){
            $body = json_decode($body,true);

            if(isset($body['action'])){
                $this->params = $body;
                $this->action = $body['action'];
            }
            else
            {
                // TODO: Add ErrorController and use here.
            }
        }
        else
        {
            // TODO: Add ErrorController and use here.
        }


        $this->run();
    }

    /**
     * Main function of Application to start running application
     */
    public function run()
    {
        if (file_exists(APP . 'controller/' . $this->controller . '.php')) {
            //require APP . 'controller/' . $this->controller . '.php';
            $controller = "JamInvites\\controller\\" . ucfirst($this->controller);
            $this->controller = $controller::create();

            $controllerAction = $this->action;
            $this->controller->$controllerAction($this->params);

        } else {
            // TODO: Add ErrorController and use here.
//            header('location: ' . URL . ' (Please check your request parameters)');
        }
    }

}