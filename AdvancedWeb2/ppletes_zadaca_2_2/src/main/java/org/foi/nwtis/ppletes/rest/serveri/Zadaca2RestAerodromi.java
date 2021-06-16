package org.foi.nwtis.ppletes.rest.serveri;

import java.util.ArrayList;
import java.util.List;
import javax.ws.rs.core.Context;
import javax.ws.rs.core.UriInfo;
import javax.ws.rs.Produces;
import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.HeaderParam;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.QueryParam;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import org.foi.nwtis.podaci.Odgovor;
import org.foi.nwtis.ppletes.ws.klijenti.Zadaca2_1WS;
import org.foi.nwtis.ppletes.ws.serveri.Aerodrom;

/**
 * REST Web Service
 *
 * @author Paula
 */
@Path("aerodromi")
public class Zadaca2RestAerodromi {

    @Context
    private UriInfo context;

    /**
     * Creates a new instance of Zadaca2RestAerodromi
     */
    public Zadaca2RestAerodromi() {
    }

    /**
     * Vraća aerodrome koje prati korisnik
     *
     * @param korisnik
     * @param lozinka
     * @return an instance of Response
     */
    @GET
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response dajAerodomeKorisnika(
            @HeaderParam("korisnik") String korisnik,
            @HeaderParam("lozinka") String lozinka) {

        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        List<Aerodrom> aerodromi = zadaca2_1WS.dajAerodomeKorisnika(korisnik, lozinka);
        if (aerodromi == null) {
            aerodromi = new ArrayList<>();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("OK");
        odgovor.setOdgovor(aerodromi.toArray());
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }

    /**
     * Vraća aerodrome prema nazivu ili državi
     *
     * @param korisnik
     * @param lozinka
     * @param naziv
     * @param drzava
     * @return an instance of Response
     */
    @Path("/svi")
    @GET
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response dajAerodome(
            @HeaderParam("korisnik") String korisnik,
            @HeaderParam("lozinka") String lozinka,
            @QueryParam("naziv") String naziv,
            @QueryParam("drzava") String drzava) {

        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        List<Aerodrom> aerodromi = new ArrayList<>();
        if (naziv != null && !naziv.isEmpty()) {
            aerodromi = zadaca2_1WS.dajAerodomeNaziv(korisnik, lozinka, naziv);
        } else if (drzava != null && !drzava.isEmpty()) {
            //TODO treba biti za državu
            aerodromi = zadaca2_1WS.dajAerodomeNaziv(korisnik, lozinka, drzava);
        } else {
            aerodromi = zadaca2_1WS.dajAerodomeNaziv(korisnik, lozinka, "%");
        }

        if (aerodromi == null) {
            aerodromi = new ArrayList<>();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("OK");
        odgovor.setOdgovor(aerodromi.toArray());
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }

    /**
     * Vraća aerodrome prema nazivu ili državi
     *
     * @param korisnik
     * @param lozinka
     * @param icao
     * @return an instance of Response
     */
    @GET
    @Path("{icao}")
    @Consumes({MediaType.APPLICATION_JSON})
    @Produces({MediaType.APPLICATION_JSON})
    public Response mojAerodrom(
            @PathParam("icao") String icao,
            @HeaderParam("korisnik") String korisnik,
            @HeaderParam("lozinka") String lozinka) {

        Zadaca2_1WS zadaca2_1WS = new Zadaca2_1WS();
        List<Aerodrom> aerodromi = new ArrayList<>();
        if (icao != null && !icao.isEmpty()) {
            aerodromi = zadaca2_1WS.mojAerodrom(korisnik, lozinka, icao);
        } else {
            aerodromi = new ArrayList<>();
        }

        Odgovor odgovor = new Odgovor();
        odgovor.setStatus("10");
        odgovor.setPoruka("OK");
        odgovor.setOdgovor(aerodromi.toArray());
        return Response
                .ok(odgovor)
                .status(200)
                .build();
    }
}
