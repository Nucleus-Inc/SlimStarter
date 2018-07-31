<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller
{
    public function index($req, $res)
    {
        $this->db->schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });

        die();
        return $this->view->render($res, 'home.twig');
    }
}