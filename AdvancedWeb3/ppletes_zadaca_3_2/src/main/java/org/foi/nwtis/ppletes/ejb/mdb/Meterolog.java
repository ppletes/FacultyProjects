package org.foi.nwtis.ppletes.ejb.mdb;

import javax.ejb.LocalBean;
import javax.ejb.Stateless;
import javax.inject.Inject;
import javax.servlet.ServletContext;
import org.foi.nwtis.ppletes.ejb.eb.Airports;
import org.foi.nwtis.ppletes.ejb.sb.AbstractFacade;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;
import org.foi.nwtis.rest.klijenti.OWMKlijent;
import org.foi.nwtis.rest.podaci.MeteoPodaci;

/**
 *
 * @author Paula
 */
@Stateless
@LocalBean
public class Meterolog implements MeterologLocal {

    // Add business logic below. (Right-click in editor and choose
    // "Insert Code > Add Business Method")
    @Inject
    ServletContext context;

    /**
     *
     * @param coordinates
     * @return
     * 
     * vraca podatke tipa Meteopodaci kojima se u ppletes_3_3 klasi AktivnostDva
     * dohvacaju podaci za temperaturu i vlagu 
     * 
     * prima parametar coorinates koji se splitom podijeli na latitude i longitude
     */
    @Override
    public MeteoPodaci dajPodatke(String coordinates) {
        BP_Konfiguracija bpk = (BP_Konfiguracija) context.getAttribute("BP_Konfig");
        String apikey = bpk.getKonfig().dajPostavku("OpenWeatherMap.apikey");

        String[] split = coordinates.split(", ");
        String lat = split[0];
        String lon = split[1];

        OWMKlijent oWMKlijent = new OWMKlijent(apikey);
        try {
            MeteoPodaci metoPodaci = oWMKlijent.getRealTimeWeather(lat, lon);
            return metoPodaci;
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return null;
    }
}
