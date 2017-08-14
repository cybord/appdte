
<?php

require_once '../includes/TipoDocumentos.php';
Class EnvioDTE{
var $EnvioDte;
var $xml;
var $EmpresaRut;       
var $ClienteProveedorRut;
var $RutUsuario;
var $fecha;
var $hora;
var $TipoDocumento;
var $objTipoDocumento;
var $CodigoSii;		
var $Folio;	
var $MovimientoId;
function EnvioDTE(){
	
$FechaHora = time();	
	
$this->fecha = date('Y-m-d',$FechaHora);
$this->hora = date('H:i:s',$FechaHora);
	
	
}

	function CreaEnvioDTE($parmTipoDocumento,$parmFolio){
			$this->objTipoDocumento = new TipoDocumentos();
			$this->CodigoSii = $this->objTipoDocumento->BuscaTipoDte($parmTipoDocumento);
			$this->Folio = $parmFolio;
		$this->CabeceraEnvio();     
		
		}
		

    function CabeceraEnvio(){
	
	
				$this->xml = new DomDocument("1.0","ISO-8859-1");
			
						$this->EnvioDte = $this->xml->createElement('envio:EnvioDTE');
				
					//	$this->EnvioDte->setAttribute("xmlns","http://www.sii.cl/SiiDte");
					//	$this->EnvioDte->setAttribute("xmlns:envio","http://www.sii.cl/SiiDte");
					//	$this->EnvioDte->setAttribute("xmlns:dsig","http://www.w3.org/2000/09/xmldsig#");
				    //	$this->EnvioDte->setAttribute("xmlns:xsi","http//www.w3.org/2001/XMLSchema-instance");
					//	$this->EnvioDte->setAttribute("xsi:schemaLocation","http://www.sii.cl/SiiDte EnvioDTE_v10.xsd");
					 //   $this->EnvioDte->setAttribute("version","1.0");
				
				$this->EnvioDte = $this->xml->appendChild($this->EnvioDte);
				
				
							$SetDTE = $this->xml->createElement('SetDTE');
							$SetDTE = $this->EnvioDte->appendChild($SetDTE);
							$SetDTE->setAttribute("ID","SetDoc");

							$Caratula = $this->xml->createElement('Caratula');
							$Caratula->setAttribute("version","1.0");
							$Caratula = $SetDTE->appendChild($Caratula);
								
							$RutEmisor = $this->xml->createElement('RutEmisor',$this->EmpresaRut);
							$RutEmisor = $Caratula->appendChild($RutEmisor);

						    $RutEnvia = $this->xml->createElement('RutEnvia','13968481-8');
							$RutEnvia = $Caratula->appendChild($RutEnvia);

							$RutReceptor = $this->xml->createElement('RutReceptor','60803000-K');
							$RutReceptor = $Caratula->appendChild($RutReceptor);

						    $FchResol = $this->xml->createElement('FchResol','2016-04-25');
							$FchResol = $Caratula->appendChild($FchResol);

							$NroResol = $this->xml->createElement('NroResol',0);
							$NroResol = $Caratula->appendChild($NroResol);

					        $TmstFirmaEnv = $this->xml->createElement('TmstFirmaEnv',$this->fecha.'T'.$this->hora);
							$TmstFirmaEnv = $Caratula->appendChild($TmstFirmaEnv);

						$SubTotDte = $this->xml->createElement('SubTotDTE');
						$SubTotDte = $Caratula->appendChild($SubTotDte);

						$TpoDte = $this->xml->createElement('TpoDTE',$this->CodigoSii);
						$TpoDte = $SubTotDte->appendChild($TpoDte);


						$NroDte = $this->xml->createElement('NroDTE',1);
						$NroDte = $SubTotDte->appendChild($NroDte);
						$this->CabeceraFirmaEnvio();
			}
			
			function CabeceraFirmaEnvio(){
											
						
					        		$signature = $this->xml->createElement('dsig:Signature');
									$signature = $this->EnvioDte->appendChild($signature);
									$signature->setAttribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");
								
									$signedinfo = $this->xml->createElement('dsig:SignedInfo');
									$signedinfo = $signature->appendChild($signedinfo);
									$canonicalizationmethod = $this->xml->createElement('dsig:CanonicalizationMethod');
									$canonicalizationmethod = $signedinfo->appendChild($canonicalizationmethod);
									$canonicalizationmethod->setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
									$signaturevalue = $this->xml->createElement('dsig:SignatureValue');
									$signaturevalue = $signature->appendChild($signaturevalue);
									$signaturemethod = $this->xml->createElement('dsig:SignatureMethod');
									$signaturemethod = $signedinfo->appendChild($signaturemethod);
									$signaturemethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#rsa-sha1");
									$reference = $this->xml->createElement('dsig:Reference');
									$reference->setAttribute("URI","#SetDoc");
									$reference = $signedinfo->appendChild($reference);
									$transforms = $this->xml->createElement('dsig:Transforms');
									$transforms = $reference->appendChild($transforms);
									$transform = $this->xml->createElement("dsig:Transform");
									$transform = $transforms->appendChild($transform);
									$transform->setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
									$digestmethod = $this->xml->createElement('dsig:DigestMethod');
									$digestmethod = $reference->appendChild($digestmethod);
									$digestmethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#sha1");
									
									$digestvalue = $this->xml->createElement('dsig:DigestValue','');
									$digestvalue = $reference->appendChild($digestvalue);
									//conversion de archivos
									//shell_exec("openssl dgst -sign /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certificadaoprueba.pem -out mysig.bin semilla.txt");
									//shell_exec("openssl base64 -in mysig.bin -out firma.txt");
									$keyinfo = $this->xml->createElement('dsig:KeyInfo');
									$keyinfo = $signature->appendChild($keyinfo);
									$keyvalue = $this->xml->createElement('dsig:KeyValue');
									$keyvalue = $keyinfo->appendChild($keyvalue);
									$x509data = $this->xml->createElement('dsig:X509Data');
									$x509data = $keyinfo->appendChild($x509data);
									$x509certificate = $this->xml->createElement('dsig:X509Certificate');
									$x509certificate = $x509data->appendChild($x509certificate);
									$this->GeneraXml();
									
			}
			function GeneraXml(){
					$this->xml->save('../DTE/EnvioDTE'.$this->MovimientoId.'.xml');	
					$this->CargaDte();
			}
			
			
			function CargaDte(){
				
	       $ArchivoDTE = fopen("../DTE/dtefirmado".$this->MovimientoId.".xml", "r");
			$ContenidoDTE = fread($ArchivoDTE,filesize("../DTE/dtefirmado".$this->MovimientoId.".xml"));
	        $ContenidoDTE = str_replace('<?xml version="1.0" encoding="ISO-8859-1"?>','',$ContenidoDTE);
	        
				
		
			$ArchivoEnvioDTE = fopen("../DTE/EnvioDTE".$this->MovimientoId.".xml", "r");
				$ContenidoEnvioDTE = fread($ArchivoEnvioDTE,filesize("../DTE/EnvioDTE".$this->MovimientoId.".xml"));
				$ContenidoEnvioDTE = str_replace('<envio:EnvioDTE>','<envio:EnvioDTE xmlns="http://www.sii.cl/SiiDte" xmlns:envio="http://www.sii.cl/SiiDte" xmlns:dsig="http://www.w3.org/2000/09/xmldsig#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sii.cl/SiiDte EnvioDTE_v10.xsd" version="1.0">',$ContenidoEnvioDTE);
				$ContenidoEnvioDTE = str_replace('</Caratula>','</Caratula>'.$ContenidoDTE,$ContenidoEnvioDTE);
				
				fclose($ArchivoEnvioDTE);
				 
				unlink('/home/appventa/public_html/DTE/EnvioDTE'.$this->MovimientoId.'.xml');
				
				$ArchivoEnvioDTE = fopen('../DTE/EnvioDTE'.$this->MovimientoId.'.xml','a');
				fputs($ArchivoEnvioDTE,$ContenidoEnvioDTE);
			    fclose($ArchivoEnvioDTE);
		         $comando = 'xmlsec1 --sign --output /home/appventa/public_html/DTE/EnvioDTEfirmado'.$this->MovimientoId.'.xml --privkey-pem /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certprueba.pem --id-attr:ID SetDTE --node-xpath /envio:EnvioDTE/dsig:Signature /home/appventa/public_html/DTE/EnvioDTE'.$this->MovimientoId.'.xml 2>&1';
		           echo shell_exec($comando);
			
			}
			
			
			
			
			
}			