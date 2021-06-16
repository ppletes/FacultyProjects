package org.foi.nwtis.ppletes.web.dretve;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.foi.nwtis.ppletes.konfiguracije.Konfiguracija;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import org.foi.nwtis.ppletes.web.podaci.AirportDAO;
import org.foi.nwtis.ppletes.web.podaci.Baza;
import org.foi.nwtis.ppletes.web.podaci.Myairports;
import org.foi.nwtis.rest.klijenti.OSKlijent;
import org.foi.nwtis.rest.podaci.AvionLeti;

/**
 *
 * @author Paula
 */
public class PreuzimanjeLetovaAvionaAerodroma extends Thread {

    //potrebne varijable i atributi
    private final BP_Konfiguracija bpk;
    Konfiguracija konfiguracija;
    int intervalCiklusa = 100 * 1000;
    Boolean preuzimanjeStatus;
    String username;
    String password;
    OSKlijent oSKlijent;
    int inicijalniPocetakIntervala;
    String pocetniDatum;
    String krajDatum;
    Long pocetniInterval;
    Long sljedeceInterval;
    int pauzaDretve;
    int trajanjeCiklusaDretve;
    AirportDAO airportDAO;

    public PreuzimanjeLetovaAvionaAerodroma(BP_Konfiguracija bpk) {
        this.bpk = bpk;
    }

    @Override
    public void interrupt() {
        super.interrupt(); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public synchronized void start() {
        konfiguracija = (Konfiguracija) bpk.getKonfig();
        username = konfiguracija.dajPostavku("OpenSkyNetwork.korisnik");
        password = konfiguracija.dajPostavku("OpenSkyNetwork.lozinka");
        oSKlijent = new OSKlijent(username, password);
        //TODO preuzimanje podataka iz konfiguracije  i pridruzi ih atributima
        pauzaDretve = Integer.parseInt(konfiguracija.dajPostavku("preuzimanje.pauza"));
        trajanjeCiklusaDretve = Integer.parseInt(konfiguracija.dajPostavku("preuzimanje.ciklus"));
        pocetniDatum = konfiguracija.dajPostavku("preuzimanje.pocetak");
        preuzimanjeStatus = Boolean.parseBoolean(konfiguracija.dajPostavku("preuzimanje.status"));
        krajDatum = konfiguracija.dajPostavku("preuzimanje.kraj");
        pretvoriDatumUMilisekunde();
        super.start(); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public void run() {
        int brojac = 0;
        while (preuzimanjeStatus) {
            System.out.println("Brojac: " + brojac++);

            try {
                Baza baza = new Baza();
                AirportDAO airportDAO = new AirportDAO();
                List<Myairports> aerodromi = baza.dajMoooje(bpk);
                java.util.Date myDate = new java.util.Date(pocetniInterval);
                java.sql.Date sqlDate = new java.sql.Date(myDate.getTime());
                for (Myairports aerodrom : aerodromi) {
                    if (!airportDAO.provjeriAerodromULog(bpk,aerodrom.getIdent(), sqlDate)) {
                        List<AvionLeti> avioni = oSKlijent.getDepartures(aerodrom.getIdent(), pocetniInterval/1000, sljedeceInterval/1000);
//                        List<AvionLeti> avioni = oSKlijent.getDepartures("EDDF", 1588521744, 1588694544);
                        airportDAO.spremiAvione(bpk,avioni);
                        airportDAO.spremiAerodromULog(bpk,aerodrom.getIdent(), sqlDate,avioni.size());
                        Thread.sleep(pauzaDretve* 1000);
                    }
                }

                pocetniInterval = sljedeceInterval;
                sljedeceInterval = pocetniInterval + (24 * 60 * trajanjeCiklusaDretve * 1000);
                if (provjeriTrenutniDatum(pocetniInterval)) {
                    Thread.sleep(24 * 60 * 60 * 1000);
                }

                //TODO üreuzimanje aerodroma i avione od aerodroma za pojedini dan 
            } catch (InterruptedException ex) {
                Logger.getLogger(PreuzimanjeLetovaAvionaAerodroma.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    public void pretvoriDatumUMilisekunde() {
        SimpleDateFormat df = new SimpleDateFormat("dd.MM.yyyy");
        Date datum;
        try {
            datum = df.parse(pocetniDatum);
            pocetniInterval = datum.getTime();
            sljedeceInterval = pocetniInterval + (24 * 60 * trajanjeCiklusaDretve * 1000);
        } catch (ParseException ex) {
            Logger.getLogger(PreuzimanjeLetovaAvionaAerodroma.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public boolean provjeriTrenutniDatum(long datPocetni) {
        SimpleDateFormat fmt = new SimpleDateFormat("dd.MM.yyyy");
        Date trenutniDatum = new Date();
        Date datumOdDretva = new Date(datPocetni);
        return fmt.format(trenutniDatum).equals(fmt.format(datumOdDretva));
    }
}
