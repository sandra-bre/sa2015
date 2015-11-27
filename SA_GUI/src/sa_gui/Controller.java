/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package sa_gui;

import java.sql.*;

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
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here  
        
        
    }
    
    public static void searchStop(String name, double lat, double lon){
        Connection conn = null;
        Statement stmt = null;
        
        try {
            //register JDBC driver
            //Class.forName(driver);
            
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            
            
            stmt = conn.createStatement();
            
            String sql = "SELECT * FROM task1";
            ResultSet rs = stmt.executeQuery(sql);
            
            while(rs.next()){
            for (int i = 1; i <= 2; i++) {
        if (i > 1) System.out.print(",  ");
        String columnName = rs.getString(i);
        System.out.print(columnName);
      }}
            
        } catch(SQLException se){
            //Handle errors for JDBC
            se.printStackTrace();
        }catch(Exception e){
            //Handle errors for Class.forName
            e.printStackTrace();
        }
    }
    
    
}
