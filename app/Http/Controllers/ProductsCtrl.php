<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsCtrl extends Controller
{
    //
    var $r, $prod_file, $prod_xml;
    function __construct($r){
        $this->r = $r;
        $this->prod_json = 'products.json';
        $this->prod_xml = 'products.xml';
    }

    function index(){       
        //return $this->saveXml();
        
       

      if ($this->r->isMethod('post')) {
            if(isset($this->r->record_id)){
                return $this->updateJson();
            }else{
                return $this->saveJson();
            }
            
        }
        
    }

    function updateJson(){
       // return array('msg' => 'json ok '.$this->r->record_id);
       $handle = fopen($this->prod_json, 'a+'); //open file... will create if not exist        
        $old_data = file_get_contents($this->prod_json); //get file contents
        fclose($handle);
        $data = json_decode($old_data, true); //decode encoded json old data
        $new_data = null;
        foreach($data as $k => $v){
            if($k == $this->r->record_id){
                $new_data[] = array(
                      'prod_name' => $this->r->product_name,
                      'prod_price' => $this->r->product_price,
                      'prod_qty' => $this->r->product_qty,
                      'added_on' => date('Y-m-d H:i:s'),
                      'total' => ($this->r->product_price * $this->r->product_qty) 
                       );
            }else{
                $new_data[] = array(
                      'prod_name' => $v['prod_name'],
                      'prod_price' => $v['prod_price'],
                      'prod_qty' => $v['prod_qty'],
                      'added_on' => $v['added_on'],
                      'total' => ($v['prod_price'] * $v['prod_qty']) 
                       );
            }
        }

        file_put_contents( $this->prod_json, json_encode($new_data) ); //write data to the file
        unset($new_data);//release memory
        
        return array('msg' => 'ok');
      
    }

    function saveJson(){
        $handle = fopen($this->prod_json, 'a+'); //open file... will create if not exist        
        $old_data = file_get_contents($this->prod_json); //get file contents
        fclose($handle);
        $data = json_decode($old_data); //decode encoded json old data
        unset($old_data);//prevent memory leaks for large json.           
       
        //push data here
        $data[] = array(
                      'prod_name' => $this->r->product_name,
                      'prod_price' => $this->r->product_price,
                      'prod_qty' => $this->r->product_qty,
                      'added_on' => date('Y-m-d H:i:s'),
                      'total' => ($this->r->product_price * $this->r->product_qty) 
                       );
        
        file_put_contents( $this->prod_json, json_encode($data) ); //write data to the file
        unset($data);//release memory

        return array('msg' => 'ok');
    }

    function Data(){
        $data = null;
        $d = null;
        $total = '0.00';
        if(file_exists($this->prod_json)){    //check json data if exist        
            $records = file_get_contents($this->prod_json);       // read json file     
            $decode = json_decode($records, true);            //decode data from json file
            if(!empty($decode)){
                $d = $decode;   
                $sort = array();
                foreach ($d as $i => $obj) {
                    $sort[$i] = $obj['added_on'];
                    $total += $obj['total'];
                }

                $sorted_db = array_multisort($sort, SORT_ASC, $d);
                krsort($d);

                
            }
        }
                
        return array('data' => $d, 'total' => $total );
        
    }

}
