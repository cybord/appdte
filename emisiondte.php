<?php
       require_once 'Semilla.php';
	   require_once 'Token.php';
	   /*
	   require_once 'ClassDte.php'; 
	  */
	   /*
	   $objDte = new ClassDte();
	   */
	   $objSemilla = new Semilla();
	  
 $objSemilla->GeneraSemilla($idMovimiento);	 

    	 $valorsemilla = $objSemilla->LeerSemilla();
	     $valorsemilla = (int)$valorsemilla;
	   
	    
	   $objToken = new Token();
	   $TokenObtenido = $objToken->GeneraToken($valorsemilla);
      $comando = "python upload.py ".$TokenObtenido." ".$idMovimiento; 
      
      
$command = escapeshellcmd($comando);
$output = shell_exec($command);
echo $output;	   


?>
