<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MainCtrl extends Controller
{
    //
    function index(Request $r){
        //return $r->p1.' - '.$r->p2.' - '.$r->p3;
        $page = null;
        $products = new ProductsCtrl($r);
        $data = $products->Data();
        switch($r->p1){
            case 'products':
                
                $page = $products->index($r);
            break;
          
            default:
                $page = view('form', compact('data'));
        }

        return $page;
    }

    

}
