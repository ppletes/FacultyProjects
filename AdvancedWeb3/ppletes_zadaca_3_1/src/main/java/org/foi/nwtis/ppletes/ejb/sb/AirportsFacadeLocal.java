/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package org.foi.nwtis.ppletes.ejb.sb;

import java.util.List;
import javax.ejb.Local;
import org.foi.nwtis.ppletes.ejb.eb.Airports;

/**
 *
 * @author Paula
 */
@Local
public interface AirportsFacadeLocal {

    void create(Airports airports);

    void edit(Airports airports);

    void remove(Airports airports);

    Airports find(Object id);

    List<Airports> findAll();

    List<Airports> findRange(int[] range);

    int count();
    
}
