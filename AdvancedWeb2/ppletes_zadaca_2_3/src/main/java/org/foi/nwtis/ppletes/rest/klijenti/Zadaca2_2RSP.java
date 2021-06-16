package org.foi.nwtis.ppletes.rest.klijenti;

import javax.ws.rs.ClientErrorException;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.WebTarget;

/**
 * Jersey REST client generated for REST resource:Zadaca2RestProvjera
 * [provjera]<br>
 * USAGE:
 * <pre>
 * Zadaca2_2RSP client = new Zadaca2_2RSP();
 * Object response = client.XXX(...);
 * // do whatever with response
 * client.close();
 * </pre>
 *
 * @author Paula
 */
public class Zadaca2_2RSP {

    private final WebTarget webTarget;
    private final Client client;
    private static final String BASE_URI = "http://localhost:8080/ppletes_zadaca_2_2/webresources";
    private String korisnik = "";
    private String lozinka = "";

    /**
     *
     */
    public Zadaca2_2RSP() {
        client = javax.ws.rs.client.ClientBuilder.newClient();
        webTarget = client.target(BASE_URI).path("provjera");
    }

    /**
     * konstruktor za Zadaca2_2RSP
     *
     * @param korisnik
     * @param lozinka
     */
    public Zadaca2_2RSP(String korisnik, String lozinka) {
        client = javax.ws.rs.client.ClientBuilder.newClient();
        webTarget = client.target(BASE_URI).path("provjera");
        this.korisnik = korisnik;
        this.lozinka = lozinka;
    }

    /**
     * provjerava ispravnost unesenih korisnickih podataka
     *
     * @param <T>
     * @param responseType
     * @return
     * @throws ClientErrorException
     */
    public <T> T provjeraKorisnika(Class<T> responseType) throws ClientErrorException {
        WebTarget resource = webTarget;
        return resource.request(javax.ws.rs.core.MediaType.APPLICATION_JSON)
                .header("korisnik", korisnik)
                .header("lozinka", lozinka)
                .get(responseType);
    }

    public void close() {
        client.close();
    }

}
