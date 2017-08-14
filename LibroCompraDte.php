<?php	
require_once '../includes/FuncionesDb.php';
class LibroCompraDte{	
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
				var $LibroCompraId;
function CreaLibro(){
	$this->xml = new DomDocument("1.0","ISO-8859-1");
	$this->objDb = new FuncionesDb();
	$this->GeneraCabezera();
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
				$this->CreaCaratula();
				
}	

function CreaCaratula(){
				$Caratula = $this->xml->createElement("Caratula");
				
				$this->RutEmisorLibro = $this->xml->createElement("RutEmisorLibro",$this->parmRutEmisorLibro);
				$this->RutEmisorLibro = $Caratula->appendChild($this->RutEmisorLibro);
				
				$this->RutEnvia = $this->xml->createElement("RutEnvia",$this->parmRutUsuario);
				$this->RutEnvia = $Caratula->appendChild($this->RutEnvia);
				
				$this->PeriodoTributario = $this->xml->createElement("PeriodoTributario",$this->parmPeriodoTributario);
				$this->PeriodoTributario = $Caratula->appendChild($this->PeriodoTributario);
				
				$this->FchResol = $this->xml->createElement("FchResol",$this->EmpresaFchResol);
				$this->FchResol = $Caratula->appendChild($this->FchResol);
				
				$this->NroResol = $this->xml->createElement("NroResol",$this->EmpresaNroResol);
				$this->NroResol = $Caratula->appendChild($this->NroResol);
				
				$this->TipoOperacion = $this->xml->createElement("TipoOperacion","COMPRA");
				$this->TipoOperacion = $Caratula->appendChild($this->TipoOperacion);
				
				$this->TipoLibro = $this->xml->createElement("TipoLibro","MENSUAL");
				$this->TipoLibro = $Caratula->appendChild($this->TipoLibro);
				
				$this->TipoEnvio = $this->xml->createElement("TipoEnvio","TOTAL");
				$this->TipoEnvio = $Caratula->appendChild($this->TipoEnvio);
				$Caratula = $this->EnvioLibro->appendChild($Caratula);
				$this->CargarResumen();
			
}

function CargarResumen(){
						
     						$idLibroCompra = $this->LibroCompraId;
						
							$ResumenPeriodo = $this->xml->createElement("ResumenPeriodo");
							
							$this->objDb->ConnectDb();	
							$this->objDb->SelectDb("AppVentasInventario");
									
							$sql = "select TipoDocumentos.CodigoSii, count(TipoDocumentos.CodigoSii) as CANTIDADDOCUMENTOS, sum(DetalleLibroCompra.IVA)AS IVA, sum(DetalleLibroCompra.MONTONETO) AS MONTONETO,sum(DetalleLibroCompra.MONTOEXENTO) AS MONTOEXENTO, sum(DetalleLibroCompra.TOTALBRUTO) AS TOTALBRUTO from DetalleLibroCompra \n";
							$sql = $sql."inner join LibroCompra on DetalleLibroCompra.LibroCompraId = LibroCompra.LibroCompraId \n";
							$sql = $sql."inner join TipoDocumentos ON TipoDocumentos.TipoDocumentoId = DetalleLibroCompra.TipoDocumentoId \n";
							$sql = $sql."where LibroCompra.LibroCompraId=$idLibroCompra \n";
							$sql = $sql."Group by TipoDocumentos.CodigoSii";

							

							
							$this->objDb->ExecuteSql($sql);
						     while($resultado = $this->objDb->FetchArray()){
								 $TotalesPeriodo = $this->xml->createElement("TotalesPeriodo");
								 $TotalesPeriodo = $ResumenPeriodo->appendChild($TotalesPeriodo);
								 $TpoDoc = $this->xml->createElement("TpoDoc",$resultado['CodigoSii']);
								 $TpoDoc = $TotalesPeriodo->appendChild($TpoDoc);
								 $TpoImp = $this->xml->createElement("TpoImp",1);		
								 $TpoImp = $TotalesPeriodo->appendChild($TpoImp);		
								 $TotDoc = $this->xml->createElement("TotDoc",$resultado['CANTIDADDOCUMENTOS']);
								 $TotDoc = $TotalesPeriodo->appendChild($TotDoc);
							//	 $TotOpExe = $this->xml->createElement("TotOpExe",0);
							//	 $TotOpExe = $TotalesPeriodo->appendChild($TotOpExe);
								 $TotMntExe = $this->xml->createElement("TotMntExe",0);	
								 $TotMntExe = $TotalesPeriodo->appendChild($TotMntExe);
								 $TotMntNeto = $this->xml->createElement("TotMntNeto",$resultado['MONTONETO']);
								 $TotMntNeto = $TotalesPeriodo->appendChild($TotMntNeto);
								 $TotMntIVA = $this->xml->createElement("TotMntIVA",0);
								 $TotMntIVA = $TotalesPeriodo->appendChild($TotMntIVA);
								 $TotIVANoRec = $this->xml->createElement("TotIVANoRec");
								 $CodIVANoRec =  $this->xml->createElement("CodIVANoRec",1);
								 $TotOpIVANoRec = $this->xml->createElement("TotOpIVANoRec",$resultado['CANTIDADDOCUMENTOS']);
								 $TotMntIVANoRec = $this->xml->createElement("TotMntIVANoRec",$resultado['IVA']);
                                         
                                  $CodIVANoRec = $TotIVANoRec->appendChild($CodIVANoRec);
								  $TotOpIVANoRec = $TotIVANoRec->appendChild($TotOpIVANoRec);
								  $TotMntIVANoRec = $TotIVANoRec->appendChild($TotMntIVANoRec);
								 
								  $TotIVANoRec = $TotalesPeriodo->appendChild($TotIVANoRec);
								 
								 
								// $TotOpIVAUsoComun = $this->xml->createElement("TotOpIVAUsoComun",0);
								 //$TotOpIVAUsoComun = $TotalesPeriodo->appendChild($TotOpIVAUsoComun);
								// $TotIVAUsoComun = $this->xml->createElement("TotIVAUsoComun",0);
								 //$TotIVAUsoComun = $TotalesPeriodo->appendChild($TotIVAUsoComun);		
								 $TotImpSinCredito = $this->xml->createElement("TotImpSinCredito",0);			
								 $TotMntTotal = $this->xml->createElement("TotMntTotal",$resultado['TOTALBRUTO']);								
								 $TotMntTotal = $TotalesPeriodo->appendChild($TotMntTotal);	
								 $TotalesPeriodo = $ResumenPeriodo->appendChild($TotalesPeriodo);
								 $ResumenPeriodo = $this->EnvioLibro->appendChild($ResumenPeriodo);
								 
							 }
								$this->CargaDetalleLibro();
						}
						
function CargaDetalleLibro(){
								$this->objDb->ConnectDb();	
								$this->objDb->SelectDb("AppVentasInventario");
								$idLibroCompra = $this->LibroCompraId;
						
                                $sql= "select TipoDocumentos.CodigoSii, DetalleLibroCompra.* from DetalleLibroCompra \n";
								$sql= $sql."inner join LibroCompra on DetalleLibroCompra.LibroCompraId = LibroCompra.LibroCompraId \n";
								$sql= $sql."inner join TipoDocumentos ON TipoDocumentos.TipoDocumentoId = DetalleLibroCompra.TipoDocumentoId \n";
						        $sql= $sql."where LibroCompra.LibroCompraId=$idLibroCompra \n";
							
								$this->objDb->ExecuteSql($sql);
							while($resultado = $this->objDb->FetchArray()){
								$Detalle = $this->xml->createElement("Detalle");
								$TpoDoc = $this->xml->createElement("TpoDoc",$resultado['CodigoSii']);
								$NroDoc =  $this->xml->createElement("NroDoc",$resultado['NumDoc']);
								$TipoImp = $this->xml->createElement("TpoImp",1);
								$TasaImp =  $this->xml->createElement("TasaImp",19.0);
								
								
								$FchDoc = $this->xml->createElement("FchDoc", $resultado['FechaDoc']);
								$RUTDoc = $this->xml->createElement("RUTDoc",$resultado['RutProveedor']);
								$RznSoc = $this->xml->createElement("RznSoc","AMULEN CONSULTORES LTDA");
						//		$MntExe = $this->xml->createElement("MntExe",$resultado['MONTOEXENTO']);
								$MntNeto = $this->xml->createElement("MntNeto",$resultado['MONTONETO']);
					
								
								
								
								
								
							//	$IVAUsoComun = $this->xml->createElement("IVAUsoComun",0);
							//	$MntSinCred = $this->xml->createElement("MntSinCred",0);
								$MntTotal = $this->xml->createElement("MntTotal",$resultado['TOTALBRUTO']);
								
								$TpoDoc = $Detalle->appendChild($TpoDoc);
								$NroDoc =  $Detalle->appendChild($NroDoc);
								$TipoImp = $Detalle->appendChild($TipoImp);
								$TasaImp = $Detalle->appendChild($TasaImp);
								$FchDoc = $Detalle->appendChild($FchDoc);
								$RUTDoc = $Detalle->appendChild($RUTDoc);
								$RznSoc = $Detalle->appendChild($RznSoc);
							//	$MntExe = $Detalle->appendChild($MntExe);
								$MntNeto = $Detalle->appendChild($MntNeto);
								
										
								$IVANoRec =  $this->xml->createElement("IVANoRec");
								$CodIVANoRec = $this->xml->createElement("CodIVANoRec",1);
								$MntIVANoRec = $this->xml->createElement("MntIVANoRec",$resultado['IVA']);
								
								
								
								$CodIVANoRec = $IVANoRec->appendChild($CodIVANoRec);
								$MntIVANoRec = $IVANoRec->appendChild($MntIVANoRec);
								
								$IVANoRec = $Detalle->appendChild($IVANoRec);
								
												
								
							//	$IVAUsoComun = $Detalle->appendChild($IVAUsoComun);
							//	$MntSinCred = $Detalle->appendChild($MntSinCred);
								$MntTotal = $Detalle->appendChild($MntTotal);
								$Detalle = $this->EnvioLibro->appendChild($Detalle);
							
								$FechaHora = time();
								$TmstFirma = $this->xml->createElement("TmstFirma", date('Y-m-d',$FechaHora)."T".date('H:i:s',$FechaHora));	
							    $TmstFirma = $this->EnvioLibro->appendChild($TmstFirma);
								
							}
								$this->EnvioLibro = $this->LibroCompraVenta->appendChild($this->EnvioLibro);
								
								$this->AgregaFirma();
						
}						
						
						

function AgregaFirma(){
	
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
	
									$this->GuardarLibro();
}

function GuardarLibro(){
	$idLibroCompra = $this->LibroCompraId;
						
				$this->xml->save('../DTE/LibroCompra'.$idLibroCompra.'.xml');	
	$this->IdentarLibro();
	
}
function IdentarLibro(){
	$idLibroCompra = $this->LibroCompraId;
						
	require '../includes/FormatXml.php';
	FormatXml("../DTE/LibroCompra".$idLibroCompra.".xml");
	$this->FirmarLibro();
}
function FirmarLibro(){
	$idLibroCompra = $this->LibroCompraId;
	$comando = 'xmlsec1 --sign --output /home/appventa/public_html/DTE/LibroCompra'.$idLibroCompra.'firmado.xml --privkey-pem /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certprueba.pem --id-attr:ID EnvioLibro /home/appventa/public_html/DTE/LibroCompra'.$idLibroCompra.'.xml 2>&1';
	echo $comando;
	shell_exec($comando);
}
}



?>	