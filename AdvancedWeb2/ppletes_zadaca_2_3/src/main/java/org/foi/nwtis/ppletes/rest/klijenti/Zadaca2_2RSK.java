package org.foi.nwtis.ppletes.rest.klijenti;

import javax.ws.rs.ClientErrorException;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.Response;
import org.foi.nwtis.ppletes.ws.serveri.Korisnik;

/**
 * Jersey REST client generated for REST resource:Zadaca2RestKorisnik
 * [korisnik]<br>
 * USAGE:
 * <pre>
 *        Zadaca2_2RSK client = new Zadaca2_2RSK();
 *        Object response = client.XXX(...);
 *        // do whatever with response
 *        client.close();
 * </pre>
 *
 * @author Paula
 */
public class Zadaca2_2RSK {

    private final WebTarget webTarget;
    private final Client client;
    private static final String BASE_URI = "http://localhost:8080/ppletes_zadaca_2_2/webresources";
    private Korisnik korisnik;

    /**
     * konstruktor za Zadaca2_2RSK
     */
    public Zadaca2_2RSK() {
        client = javax.ws.rs.client.ClientBuilder.newClient();
        webTarget = client.target(BASE_URI).path("korisnik");
    }

    /**
     * dodaje novog korisnika
     *
     * @param requestEntity
     * @return
     * @throws ClientErrorException
     */
    public Response dodajKorisnika(Object requestEntity) throws ClientErrorException {
        return webTarget.request(javax.ws.rs.core.MediaType.APPLICATION_JSON)
                .header("korisnik", korisnik)
                .post(javax.ws.rs.client.Entity.entity(requestEntity, javax.ws.rs.core.MediaType.APPLICATION_JSON), Response.class);
    }

    public void close() {
        client.close();
    }

}
