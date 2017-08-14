/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package barcode;
import java.sql.Connection;
import java.sql.DriverManager;
 
public class ConexionBd {
  public Connection conexion = null;
    public  Connection ConectarBd(){
      try{  
          String password = "";
        String user = "";
        String bd = "jdbc:mysql://192.168.0.106/AppVentasInventario";
        Class.forName("com.mysql.jdbc.Driver");
        System.out.print("Conexion a bd");
         Connection conexion = DriverManager.getConnection(bd,user,password);      
      return conexion; 
      }
     catch(Exception e){
         System.out.println(e);
     }
   return conexion;
}
}
