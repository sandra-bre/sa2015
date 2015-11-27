/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package sa_gui;

import java.sql.*;
import javax.swing.table.DefaultTableModel;

/**
 *
 * @author Sandra
 */
public class Controller {

    // JDBC driver and database URL
    static final String driver = "com.mysql.jdbc.Driver";
    static final String DB_URL = "jdbc:mysql://localhost:3306/sa_database";
    
    // Database credentials
    static final String user = "root";
    static final String pass = "root";
    
    // Variables
    static ResultSet rsstop;
    static String stopname;
    static double stoplat;
    static double stoplon;
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here  
        
        
    }
    
    public static void searchStop(String name, double lat, double lon){
        Connection conn = null;
        Statement stmt = null;
                
        stopname = name;
        stoplat = lat;
        stoplon = lon;
        
        try {
            //register JDBC driver
            //Class.forName(driver);
            
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            
            
            stmt = conn.createStatement();
            
            String sql = "SELECT * FROM task1 where ";
            boolean bool = false;
          
            if (stopname != "leer")
            {
                sql += "name = \"" + stopname + "\"";
                bool = true;
            }
            if (stoplat != 0)
            {
                if(bool == true) { sql += "AND "; }
                sql += "latitude = '" + stoplat + "'";
                bool = true;
            }
            if (stoplon != 0)
            {
                if(bool == true) { sql += "AND "; }
                sql += "longitude = '" + stoplon + "'";
            }
            
            rsstop = stmt.executeQuery(sql);
            
                    
        } catch(SQLException se){
            //Handle errors for JDBC
            se.printStackTrace();
        }catch(Exception e){
            //Handle errors for Class.forName
            e.printStackTrace();
        }
    }
    
    public static String getStopName() { return stopname; }
    public static double getStopLat() { return stoplat; }
    public static double getStopLon() { return stoplon; }
    public static ResultSet getResultStop() { return rsstop; }
    
}
