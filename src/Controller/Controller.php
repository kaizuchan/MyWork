<?php
namespace App\Controller;

class PagesController extends AppController {
    public $autoRender = false;

    public function index() {
        echo "Post Index";
    }
    
}