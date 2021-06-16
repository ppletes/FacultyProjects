package org.foi.nwtis.ppletes.web.slusaci;

import java.io.File;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletContext;
import javax.servlet.ServletContextEvent;
import javax.servlet.ServletContextListener;
import javax.servlet.annotation.WebListener;
import org.foi.nwtis.ppletes.konfiguracije.NeispravnaKonfiguracija;
import org.foi.nwtis.ppletes.konfiguracije.NemaKonfiguracije;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;

/**
 *
 * @author Paula
 */
@WebListener
public class SlusacAplikacije implements ServletContextListener {

    /**
     *
     * @param sce
     */
    @Override
    public void contextInitialized(ServletContextEvent sce) {
        ServletContext sc = sce.getServletContext();
        String datoteke = sc.getInitParameter("konfiguracija");
        String putanja = sc.getRealPath("WEB-INF") + File.separator + datoteke;
        try {
            BP_Konfiguracija konf = new BP_Konfiguracija(putanja);
            sc.setAttribute("BP_Konfig", konf);

        } catch (NemaKonfiguracije | NeispravnaKonfiguracija ex) {
            Logger.getLogger(SlusacAplikacije.class.getName()).log(Level.SEVERE, null, ex);
        }

        System.out.println("Aplikacija je pokrenuta!");
    }

    /**
     *
     * @param sce
     */
    @Override
    public void contextDestroyed(ServletContextEvent sce) {
        System.out.println("Aplikacija je zaustavljana!");
    }
}
