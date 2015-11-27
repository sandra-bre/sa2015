/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package sa_gui;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

/**
 *
 * @author Sandra
 */
public class Controller {

    ResultSet rs;
    String stopquery;
    
    Connection con = DriverManager.getConnection("jdbc:mysql:localhost:3306:database", "root", "root") throws SQLException;
            getConnection("jdbc:mysql://localhost:3306/database", "root", "root") throws SQLException;
    
    Statement stmt = con.createStatement();
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Controller cont = new Controller();
    }
    
    public void searchStop(String name, double lat, double lon){
       stopquery = "SELECT * FROM task1";
       rs = stmt.executeQuery(stopquery);
    }
    
    
}
