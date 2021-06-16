/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package org.foi.nwtis.ppletes.ws.klijenti;

import org.foi.nwtis.ppletes.ws.serveri.Korisnik;

/**
 *
 * @author Paula
 */
public class Zadaca2_4WS {

    /**
     * dodaje novog korisnika
     *
     * @param noviKorisnik
     * @return
     */
    public Boolean dodajKorisnika(Korisnik noviKorisnik) {
        Boolean korisnik = null;
        try {
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service service = new org.foi.nwtis.ppletes.ws.serveri.Zadaca2_Service();
            org.foi.nwtis.ppletes.ws.serveri.Zadaca2 port = service.getZadaca2Port();

            korisnik = port.dodajKorisnika(noviKorisnik);
        } catch (Exception ex) {
            System.out.println(ex.getMessage());
        }
        return korisnik;
    }

}
