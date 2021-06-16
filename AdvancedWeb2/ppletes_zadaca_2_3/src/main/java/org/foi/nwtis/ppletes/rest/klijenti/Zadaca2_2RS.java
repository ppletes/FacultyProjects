package org.foi.nwtis.ppletes.rest.klijenti;

import javax.ws.rs.ClientErrorException;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.WebTarget;

/**
 * Jersey REST client generated for REST resource:Zadaca2RestAerodromi
 * [aerodromi]<br>
 * USAGE:
 * <pre>
 *        Zadaca2_2RS client = new Zadaca2_2RS();
 *        Object response = client.XXX(...);
 *        // do whatever with response
 *        client.close();
 * </pre>
 *
 * @author Paula
 */
public class Zadaca2_2RS {

    private final WebTarget webTarget;
    private final Client client;
    private static final String BASE_URI = "http://localhost:8080/ppletes_zadaca_2_2/webresources";
    private String korisnik = "";
    private String lozinka = "";

    public Zadaca2_2RS() {
        client = javax.ws.rs.client.ClientBuilder.newClient();
        webTarget = client.target(BASE_URI).path("aerodromi");
    }

    /**
     * konstruktor za Zadaca2_2RS
     *
     * @param korisnik
     * @param lozinka
     */
    public Zadaca2_2RS(String korisnik, String lozinka) {
        client = javax.ws.rs.client.ClientBuilder.newClient();
        webTarget = client.target(BASE_URI).path("aerodromi");
        this.korisnik = korisnik;
        this.lozinka = lozinka;
    }

    public void putJson(Object requestEntity) throws ClientErrorException {
        webTarget.request(javax.ws.rs.core.MediaType.APPLICATION_JSON).put(javax.ws.rs.client.Entity.entity(requestEntity, javax.ws.rs.core.MediaType.APPLICATION_JSON));
    }

    /**
     * vraca aerodrome korisnika
     *
     * @param <T>
     * @param responseType
     * @return
     * @throws ClientErrorException
     */
    public <T> T dajAerodomeKorisnika(Class<T> responseType) throws ClientErrorException {
        WebTarget resource = webTarget;
        return resource.request(javax.ws.rs.core.MediaType.APPLICATION_JSON)
                .header("korisnik", korisnik)
                .header("lozinka", lozinka)
                .get(responseType);
    }

    /**
     * vraća sve aerodrome
     *
     * @param <T>
     * @param responseType
     * @param drzava
     * @param naziv
     * @return
     * @throws ClientErrorException
     */
    public <T> T dajAerodome(Class<T> responseType, String drzava, String naziv) throws ClientErrorException {
        WebTarget resource = webTarget;
        if (drzava != null) {
            resource = resource.queryParam("drzava", drzava);
        }
        if (naziv != null) {
            resource = resource.queryParam("naziv", naziv);
        }
        resource = resource.path("svi");
        return resource.request(javax.ws.rs.core.MediaType.APPLICATION_JSON).get(responseType);
    }

    public void close() {
        client.close();
    }

}
