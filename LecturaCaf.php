<?php


 class LecturaCaf{
	  var $FechaAutorizacionFolio;
	  var $RangoDesde;
	  var $RangoHasta;
	  var $RazonSocial;
	  var $RutEmisor;
	  var $Modulo;
	  var $Exponente;
	  var $Frma;
	  var $TipoDte;
	  var $Idk;
	  var $RsaSk;
	  var $RsaPubK;
	  var $TipoDocumento;
function LecturaCaf($parmTipoDocumento){
	
	$this->TipoDocumento = $parmTipoDocumento;
	
}	  
	  
function LeerCaf(){
	
$doc = new DOMDocument;
if($this->TipoDocumento==3){
$doc->load('../caf/caf.xml');
}	
if($this->TipoDocumento==2){
$doc->load('../caf/guias.xml');
}	


if($this->TipoDocumento==4){
$doc->load('../caf/notacredito.xml');
}	

if($this->TipoDocumento==6){
$doc->load('../caf/notadebito.xml');
}	



	
$items = $doc->getElementsByTagName('FA');
for ($i = 0; $i < $items->length; $i++) {
    $this->FechaAutorizacionFolio = $items->item($i)->nodeValue;
	
}

$items = $doc->getElementsByTagName('D');
for ($i = 0; $i < $items->length; $i++) {
    $this->RangoDesde = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('H');
for ($i = 0; $i < $items->length; $i++) {
    $this->RangoHasta = $items->item($i)->nodeValue;
}


$items = $doc->getElementsByTagName('RS');
for ($i = 0; $i < $items->length; $i++) {
    $this->RazonSocial = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('RE');
for ($i = 0; $i < $items->length; $i++) {
    $this->RutEmisor = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('M');
for ($i = 0; $i < $items->length; $i++) {
    $this->Modulo = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('E');
for ($i = 0; $i < $items->length; $i++) {
    $this->Exponente = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('IDK');
for ($i = 0; $i < $items->length; $i++) {
    $this->Idk = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('FRMA');
for ($i = 0; $i < $items->length; $i++) {
    $this->Frma = $items->item($i)->nodeValue;
}

$items = $doc->getElementsByTagName('RSASK');
for ($i = 0; $i < $items->length; $i++) {
    $this->RsaSk = $items->item($i)->nodeValue;
}


$items = $doc->getElementsByTagName('RSAPUBK');
for ($i = 0; $i < $items->length; $i++) {
    $this->RsaPubK = $items->item($i)->nodeValue;
}


$items = $doc->getElementsByTagName('TD');
for ($i = 0; $i < $items->length; $i++) {
    $this->TipoDte = $items->item($i)->nodeValue;
}


}
}

?>