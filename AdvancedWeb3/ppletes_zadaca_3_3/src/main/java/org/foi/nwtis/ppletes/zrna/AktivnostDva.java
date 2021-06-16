package org.foi.nwtis.ppletes.zrna;

import java.io.Serializable;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import javax.annotation.PostConstruct;
import javax.ejb.EJB;
import javax.faces.view.ViewScoped;
import javax.inject.Inject;
import javax.inject.Named;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import javax.persistence.Query;
import javax.persistence.TypedQuery;
import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import lombok.Getter;
import lombok.Setter;
import javax.persistence.criteria.Root;
import javax.servlet.ServletContext;
import org.foi.nwtis.ppletes.ejb.eb.Airports;
import org.foi.nwtis.ppletes.ejb.eb.Korisnici;
import org.foi.nwtis.ppletes.ejb.mdb.Meterolog;
import org.foi.nwtis.ppletes.ejb.sb.AirportsFacadeLocal;
import org.foi.nwtis.ppletes.ejb.sb.KorisniciFacadeLocal;
import org.foi.nwtis.ppletes.ejb.sb.MyairportsFacadeLocal;

import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import org.foi.nwtis.rest.klijenti.OWMKlijent;
import org.foi.nwtis.rest.podaci.MeteoPodaci;

/**
 *
 * @author Paula
 */
@ViewScoped
@Named("pregledDrugi")
public class AktivnostDva implements Serializable {

    @Inject
    ServletContext context;

    @EJB
    Meterolog ml;

    @Getter
    private final List<MeteoPodaci> podaciMeteo = new ArrayList<>();

    @EJB
    KorisniciFacadeLocal kfl;

    @EJB
    MyairportsFacadeLocal mfl;

    @Getter
    List<Korisnici> korisnici = new ArrayList<>();

    @Getter
    @Setter
    String odabraniKorisnik;
    @Getter
    @Setter
    String odabraniAerodrom;

    @EJB
    AirportsFacadeLocal afl;

    @Getter
    List<Airports> aerodromi = new ArrayList<>();

    @Getter
    @Setter
    private String naziv;

    @Getter
    int brojAerodroma = 0;
    @Getter
    Date zadnjeOsvjezavanje;
    @Getter
    String format;

    DateFormat formatterHR = new SimpleDateFormat("dd.MM.yyyy HH:mm:ss.SSS");

    @Getter
    boolean show = false;

    private static final EntityManagerFactory entityManagerFactory
            = Persistence.createEntityManagerFactory("NWTiS_DZ3_PU");

    public AktivnostDva() {
    }

    /**
     * ucitava sve korisnike u tablicu
     */
    @PostConstruct
    public void ucitaj() {
        korisnici = kfl.findAll();
    }

    /**
     * pretrazuje aerodrome iz tablice Airports po nazivu na temelju JPQL-a
     */
    public void nameJPQL() {
        show = true;
        EntityManager em = entityManagerFactory.createEntityManager();
        Query query = em.createQuery("SELECT e FROM Airports e WHERE e.name= '" + naziv + "' OR e.name LIKE '%" + naziv + "%' ");
        List<Airports> resultList = query.getResultList();
        aerodromi = resultList;
        em.close();
    }

    /**
     * posprema u varijablu odabranog korisnika i vraća datum-vrijeme najnovijeg
     * osviježenja
     *
     * @param kor
     * @return
     */
    public String odaberiKor(String kor) {
        odabraniKorisnik = kor;
        zadnjeOsvjezavanje = new Date();
        format = formatterHR.format(zadnjeOsvjezavanje);
        return odabraniKorisnik;
    }

    /**
     * pretrazuje aerodrome iz tablice Airports po nazivu na temelju Criteria
     * API-a
     */
    public void nameCApi() {
        show = true;
        EntityManager em = entityManagerFactory.createEntityManager();
        CriteriaBuilder cb = em.getCriteriaBuilder();
        CriteriaQuery<Airports> query = cb.createQuery(Airports.class);//create query object
        Root<Airports> employeeRoot = query.from(Airports.class);//get object representing 'from' part
        query.select(employeeRoot)
                .where(cb.like(employeeRoot.get("name"), "%" + naziv + "%"));
        TypedQuery<Airports> typedQuery = em.createQuery(query);
        List<Airports> resultList = typedQuery.getResultList();
        aerodromi = resultList;
        em.close();
    }

    /**
     *
     * @param coordinates
     * @return
     *
     * vraca temperaturu aerodroma na temelju vrijednosti koordinata
     * podijeljenih na geo sirinu i duzinu
     */
    public float temp(String coordinates) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        String apikey = bpk.getKonfig().dajPostavku("OpenWeatherMap.apikey");

        String[] split = coordinates.split(", ");
        String lat = split[0];
        String lon = split[1];

        OWMKlijent oWMKlijent = new OWMKlijent(apikey);
        try {
            MeteoPodaci metoPodaci = oWMKlijent.getRealTimeWeather(lat, lon);
            return metoPodaci.getTemperatureValue();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return 0.0f;
    }

    /**
     *
     * @param coordinates
     * @return
     *
     * vraca jedinicu temperature --> celzijus
     */
    public String tempUnit(String coordinates) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        String apikey = bpk.getKonfig().dajPostavku("OpenWeatherMap.apikey");

        String[] split = coordinates.split(", ");
        String lat = split[0];
        String lon = split[1];

        OWMKlijent oWMKlijent = new OWMKlijent(apikey);
        try {
            MeteoPodaci metoPodaci = oWMKlijent.getRealTimeWeather(lat, lon);
            return metoPodaci.getTemperatureUnit();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return "";
    }

    /**
     *
     * @param coordinates
     * @return
     *
     * vraca vlagu aerodroma na temelju vrijednosti koordinata podijeljenih na
     * geo sirinu i duzinu
     */
    public float vlaga(String coordinates) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        String apikey = bpk.getKonfig().dajPostavku("OpenWeatherMap.apikey");

        String[] split = coordinates.split(", ");
        String lat = split[0];
        String lon = split[1];

        OWMKlijent oWMKlijent = new OWMKlijent(apikey);
        try {
            MeteoPodaci metoPodaci = oWMKlijent.getRealTimeWeather(lat, lon);
            return metoPodaci.getHumidityValue();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return 0.0f;
    }

    /**
     *
     * @param coordinates
     * @return
     *
     * vraca jedinicu temperature --> %
     */
    public String vlagaUnit(String coordinates) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        String apikey = bpk.getKonfig().dajPostavku("OpenWeatherMap.apikey");

        String[] split = coordinates.split(", ");
        String lat = split[0];
        String lon = split[1];

        OWMKlijent oWMKlijent = new OWMKlijent(apikey);
        try {
            MeteoPodaci metoPodaci = oWMKlijent.getRealTimeWeather(lat, lon);
            return metoPodaci.getHumidityUnit();
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return "";
    }
}
