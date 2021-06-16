/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package org.foi.nwtis.ppletes.web.podaci;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.inject.Inject;
import javax.servlet.ServletContext;
import org.foi.nwtis.podaci.Airport;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import org.foi.nwtis.rest.podaci.AvionLeti;

/**
 *
 * @author Paula
 */
public class Baza {
    
    public boolean dodajMojAeroLog(BP_Konfiguracija bpk, String ident, Date flight, int broj) {
        List<MyAirportsLog> dajSveLog = dajSveLog(bpk);
        for (MyAirportsLog mylog : dajSveLog) {
            if (!mylog.getFlightDate().equals(flight)) {

                String url = bpk.getServerDatabase() + bpk.getUserDatabase();
                String bpkorisnik = bpk.getUserUsername();
                String bplozinka = bpk.getUserPassword();
                String upit = "INSERT INTO MYAIRPORTSLOG (IDENT, FLIGHTDATE, STORED, FLIGHTNUMBER) VALUES ('" + ident + "' ," + flight + ", CURRENT_TIMESTAMP, " + broj + ")";

                try {
                    Class.forName(bpk.getDriverDatabase(url));

                    try (
                            Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                            PreparedStatement s = con.prepareCall(upit)) {

                        int executeUpdate = s.executeUpdate();
                        return executeUpdate == 1;

                    } catch (SQLException ex) {
                        Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                    }
                } catch (ClassNotFoundException ex) {
                    Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }
        return false;
    }

    public List<Myairports> dajMoooje(BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT DISTINCT username,id,ident,stored FROM myairports";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Myairports> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String username = rs.getString("username");
                    String stored = rs.getString("stored");
                    
                    Myairports a = new Myairports(ident, username, stored);

                    aerodromi.add(a);
                }
                return aerodromi;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    public List<Airplanes> dajSveAirplanes(BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT icao24, firstSeen, estDepartureAirport, lastSeen, estArrivalAirport, callsign, "
                + "estDepartureAirportHorizDistance, estDepartureAirportVertDistance, estArrivalAirportHorizDistance, "
                + "estArrivalAirportVertDistance, departureAirportCandidatesCount, arrivalAirportCandidatesCount, "
                + "stored FROM airplanes";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airplanes> airplanes = new ArrayList<>();

                while (rs.next()) {
                    String icao24 = rs.getString("icao24");
                    String firstSeen = rs.getString("firstSeen");
                    String estDepartureAirport = rs.getString("estDepartureAirport");
                    String lastSeen = rs.getString("lastSeen");
                    String estArrivalAirport = rs.getString("estArrivalAirport");
                    String callsign = rs.getString("callsign");
                    String estDepartureAirportHorizDistance = rs.getString("estDepartureAirportHorizDistance");
                    String estDepartureAirportVertDistance = rs.getString("estDepartureAirportVertDistance");
                    String estArrivalAirportHorizDistance = rs.getString("estArrivalAirportHorizDistance");
                    String estArrivalAirportVertDistance = rs.getString("estArrivalAirportVertDistance");
                    String departureAirportCandidatesCount = rs.getString("departureAirportCandidatesCount");
                    String arrivalAirportCandidatesCount = rs.getString("arrivalAirportCandidatesCount");
                    String stored = rs.getString("stored");
                    Timestamp storedTS = Timestamp.valueOf(stored);
                    Airplanes a = new Airplanes(icao24, Integer.parseInt(firstSeen), estDepartureAirport, Integer.parseInt(lastSeen), estArrivalAirport,
                            callsign, Integer.parseInt(estDepartureAirportHorizDistance), Integer.parseInt(estDepartureAirportVertDistance), Integer.parseInt(estArrivalAirportHorizDistance),
                            Integer.parseInt(estArrivalAirportVertDistance), Integer.parseInt(departureAirportCandidatesCount), Integer.parseInt(arrivalAirportCandidatesCount));

                    airplanes.add(a);
                }
                return airplanes;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    public List<MyAirportsLog> dajSveLog(BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, flightdate, stored FROM myairportslog";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<MyAirportsLog> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    MyAirportsLog a = new MyAirportsLog(ident);

                    aerodromi.add(a);
                }
                return aerodromi;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    public boolean dodajAvion(BP_Konfiguracija bpk, List<AvionLeti> avion) {
        for (AvionLeti a : avion) {
            if (a.getEstArrivalAirport() != null) {

                String url = bpk.getServerDatabase() + bpk.getUserDatabase();
                String bpkorisnik = bpk.getUserUsername();
                String bplozinka = bpk.getUserPassword();
                Date date = new Date();
                String upit = "INSERT INTO airplanes (ICAO24, FIRSTSEEN, ESTDEPARTUREAIRPORT, LASTSEEN, ESTARRIVALAIRPORT, CALLSIGN, ESTDEPARTUREAIRPORTHORIZDISTANCE, ESTDEPARTUREAIRPORTVERTDISTANCE, ESTARRIVALAIRPORTHORIZDISTANCE, ESTARRIVALAIRPORTVERTDISTANCE, DEPARTUREAIRPORTCANDIDATESCOUNT, ARRIVALAIRPORTCANDIDATESCOUNT, STORED) "
                        + " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

                try {
                    Class.forName(bpk.getDriverDatabase(url));

                    try (
                            Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                            PreparedStatement s = con.prepareCall(upit)) {

                        s.setString(1, a.getIcao24());
                        s.setInt(2, a.getFirstSeen());
                        s.setString(3, a.getEstDepartureAirport());
                        s.setInt(4, a.getLastSeen());
                        s.setString(5, a.getEstArrivalAirport());
                        s.setString(6, a.getCallsign());
                        s.setInt(7, a.getEstDepartureAirportHorizDistance());
                        s.setInt(8, a.getEstDepartureAirportVertDistance());
                        s.setInt(9, a.getEstArrivalAirportHorizDistance());
                        s.setInt(10, a.getEstArrivalAirportVertDistance());
                        s.setInt(11, a.getDepartureAirportCandidatesCount());
                        s.setInt(12, a.getArrivalAirportCandidatesCount());
                        s.setTimestamp(13, new Timestamp(date.getTime()));

                        int executeUpdate = s.executeUpdate();
                        return executeUpdate == 1;

                    } catch (SQLException ex) {
                        Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                    }
                } catch (ClassNotFoundException ex) {
                    Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                }

            }
        }
        return false;
    }

}
