
<?php


ini_set('default_charset','iso8859-1');
require_once '../libdte/LecturaCaf.php';
require_once '../includes/TipoDocumentos.php';
require_once '../includes/BlobData.php';
require_once '../includes/AppRecord.php';
require_once '../includes/FormatoFecha.php';

				Class ClassDte{
											var $objCaf;
											var $xml;
											var $EnvioDte;
											var $Documento;
											var $DTE;
											var $objTipoDocumento;
											//datos del emisor
											var $EmpresaRaz;
											var $EmpresaRut;
											var $EmpresaGir;
											var $EmpresaDir;
											var $EmpresaFon;
											var $EmpresaEma;

											var $EmpresaCiu;
											var $EmpresaCom;
											var $EmpresaActeco;
											//datos del receptor
											var $ClienteProveedorRut;
											var $ClienteProveedorRaz;
											var $ClienteProveedorGir;
											var $ClienteProveedorDir;
											var $ClienteProveedorCom;
											var $ClienteProveedorCiu;
											var $ClienteProveedorFon;
											var $hora;
											var $fecha;
											var $NroDetalle;
											var $EmpresaId;
											var $TipoDocumento;
											var $NumFolio;
											var $MovimientoId;
											//recoge los totales
											var $ParmMontoNeto;
											var $ParmTasaIva;
											var $ParmIva;
											var $ParmValorTotal;
											var $ParmMontoExento;
											var $auxNombre;
											var $auxCadena;
											var $FlagDescuento;
											var $FlagRecargo;
											var $Detalle;
											var $NroLineaDescuento;
											var $TipoDTE;
											var $FlagIva;
											//variables para la referencia de la nota de credito
											var $parmRazonRef;
											var $parmTpoDocRef;
											var $parmNroFolioRef;
											var $parmCodRef;
											var $parmFchRef;
											
											
											//variables para la referencia 2 de la nota de credito
											var $parmRazonRef2;
											var $parmTpoDocRef2;
											var $parmNroFolioRef2;
											var $parmCodRef2;
											var $parmFchRef2;
										
											
											
											
											
											
function  ClassDte($parmIdEmpresa,$parmTipoDocumento,$parmIdMovimiento){
$this->MovimientoId = $parmIdMovimiento;

$FechaHora = time();	
//$this->hora= date ();
$this->fecha = date('Y-m-d',$FechaHora);
$this->hora = date('H:i:s',$FechaHora);
	$this->objCaf = new LecturaCaf($parmTipoDocumento);
	$this->NroDetalle = 1;
$this->EmpresaId = $parmIdEmpresa;
$this->TipoDocumento = $parmTipoDocumento;
	}

		function CreaDocumento(){
				$this->xml = new DomDocument("1.0","ISO-8859-1");
		    
		}

function GeneraCabezera(){
							
							$this->objTipoDocumento = new TipoDocumentos();
							$this->DTE = $this->xml->createElement('DTE');
							$this->DTE = $this->xml->appendChild($this->DTE);
							$this->DTE->setAttribute("version", "1.0");
					
							$this->Documento = $this->xml->createElement('Documento');
							
							$this->Documento = $this->DTE->appendChild($this->Documento);
							$this->Documento->setAttribute("ID","F".$this->NumFolio."T".$this->objTipoDocumento->BuscaTipoDte($this->TipoDocumento));
							$Encabezado = $this->xml->createElement('Encabezado');
							$Encabezado = $this->Documento->appendChild($Encabezado);

							$IdDoc = $this->xml->createElement('IdDoc');
							$IdDoc = $Encabezado->appendChild($IdDoc);
							

							$this->TipoDTE = $this->xml->createElement('TipoDTE',$this->objTipoDocumento->BuscaTipoDte($this->TipoDocumento));
							$this->FlagIva = $this->objTipoDocumento->FlagIva;
							$this->TipoDTE = $IdDoc->appendChild($this->TipoDTE);
							 
							$Folio = $this->xml->createElement('Folio',$this->NumFolio);
							$Folio = $IdDoc->appendChild($Folio);
							 
							$FchaEmis = $this->xml->createElement('FchEmis',$this->fecha);
							$FchaEmis = $IdDoc->appendChild($FchaEmis);


							$Emisor = $this->xml->createElement('Emisor');
							$Emisor = $Encabezado->appendChild($Emisor);

							$RUTEmisor = $this->xml->createElement('RUTEmisor',$this->EmpresaRut);
							$RUTEmisor = $Emisor->appendChild($RUTEmisor);

							$RznSoc = $this->xml->createElement('RznSoc',$this->EmpresaRaz);
							$RznSoc = $Emisor->appendChild($RznSoc);

							$GiroEmis = $this->xml->createElement('GiroEmis',$this->EmpresaGir);
							$GiroEmis = $Emisor->appendChild($GiroEmis);


							$Acteco = $this->xml->createElement('Acteco',$this->EmpresaActeco);
							$Acteco = $Emisor->appendChild($Acteco);

							$CdgSIISucur = $this->xml->createElement('CdgSIISucur',1);
							$CdgSIISucur = $Emisor->appendChild($CdgSIISucur);

							$DirOrigen =  $this->xml->createElement('DirOrigen',$this->EmpresaDir);
							$DirOrigen = $Emisor->appendChild($DirOrigen);


							$CmnaOrigen = $this->xml->createElement('CmnaOrigen',$this->EmpresaCom);
							$CmnaOrigen = $Emisor->appendChild($CmnaOrigen);

							$CiudadOrigen = $this->xml->createElement('CiudadOrigen',$this->EmpresaCiu);
							$CiudadOrigen = $Emisor->appendChild($CiudadOrigen);


							$Receptor  = $this->xml->createElement('Receptor');
							$Receptor = $Encabezado->appendChild($Receptor);

							$RUTRecep = $this->xml->createElement('RUTRecep',$this->ClienteProveedorRut);
							$RUTRecep = $Receptor->appendChild($RUTRecep);

							$RznSocRecep = $this->xml->createElement('RznSocRecep',$this->ClienteProveedorRaz);
							$RznSocRecep = $Receptor->appendChild($RznSocRecep);

							$GiroRecep = $this->xml->createElement('GiroRecep',$this->ClienteProveedorGir);
							$GiroRecep = $Receptor->appendChild($GiroRecep);

							$DirRecep = $this->xml->createElement('DirRecep',$this->ClienteProveedorDir);
							$DirRecep = $Receptor->appendChild($DirRecep);

							$CmnaRecep = $this->xml->createElement('CmnaRecep',$this->ClienteProveedorCiu);
							$CmnaRecep = $Receptor->appendChild($CmnaRecep);

							$CiudadRecep = $this->xml->createElement('CiudadRecep',$this->ClienteProveedorCiu);
							$CiudadRecep = $Receptor->appendChild($CiudadRecep);

							$Totales = $this->xml->createElement('Totales');
							$Totales = $Encabezado->appendChild($Totales);
							
							
							
							
							$MntNeto = $this->xml->createElement('MntNeto',$this->ParmMontoNeto);
							$MntNeto = $Totales->appendChild($MntNeto);
							
							if($this->ParmMontoExento>0){
														
							$MntExe = $this->xml->createElement('MntExe',$this->ParmMontoExento);
							$MntExe = $Totales->appendChild($MntExe);
							}
												
							
							if($this->FlagIva==1){
							$TasaIva = $this->xml->createElement('TasaIVA',($this->ParmTasaIva*100));
							$TasaIva = $Totales->appendChild($TasaIva);

							$IVA = $this->xml->createElement('IVA',$this->ParmIva);
							$IVA = $Totales->appendChild($IVA);
							}
							
								
							
							$MntTotal = $this->xml->createElement('MntTotal',$this->ParmValorTotal);
							$MntTotal = $Totales->appendChild($MntTotal);
	
}

				function AgregaDetalle($parmProductoCod,$parmProductoNom,$parmProductoPre,$parmCantidad,$parmDescuentoMonto,$parmRecargo,$parmPorcentaje,$parmProductoAfectoExento,$parmTotalDetalle){
							
								
							$this->Detalle = $this->xml->createElement('Detalle');

							$NroLinDet = $this->xml->createElement('NroLinDet',$this->NroDetalle);

							$NroLinDet = $this->Detalle->appendChild($NroLinDet);

							$CdgItem = $this->xml->createElement('CdgItem');
							$CdgItem = $this->Detalle->appendChild($CdgItem);

							$TpoCodigo = $this->xml->createElement('TpoCodigo','INT');
							$TpoCodigo = $CdgItem->appendChild($TpoCodigo);

							$VlrCodigo = $this->xml->createElement('VlrCodigo',$parmProductoCod);
							$VlrCodigo = $CdgItem->appendChild($VlrCodigo);
							
								if($parmProductoAfectoExento==0){
						          $IndExe = $this->xml->createElement('IndExe',1);	
						            $IndExe = $this->Detalle->appendChild($IndExe);
						        }

							
							
                           
							$NmbItem = $this->xml->createElement('NmbItem',$this->HtmlChars($parmProductoNom));
							$NmbItem = $this->Detalle->appendChild($NmbItem);
						
                   
							$DscItem = $this->xml->createElement('DscItem',$this->FormatoCaracter($parmProductoNom));
							$DscItem = $this->Detalle->appendChild($DscItem);
							
							if($this->NroDetalle==1){
								$this->auxNombre = $parmProductoNom;
								
							}	
							
						//	$DescItem = $this->xml->createElement('DscItem');
						//	$DescItem = $this->Detalle->appendChild($DescItem);

						
						if($parmCantidad>0){
							$QtyItem = $this->xml->createElement('QtyItem',$parmCantidad);
							$QtyItem = $this->Detalle->appendChild($QtyItem);
						}

						if($parmProductoPre>0){

							$PrcItem = $this->xml->createElement('PrcItem',$parmProductoPre);
							$PrcItem = $this->Detalle->appendChild($PrcItem);
						}
							//si hay descuentos y recargos se agregan
							//en el descuento agrego la siguientes lineas
							$RecargoMonto = 0;
							$DescuentoMonto = 0;
									
							if($parmDescuentoMonto>0){
								$DescuentoPct = $this->xml->createElement('DescuentoPct',$parmPorcentaje);	
								$DescuentoPct = $this->Detalle->appendChild($DescuentoPct);	
								$DescuentoMonto = $this->xml->createElement('DescuentoMonto',round(($parmDescuentoMonto * $parmCantidad)));
								$DescuentoMonto = $this->Detalle->appendChild($DescuentoMonto);
							}
						
						if($parmRecargo>0){
								$RecargoPct = $this->xml->createElement('RecargoPct',$parmPorcentaje);	
								$RecargoPct = $this->Detalle->appendChild($RecargoPct);	
								$RecargoMonto = $this->xml->createElement('RecargoMonto',round($parmRecargo * $parmCantidad));
								$RecargoMonto = $this->Detalle->appendChild($RecargoMonto);
							}
						
						
						
						
						$total = $parmTotalDetalle;
						
						
                            						
							$MontoItem = $this->xml->createElement('MontoItem',$total);
							$MontoItem = $this->Detalle->appendChild($MontoItem);
						

					
   						$this->Detalle = $this->Documento->appendChild($this->Detalle);
							
							
							
							$this->NroDetalle++;
					}

	function CargarCaf(){
					$this->objCaf->LeerCaf();
					$TED = $this->xml->createElement('TED');
					$TED->setAttribute("version","1.0");
					
						$DD = $this->xml->createElement('DD');
						$DD = $TED->appendChild($DD);
						
						
						

						$RE = $this->xml->createElement('RE',$this->EmpresaRut);
							$RE = $DD->appendChild($RE);

						$TD = $this->xml->createElement('TD',$this->objCaf->TipoDte);
						$TD = $DD->appendChild($TD);

							$F = $this->xml->createElement('F',$this->NumFolio);
							$F = $DD->appendChild($F);

						$FE = $this->xml->createElement('FE',$this->fecha);
						$FE = $DD->appendChild($FE);

						$RR = $this->xml->createElement('RR',$this->ClienteProveedorRut);
						$RR = $DD->appendChild($RR);

						$RSR = $this->xml->createElement('RSR',$this->ClienteProveedorRaz);
						$RSR = $DD->appendChild($RSR);

						$MNT  = $this->xml->createElement('MNT',$this->ParmValorTotal);
						$MNT = $DD->appendChild($MNT);

						$IT1 = $this->xml->createElement('IT1',$this->FormatoCaracter($this->auxNombre));
						$IT1 = $DD->appendChild($IT1);
					
						$CAF = $this->xml->createElement('CAF');
						$CAF = $DD->appendChild($CAF);
						$CAF->setAttribute("version","1.0");

						$DA = $this->xml->createElement('DA');
						$DA = $CAF->appendChild($DA);

						//cargo los datos del CAF
						$RE = $this->xml->createElement('RE',$this->objCaf->RutEmisor);
						$RE = $DA->appendChild($RE);
									
						$RS = $this->xml->createElement('RS',$this->objCaf->RazonSocial);
						$RS = $DA->appendChild($RS);

						$TD = $this->xml->createElement('TD',$this->objCaf->TipoDte);
						$TD = $DA->appendChild($TD);

						$RNG = $this->xml->createElement('RNG');
						$RNG = $DA->appendChild($RNG);

						$D = $this->xml->createElement('D',$this->objCaf->RangoDesde);
						$D = $RNG->appendChild($D);		
											
						$H = $this->xml->createElement('H',$this->objCaf->RangoHasta);
						$H = $RNG->appendChild($H);					
											
						$FA = $this->xml->createElement('FA',$this->objCaf->FechaAutorizacionFolio);					
						$FA = $DA->appendChild($FA);					
											
						$RSAPK = $this->xml->createElement('RSAPK');
						$RSAPK = $DA->appendChild($RSAPK);

						$M = $this->xml->createElement('M',$this->objCaf->Modulo);
						$M = $RSAPK->appendChild($M);
							
						$E = $this->xml->createElement('E',$this->objCaf->Exponente);	
						$E = $RSAPK->appendChild($E);

						$IDK = $this->xml->createElement('IDK',$this->objCaf->Idk);
						$IDK = $DA->appendChild($IDK);


									

								$FRMA = $this->xml->createElement('FRMA',$this->objCaf->Frma);
								$FRMA = $CAF->appendChild($FRMA);
								$FRMA->setAttribute("algoritmo","SHA1withRSA");	


						
						
						$TSTED = $this->xml->createElement('TSTED',$this->fecha.'T'.$this->hora);
						$TSTED = $DD->appendChild($TSTED);
						
								$TED = $this->Documento->appendChild($TED);
							
							$this->GeneraTimbre();	
							$privatekeyrsa = $this->objCaf->RsaSk;
							
							
							$ficherotimbre = fopen("timbre".$this->MovimientoId.".txt","rb");
							$datos = fread($ficherotimbre,filesize("timbre".$this->MovimientoId.".txt"));
							fclose($ficherotimbre);
							
							$archivorsa = fopen("archivorsa".$this->MovimientoId.".pem","a");
			                
							fputs($archivorsa,$privatekeyrsa);
					        fclose($archivorsa);
                         		
							shell_exec("python /home/appventa/public_html/controllers/sign.py ".$this->MovimientoId);
					
								
							$ficherotimbre = fopen("timbrefirmado".$this->MovimientoId.".txt","rb");
							 $datos = fread($ficherotimbre,filesize("timbrefirmado".$this->MovimientoId.".txt"));
							//seccion timbre
							
			                    $FRMT = $this->xml->createElement("FRMT",$datos);
								$FRMT = $TED->appendChild($FRMT);
								$FRMT->setAttribute("algoritmo", "SHA1withRSA");
								
								$this->auxCadena = $this->auxCadena.'<FRMT algoritmo="'.'SHA1withRSA'.'">'.$datos.'</FRMT>';
					           
							   $objAppRecord = new AppRecord();
					           $objAppRecord->ExecuteSql("Update Movimiento set MovimientoBarCod = '$this->auxCadena' where MovimientoId=$this->MovimientoId");
							   
							   
							   
					            $archivoted = fopen("nodoted".$this->MovimientoId.".txt","a");
			                    fputs($archivoted,$this->auxCadena);
					            fclose($archivoted);
					            	
						//	$comando ="python timbre.py ".$this->MovimientoId;
																		
								
						//	$command = escapeshellcmd($comando);
						//	$output = shell_exec($command);
						//	echo $output;	   

						//	$fichero = fopen("timbre".$this->MovimientoId.".png","rb");
	                     //   $contenido = fread($fichero,filesize("timbre".$this->MovimientoId.".png"));
						//	$contenido = addslashes($contenido);   
							
					   
					//	$tipo_archivo = mysql_result($consulta_foto_discos,0,'tipoarchivo');
					//	$original = imagecreatefrompng("timbre".$this->MovimientoId.".png");
					//	$thumb = imagecreatetruecolor(197,99); // Lo haremos de un tamaño 150x150
					//	$ancho = imagesx($original);
					//	$alto = imagesy($original);
					//	imagecopyresampled($thumb,$original,0,0,0,0,197,99,$ancho,$alto);
					//	imagejpeg($thumb,'thumbnail'.$this->MovimientoId.'.jpg',100); // 90 es la calidad de compresión
					//	imagedestroy($thumb);
					
					//        $fichero = fopen("thumbnail".$this->MovimientoId.".jpg","rb");
	                 //       $contenido = fread($fichero,filesize("thumbnail".$this->MovimientoId.".jpg"));
					//		$contenido = addslashes($contenido);   
							
					     
					    
						
					//	$objAppRecord->ExecuteSql("insert into TimbreDte (MovimientoId, BlobData) values($this->MovimientoId,'$contenido')");
					
			
					
							
					
					
					
									
								$TmstFirma = $this->xml->createElement("TmstFirma",$this->fecha.'T'.$this->hora);
								$TmstFirma = $this->Documento->appendChild($TmstFirma);
								
				//añado la seccion de firma del documento 

					        		$signature = $this->xml->createElement('Signature');
									$signature = $this->DTE->appendChild($signature);
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
									$auxnumfoliO = $this->NumFolio;
									
								    $this->objTipoDocumento = new TipoDocumentos();
					          		$auxtipodte = $this->objTipoDocumento->BuscaTipoDte($this->TipoDocumento);
							
									
									$auxstring = "#F".$auxnumfoliO."T".$auxtipodte;
									$reference->setAttribute("URI",$auxstring);
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
			
			function GeneraTimbre(){
				
				   $Cadena = "<DD>";
				   $Cadena = $Cadena."<RE>".$this->objCaf->RutEmisor."</RE>";
				   $Cadena = $Cadena."<TD>".$this->objCaf->TipoDte."</TD>";
				   $Cadena = $Cadena."<F>".$this->NumFolio."</F>";
	               $Cadena = $Cadena."<FE>".$this->fecha."</FE>";
                   $Cadena = $Cadena."<RR>".$this->ClienteProveedorRut."</RR>";
				   $Cadena = $Cadena."<RSR>".$this->ClienteProveedorRaz."</RSR>";
				   $Cadena = $Cadena."<MNT>".$this->ParmValorTotal."</MNT>";
				   $Cadena = $Cadena."<IT1>".$this->FormatoCaracter($this->auxNombre)."</IT1>";
				   $Cadena = $Cadena.'<CAF version="1.0">';
				   $Cadena = $Cadena."<DA>";
				   $Cadena = $Cadena."<RE>".trim($this->objCaf->RutEmisor)."</RE>";
				   $Cadena = $Cadena."<RS>".$this->objCaf->RazonSocial."</RS>";
				   $Cadena = $Cadena."<TD>".$this->objCaf->TipoDte."</TD>";
				   $Cadena = $Cadena."<RNG>";
				   $Cadena = $Cadena."<D>".$this->objCaf->RangoDesde."</D>";
				   $Cadena = $Cadena."<H>".$this->objCaf->RangoHasta."</H>";
				   $Cadena = $Cadena."</RNG>";
				   $Cadena = $Cadena."<FA>".$this->objCaf->FechaAutorizacionFolio."</FA>";
				   $Cadena = $Cadena."<RSAPK>";
				   $Cadena = $Cadena."<M>".$this->objCaf->Modulo."</M>";
				   $Cadena = $Cadena."<E>".$this->objCaf->Exponente."</E>";
				   $Cadena = $Cadena."</RSAPK>";
				   $Cadena = $Cadena."<IDK>".$this->objCaf->Idk."</IDK>";
				   $Cadena = $Cadena."</DA>";
				   $Cadena = $Cadena.'<FRMA algoritmo="SHA1withRSA">'.$this->objCaf->Frma.'</FRMA>';
				   $Cadena = $Cadena."</CAF>";
				   $Cadena = $Cadena."<TSTED>".$this->fecha.'T'.$this->hora."</TSTED>";
				   $Cadena = $Cadena."</DD>";
				   
                    header("Content-Type:text/html; charset=iso-8859-1"); 
				   $archivotimbre = fopen("timbre".$this->MovimientoId.".txt","a");
			        fputs($archivotimbre,$Cadena);
					fclose($archivotimbre);
					$this->auxCadena = $Cadena;
					
			
			}
			
			function GuardarDocumento(){
				$this->xml->save('../DTE/dte'.$this->MovimientoId.'.xml');	
					
					
		$ArchivoDTE = fopen("/home/appventa/public_html/DTE/dte".$this->MovimientoId.".xml", "r");
			$ContenidoDTE = fread($ArchivoDTE,filesize("/home/appventa/public_html/DTE/dte".$this->MovimientoId.".xml"));
         	$ContenidoDTE = str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$ContenidoDTE);
			fclose($ArchivoDTE);	
					
					
				unlink('/home/appventa/public_html/DTE/dte'.$this->MovimientoId.'.xml');
				
				$ArchivoDTE = fopen('/home/appventa/public_html/DTE/dte'.$this->MovimientoId.'.xml','a');
				fputs($ArchivoDTE,$ContenidoDTE);
			    fclose($ArchivoDTE);
				
					require '../includes/FormatXml.php';
					FormatXml("../DTE/dte".$this->MovimientoId.".xml");
					
					
        $comando = 'xmlsec1 --sign --output /home/appventa/public_html/DTE/dtefirmado'.$this->MovimientoId.'.xml --privkey-pem /home/appventa/public_html/certificates/privatekey.pem,/home/appventa/public_html/certificates/certprueba.pem --id-attr:ID Documento /home/appventa/public_html/DTE/dte'.$this->MovimientoId.'.xml 2>&1';
					
		 shell_exec($comando);
					
			}

			
		function AgregaDescuentoAfecto($parmDescuentoAfecto){
							$DscRcgGlobal = $this->xml->createElement('DscRcgGlobal');
							$NroLinDR = $this->xml->createElement('NroLinDR',1);
     						$NroLinDR = $DscRcgGlobal->appendChild($NroLinDR);
							$TpoMov = $this->xml->createElement('TpoMov','D');
	     					$TpoMov = $DscRcgGlobal->appendChild($TpoMov);
							$GlosaDR = $this->xml->createElement('GlosaDR','DESCUENTO');
							$GlosaDR = $DscRcgGlobal->appendChild($GlosaDR);
		     				$TpoValor = $this->xml->createElement('TpoValor',"$");
							$TpoValor = $DscRcgGlobal->appendChild($TpoValor);		
							$ValorDR = $this->xml->createElement('ValorDR',$parmDescuentoAfecto);  
							$ValorDR = $DscRcgGlobal->appendChild($ValorDR);
							$DscRcgGlobal = $this->Documento->appendChild($DscRcgGlobal);
							
		}	
		
		function AgregaReferencia(){
			$Referencia = $this->xml->createElement('Referencia');
			$NroLinRef = $this->xml->createElement('NroLinRef',1);
			$NroLinRef = $Referencia->appendChild($NroLinRef);
			// $this->parmTpoDocRef //
			$TpoDocRef = $this->xml->createElement('TpoDocRef','SET');
			$TpoDocRef = $Referencia->appendChild($TpoDocRef);
		//	$this->IndGlobal = $this->xml->createElement('IndGlobal',"no aplica");
		//	$this->IndGlobal = $Referencia->appendChild($this->IndGlobal);
			$FolioRef = $this->xml->createElement('FolioRef',$this->parmNroFolioRef);
			$FolioRef =  $Referencia->appendChild($FolioRef);
		    $objeto_DateTime = date_create_from_format("d/m/Y", $this->parmFchRef);
		   $fechareferencia = date_format($objeto_DateTime, "Y-m-d");	
			$FchRef = $this->xml->createElement('FchRef',$fechareferencia);
			$FchRef =  $Referencia->appendChild($FchRef);
			//$CodRef = $this->xml->createElement('CodRef',$this->parmCodRef);
			//$CodRef = $Referencia->appendChild($CodRef);
			$RazonRef = $this->xml->createElement('RazonRef',$this->parmRazonRef);
			$RazonRef = $Referencia->appendChild($RazonRef);
			$Referencia = $this->Documento->appendChild($Referencia);
			
		}
		
		
		function AgregaReferencia2(){
			$Referencia2 = $this->xml->createElement('Referencia');
			$NroLinRef2 = $this->xml->createElement('NroLinRef',2);
			$NroLinRef2 = $Referencia2->appendChild($NroLinRef2);
			$TpoDocRef2 = $this->xml->createElement('TpoDocRef',$this->parmTpoDocRef2);
			$TpoDocRef2 = $Referencia2->appendChild($TpoDocRef2);
		//	$this->IndGlobal = $this->xml->createElement('IndGlobal',"no aplica");
		//	$this->IndGlobal = $Referencia->appendChild($this->IndGlobal);
			$FolioRef2 = $this->xml->createElement('FolioRef',$this->parmNroFolioRef2);
			$FolioRef2 =  $Referencia2->appendChild($FolioRef2);
		    $objeto_DateTime = date_create_from_format("d/m/Y", $this->parmFchRef2);
		    $fechareferencia2 = date_format($objeto_DateTime, "Y-m-d");	
			$FchRef2 = $this->xml->createElement('FchRef',$fechareferencia2);
			$FchRef2 =  $Referencia2->appendChild($FchRef2);
			$CodRef2 = $this->xml->createElement('CodRef',$this->parmCodRef2);
			$CodRef2 = $Referencia2->appendChild($CodRef2);
			$RazonRef2 = $this->xml->createElement('RazonRef',$this->parmRazonRef2);
			$RazonRef2 = $Referencia2->appendChild($RazonRef2);
			$Referencia2 = $this->Documento->appendChild($Referencia2);
			
		}
		
		
		
		
		
		
		
		
		
			function FormatoCaracter($parmString){
			  $nuevo = str_replace(array('ó','ñ','&'),array('o','n','AND'),$parmString);
               return $nuevo;
				
			}
			
			function HtmlChars($parmString){
			
             $nuevo = htmlspecialchars($parmString, ENT_QUOTES);
			 return $nuevo;
			}
			
			
	}
?>