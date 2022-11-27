<?php

    namespace RedeSocial;

    class Application{

        private $controller;

        private function setApp(){
            $loadName='RedeSocial\Controllers\\';
            $url = explode('/',@$_GET['url']);

            if ($url[0]=='') {
                $loadName.='Home';

            }else{
                $loadName.=ucfirst(strtolower($url[0]));
            }

            $loadName.='Controller';

            if (file_exists($loadName.'.php')) {
                $this->controller = new $loadName();

            }else{
                //echo $loadName;
                include('Views/Pages/NotFound.php');
                die();
            }

        }

        public function Run(){
            $this->setApp();
            $this->controller->index();
        }
    }

?>