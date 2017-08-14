package barcode;
import com.itextpdf.text.pdf.BarcodePDF417;
import java.awt.Color;
import java.awt.image.BufferedImage;
import java.io.ByteArrayOutputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import javax.imageio.ImageIO;
import com.itextpdf.text.Image;
import com.itextpdf.text.BadElementException;
import com.itextpdf.text.pdf.PdfWriter;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import java.io.FileNotFoundException; 
import com.itextpdf.text.pdf.PdfContentByte;
import com.itextpdf.text.pdf.PdfReader;
import com.itextpdf.text.pdf.PdfStamper;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;

public class BarCode {
    public static void main(String[] args) throws IOException, DocumentException   {
    
 try{    
	
     
     
     
        String cadena;
        String Timbre = new String(); 	
        String Timbre2 = new String();
        String idMovimiento = new String();
	idMovimiento = args[0];
        
	FileReader f = new FileReader("timbre"+idMovimiento +".txt");
        BufferedReader b = new BufferedReader(f);
        while((cadena = b.readLine())!=null) {
	
                    
        Timbre = Timbre + cadena;
        }
        b.close();
        Timbre2 = "<TED>" + Timbre + "</TED>";
	


        BarcodePDF417 barcode = new BarcodePDF417();
	barcode.setCodeRows(5);
	barcode.setCodeColumns(18);
	barcode.setErrorLevel(5);
	barcode.setLenCodewords(999);	        
	
	barcode.setText(Timbre2.getBytes("ISO-8859-1"));
        barcode.setOptions(BarcodePDF417.PDF417_FORCE_BINARY);
       
	com.itextpdf.text.Image image = barcode.getImage();
	
        PdfReader reader = new PdfReader("/home/appventa/public_html/downloads/dte"+idMovimiento+".pdf");
        PdfStamper stamper = new PdfStamper(reader, new FileOutputStream("/home/appventa/public_html/downloads/dtestamped"+idMovimiento+".pdf"));
        PdfContentByte content = stamper.getOverContent(1);
	image.scaleAbsolute(184, 72);
	image.setAbsolutePosition(70, 73);		
	content.addImage(image);
	stamper.close();
        		
}			 
      catch (BadElementException e) {
	System.out.print(e);	
	}      
       
	catch (FileNotFoundException e){
            	System.out.print(e);	
	}      	

     }

}
