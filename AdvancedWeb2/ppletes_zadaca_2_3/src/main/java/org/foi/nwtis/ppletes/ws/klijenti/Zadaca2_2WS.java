package org.foi.nwtis.ppletes.ws.klijenti;

/**
 *
 * @author Paula
 */
public class Zadaca2_2WS {

    /**
     * provjerava korisnicke podatke
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    public Boolean provjeraKorisnika(String korisnik, String lozinka) {
        Boolean korisnici = null;

        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            korisnici = port.provjeraKorisnika(korisnik, lozinka);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return korisnici;
    }

}
