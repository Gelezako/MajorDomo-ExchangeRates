<?php
/**
* ExchangeRates 
* @package project
* @author Alex Sokolov <admin@gelezako.com>
* @copyright Alex Sokolov http://blog.gelezako.com (c)
* @version 0.1 (wizard, 10:02:10 [Feb 06, 2017])
*/
//
//
class ExchangeRates extends module {
/**
* ExchangeRates
*
* Module class constructor
*
* @access private
*/
public function ExchangeRates() {
  $this->name="ExchangeRates";
  $this->title="Курс валют";
  $this->module_category="<#LANG_SECTION_APPLICATIONS#>";
  $this->checkInstalled();
}
/**
* saveParams
*
* Saving module parameters
*
* @access public
*/
public function saveParams($data=0) {
 $p=array();
 if (IsSet($this->id)) {
  $p["id"]=$this->id;
 }
 if (IsSet($this->view_mode)) {
  $p["view_mode"]=$this->view_mode;
 }
 if (IsSet($this->edit_mode)) {
  $p["edit_mode"]=$this->edit_mode;
 }
 if (IsSet($this->tab)) {
  $p["tab"]=$this->tab;
 }
 return parent::saveParams($p);
}
/**
* getParams
*
* Getting module parameters from query string
*
* @access public
*/
public function getParams() {
  global $id;
  global $mode;
  global $view_mode;
  global $edit_mode;
  global $tab;
  if (isset($id)) {
   $this->id=$id;
  }
  if (isset($mode)) {
   $this->mode=$mode;
  }
  if (isset($view_mode)) {
   $this->view_mode=$view_mode;
  }
  if (isset($edit_mode)) {
   $this->edit_mode=$edit_mode;
  }
  if (isset($tab)) {
   $this->tab=$tab;
  }
}
/**
* Run
*
* Description
*
* @access public
*/
public function run() {
 global $session;
  $out=array();
  if ($this->action=='admin') {
   $this->admin($out);
  } else {
   $this->usual($out);
  }
  if (IsSet($this->owner->action)) {
   $out['PARENT_ACTION']=$this->owner->action;
  }
  if (IsSet($this->owner->name)) {
   $out['PARENT_NAME']=$this->owner->name;
  }
  $out['VIEW_MODE']=$this->view_mode;
  $out['EDIT_MODE']=$this->edit_mode;
  $out['MODE']=$this->mode;
  $out['ACTION']=$this->action;
  $this->data=$out;
  $p=new parser(DIR_TEMPLATES.$this->name."/".$this->name.".html", $this->data, $this);
  $this->result=$p->result;
}
/**
* BackEnd
*
* Module backend
*
* @access public
*/

protected function SetAutoUpdate()
   {
       injectObjectMethodCode('ClockChime.onNewHour','ExchangeRates','
       include_once(DIR_MODULES . "ExchangeRates/ExchangeRates.class.php");
       $app_exRate = new ExchangeRates();
       $app_exRate->SaveAutoUpdate();
'); 
   }

public function SaveAutoUpdate(){
	libxml_use_internal_errors(true);
	$url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=11'; 
	$xml = @simplexml_load_file($url);
	if ($xml) {
        $i=0;
        //получаем курс евро
        foreach($xml->row[1]->exchangerate->attributes() as $key => $exchangerate){
          if($i==2){
            sg("Rate.eurobuy",round((float)$exchangerate,1));
          }
          else if($i==3){
          sg("Rate.eurosale",round((float)$exchangerate,1));
          }
          ++$i;
        }
		
		//получаем курс доллара
		$j=0;
        foreach($xml->row[0]->exchangerate->attributes() as $key => $exchangerate){
          if($j==2){
          sg("Rate.usdbuy",round((float)$exchangerate,1));
          }
          else if($j==3){
          sg("Rate.usdsale",round((float)$exchangerate,1));
          }
          ++$j;
        }
		
		//получаем курс рубля
		$k=0;
        foreach($xml->row[2]->exchangerate->attributes() as $key => $exchangerate){
          if($k==2){
          sg("Rate.rurbuy",round((float)$exchangerate,2));
          }
          else if($k==3){
          sg("Rate.rursale",round((float)$exchangerate,2));
          }
          ++$k;
        }
     }
	 
	   $file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
      if ($file) {
            $xml = $file->xpath("//Valute[@ID='R01235']");
            $valute = strval($xml[0]->Value);
            $dollar = str_replace(",",".",$valute);
            sg("Rate.dollarrur",round((float)$dollar,2));

			$xml = $file->xpath("//Valute[@ID='R01239']");
            $valute = strval($xml[0]->Value);
            $euro = str_replace(",",".",$valute);
            sg("Rate.eurorur",round((float)$euro,2));
        }

}

public function admin(&$out) {
	global $date1,$date2,$date; //время последнего обновления курсов
    libxml_use_internal_errors(true);
	$url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=11'; 
	$xml = @simplexml_load_file($url);
    if (!$xml) {
     $out["notification"]="Невозможно получить курс валют ПриватБанка";
     }
     else{
        global $eurohr;
        if(isset($eurohr)){ 
        $i=0;
        //получаем курс евро
        foreach($xml->row[1]->exchangerate->attributes() as $key => $exchangerate){
          if($i==2){
            sg("Rate.eurobuy",round((float)$exchangerate,1));
            $out["eurobuy"]=round((float)$exchangerate,1);
          }
          else if($i==3){
          sg("Rate.eurosale",round((float)$exchangerate,1));
          $out["eurosale"]=round((float)$exchangerate,1);
          }
          ++$i;
        }}


        global $usdhr;
        if(isset($usdhr)){ 
        //получаем курс доллара
        $j=0;
        foreach($xml->row[0]->exchangerate->attributes() as $key => $exchangerate){
          if($j==2){
          sg("Rate.usdbuy",round((float)$exchangerate,1));
          $out["usdbuy"]=round((float)$exchangerate,1);
          }
          else if($j==3){
          sg("Rate.usdsale",round((float)$exchangerate,1));
          $out["usdsale"]=round((float)$exchangerate,1);
          }
          ++$j;
        }}

        global $rurhr;
        if(isset($rurhr)){
        //получаем курс рубля
        $k=0;
        foreach($xml->row[2]->exchangerate->attributes() as $key => $exchangerate){
          if($k==2){
          sg("Rate.rurbuy",round((float)$exchangerate,2));
          $out["rurbuy"]=round((float)$exchangerate,2);
          }
          else if($k==3){
          sg("Rate.rursale",round((float)$exchangerate,2));
          $out["rursale"]=round((float)$exchangerate,2);
          }
          ++$k;
        }}   
    sg("Rate.date1",date("Y-m-d H:i:s"));
	$out["date1"]=date("Y-m-d H:i:s");
    } //Конец парсинга хмл от ПриватБанка

// Начало парсинга хмл банка России
  global $dollarrur,$eurorur;
  $file = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
      if (!$file) {
        $out["notification2"]="Невозможно получить курс валют Банка России";
        }
     else{ 
        if(isset($dollarrur)){
            $xml = $file->xpath("//Valute[@ID='R01235']");
            $valute = strval($xml[0]->Value);
            $dollar = str_replace(",",".",$valute);
            sg("Rate.dollarrur",round((float)$dollar,2));
            $out["dollarrur"]=round((float)$dollar,2);
        }
        if(isset($eurorur)){
            $xml = $file->xpath("//Valute[@ID='R01239']");
            $valute = strval($xml[0]->Value);
            $euro = str_replace(",",".",$valute);
            sg("Rate.eurorur",round((float)$euro,2));
            $out["eurorur"]=round((float)$euro,2);
        }
	sg("Rate.date2",date("Y-m-d H:i:s"));
	$out["date2"]=date("Y-m-d H:i:s");
    }
    
	
	// Начало парсинга курсов от Минфин
	global $euronbu,$usdnbu,$rurnbu;
    ini_set("user_agent","MajorDomo-ExchangeRates/0.1");
	$file_nbu = file_get_contents('http://api.minfin.com.ua/nbu/434f685ddcfc82024569b9516a87838053f383a0/',true);
	$file_nbu = json_decode($file_nbu);
		  if (!$file_nbu) {
			$out["notification3"]="Невозможно получить курс валют НБУ";
			}
		 else{ 
			if(isset($usdnbu)){
				$d=$file_nbu->usd->ask;
				sg("Rate.usdnbu",round((float)$d,2));
				$out["usdnbu"]=round((float)$d,2);
			}
			if(isset($euronbu)){	
				sg("Rate.euronbu",round((float)$file_nbu->eur->ask,2));
				$out["euronbu"]=round((float)$file_nbu->eur->ask,2);
			}
			if(isset($rurnbu)){
				sg("Rate.rurnbu",round((float)$file_nbu->rub->ask,2));
				$out["rurnbu"]=round((float)$file_nbu->rub->ask,2);
			}
		sg("Rate.date3",date("Y-m-d H:i:s"));
	    $out["date3"]=date("Y-m-d H:i:s");
		}

	//Конец парсинга курсов от Минфин
	
}




/**
* FrontEnd
*
* Module frontend
*
* @access public
*/
public function usual(&$out) {
 $this->admin($out);
}
/**
* Install
*
* Module installation routine
*
* @access private
*/
public function install($data='') {
	 $className = 'ExchangeRates'; //имя класса
 $objectName = array('Rate');//имя обьектов
 $objDescription = array('Курс валют');
 $rec = SQLSelectOne("SELECT ID FROM classes WHERE TITLE LIKE '" . DBSafe($className) . "'");
 
    if (!$rec['ID']) {
        $rec = array();
        $rec['TITLE'] = $className;
        $rec['DESCRIPTION'] = $objDescription;
        $rec['ID'] = SQLInsert('classes', $rec);
    }
    for ($i = 0; $i < count($objectName); $i++) {
        $obj_rec = SQLSelectOne("SELECT ID FROM objects WHERE CLASS_ID='" . $rec['ID'] . "' AND TITLE LIKE '" . DBSafe($objectName[$i]) . "'");
        if (!$obj_rec['ID']) {
            $obj_rec = array();
            $obj_rec['CLASS_ID'] = $rec['ID'];
            $obj_rec['TITLE'] = $objectName[$i];
            $obj_rec['DESCRIPTION'] = $objDescription[$i];
            $obj_rec['ID'] = SQLInsert('objects', $obj_rec);
        }
    }
  
  $this->SetAutoUpdate();
  parent::install();
 }

public function uninstall()
   {
      SQLExec("delete from pvalues where property_id in (select id FROM properties where object_id in (select id from objects where class_id = (select id from classes where title = 'ExchangeRates')))");
      SQLExec("delete from properties where object_id in (select id from objects where class_id = (select id from classes where title = 'ExchangeRates'))");
      SQLExec("delete from objects where class_id = (select id from classes where title = 'ExchangeRates')");
      SQLExec("delete from classes where title = 'ExchangeRates'");
      
      parent::uninstall();
   }
// --------------------------------------------------------------------
}
/*
*
* TW9kdWxlIGNyZWF0ZWQgRmViIDA2LCAyMDE3IHVzaW5nIFNlcmdlIEouIHdpemFyZCAoQWN0aXZlVW5pdCBJbmMgd3d3LmFjdGl2ZXVuaXQuY29tKQ==
*
*/
