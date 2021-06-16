package org.foi.nwtis.ppletes.web.podaci;

import java.sql.Date;
import java.sql.Timestamp;
import lombok.Getter;
import lombok.Setter;

/**
 *
 * @author Paula
 */
public class MyAirportsLog {

    @Getter
    @Setter
    private String ident;
    @Getter
    @Setter
    private Date flightDate;
    @Getter
    @Setter
    private Timestamp stored;
    @Getter
    @Setter
    private int broj;

    public MyAirportsLog() {
    }

    /**
     *
     * @param ident
     * @param flightDate
     * @param stored
     */
    public MyAirportsLog(String ident, int broj) {
        this.ident = ident;
        this.broj = broj;
    }

    MyAirportsLog(String ident) {
        this.ident = ident;
    }
}
