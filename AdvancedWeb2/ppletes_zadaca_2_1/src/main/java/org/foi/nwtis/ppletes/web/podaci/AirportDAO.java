package org.foi.nwtis.ppletes.web.podaci;

import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.foi.nwtis.podaci.Aerodrom;
import org.foi.nwtis.podaci.Airport;
import org.foi.nwtis.rest.podaci.AvionLeti;
import org.foi.nwtis.rest.podaci.Lokacija;

/**
 *
 * @author Paula
 */
public class AirportDAO {

    DateFormat formatDatuma = new SimpleDateFormat("yyyy-MM-dd");

    /**
     * daje listu svih aerodroma prema nazivu drzave
     *
     * @param bpk
     * @param drzava
     * @return
     */
    public List<Airport> dajSveAerodrome(BP_Konfiguracija bpk, String drzava) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, type, name, elevation_ft, continent, iso_country, "
                + "iso_region, municipality, gps_code, iata_code, local_code, coordinates FROM airports";

        if (drzava != null && !drzava.trim().isEmpty()) {
            if (drzava.compareTo("*") == 0) {
            } else {
                upit += " WHERE iso_country = '" + drzava + "'";
            }
        }

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airport> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);

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

    /**
     * daje listu svih aerodroma prema nazivu
     *
     * @param naziv
     * @param bpk
     * @return
     */
    public List<Aerodrom> dajSveAerodromeNaziv(String naziv, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, type, name, elevation_ft, continent, iso_country, "
                + "iso_region, municipality, gps_code, iata_code, local_code, coordinates FROM airports";

        if (naziv != null && !naziv.trim().isEmpty()) {
            if (naziv.compareTo("*") == 0) {
            } else {
                upit += " WHERE name = '" + naziv + "' OR name LIKE '" + naziv + "%' ";
            }
        }

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Aerodrom> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    String[] parts = coordinates.split(", ");
                    String lat = parts[0];
                    String lon = parts[1];
                    Lokacija lokacija = new Lokacija();
                    lokacija.postavi(lat, lon);
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);
                    List<Airport> air = new ArrayList<>();
                    air.add(a);
                    for (Airport aa : air) {
                        String ident1 = aa.getIdent();
                        String name1 = aa.getName();
                        String coordinates1 = aa.getCoordinates();
                        String iso_country1 = aa.getIso_country();
                        String[] parts1 = coordinates1.split(", ");
                        String lat1 = parts1[0];
                        String lon1 = parts1[1];
                        Aerodrom aero = new Aerodrom(ident1, name1, iso_country1, new Lokacija(lon1, lat1));
                        aerodromi.add(aero);
                    }

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

    /**
     * daje listu svih aerodroma prema drzavi
     *
     * @param naziv
     * @param bpk
     * @return
     */
    public List<Aerodrom> dajSveAerodromeDrzava(String naziv, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, type, name, elevation_ft, continent, iso_country, "
                + "iso_region, municipality, gps_code, iata_code, local_code, coordinates FROM airports";

        if (naziv != null && !naziv.trim().isEmpty()) {
            if (naziv.compareTo("*") == 0) {
            } else {
                upit += " WHERE iso_country = '" + naziv + "' OR iso_country LIKE '" + naziv + "%' ";
            }
        }

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Aerodrom> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    String[] parts = coordinates.split(", ");
                    String lat = parts[0];
                    String lon = parts[1];
                    Lokacija lokacija = new Lokacija();
                    lokacija.postavi(lat, lon);
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);
                    List<Airport> air = new ArrayList<>();
                    air.add(a);
                    for (Airport aa : air) {
                        String ident1 = aa.getIdent();
                        String name1 = aa.getName();
                        String coordinates1 = aa.getCoordinates();
                        String iso_country1 = aa.getIso_country();
                        String[] parts1 = coordinates1.split(", ");
                        String lat1 = parts1[0];
                        String lon1 = parts1[1];
                        Aerodrom aero = new Aerodrom(ident1, name1, iso_country1, new Lokacija(lon1, lat1));
                        aerodromi.add(aero);
                    }

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

    /**
     * daje listu aerodroma iz tablice myairports
     *
     * @param bpk
     * @param korisnik
     * @return
     */
    public List<Aerodrom> mojiAerodromiLista(BP_Konfiguracija bpk, String korisnik) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT airports.ident, airports.type, airports.name, airports.elevation_ft, airports.continent, airports.iso_country, "
                + "airports.iso_region, airports.municipality, airports.gps_code, airports.iata_code, airports.local_code, airports.coordinates, "
                + "myairports.ident, myairports.username FROM myairports INNER JOIN airports ON myairports.ident = airports.ident WHERE myairports.username = '" + korisnik + "' ";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Aerodrom> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    String[] parts = coordinates.split(", ");
                    String lat = parts[0];
                    String lon = parts[1];
                    Lokacija lokacija = new Lokacija();
                    lokacija.postavi(lat, lon);
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);
                    List<Airport> air = new ArrayList<>();
                    air.add(a);
                    for (Airport aa : air) {
                        String ident1 = aa.getIdent();
                        String name1 = aa.getName();
                        String coordinates1 = aa.getCoordinates();
                        String iso_country1 = aa.getIso_country();
                        String[] parts1 = coordinates1.split(", ");
                        String lat1 = parts1[0];
                        String lon1 = parts1[1];
                        Aerodrom aero = new Aerodrom(ident1, name1, iso_country1, new Lokacija(lon1, lat1));
                        aerodromi.add(aero);
                    }

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

    /**
     * daje tocno odredeni aerodrom koji je korisnik zatrzio putem parametra
     * icao iz konstruktora Airport
     *
     * @param bpk
     * @param icao
     * @param korisnik
     * @return
     */
    public List<Airport> mojAerodromLista(BP_Konfiguracija bpk, String icao, String korisnik) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT airports.ident, airports.type, airports.name, airports.elevation_ft, airports.continent, airports.iso_country, "
                + "airports.iso_region, airports.municipality, airports.gps_code, airports.iata_code, airports.local_code, airports.coordinates, "
                + "myairports.ident, myairports.username FROM myairports INNER JOIN airports ON airports.ident = myairports.ident WHERE myairports.ident = '" + icao + "' AND myairports.username = '" + korisnik + "' ";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airport> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");

                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);
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

    /**
     * daje tocno odredeni aerodrom koji je korisnik zatrzio putem parametra
     * icao iz konstruktora Aerodrom
     *
     * @param bpk
     * @param korisnik
     * @param icao
     * @return
     */
    public List<Aerodrom> mojAerodromL(BP_Konfiguracija bpk, String korisnik, String icao) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT airports.ident, airports.type, airports.name, airports.elevation_ft, airports.continent, airports.iso_country, "
                + "airports.iso_region, airports.municipality, airports.gps_code, airports.iata_code, airports.local_code, airports.coordinates, "
                + "myairports.ident, myairports.username FROM myairports INNER JOIN airports ON myairports.ident = airports.ident WHERE myairports.ident = '" + icao + "' AND myairports.username = '" + korisnik + "' ";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Aerodrom> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    String[] parts = coordinates.split(", ");
                    String lat = parts[0];
                    String lon = parts[1];
                    Lokacija lokacija = new Lokacija();
                    lokacija.postavi(lat, lon);
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);
                    List<Airport> air = new ArrayList<>();
                    air.add(a);
                    for (Airport aa : air) {
                        String ident1 = aa.getIdent();
                        String name1 = aa.getName();
                        String coordinates1 = aa.getCoordinates();
                        String iso_country1 = aa.getIso_country();
                        String[] parts1 = coordinates1.split(", ");
                        String lat1 = parts1[0];
                        String lon1 = parts1[1];
                        Aerodrom aero = new Aerodrom(ident1, name1, iso_country1, new Lokacija(lon1, lat1));
                        aerodromi.add(aero);
                    }

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

    /**
     * daje sve aerodrome iz tablice airports
     *
     * @param bpk
     * @return
     */
    public List<Airport> dajSveAerodrome2(BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, type, name, elevation_ft, continent, iso_country, "
                + "iso_region, municipality, gps_code, iata_code, local_code, coordinates FROM airports";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airport> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);

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

   

    /**
     * upisuje podatke u tablicu airplanes
     *
     * @param bpk
     * @param korisnik
     * @param lozinka
     * @param icao
     * @return
     */
    public boolean dodajMojAero(BP_Konfiguracija bpk, String korisnik, String lozinka, String icao) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO myairports (IDENT, USERNAME, STORED) VALUES ('" + icao + "' , '" + korisnik + "', CURRENT_TIMESTAMP)";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                List<Airport> dajSveAerodrome2 = dajSveAerodrome2(bpk);
                for (Airport air : dajSveAerodrome2) {
                    String ident = air.getIdent();

                    if (ident == null ? icao == null : ident.equals(icao)) {

                        int brojAzuriranja = s.executeUpdate(upit);
                        return brojAzuriranja == 1;

                    }
                }
            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    /**
     * upisuje podatke u tablicu myairportslog
     *
     * @param bpk
     * @param icao
     * @param stored
     * @return
     */
    public boolean dodajMojAeroLog(BP_Konfiguracija bpk, String icao, String stored) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO myairportslog (IDENT, FLIGHTDATE, STORED) VALUES ('" + icao + "' ,'" + stored + "', CURRENT_TIMESTAMP)";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                List<Airport> dajSveAerodrome2 = dajSveAerodrome2(bpk);
                for (Airport air : dajSveAerodrome2) {
                    String ident = air.getIdent();

                    if (ident == null ? icao == null : ident.equals(icao)) {

                        int brojAzuriranja = s.executeUpdate(upit);
                        return brojAzuriranja == 1;

                    }
                }
            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

   public List<Airport> dajSveKorisnikAerodrome(BP_Konfiguracija bpk) {
       String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT a.* FROM MYAIRPORTS ma,AIRPORTS a WHERE ma.IDENT=a.IDENT";
        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airport> aerodromi = new ArrayList<>();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);

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
   
    public List<Airport> dajMyair(BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT a.* FROM airports a INNER JOIN myairports my ON my.ident = a.ident"; 

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Airport> aerodromi = new ArrayList<>();

                while (rs.next()) {
                   String ident = rs.getString("ident");
                    String type = rs.getString("type");
                    String name = rs.getString("name");
                    String elevation_ft = rs.getString("elevation_ft");
                    String continent = rs.getString("continent");
                    String iso_country = rs.getString("iso_country");
                    String iso_region = rs.getString("iso_region");
                    String municipality = rs.getString("municipality");
                    String gps_code = rs.getString("gps_code");
                    String iata_code = rs.getString("iata_code");
                    String local_code = rs.getString("local_code");
                    String coordinates = rs.getString("coordinates");
                    Airport a = new Airport(ident, type, name, elevation_ft, continent, iso_country, iso_region, municipality, gps_code, iata_code, local_code, coordinates);

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

    public MyAirportsLog dajMyairports(BP_Konfiguracija bpk, Date date) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, flightdate FROM myairportslog WHERE flightdate = '" + date + "'";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                MyAirportsLog my = new MyAirportsLog();

                while (rs.next()) {
                    String ident = rs.getString("ident");
                    my.setIdent(ident);
                    
                }
                return my;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    /**
     * daje listu svih aerodroma iz tablice airplanes
     *
     * @param bpk
     * @return
     */
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

    /**
     * daje listu svih aerodroma iz tablice mayairportslog
     *
     * @param bpk
     * @return
     */
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

    /**
     * upisuje podatke u tablicu myairportslog
     *
     * @param bpk
     * @param icao
     * @param stored
     * @return
     */
    public boolean dodajMojAeroLog(BP_Konfiguracija bpk, String ident, int broj) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO myairportslog (IDENT, FLIGHTDATE, STORED, FLIGHTNUMBER) VALUES (" + "'" + ident + "' , CURRENT_DATE , CURRENT_TIMESTAMP, " + broj + ")";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                int brojAzuriranja = s.executeUpdate(upit);

                return brojAzuriranja == 1;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    public boolean dodajAvion(BP_Konfiguracija bpk, Airplanes a) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO airplanes (ICAO24, FIRSTSEEN, ESTDEPARTUREAIRPORT, LASTSEEN, ESTARRIVALAIRPORT, CALLSIGN, ESTDEPARTUREAIRPORTHORIZDISTANCE, ESTDEPARTUREAIRPORTVERTDISTANCE, ESTARRIVALAIRPORTHORIZDISTANCE, ESTARRIVALAIRPORTVERTDISTANCE, DEPARTUREAIRPORTCANDIDATESCOUNT, ARRIVALAIRPORTCANDIDATESCOUNT, STORED) "
                + "VALUES (" + "'" + a.getIcao24() + "' ," + a.getFirstSeen() + ",'" + a.getEstDepartureAirport() + "'," + a.getLastSeen() + ", '" + a.getEstArrivalAirport() + "','" + a.getCallsign() + "'," + a.getEstDepartureAirportHorizDistance() + "," + a.getEstDepartureAirportVertDistance() + "," + a.getEstArrivalAirportHorizDistance() + ", " + a.getEstArrivalAirportVertDistance() + "," + a.getDepartureAirportCandidatesCount() + "," + a.getArrivalAirportCandidatesCount() + ", CURRENT_TIMESTAMP)";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                return s.executeUpdate(upit)==1;

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }
    
    public boolean provjeriAerodromULog(BP_Konfiguracija bpk,String ident, java.sql.Date datum) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT ident, flightdate FROM MYAIRPORTSLOG WHERE "
                + "IDENT = '" + ident + "' AND FLIGHTDATE = '" + datum + "'";
        try {
            Class.forName(bpk.getDriverDatabase(url));
            try {
                Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                ResultSet rs = s.executeQuery(upit);
                if (rs.next()) {
                    return true;
                }

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                System.err.println("SQL provjera aerodromaUlog " + ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }
	
	public void spremiAerodromULog(BP_Konfiguracija bpk,String ident, java.sql.Date datum, int brojAviona) {
            String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO  MYAIRPORTSLOG (IDENT, FLIGHTDATE, STORED, FLIGHTNUMBER) VALUES ("
                + "'" + ident + "', '" + datum + "', CURRENT_TIMESTAMP, " + brojAviona + ")";
        try {
            Class.forName(bpk.getDriverDatabase(url));
            try {
                Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                s.executeUpdate(upit);

            } catch (SQLException ex) {
                Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                System.err.println("SQL spremanje aerodromaUlog " + ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
            System.err.println("ClassNotFoundException spremanje aerodromaUlog " + ex);
        }
    }
	
	public void spremiAvione(BP_Konfiguracija bpk,List<AvionLeti> avioni) {
              String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        for (AvionLeti avion : avioni) {
            if (avion.getEstArrivalAirport() != null) {
                Timestamp timestamp = new Timestamp(System.currentTimeMillis());
                String upit = "INSERT INTO AIRPLANES (icao24, firstseen, estdepartureairport, lastseen, estarrivalairport, "
                        + "callsign, estDepartureAirportHorizDistance, estDepartureAirportVertDistance, estArrivalAirportHorizDistance, "
                        + "estArrivalAirportVertDistance, departureAirportCandidatesCount, arrivalAirportCandidatesCount, stored)"
                        + " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                try (Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);) {
                    PreparedStatement s = con.prepareCall(upit);
                    s.setString(1, avion.getIcao24());
                    s.setInt(2, avion.getFirstSeen());
                    s.setString(3, avion.getEstDepartureAirport());
                    s.setInt(4, avion.getLastSeen());
                    s.setString(5, avion.getEstArrivalAirport());
                    s.setString(6, avion.getCallsign());
                    s.setInt(7, avion.getEstDepartureAirportHorizDistance());
                    s.setInt(8, avion.getEstDepartureAirportVertDistance());
                    s.setInt(9, avion.getEstArrivalAirportHorizDistance());
                    s.setInt(10, avion.getEstArrivalAirportVertDistance());
                    s.setInt(11, avion.getDepartureAirportCandidatesCount());
                    s.setInt(12, avion.getArrivalAirportCandidatesCount());
                    s.setTimestamp(13, timestamp);
                    s.executeUpdate();
                    //                rs.close();
                    //                s.close();
                    //                con.close();
                } catch (SQLException ex) {
                    Logger.getLogger(AirportDAO.class.getName()).log(Level.SEVERE, null, ex);
                    System.err.println("SQL spremiAvione " + ex);
                }
            }
        }
    }
}

   
