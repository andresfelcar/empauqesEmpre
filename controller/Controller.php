<?php
require_once "Invoices_Controller.php";
require_once "Login_Controller.php";
require_once "Products_Controller.php";
require_once "Sellers_Controller.php";
require_once "Clients_Controller.php";
require_once "Zone_Controller.php";
require_once "Ranking_Controller.php";
require_once "ProductsList_Controller.php";




class Controller{

    public function Login($option,$array = []){
        return Login_Controller::Main($option,$array);
    }

    public function Products($option,$array = []){
        return Products_Controller::Main($option,$array);
    }

    public function Invoices($option,$array = []){
        return Invoices_Controller::Main($option,$array);
    }

    public function Sellers($option,$array = []){
        return Sellers_Controller::Main($option,$array);
    }
    public function Clients($option,$array = []){
        return Clients_Controller::Main($option,$array);
    }
     public function Zone($option,$array = []){
        return Zone_Controller::Main($option,$array);
    }
     public function Ranking($option,$array = []){
        return Ranking_Controller::Main($option,$array);
    }
    public function ProductsList($option,$array = []){
        return ProductsList_Controller::Main($option,$array);
    }
}
