package org.foi.nwtis.ppletes.web.podaci;

import java.util.Date;
import lombok.Getter;
import lombok.Setter;

/**
 *
 * @author Paula
 */
public class Myairports{

    @Getter
    @Setter
    private String ident;
    @Getter
    @Setter
    private String username;
    @Getter
    @Setter
    private String stored;

    public Myairports() {
    }

    /**
     *
     * @param ident
     * @param flightDate
     * @param stored
     */
    public Myairports(String ident, String username, String stored) {
        this.ident = ident;
        this.username = username;
        this.stored = stored;
    }
}