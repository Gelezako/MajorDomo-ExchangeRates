<?php
/**
* ExchangeRates 
* @package project
* @author Wizard <sergejey@gmail.com>
* @copyright http://majordomo.smartliving.ru/ (c)
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
function ExchangeRates() {
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
function saveParams($data=0) {
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
function getParams() {
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
function run() {
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
function grivna($kop){
if ($kop=="2" or $kop=="3" or $kop=="4") return "гривны";
else return "гривен";
}

function admin(&$out) {
	$url = 'https://api.privatbank.ua/p24api/pubinfo?exchange&coursid=11';
	$xml = simplexml_load_file($url);

 global $euro;
 if(isset($euro)){ 
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
}}

 global $usd;
 if(isset($usd)){ 
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
}}
 global $rur;
 if(isset($rur)){
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
 }}

}
/**
* FrontEnd
*
* Module frontend
*
* @access public
*/
function usual(&$out) {
 $this->admin($out);
}
/**
* Install
*
* Module installation routine
*
* @access private
*/
 function install($data='') {
	 $className = 'ExchangeRates'; //имя класса
 $objectName = array('Rate');//имя обьектов
 $objDescription = array('Курс валют от ПриватБанка');
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
	addClassProperty('Rate', 'eurobuy', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
	addClassProperty('Rate', 'eurosale', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
	addClassProperty('Rate', 'usdbuy', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
	addClassProperty('Rate', 'usdsale', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
	addClassProperty('Rate', 'rurbuy', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
	addClassProperty('Rate', 'rursale', 'include_once(DIR_MODULES."ExchangeRates/ExchangeRates.class.php");');
  parent::install();
 }
// --------------------------------------------------------------------
}
/*
*
* TW9kdWxlIGNyZWF0ZWQgRmViIDA2LCAyMDE3IHVzaW5nIFNlcmdlIEouIHdpemFyZCAoQWN0aXZlVW5pdCBJbmMgd3d3LmFjdGl2ZXVuaXQuY29tKQ==
*
*/
