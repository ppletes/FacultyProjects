package org.foi.nwtis.ppletes.ws.klijenti;

import java.util.List;
import org.foi.nwtis.ppletes.ws.serveri.Aerodrom;

/**
 *
 * @author Paula
 */
public class Zadaca2_1WS {

    /**
     * vraca listu aerodroma koje korinik prati
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
}
