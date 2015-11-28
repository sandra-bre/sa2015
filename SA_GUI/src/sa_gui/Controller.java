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
    static String latoperator;
    static String lonoperator;
    
    static ResultSet rsconnection;
    static String connectionstart;
    static String connectiondest;
    
    static ResultSet tmp;
    static String routename;
    static String routestart;
    static String routedest;
    static String[] routestops = new String[100];
    static int[] stopIDs = new int[100];
    
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
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            
            
            stmt = conn.createStatement();
            
            String sql = "SELECT * FROM task1 where ";
            boolean bool = false;
          
            if (stopname != "leer")
            {
                sql += "name LIKE '%" + stopname + "%'";
                bool = true;
            }
            if (stoplat != 0)
            {
                if(bool == true) { sql += " AND "; }
                sql += "latitude " + latoperator + " '" + stoplat + "'";
                bool = true;
            }
            if (stoplon != 0)
            {
                if(bool == true) { sql += " AND "; }
                sql += "longitude " + lonoperator + " '"+ stoplon + "'";
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
    
    public static void searchConnection(String conStart, String conDestination){
        Connection conn = null;
        Statement stmt = null;
                
        connectionstart = conStart;
        connectiondest = conDestination;
        
        try {
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            stmt = conn.createStatement();
            
            String sql = "SELECT r.name FROM (SELECT route_id, m.stop_id ";
            sql += "FROM task1 t2 INNER JOIN mapping m ON (t2.id = m.stop_id) ";
            sql += "WHERE t2.name LIKE '%" + connectionstart + "%') t1 ";
            sql += "INNER JOIN (SELECT route_id ";
            sql += "FROM task1 t3 INNER JOIN mapping m ON (t3.id = m.stop_id) ";
            sql += "WHERE t3.name LIKE '%" + connectiondest + "%' ) t2 ON(t1.route_id = t2.route_id) ";
            sql += "INNER JOIN routes r ON(r.route_id = t2.route_id)";
                       
            rsconnection = stmt.executeQuery(sql);
            
                    
        } catch(SQLException se){
            //Handle errors for JDBC
            se.printStackTrace();
        }catch(Exception e){
            //Handle errors for Class.forName
            e.printStackTrace();
        }
    }
    
    public static String getConStart() { return connectionstart; }
    public static String getConDest() { return connectiondest; }
    
    public static boolean checkRouteStops(String rname, String rstart, String rdest, String[] rstops){
        //check if stops exist
        Connection conn = null;
        Statement stmt = null;
        
        routename = rname;
        routestart = rstart;
        routedest = rdest;
        
        try {
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            stmt = conn.createStatement();

            String sql = "SELECT DISTINCT name, id FROM task1 WHERE name LIKE '%" + routestart + "%'";
            tmp = stmt.executeQuery(sql);

            if(!tmp.isBeforeFirst()) { return false; }
            else
            { 
                tmp.first(); routestart = tmp.getString(1); 
                stopIDs[0] = Integer.parseInt(tmp.getString(2));
            } 

            sql = "SELECT DISTINCT name, id FROM task1 WHERE name LIKE '%" + routedest + "%'";
            tmp = stmt.executeQuery(sql);

            if(!tmp.isBeforeFirst()) { return false; }
            else
            { 
                tmp.first(); routedest = tmp.getString(1); 
                stopIDs[1] = Integer.parseInt(tmp.getString(2));
            }
            
            int routeid = 0;
            for (int i = 0; i < rstops.length; i++)
            {
                if(rstops[i].equals("") == false)
                {
                    String tmpstring = rstops[i];
                    sql = "SELECT DISTINCT name, id FROM task1 WHERE name LIKE '%" + tmpstring + "%'";
                    tmp = stmt.executeQuery(sql);
                    if(tmp.isBeforeFirst()) 
                    {
                        tmp.first();
                        routestops[routeid] = new String(tmp.getString(1));
                        stopIDs[routeid + 2] = Integer.parseInt(tmp.getString(2));
                        routeid++;
                    }
                }                
            }
        
        } catch(SQLException se){
            //Handle errors for JDBC
            se.printStackTrace();
        }catch(Exception e){
            //Handle errors for Class.forName
            e.printStackTrace();
        }
        
        return true;
        
    }
    
    public static boolean createNewRoute(){
        Connection conn = null;
        Statement stmt = null;
                
        try {            
            //open connection
            conn = DriverManager.getConnection(DB_URL, user, pass);
            stmt = conn.createStatement();
            
            //route erstellen
            String sql = "SELECT MAX(route_id) FROM routes";
                       
            rsconnection = stmt.executeQuery(sql);
            //rsconnection.first();
            rsconnection.first();
            long newID = (Long.parseLong(rsconnection.getString(1))) + 1;
            
            sql = "INSERT INTO routes (route_id, name) VALUES ('" + newID + "', '"
                 +  routename + ": " + routestart + " => " + routedest + "')";
            
            stmt.executeUpdate(sql);
            
            if(stopIDs[0] != 0)
            {
                sql = "INSERT INTO mapping (route_id, stop_id) VALUES ";
                for(int i = 0; stopIDs[i] != 0; i++)
                {
                    sql += "(" + newID + ", " + stopIDs[i] + ")";
                    if(stopIDs[i+1] != 0) { sql += " , "; }
                }
                stmt.executeUpdate(sql);
            }
            
            
        } catch(SQLException se){
            //Handle errors for JDBC
            se.printStackTrace();
            return false;
        }catch(Exception e){
            //Handle errors for Class.forName
            e.printStackTrace();
            return false;
        }
        return true;
    }

    public static String getRouteName() { return routename; }
    public static String getRouteStart() { return routestart; }
    public static String getRouteDest() { return routedest; }
    public static String[] getRouteStops() { return routestops; }
    
}
