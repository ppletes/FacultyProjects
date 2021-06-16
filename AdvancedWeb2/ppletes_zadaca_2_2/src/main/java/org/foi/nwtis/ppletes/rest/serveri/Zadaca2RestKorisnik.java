package org.foi.nwtis.ppletes.rest.serveri;

import javax.ws.rs.Consumes;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.core.UriInfo;
import org.foi.nwtis.podaci.Odgovor;
import org.foi.nwtis.ppletes.ws.klijenti.Zadaca2_1WS;
import org.foi.nwtis.ppletes.ws.serveri.Korisnik;

/**
 *
 * @author Paula
 */
@Path("korisnik")
public class Zadaca2RestKorisnik {

    @Context
    private UriInfo context;

    public Zadaca2RestKorisnik() {
    }

    /**
     * dodaje novog korisnika
     *
     * @param korisnik
     * @return
     */
    @POST
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response dodajKorisnika(
            @HeaderParam("korisnik") Korisnik korisnik) {

        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        Boolean provjera = zadaca2_1WS.dodajKorisnika(korisnik);
        if (provjera != true) {
            Odgovor odgovor = new Odgovor();
            odgovor.setStatus("40");
            odgovor.setPoruka("false; Korisnik nije dodan!");
            return Response
                    .ok(odgovor)
                    .status(200)
                    .build();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("true; Korisnik je dodan!");
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }
}
