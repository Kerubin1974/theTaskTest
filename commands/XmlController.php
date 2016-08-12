<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

/**
 * Description of XmlController
 *
 * @author kerubin
 */
class XmlController extends AppController {
    public $files=['./xml_test/plans.xml', './xml_test/plan_properties.xml'];
    
    public function actionIndex() {
        echo "ТЕСТОВОЕ ЗАДАНИЕ - мучения Вячеслава\n\n";
        echo "открываем plans.xml\n";
        $this->parsePlans($this->files[0]);
        echo "\n открываем plan_properties.xml\n";
        $this->parseProperties($this->files[1]);
        echo "\nА ВОТ НА ЭТОМ УСЁ !!!\n";
    }
    
    public function parsePlans($xmlfile) {
        $theCurrentDate = time();
        $xml = simplexml_load_file($xmlfile) ;
        echo "Записываем данные в таблицу PLANS \n\n";
        foreach ($xml->result->ROWSET->ROW as $value) {
            $d=$this->timeStamp($value->ACTIVE_TO);            
            if($d>$theCurrentDate){
                // если дата актуальна - записываем в базу
                // дату как метку времени
                $model = new \app\models\Plans;
                $model->plan_id = $value->PLAN_ID;
                $model->name = $value->PLAN_NAME;
                $model->group = $value->PLAN_GROUP_ID;
                $model->active_from = $this->timeStamp($value->ACTIVE_FROM);
                $model->active_to = $this->timeStamp($value->ACTIVE_TO);
                $res = $model->save();
                if( $res == 1 ) { echo "ID: ".$value->PLAN_ID." OK\n"; }
            }else{
                echo "ID: ".$value->PLAN_ID." дата ".$value->ACTIVE_TO." не актуальна \n";
            }
        }
    }
    public function parseProperties($xmlfile) {
        $theCurrentDate = time();
        $xml = simplexml_load_file($xmlfile) ;
        echo "Записываем данные в таблицу PROPERTIES \n\n";
        foreach ($xml->result->ROWSET->ROW as $value) {
            $d=$this->timeStamp($value->ACTIVE_TO);            
            if($d>$theCurrentDate){
                // если дата актуальна - записываем в базу
                // дату как метку времени
                $model = new \app\models\Properties();
                $model->property_id = $value->PROPERTY_ID;
                $model->type = $value->PROPERTY_TYPE_ID;
                $model->plan_id = $value->PLAN_ID;
                $model->value = $value->PROP_VALUE;
                $model->active_from = $this->timeStamp($value->ACTIVE_FROM);
                $model->active_to = $this->timeStamp($value->ACTIVE_TO);
                $res = $model->save();
                if( $res == 1 ) { echo "ID: ".$value->PROPERTY_ID." OK\n"; }
            }else{
                echo "ID: ".$value->PROPERTY_ID." дата ".$value->ACTIVE_TO." не актуальна \n";
            }
        }
    }
    
    public function timeStamp($dt = false) {
        // Возвращает метку времени Unix
        if($dt == false) {return 0;}
        $d = split("-", $dt);
        $mons = array("JAN" => 1, "FEB" => 2, "MAR" => 3, "APR" => 4, "MAY" => 5, "JUN" => 6, "JUL" => 7, "AUG" => 8, "SEP" => 9, "OCT" => 10, "NOV" => 11, "DEC" => 12);
//        $theCurrentDate = time();
        return mktime(0, 0, 0, $d[0], $mons[$d[1]], $d[2]);
    }
}
