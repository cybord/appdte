/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package barcode;
import barcode.ConexionBd;

import java.util.Map;
import java.util.HashMap;
import java.util.Locale;
        
import net.sf.jasperreports.engine.JRException;
import net.sf.jasperreports.engine.JRExporter;
import net.sf.jasperreports.engine.JRExporterParameter;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.export.JRPdfExporter;

public class ImpresionDte {
    public static void main(String[] args){
      try {
          
          Locale locale = null;
            //el primer parametro es el idioma, el segundo es el país, siempre en MAYUSCULAS.
            // ejemplo: es “español”, en “ingles”, US “Estados Unidos”, MX “Mexico”
        locale = new Locale("de","DE");
        Locale.setDefault(locale);
     
        String idMovimiento = args[0];
        ConexionBd objbarcode = new ConexionBd();
    java.sql.Connection objconexion = objbarcode.ConectarBd();
         String fileName = "/home/appventa/public_html/reportes/dtereport.jasper";
        String outFileName = "/home/appventa/public_html/downloads/dte"+idMovimiento+".pdf";
      
       Map hm = new HashMap();
        
       
        hm.put("parmIdMovimiento",idMovimiento);  
          JasperPrint print = JasperFillManager.fillReport(fileName, hm, objconexion);
 
            // Create a PDF exporter
            JRExporter exporter = new JRPdfExporter();
 
            // Configure the exporter (set output file name and print object)
            exporter.setParameter(JRExporterParameter.OUTPUT_FILE_NAME, outFileName);
            exporter.setParameter(JRExporterParameter.JASPER_PRINT, print);
 
            // Export the PDF file
            exporter.exportReport();
         
        } catch (JRException e) {
            e.printStackTrace();
            System.exit(1);
        } catch (Exception e) {
            e.printStackTrace();
            System.exit(1);
        }
        
        
        
        
        
        
        
        
    }
}
