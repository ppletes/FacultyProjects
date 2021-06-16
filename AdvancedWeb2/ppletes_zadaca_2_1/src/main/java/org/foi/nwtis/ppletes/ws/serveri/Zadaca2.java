package org.foi.nwtis.ppletes.ws.serveri;

import static java.lang.Long.MAX_VALUE;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.inject.Inject;
import javax.jws.WebMethod;
import javax.jws.WebParam;
import javax.jws.WebService;
import javax.servlet.ServletContext;
import org.foi.nwtis.podaci.Aerodrom;
import org.foi.nwtis.podaci.Airport;
import org.foi.nwtis.podaci.Korisnik;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import org.foi.nwtis.ppletes.web.podaci.AirportDAO;
import org.foi.nwtis.ppletes.web.podaci.KorisnikDAO;
import org.foi.nwtis.rest.klijenti.OSKlijent;
import org.foi.nwtis.rest.podaci.AvionLeti;
import org.foi.nwtis.rest.podaci.AvionLetiPozicije;
import org.foi.nwtis.rest.podaci.LetPozicija;
import org.foi.nwtis.rest.podaci.Lokacija;

/**
 *
 * @author Paula
 */
@WebService(serviceName = "Zadaca2")
public class Zadaca2 {

    @Inject
    ServletContext context;

    OSKlijent osKlijent;

    /**
     * This is a sample web service operation dodaje novog korisnika u bazu
     *
     * @param korisnik
     * @return
     */
    @WebMethod(operationName = "dodajKorisnika")
    public Boolean dodajKorisnika(@WebParam(name = "noviKorisnik") Korisnik korisnik) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        boolean dodajKorisnika = korisnikDAO.dodajKorisnika(korisnik, bpk);
        return dodajKorisnika;
    }

    /**
     * This is a sample web service operation dodaje novi aerodrom korisniku
     * (myairposrt - oni koje korisnik prati)
     *
     * @param icao
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "dodajMojAerodrom")
    public Boolean dodajMojAerodrom(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "icao") String icao) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            AirportDAO airportDAO = new AirportDAO();
            return airportDAO.dodajMojAero(bpk, korisnik, lozinka, icao);

        }

        return null;
    }

    /**
     * Web service operation provjerava korisnicke podatke
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "provjeraKorisnika")
    public Boolean provjeraKorisnika(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        return !dohvatiKorisnikaLista.isEmpty();
    }

    /**
     * This is a sample web service operation vraća najveću visinu leta aviona
     *
     * @param korisnik
     * @param icao24
     * @param zaVrijeme
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "najvecaVisinaLetaAviona")
    public LetPozicija najvecaVisinaLetaAviona(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "icao24") String icao24, @WebParam(name = "zaVrijeme") long zaVrijeme) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            String osnKorisnik = bpk.getKonfig().dajPostavku("OpenSkyNetwork.korisnik");
            String osnLozinka = bpk.getKonfig().dajPostavku("OpenSkyNetwork.lozinka");
            OSKlijent osKli = new OSKlijent(osnKorisnik, osnLozinka);

            AvionLetiPozicije tracks = osKli.getTracks(icao24, zaVrijeme);

            Collection<LetPozicija> path = tracks.getPath();

            for (LetPozicija let : path) {
                float baro_altitude = let.getBaro_altitude();

                if (baro_altitude == MAX_VALUE) {
                    LetPozicija letPozicija = new LetPozicija();
                    letPozicija.setBaro_altitude(baro_altitude);
                    return letPozicija;
                }
            }
        }
        return null;
    }

    /**
     * This is a sample web service operation vraća aerodrome korisnika
     *
     * @param noviKorisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "dajAerodromeKorisnika")
    public List<Aerodrom> dajAerodromeKorisnika(@WebParam(name = "noviKorisnik") String noviKorisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(noviKorisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            try {

                String url = bpk.getKonfig().dajPostavku("server.database") + bpk.getKonfig().dajPostavku("user.database");
                String bpkorisnik = bpk.getKonfig().dajPostavku("user.username");
                String bplozinka = bpk.getKonfig().dajPostavku("user.password");
                String upit = "SELECT airports.ident, airports.coordinates, airports.iso_country, airports.name,  "
                        + "myairports.ident, myairports.username "
                        + "FROM myairports INNER JOIN airports ON myairports.ident = airports.ident";

                List<Aerodrom> aerodromi = new ArrayList<>();

                Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                Statement s = con.createStatement();
                ResultSet rs = s.executeQuery(upit);

                while (rs.next()) {
                    String lokacija = rs.getString("coordinates");
                    String[] parts = lokacija.split(",");
                    String lat = parts[0];
                    String lon = parts[1];
                    Aerodrom aerodrom = new Aerodrom(rs.getString("ident"), rs.getString("name"), rs.getString("iso_country"), new Lokacija(lat, lon));
                    aerodromi.add(aerodrom);
                }

                return aerodromi;
            } catch (SQLException ex) {
                Logger.getLogger(Zadaca2.class.getName()).log(Level.SEVERE, null, ex);
            }
            return null;
        }

        return null;
    }

    /**
     * This is a sample web service operation vraća aerodrome prema nazivu
     *
     * @param noviKorisnik
     * @param lozinka
     * @param naziv
     * @return
     */
    @WebMethod(operationName = "dajAerodromeNaziv")
    public List<Aerodrom> dajAerodromeNaziv(@WebParam(name = "noviKorisnik") String noviKorisnik, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "naziv") String naziv) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(noviKorisnik, lozinka, bpk);

        List<Aerodrom> dajSveAerodromeNaziv;
        AirportDAO airportDAO = new AirportDAO();

        if (!dohvatiKorisnikaLista.isEmpty()) {

            if (naziv != null && !naziv.trim().isEmpty()) {
                dajSveAerodromeNaziv = airportDAO.dajSveAerodromeNaziv(naziv, bpk);
            } else {
                dajSveAerodromeNaziv = new ArrayList<>();
            }
            return dajSveAerodromeNaziv;

        }

        return null;
    }

    /**
     * This is a sample web service operation vraća aerodrome prema drzavi
     *
     * @param noviKorisnik
     * @param lozinka
     * @param naziv
     * @return
     */
    @WebMethod(operationName = "dajAerodromeDrzava")
    public List<Aerodrom> dajAerodromeDrzava(@WebParam(name = "noviKorisnik") String noviKorisnik, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "naziv") String naziv) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(noviKorisnik, lozinka, bpk);

        List<Aerodrom> dajSveAerodromeNaziv;
        AirportDAO airportDAO = new AirportDAO();

        if (!dohvatiKorisnikaLista.isEmpty()) {

            if (naziv != null && !naziv.trim().isEmpty()) {
                dajSveAerodromeNaziv = airportDAO.dajSveAerodromeDrzava(naziv, bpk);
            } else {
                dajSveAerodromeNaziv = new ArrayList<>();
            }
            return dajSveAerodromeNaziv;

        }

        return null;
    }

    /**
     * Web service operation azurira korisnika
     *
     * @param koris
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "azurirajKorisnika")
    public Boolean azurirajKorisnika(@WebParam(name = "koris") String koris, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "korisnik") Korisnik korisnik) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();

        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(koris, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            for (Korisnik kor : dohvatiKorisnikaLista) {
                String korIme = kor.getKorIme();

                return korisnikDAO.azurirajKorisnika2(korIme, korisnik, lozinka, bpk);

            }
        }

        return null;
    }

    /**
     * vraća sve korisnike
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "sviKorisnici")
    public List<Korisnik> sviKorisnici(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();

        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            List<Korisnik> dohvatiSveKorisnikeLista = korisnikDAO.dohvatiSveKorisnikeLista(korisnik, lozinka, bpk);

            return dohvatiSveKorisnikeLista;

        }

        return null;
    }

    /**
     * This is a sample web service operation vrača sve korisnike s aerodromima
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "korisniciAerodroma")
    public List<Korisnik> korisniciAerodroma(@WebParam(name = "noviKorisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();

        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            List<Korisnik> dohvatiKorisnikeAerodroma = korisnikDAO.dohvatiKorisnikeAerodroma(korisnik, lozinka, bpk);

            return dohvatiKorisnikeAerodroma;

        }

        return null;
    }

    /**
     * Web service operation vraća listu vlastitih aerodroma
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "mojiAerodromi")
    public List<Aerodrom> mojiAerodromi(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        AirportDAO airportDAO = new AirportDAO();
        List<Aerodrom> mojiAerodromiLista = airportDAO.mojiAerodromiLista(bpk, korisnik);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            if (!mojiAerodromiLista.isEmpty()) {
                return mojiAerodromiLista;
            }
            return null;

        }

        return null;
    }

    /**
     * Web service operation vraća true ako korisnik ima aerodrom koji prati
     *
     * @param icao
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "imamAerodrom")
    public Boolean imamAerodrom(@WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka, @WebParam(name = "icao") String icao) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            AirportDAO airportDAO = new AirportDAO();
            List<Airport> mojAerodromLista = airportDAO.mojAerodromLista(bpk, icao, korisnik);

            return !mojAerodromLista.isEmpty();

        }
        return null;
    }

    /**
     * Web service operation vraća listu aviona koji lete
     *
     * @param icao
     * @param odVremena
     * @param doVremena
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "poletjeliAvioniAerodrom")
    public List<AvionLeti> poletjeliAvioniAerodrom(@WebParam(name = "icao") String icao, @WebParam(name = "odVremena") long odVremena, @WebParam(name = "doVremena") long doVremena, @WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            String osnKorisnik = bpk.getKonfig().dajPostavku("OpenSkyNetwork.korisnik");
            String osnLozinka = bpk.getKonfig().dajPostavku("OpenSkyNetwork.lozinka");
            OSKlijent osKli = new OSKlijent(osnKorisnik, osnLozinka);

            List<AvionLeti> departures = osKli.getDepartures(icao, odVremena, doVremena);
            List<AvionLeti> avion = new ArrayList<>();

            for (AvionLeti a : departures) {
                String icao24 = a.getIcao24();
                int arrivalAirportCandidatesCount = a.getArrivalAirportCandidatesCount();
                String callsign = a.getCallsign();
                int departureAirportCandidatesCount = a.getDepartureAirportCandidatesCount();
                String estArrivalAirport = a.getEstArrivalAirport();
                int estArrivalAirportHorizDistance = a.getEstArrivalAirportHorizDistance();
                int estArrivalAirportVertDistance = a.getEstArrivalAirportVertDistance();
                String estDepartureAirport = a.getEstDepartureAirport();
                int estDepartureAirportHorizDistance = a.getEstDepartureAirportHorizDistance();
                int estDepartureAirportVertDistance = a.getEstDepartureAirportVertDistance();
                int firstSeen = a.getFirstSeen();
                int lastSeen = a.getLastSeen();

                AvionLeti leti = new AvionLeti(icao24, firstSeen, estDepartureAirport, lastSeen, estArrivalAirport, callsign, estDepartureAirportHorizDistance, estDepartureAirportVertDistance, estArrivalAirportHorizDistance, estArrivalAirportVertDistance, departureAirportCandidatesCount, arrivalAirportCandidatesCount);
                avion.add(leti);
            }
            return avion;

        }

        return null;
    }

    /**
     * Web service operation vraća podatke traženog aerodroma kojeg korisnik
     * prati
     *
     * @param icao
     * @param korisnik
     * @param lozinka
     * @return
     */
    @WebMethod(operationName = "mojAerodrom")
    public List<Aerodrom> mojAerodrom(@WebParam(name = "icao") String icao, @WebParam(name = "korisnik") String korisnik, @WebParam(name = "lozinka") String lozinka) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");

        KorisnikDAO korisnikDAO = new KorisnikDAO();
        List<Korisnik> dohvatiKorisnikaLista = korisnikDAO.dohvatiKorisnikaLista(korisnik, lozinka, bpk);

        if (!dohvatiKorisnikaLista.isEmpty()) {

            AirportDAO airportDAO = new AirportDAO();
            List<Aerodrom> mojAerodromL = airportDAO.mojAerodromL(bpk, korisnik, icao);

            if (mojAerodromL.isEmpty()) {
                mojAerodromL = new ArrayList<>();
            }

            return mojAerodromL;
        }

        return null;
    }

    /**
     * dodatna metoda
     *
     * @param number
     * @return
     */
    public String zvjezdLozinka(String number) {
        StringBuilder temp = new StringBuilder();
        for (int i = 0; i < number.length(); i++) {
            temp.append("*");
        }
        return temp.toString();
    }
}
