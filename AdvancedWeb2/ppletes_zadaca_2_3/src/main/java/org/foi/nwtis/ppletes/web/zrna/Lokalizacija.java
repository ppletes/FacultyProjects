package org.foi.nwtis.ppletes.web.zrna;

import javax.inject.Named;
import javax.enterprise.context.SessionScoped;
import java.io.Serializable;
import java.util.Locale;
import javax.faces.context.FacesContext;
import javax.inject.Inject;
import lombok.Getter;
import lombok.Setter;

/**
 * sluzi za prijevod stranice, default jezik je hrvatski
 *
 * @author Paula
 */
@Named(value = "lokalizacija")
@SessionScoped
public class Lokalizacija implements Serializable {

    @Getter
    @Setter
    private String jezik = "hr";

    @Inject
    private FacesContext facesContext;

    public Lokalizacija() {
    }

    public Object odaberiJezik() {
        facesContext.getViewRoot().setLocale(new Locale(jezik));
        return "";
    }

}
