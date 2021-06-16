package org.foi.nwtis.ppletes.rest.serveri;

import java.util.Set;
import javax.ws.rs.core.Application;

/**
 *
 * @author Paula
 */
@javax.ws.rs.ApplicationPath("webresources")
public class ApplicationConfig extends Application {

    @Override
    public Set<Class<?>> getClasses() {
        Set<Class<?>> resources = new java.util.HashSet<>();
        addRestResourceClasses(resources);
        return resources;
    }

    private void addRestResourceClasses(Set<Class<?>> resources) {
        resources.add(org.foi.nwtis.ppletes.rest.serveri.Zadaca2RestAerodromi.class);
        resources.add(org.foi.nwtis.ppletes.rest.serveri.Zadaca2RestDodaj.class);
        resources.add(org.foi.nwtis.ppletes.rest.serveri.Zadaca2RestKorisnik.class);
        resources.add(org.foi.nwtis.ppletes.rest.serveri.Zadaca2RestProvjera.class);
    }

}
