<?php
    namespace RedeSocial\Views;

    class MainView{
        public static function render($filename){
            include('Pages/'.$filename.'.php');
        }
    }
?>