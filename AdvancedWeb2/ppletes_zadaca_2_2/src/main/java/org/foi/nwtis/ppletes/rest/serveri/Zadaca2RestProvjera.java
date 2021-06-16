package org.foi.nwtis.ppletes.rest.serveri;

import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.UriInfo;
import org.foi.nwtis.podaci.Odgovor;
import org.foi.nwtis.ppletes.ws.klijenti.Zadaca2_1WS;

/**
 *
 * @author Paula
 */
@Path("provjera")
public class Zadaca2RestProvjera {

    @Context
    private UriInfo context;

    public Zadaca2RestProvjera() {
    }

    /**
     * provjerava korisnicke podatke
     *
     * @param korisnik
     * @param lozinka
     * @return
     */
    @GET
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response provjeraKorisnika(
            @HeaderParam("korisnik") String korisnik,
            @HeaderParam("lozinka") String lozinka) {

        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        Boolean provjera = zadaca2_1WS.provjeraKorisnika(korisnik, lozinka);
        if (provjera != true) {
            Odgovor odgovor = new Odgovor();
            odgovor.setStatus("40");
            odgovor.setPoruka("false; Korisnik ne postoji!");
            return Response
                    .ok(odgovor)
                    .status(200)
                    .build();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("true; Korisnik postoji!");
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }
}
