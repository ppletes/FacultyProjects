package org.foi.nwtis.ppletes.ws.klijenti;

/**
 *
 * @author Paula
 */
public class Zadaca2_3WS {

    /**
     * dodaje novi aerodrom korisniku da ga prati
     *
     * @param korisnik
     * @param lozinka
     * @param icao
     * @return
     */
    public Boolean dodajMojAerodrom(String korisnik, String lozinka, String icao) {
        Boolean aerodrom = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            aerodrom = port.dodajMojAerodrom(korisnik, lozinka, icao);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return aerodrom;
    }

}
