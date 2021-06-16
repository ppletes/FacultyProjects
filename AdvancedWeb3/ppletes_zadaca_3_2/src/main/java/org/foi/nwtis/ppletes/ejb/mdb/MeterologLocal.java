package org.foi.nwtis.ppletes.ejb.mdb;

import javax.ejb.Local;
import org.foi.nwtis.rest.podaci.MeteoPodaci;

/**
 *
 * @author Paula
 * 
 * dohvaćanje podataka lokalno od Meterolog.java
 */
@Local
public interface MeterologLocal {
    MeteoPodaci dajPodatke(String id);
}
