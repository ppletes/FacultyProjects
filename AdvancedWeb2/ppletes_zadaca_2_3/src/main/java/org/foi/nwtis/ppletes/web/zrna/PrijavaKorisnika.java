package org.foi.nwtis.ppletes.web.zrna;

import java.io.Serializable;
import javax.enterprise.context.SessionScoped;
import javax.faces.application.FacesMessage;
import javax.faces.context.FacesContext;
import javax.inject.Named;
import lombok.Getter;
import lombok.Setter;
import org.foi.nwtis.podaci.Odgovor;
import org.foi.nwtis.ppletes.rest.klijenti.Zadaca2_2RSP;

/**
 *
 * @author Paula
 */
@Named(value = "prijavaKorisnika")
@SessionScoped
public class PrijavaKorisnika implements Serializable {

    @Getter
    @Setter
    private String korisnik;

    @Getter
    @Setter
    private String lozinka;

    /**
     * Creates a new instance of PrijavaKorisnika
     */
    public PrijavaKorisnika() {
    }

    /**
     * provjerava korisnicke podatke
     *
     * @return
     */
    public boolean provjeriKorisnike() {

        Zadaca2_2RSP zadaca2_RSP = new Zadaca2_2RSP(korisnik, lozinka);
        Odgovor odgovor = zadaca2_RSP.provjeraKorisnika(Odgovor.class);
        String status = odgovor.getStatus();

        if (status.startsWith("10")) {
            return true;
        }

        return false;
    }

    /**
     * metoda z aprijavu korisnika, postavlja sesiju
     *
     * @return
     */
    public String login() {

        FacesContext context = FacesContext.getCurrentInstance();

        if (provjeriKorisnike() == false) {
            context.addMessage(null, new FacesMessage("Krivi korisnički podaci!"));
            korisnik = null;
            lozinka = null;
            return null;
        } else {
            context.getExternalContext().getSessionMap().put("user", korisnik);
            context.getExternalContext().getSessionMap().put("password", lozinka);
            return "dodavanjeAerodroma?faces-redirect=true";
        }
    }

    /**
     * metoda za odjavu korisnika, unistava sesiju
     *
     * @return
     */
    public String logout() {
        FacesContext.getCurrentInstance().getExternalContext().invalidateSession();
        return "index?faces-redirect=true";
    }
}
