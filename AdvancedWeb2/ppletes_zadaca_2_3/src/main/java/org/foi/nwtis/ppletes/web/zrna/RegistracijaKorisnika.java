package org.foi.nwtis.ppletes.web.zrna;

import java.io.Serializable;
import javax.enterprise.context.RequestScoped;
import javax.inject.Named;
import javax.ws.rs.core.Response;
import lombok.Getter;
import lombok.Setter;
import org.foi.nwtis.podaci.Korisnik;
import org.foi.nwtis.ppletes.rest.klijenti.Zadaca2_2RSK;

/**
 *
 * @author Paula
 */
@Named(value = "registracijaKorisnika")
@RequestScoped
public class RegistracijaKorisnika implements Serializable {

    @Getter
    @Setter
    private Korisnik noviKorisnik;

    @Getter
    @Setter
    private String ime;

    @Getter
    @Setter
    private String korIme;

    @Getter
    @Setter
    private String prezime;

    @Getter
    @Setter
    private String email;

    @Getter
    @Setter
    private String lozinka;

    /**
     * Creates a new instance of RegistracijaKorisnika
     */
    public RegistracijaKorisnika() {
    }

    /**
     * metoda za dodavanje novog korisnika
     *
     * @param korIme
     * @param ime
     * @param lozinka
     * @param prezime
     * @param email
     * @return
     */
    public String dodajKorisnika(String korIme, String ime, String lozinka, String prezime, String email) {

        Zadaca2_2RSK zadaca = new Zadaca2_2RSK();
        noviKorisnik = new Korisnik(korIme, ime, prezime, lozinka, email, null, null);

        Response dodajKorisnika = zadaca.dodajKorisnika(noviKorisnik);

        if (dodajKorisnika == null) {
            return null;
        }
        return "index?faces-redirect=true";
    }
}
