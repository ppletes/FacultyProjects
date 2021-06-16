package org.foi.nwtis.ppletes.ws.klijenti;

import java.util.List;
import org.foi.nwtis.ppletes.ws.serveri.Aerodrom;
import org.foi.nwtis.ppletes.ws.serveri.Korisnik;

/**
 *
 * @author Paula
 */
public class Zadaca2_1WS {

    /**
     * daje listu aerodroma korisnika
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    public List<Aerodrom> dajAerodomeKorisnika(String korisnik, String lozinka) {
        List<Aerodrom> aerodromi = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            aerodromi = port.dajAerodromeKorisnika(korisnik, lozinka);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return aerodromi;
    }

    /**
     * daje listu aerodroma korisnika prema nazivu
     *
     * @param korisnik
     * @param lozinka
     * @param naziv
     * @return
     */
    public List<Aerodrom> dajAerodomeNaziv(String korisnik, String lozinka, String naziv) {
        List<Aerodrom> aerodromi = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            aerodromi = port.dajAerodromeNaziv(korisnik, lozinka, naziv);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return aerodromi;
    }

    /**
     * provjerava korisnika - korisnicke podatke
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    public Boolean provjeraKorisnika(String korisnik, String lozinka) {
        Boolean provjera = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            provjera = port.provjeraKorisnika(korisnik, lozinka);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return provjera;
    }

    /**
     * dodaje novi aerodrom u listu aerodroma koje parti korisnik
     *
     * @param korisnik
     * @param lozinka
     * @param icao
     * @return
     */
    public Boolean dodajMojAerodrom(String korisnik, String lozinka, String icao) {
        Boolean dodajMojAerodrom = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            dodajMojAerodrom = port.dodajMojAerodrom(korisnik, lozinka, icao);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return dodajMojAerodrom;
    }

    /**
     * vraća vlastiti aerodrom
     *
     * @param korisnik
     * @param lozinka
     * @param naziv
     * @return
     */
    public List<Aerodrom> mojAerodrom(String korisnik, String lozinka, String naziv) {
        List<Aerodrom> aerodromi = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            aerodromi = port.mojAerodrom(naziv, korisnik, lozinka);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return aerodromi;
    }

    /**
     * dodaje novog korisnika
     *
     * @param noviKorisnik
     * @return
     */
    public Boolean dodajKorisnika(Korisnik noviKorisnik) {
        Boolean korisnik = null;
        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            korisnik = port.dodajKorisnika(noviKorisnik);

        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }

        return korisnik;
    }

}
