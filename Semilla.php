<?php
class Semilla{
	           var $idMovimiento;
function GeneraSemilla($parmMovimiento){	
$this->idMovimiento = $parmMovimiento;
try{
 $servicio="https://maullin.sii.cl/DTEWS/CrSeed.jws?WSDL"; //url del servicio
 $client = new SoapClient($servicio);
 $result = $client->getSeed();	 
}

catch(SoapFault $fault) {
    echo("NO SE PUEDE CONECTAR AL WEBSERVICE");
	echo '<div align="center">Descargar archivo en formato:<br><br><a target="_blank" href="../downloads/dtestamped'.$this->idMovimiento.'.pdf"><img src="../img/pdficon.png"></a></div>';  
	exit;
}
 
$file=fopen("semilla".$this->idMovimiento.".xml","a");
fputs($file,$result);

}

function LeerSemilla(){
$doc = new DOMDocument;
$doc->load('semilla'.$this->idMovimiento.'.xml');

$items = $doc->getElementsByTagName('SEMILLA');

for ($i = 0; $i < $items->length; $i++) {
    $semilla = $items->item($i)->nodeValue . "\n";
}


$file=fopen("semilla".$this->idMovimiento.".txt","a");
fputs($file,$semilla);
return $semilla;

}	

}


?>