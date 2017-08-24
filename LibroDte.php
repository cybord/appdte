<?php	
class LibroDte{	
				var $LibroCompraVenta;
				var $xml;
				var $RutEmisorLibro;
				var $RutEnvia;
				var $PeriodoTributario;
				var $FchResol;
				var $NroResol;
				var $TipoOperacion;
				var $TipoLibro;
				var  $TipoEnvio;
				var $EnvioLibro;
				var $objDb;
				var $EmpresaFchResol;
				var $EmpresaNroResol;
				var $parmRutEmisorLibro;
				var $parmRutUsuario;
				var $parmPeriodoTributario;
				var $pamTipoOperacion;
/* parametros de resumen del periodo    */
var $auxCantidadDocumentos; 
var $auxTotalExento;       
var $auxTotalAfecto;  
var $auxTotalIva;  
var $auxTotalBruto;     
var $auxCodigoSii;   
var $auxTotOpExe; 
var $auxTotOpIVAUsoComun;  
/* parametros de detalle de documento */
var $auxCodigoDocumento;
var $auxNumDoc;
var $auxRutClienteProveedor;
var $auxRazonSocial;
var $auxFechaDoc;
var $auxMontoAfecto;
var $auxMontoExento;
var $auxMontoIva;
var $auxMontoTotal;
var $ResumenPeriodo;
/* campos para las compras */
var $auxTotIVANoRec = 0;
var $auxCodIVANoRec =  1;
var $auxTotOpIVANoRec = 0;
var $auxTotMntIVANoRec = 0;
/* datos cabecera    */
var $auxTipoOperacion;
var $auxRutEmisorLibro;
var $auxRutUsuario;
var $auxPeriodoTributario;
var $auxFchResol;
var $auxNroResol;
var $auxEmpresaFchResol;
var $auxEmpresaNroResol;
function CreaLibro(){
	$this->xml = new DomDocument("1.0","ISO-8859-1");
	
	}

	

function GeneraCabezera(){
				$this->LibroCompraVenta = $this->xml->createElement('LibroCompraVenta');
				$this->LibroCompraVenta->setAttribute("version","1.0");
				$this->LibroCompraVenta->setAttribute("xmlns","http://www.sii.cl/SiiDte");
				$this->LibroCompraVenta->setAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
				$this->LibroCompraVenta->setAttribute("xsi:schemaLocation","http://www.sii.cl/SiiDte LibroCV_v10.xsd");
		 		$this->LibroCompraVenta = $this->xml->appendChild($this->LibroCompraVenta);
				$this->EnvioLibro = $this->xml->createElement("EnvioLibro");
				$this->EnvioLibro->setAttribute("ID", "F60T33");
				$this->EnvioLibro = $this->LibroCompraVenta->appendChild($this->EnvioLibro);
				
					        
}	

function CreaCaratula(){
				$Caratula = $this->xml->createElement("Caratula");
				$this->RutEmisorLibro = $this->xml->createElement("RutEmisorLibro",$this->auxRutEmisorLibro);
				$this->RutEmisorLibro = $Caratula->appendChild($this->RutEmisorLibro);
				$this->RutEnvia = $this->xml->createElement("RutEnvia",$this->auxRutUsuario);
				$this->RutEnvia = $Caratula->appendChild($this->RutEnvia);
				$this->PeriodoTributario = $this->xml->createElement("PeriodoTributario",$this->auxPeriodoTributario);
				$this->PeriodoTributario = $Caratula->appendChild($this->PeriodoTributario);
				$this->FchResol = $this->xml->createElement("FchResol",$this->auxEmpresaFchResol);
				$this->FchResol = $Caratula->appendChild($this->FchResol);
				$this->NroResol = $this->xml->createElement("NroResol",$this->auxEmpresaNroResol);
				$this->NroResol = $Caratula->appendChild($this->NroResol);
				$this->TipoOperacion = $this->xml->createElement("TipoOperacion",$this->auxTipoOperacion);
				$this->TipoOperacion = $Caratula->appendChild($this->TipoOperacion);
				$this->TipoLibro = $this->xml->createElement("TipoLibro","MENSUAL");
				$this->TipoLibro = $Caratula->appendChild($this->TipoLibro);
				$this->TipoEnvio = $this->xml->createElement("TipoEnvio","TOTAL");
				$this->TipoEnvio = $Caratula->appendChild($this->TipoEnvio);
				$Caratula = $this->EnvioLibro->appendChild($Caratula);
				$this->ResumenPeriodo = $this->xml->createElement("ResumenPeriodo");
				$this->ResumenPeriodo = $this->EnvioLibro->appendChild($this->ResumenPeriodo);
								
			
}

function CargarResumen(){
		
		$TotalesPeriodo = $this->xml->createElement("TotalesPeriodo");
		$TpoDoc = $this->xml->createElement("TpoDoc",$this->auxCodigoSii);
		$TpoDoc = $TotalesPeriodo->appendChild($TpoDoc);
		$TpoImp = $this->xml->createElement("TpoImp",1);		
		$TpoImp = $TotalesPeriodo->appendChild($TpoImp);		
		$TotDoc = $this->xml->createElement("TotDoc",$this->auxCantidadDocumentos);
		$TotDoc = $TotalesPeriodo->appendChild($TotDoc);
							

		 if($this->auxTotOpExe>0){
				 $TotOpExe = $this->xml->createElement("TotOpExe",$this->auxTotOpExe);
				 $TotOpExe = $TotalesPeriodo->appendChild($TotOpExe);
		 }
		 $TotMntExe = $this->xml->createElement("TotMntExe",$this->auxTotalExento);	
		 $TotMntExe = $TotalesPeriodo->appendChild($TotMntExe);
							 
		$TotMntNeto = $this->xml->createElement("TotMntNeto",$this->auxTotalAfecto);
		$TotMntNeto = $TotalesPeriodo->appendChild($TotMntNeto);
		$TotMntIVA = $this->xml->createElement("TotMntIVA",$this->auxTotalIva);
		$TotMntIVA = $TotalesPeriodo->appendChild($TotMntIVA);
							
		 if($this->auxTipoOperacion=='COMPRA'){
			 $TotIVANoRec = $this->xml->createElement("TotIVANoRec");
			 $CodIVANoRec =  $this->xml->createElement("CodIVANoRec",1);
			 $TotOpIVANoRec = $this->xml->createElement("TotOpIVANoRec",$this->auxTotOpIVANoRec);
			 $TotMntIVANoRec = $this->xml->createElement("TotMntIVANoRec",$this->auxTotMntIVANoRec);
             $CodIVANoRec = $TotIVANoRec->appendChild($CodIVANoRec);
			 $TotOpIVANoRec = $TotIVANoRec->appendChild($TotOpIVANoRec);
			 $TotMntIVANoRec = $TotIVANoRec->appendChild($TotMntIVANoRec);
			 $TotIVANoRec = $TotalesPeriodo->appendChild($TotIVANoRec);
		     $TotOpIVAUsoComun = $this->xml->createElement("TotOpIVAUsoComun",$this->auxTotOpIVAUsoComun);
			 $TotOpIVAUsoComun = $TotalesPeriodo->appendChild($TotOpIVAUsoComun);
			 $TotIVAUsoComun = $this->xml->createElement("TotIVAUsoComun",0);
			 $TotIVAUsoComun = $TotalesPeriodo->appendChild($TotIVAUsoComun);		
			 $TotImpSinCredito = $this->xml->createElement("TotImpSinCredito",0);			
	    }
								
		$TotMntTotal = $this->xml->createElement("TotMntTotal",$this->auxTotalBruto);								
		$TotMntTotal = $TotalesPeriodo->appendChild($TotMntTotal);	
		$TotalesPeriodo = $this->ResumenPeriodo->appendChild($TotalesPeriodo);
								 
							
								
						}
						
function CargaDetalle(){
		  $Detalle = $this->xml->createElement("Detalle");
		  $TpoDoc = $this->xml->createElement("TpoDoc",$this->auxCodigoDocumento);
		  $NroDoc =  $this->xml->createElement("NroDoc",$this->auxNumDoc);
		  $TipoImp = $this->xml->createElement("TpoImp",1);
		  $TasaImp =  $this->xml->createElement("TasaImp",0.19);
		  $FchDoc = $this->xml->createElement("FchDoc", $this->auxFechaDoc);
		  $RUTDoc = $this->xml->createElement("RUTDoc",$this->auxRutClienteProveedor);
		  $RznSoc = $this->xml->createElement("RznSoc",$this->auxRazonSocial);
			if($this->auxTotOpExe>0){
				$MntExe = $this->xml->createElement("MntExe",$this->auxMontoExento);
			}
		   $MntNeto = $this->xml->createElement("MntNeto",$this->auxMontoAfecto);				
			/*	$IVAUsoComun = $this->xml->createElement("IVAUsoComun",$this->auxMontoIva); */
			//	$MntSinCred = $this->xml->createElement("MntSinCred",0);
			$MntTotal = $this->xml->createElement("MntTotal",$this->auxMontoTotal);
			$TpoDoc = $Detalle->appendChild($TpoDoc);
			$NroDoc =  $Detalle->appendChild($NroDoc);
			$TipoImp = $Detalle->appendChild($TipoImp);
			$TasaImp = $Detalle->appendChild($TasaImp);
			$FchDoc = $Detalle->appendChild($FchDoc);
			$RUTDoc = $Detalle->appendChild($RUTDoc);
			$RznSoc = $Detalle->appendChild($RznSoc);
			if($this->auxTotOpExe>0){
					$MntExe = $Detalle->appendChild($MntExe);
			}
			$MntIva = $this->xml->createElement("MntIVA",$this->auxMontoIva);
			$MntNeto = $Detalle->appendChild($MntNeto);
			$MntIva = $Detalle->appendChild($MntIva);
			/*		$IVANoRec =  $this->xml->createElement("IVANoRec");
			$CodIVANoRec = $this->xml->createElement("CodIVANoRec",1);
			$MntIVANoRec = $this->xml->createElement("MntIVANoRec",$resultado['IVA']);
			$CodIVANoRec = $IVANoRec->appendChild($CodIVANoRec);
			$MntIVANoRec = $IVANoRec->appendChild($MntIVANoRec);
			$IVANoRec = $Detalle->appendChild($IVANoRec);
			*/
			/*	$IVAUsoComun = $Detalle->appendChild($IVAUsoComun);*/
			//	$MntSinCred = $Detalle->appendChild($MntSinCred);
			$MntTotal = $Detalle->appendChild($MntTotal);
			$Detalle = $this->EnvioLibro->appendChild($Detalle);
}						
						
						

function AgregaFirma(){
	
		$FechaHora = time();
		$TmstFirma = $this->xml->createElement("TmstFirma", date('Y-m-d',$FechaHora)."T".date('H:i:s',$FechaHora));	
		$TmstFirma = $this->EnvioLibro->appendChild($TmstFirma);
		$signature = $this->xml->createElement('Signature');
		$signature = $this->LibroCompraVenta->appendChild($signature);
		$signature->setAttribute("xmlns", "http://www.w3.org/2000/09/xmldsig#");
		$signedinfo = $this->xml->createElement('SignedInfo');
		$signedinfo = $signature->appendChild($signedinfo);
		$canonicalizationmethod = $this->xml->createElement('CanonicalizationMethod');
		$canonicalizationmethod = $signedinfo->appendChild($canonicalizationmethod);
		$canonicalizationmethod->setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
		$signaturevalue = $this->xml->createElement('SignatureValue');
		$signaturevalue = $signature->appendChild($signaturevalue);
		$signaturemethod = $this->xml->createElement('SignatureMethod');
		$signaturemethod = $signedinfo->appendChild($signaturemethod);
		$signaturemethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#rsa-sha1");
		$reference = $this->xml->createElement('Reference');
		$reference->setAttribute("URI","#F60T33");
		$reference = $signedinfo->appendChild($reference);
		$transforms = $this->xml->createElement('Transforms');
		$transforms = $reference->appendChild($transforms);
		$transform = $this->xml->createElement("Transform");
		$transform = $transforms->appendChild($transform);
		$transform->setAttribute("Algorithm","http://www.w3.org/TR/2001/REC-xml-c14n-20010315");
		$digestmethod = $this->xml->createElement('DigestMethod');
		$digestmethod = $reference->appendChild($digestmethod);
		$digestmethod->setAttribute("Algorithm","http://www.w3.org/2000/09/xmldsig#sha1");
		$digestvalue = $this->xml->createElement('DigestValue','');
		$digestvalue = $reference->appendChild($digestvalue);
		$keyinfo = $this->xml->createElement('KeyInfo');
		$keyinfo = $signature->appendChild($keyinfo);
		$keyvalue = $this->xml->createElement('KeyValue');
		$keyvalue = $keyinfo->appendChild($keyvalue);
		$x509data = $this->xml->createElement('X509Data');
		$x509data = $keyinfo->appendChild($x509data);
		$x509certificate = $this->xml->createElement('X509Certificate');
		$x509certificate = $x509data->appendChild($x509certificate);
	
									
}

function GuardarLibro($parmNombreArchivo){
				$this->xml->save('../DTE/'.$parmNombreArchivo.'.xml');		
}
function IdentarLibro($parmNombreArchivo){
	require '../includes/FormatXml.php';
	FormatXml("../DTE/".$parmNombreArchivo.".xml");
	
}
function FirmarLibro($parmNombreArchivo){
	$comando = 'xmlsec1 --sign --output /home/appventa/public_html/DTE/'.$parmNombreArchivo.'firmado.xml --privkey-pem /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certprueba.pem --id-attr:ID EnvioLibro /home/appventa/public_html/DTE/'.$parmNombreArchivo.'.xml 2>&1';
	
	shell_exec($comando);
}
}



?>	