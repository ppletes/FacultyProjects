package org.foi.nwtis.ppletes.web.zrna;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import javax.inject.Named;
import javax.enterprise.context.SessionScoped;
import javax.inject.Inject;
import lombok.Getter;
import lombok.Setter;
import org.foi.nwtis.podaci.Aerodrom;
import org.foi.nwtis.podaci.OdgovorAerodrom;
import org.foi.nwtis.ppletes.rest.klijenti.Zadaca2_2RS;

/**
 *
 * @author Paula
 */
@Named(value = "dodavanjeAerodroma")
@SessionScoped
public class DodavanjeAerodroma implements Serializable {

    @Inject
    PrijavaKorisnika prijavaKorisnika;

    String korisnik;
    String lozinka;

    @Getter
    @Setter
    String naziv;
    @Getter
    @Setter
    String drzava;
    @Getter
    List<Aerodrom> aerodromi;

    @Getter
    List<Aerodrom> aerodromiKorisnika = new ArrayList<>();

    @Getter
    @Setter
    String icaoOdabrani;

    /**
     * Creates a new instance of DodavanjeAerodroma
     */
    public DodavanjeAerodroma() {
        //TODO ovo nije pravi način jer treba dinamički pozivati 
        //TODO prema potrebi iz servisa za bazu podataka tako da postoji ažuriranje

        Zadaca2_2RS zadaca2_RS = new Zadaca2_2RS(korisnik, lozinka);
        OdgovorAerodrom odgovor = zadaca2_RS.dajAerodomeKorisnika(OdgovorAerodrom.class);
        aerodromiKorisnika = Arrays.asList(odgovor.getOdgovor());
    }

    /**
     * dohvaca podatke prijavljenog korisnika iz sesije
     */
    public void preuzmiPodatkeKorisnika() {
        korisnik = prijavaKorisnika.getKorisnik();
        lozinka = prijavaKorisnika.getLozinka();
    }

    /**
     * vraća aerodrome prema nazivu
     *
     * @return
     */
    public String dajAerodromaNaziv() {
        preuzmiPodatkeKorisnika();
        aerodromi = dajAerodrome(korisnik, lozinka, naziv, "");
        return "";
    }

    /**
     * vraca aerodrome prema drzavi
     *
     * @return
     */
    public String dajAerodromaDrzava() {
        preuzmiPodatkeKorisnika();
        aerodromi = dajAerodrome(korisnik, lozinka, "", drzava);
        return "";
    }

    /**
     * brise aerodrome iz liste (samo da korisniku bude lakše, ne brise se iz
     * baze)
     *
     * @return
     */
    public String obrisiAerodromeKorisnika() {
        aerodromiKorisnika = new ArrayList<>();
        return "";
    }

    /**
     * vraća aerodorme uz pomoc restful servisa
     *
     * @param korisnik
     * @param lozinka
     * @param naziv
     * @param drzava
     * @return
     */
    private List<Aerodrom> dajAerodrome(String korisnik, String lozinka, String naziv, String drzava) {
        List<Aerodrom> aerodromiPreuzeti = new ArrayList<>();

        Zadaca2_2RS zadaca2_RS = new Zadaca2_2RS(korisnik, lozinka);
        OdgovorAerodrom odgovor = zadaca2_RS.dajAerodome(OdgovorAerodrom.class, naziv, drzava);
        aerodromiPreuzeti = Arrays.asList(odgovor.getOdgovor());

        return aerodromiPreuzeti;
    }

    /**
     * dodaje novi aerodrom u tablicu aerodroma koje prate korisnici
     *
     * @param icao
     * @return
     */
    public String dodajAerodromKorisniku(String icao) {
        // TODO Dodaj aerodrom u kolekciju aerodroma u bazi podataka
        boolean nema = true;
        icaoOdabrani = icao;
        for (Aerodrom a : aerodromi) {
            if (a.getIcao().compareTo(icaoOdabrani) == 0) {
                for (Aerodrom b : aerodromiKorisnika) {
                    if (a.getIcao().compareTo(b.getIcao()) == 0) {
                        nema = false;
                        break;
                    }
                }
                if (nema) {
                    aerodromiKorisnika.add(a);
                }
                break;
            }
        }
        return "";
    }

}
