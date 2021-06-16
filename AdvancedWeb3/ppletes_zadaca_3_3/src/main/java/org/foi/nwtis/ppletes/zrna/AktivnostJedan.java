package org.foi.nwtis.ppletes.zrna;

import java.io.Serializable;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.annotation.PostConstruct;
import javax.ejb.EJB;
import javax.inject.Named;
import javax.faces.view.ViewScoped;
import lombok.Getter;
import lombok.Setter;
import org.foi.nwtis.ppletes.ejb.eb.Airports;
import org.foi.nwtis.ppletes.ejb.eb.Korisnici;
import org.foi.nwtis.ppletes.ejb.eb.Myairports;
import org.foi.nwtis.ppletes.ejb.eb.Myairportslog;
import org.foi.nwtis.ppletes.ejb.sb.KorisniciFacadeLocal;
import org.foi.nwtis.ppletes.ejb.sb.MyairportsFacadeLocal;
import org.foi.nwtis.ppletes.ejb.sb.MyairportslogFacadeLocal;

/**
 *
 * @author Paula
 */
@Named(value = "pregledPrvi")
@ViewScoped
public class AktivnostJedan implements Serializable {

    @EJB
    KorisniciFacadeLocal kfl;

    @EJB
    MyairportsFacadeLocal mfl;

    @EJB
    MyairportslogFacadeLocal mlfl;

    @Getter
    List<Korisnici> korisnici = new ArrayList<>();

    @Getter
    List<Myairports> aerodromi = new ArrayList<>();

    @Getter
    List<Myairportslog> aerodromiLog = new ArrayList<>();
    @Getter
    List<Myairportslog> aerodromLog2 = new ArrayList<>();

    @Getter
    @Setter
    String odabraniKorisnik;

    @Getter
    @Setter
    Integer odabraniAerodrom;

    @Getter
    @Setter
    Myairportslog odabraniDan;

    DateFormat formatterHR = new SimpleDateFormat("dd.MM.yyyy HH:mm:ss.SSS");
    DateFormat formatterHR2 = new SimpleDateFormat("dd.MM.yyyy");

    @Getter
    private boolean show = false;

    @Getter
    private boolean show2 = false;

    @Getter
    private boolean show3 = false;

    public AktivnostJedan() {
    }

    /**
     * ucitava sve korisnike
     */
    @PostConstruct
    public void ucitaj() {
        korisnici = kfl.findAll();
    }

    /**
     *
     * @return
     * 
     * vraca pracene aerodrome korisnika
     */
    public String prikaziAerodrom() {
        show = !show;
        Korisnici find = kfl.find(odabraniKorisnik);
        aerodromi = find.getMyairportsList();
        return "";
    }

    /**
     *
     * @return
     * 
     * prikazuje datum i vrijeme praćenog aerodroma
     */
    public String pikaziDan() {
        show2 = !show2;
        Myairports find = mfl.find(odabraniAerodrom);
        aerodromiLog = find.getIdent().getMyairportslogList();
        return "";
    }

    /**
     *
     * @param a
     * @return
     * 
     * brise vrijeme pracenog aerodroma iz baze --> tablica Myairportslog
     */
    public String obrisiLog(Myairportslog a) {
        mlfl.remove(a);
        Airports airports = a.getAirports();
        aerodromLog2 = airports.getMyairportslogList();
        aerodromLog2.remove(a);
        aerodromiLog.remove(a);
        show3 = true;
        return "";
    }

    /**
     *
     * @return
     * 
     * skriva zadnje dvije liste i zadnji button - vraća se na početak
     */
    public String sakri() {
        show = !show;
        show2 = !show2;
        show3 = !show3;
        return "";
    }

    /**
     *
     * @param fecha
     * @param pattern
     * @return
     * 
     * formatira datum unutar xhtml-a
     */
    public String formatDate(Date fecha, String pattern) {
        return (new SimpleDateFormat(pattern)).format(fecha);
    }
}
