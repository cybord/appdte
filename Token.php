<?php

Class Token{

function GeneraToken($parmSemilla){
$valorsemilla = $parmSemilla;
$token = '';
$xml = new DomDocument("1.0","iso-8859-1");
$gettoken = $xml->createElement('getToken');
$gettoken = $xml->appendChild($gettoken);

$item= $xml->createElement('iTem');
$item =$gettoken->appendChild($item);	

$semilla = $xml->createElement('Semilla',$valorsemilla);
$semilla = $item->appendChild($semilla);

$signature = $xml->createElement('Signature');
$signature = $gettoken->appendChild($signature);
$signature->setAttribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");


$signedinfo = $xml->createElement('SignedInfo');
$signedinfo = $signature->appendChild($signedinfo);

$canonicalizationmethod = $xml->createElement('CanonicalizationMethod');
$canonicalizationmethod = $signedinfo->appendChild($canonicalizationmethod);
$canonicalizationmethod->setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");



$signaturevalue = $xml->createElement('SignatureValue');
$signaturevalue = $signature->appendChild($signaturevalue);




$signaturemethod = $xml->createElement('SignatureMethod');
$signaturemethod = $signedinfo->appendChild($signaturemethod);
$signaturemethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#rsa-sha1");

$reference = $xml->createElement('Reference');
$reference = $signedinfo->appendChild($reference);
$reference->setAttribute("URI","");

$transforms = $xml->createElement('Transforms');
$transforms = $reference->appendChild($transforms);
$transform = $xml->createElement("Transform"," ");
$transform = $transforms->appendChild($transform);
$transform->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#enveloped-signature");

$digestmethod = $xml->createElement('DigestMethod');
$digestmethod = $reference->appendChild($digestmethod);
$digestmethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#sha1");

$digestvalue = $xml->createElement('DigestValue','');
$digestvalue = $reference->appendChild($digestvalue);

$keyinfo = $xml->createElement('KeyInfo');
$keyinfo = $signature->appendChild($keyinfo);

$keyvalue = $xml->createElement('KeyValue');
$keyvalue = $keyinfo->appendChild($keyvalue);


$x509data = $xml->createElement('X509Data');
$x509data = $keyinfo->appendChild($x509data);






$x509certificate = $xml->createElement('X509Certificate');
$x509certificate = $x509data->appendChild($x509certificate);




$xml->formatOutput = true;  //poner los string en la variable $strings_xml:
$strings_xml = $xml->saveXML();
$xml->save('token'.$parmSemilla.'.xml');


$comando = 'xmlsec1 --sign --output tokenfirmado'.$parmSemilla.'.xml --privkey-pem /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certprueba.pem  token'.$parmSemilla.'.xml 2>&1';


echo shell_exec($comando);
$nombre_fichero = 'tokenfirmado'.$parmSemilla.'.xml';
  $archivo = fopen($nombre_fichero, "r");
   $xmldoc = fread($archivo, filesize($nombre_fichero));

$servicio="https://maullin.sii.cl/DTEWS/GetTokenFromSeed.jws?WSDL"; //url del servicio
$client = new SoapClient($servicio);
$result = $client->getToken($xmldoc);

$file=fopen('tokensigned'.$parmSemilla.'.xml',"a");
fputs($file,$result);

$doc = new DOMDocument;
$doc->load('tokensigned'.$parmSemilla.'.xml');

$items = $doc->getElementsByTagName('TOKEN');

for ($i = 0; $i < $items->length; $i++) {
    $token = $items->item($i)->nodeValue . "\n";
}
return $token;

$items = $doc->getElementsByTagName('GLOSA');

for ($i = 0; $i < $items->length; $i++) {
    $token = $items->item($i)->nodeValue . "\n";
}
echo "GLOSA: ".$token.'<br>';


$items = $doc->getElementsByTagName('ESTADO');

for ($i = 0; $i < $items->length; $i++) {
    $token = $items->item($i)->nodeValue . "\n";
}
echo "ESTADO: ".$token.'<br>';
}
}




?>