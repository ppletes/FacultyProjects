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

/**
 * REST Web Service
 *
 * @author Paula
 */
@Path("dodaj")
public class Zadaca2RestDodaj {

    @Context
    private UriInfo context;

    /**
     * Creates a new instance of Zadaca2RestDodaj
     */
    public Zadaca2RestDodaj() {
    }

    /**
     * doaje novi aerodrom korisnika koji ce pratiti
     *
     * @param korisnik
     * @param lozinka
     * @param icao
     * @return
     */
    @POST
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response dodajMojAerodrom(@HeaderParam("korisnik") String korisnik,
            @HeaderParam("lozinka") String lozinka,
            @HeaderParam("icao") String icao) {
        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        Boolean dodajMojAerodrom = zadaca2_1WS.dodajMojAerodrom(korisnik, lozinka, icao);

        if (dodajMojAerodrom != true) {
            Odgovor odgovor = new Odgovor();
            odgovor.setStatus("40");
            odgovor.setPoruka("false; Ne može se unjeti aerodrom!");
            return Response
                    .ok(odgovor)
                    .status(200)
                    .build();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("true; Aerodrom unesen!");
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }
}
