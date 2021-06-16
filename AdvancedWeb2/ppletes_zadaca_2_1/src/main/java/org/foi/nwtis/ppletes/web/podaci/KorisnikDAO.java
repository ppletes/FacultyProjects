package org.foi.nwtis.ppletes.web.podaci;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.foi.nwtis.podaci.Korisnik;
import org.foi.nwtis.ppletes.konfiguracije.bp.BP_Konfiguracija;

/**
 *
 * @author Paula
 */
public class KorisnikDAO {

    /**
     * Dohvaća sve korisnike s obzirom na parametre korisnickog imena i lozinke
     *
     * @param korisnik
     * @param lozinka
     * @param prijava
     * @param bpk
     * @return
     */
    public Korisnik dohvatiKorisnika(String korisnik, String lozinka, Boolean prijava, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT IME, PREZIME, EMAIL_ADRESA, KOR_IME, LOZINKA FROM korisnici WHERE " + "KOR_IME = '" + korisnik + "'";

        if (prijava) {
            upit += " and LOZINKA = '" + lozinka + "'";
        }

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                while (rs.next()) {
                    String korisnik1 = rs.getString("kor_ime");
                    String ime = rs.getString("ime");
                    String prezime = rs.getString("prezime");
                    String email = rs.getString("email_adresa");
                    Timestamp kreiran = rs.getTimestamp("datum_kreiranja");
                    Timestamp promjena = rs.getTimestamp("datum_promjene");
                    Korisnik k = new Korisnik(korisnik1, ime, prezime, "******", email, kreiran, promjena);
                    return k;
                }

            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    /**
     * azurira korisnicke podatke s obzirom na uneseno korisnicko ime i lozinku
     *
     * @param k
     * @param lozinka
     * @param bpk
     * @return
     */
    public boolean azurirajKorisnika(Korisnik k, String lozinka, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "UPDATE korisnici SET IME = '" + k.getIme() + "', PREZIME = '" + k.getPrezime() + "', EMAIL_ADRESA = '" + k.getEmailAdresa() + "', LOZINKA = '" + lozinka + "' WHERE " + "KOR_IME = '" + k.getKorIme() + "'";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                int brojAzuriranja = s.executeUpdate(upit);

                return brojAzuriranja == 1;

            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    /**
     * azurira korisnicke podatke s obzirom na korisnicko ime
     *
     * @param korisnik
     * @param k
     * @param lozinka
     * @param bpk
     * @return
     */
    public boolean azurirajKorisnika2(String korisnik, Korisnik k, String lozinka, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "UPDATE korisnici SET IME = '" + k.getIme() + "', PREZIME = '" + k.getPrezime() + "', KOR_IME = '" + k.getKorIme() + "', EMAIL_ADRESA = '" + k.getEmailAdresa() + "', LOZINKA = '" + k.getLozinka() + "', DATUM_PROMJENE = CURRENT_TIMESTAMP" + " WHERE " + "KOR_IME = '" + korisnik + "'";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                int brojAzuriranja = s.executeUpdate(upit);

                return brojAzuriranja == 1;

            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    /**
     * dodaje novog korisnika u tablicu korisnici
     *
     * @param k
     * @param bpk
     * @return
     */
    public boolean dodajKorisnika(Korisnik k, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "INSERT INTO korisnici (IME, PREZIME, EMAIL_ADRESA, KOR_IME, LOZINKA, DATUM_KREIRANJA, DATUM_PROMJENE) VALUES (" + "'" + k.getIme() + "', '" + k.getPrezime() + "', '" + k.getEmailAdresa() + "', '" + k.getKorIme() + "', '" + k.getLozinka() + "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement()) {

                int brojAzuriranja = s.executeUpdate(upit);

                return brojAzuriranja == 1;

            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return false;
    }

    /**
     * dohvaća podatke o korisniku s obzirom na unesene parametre korisnicko ime
     * i lozinka
     *
     * @param korisnik
     * @param lozinka
     * @param bpk
     * @return
     */
    public List<Korisnik> dohvatiKorisnikaLista(String korisnik, String lozinka, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT IME, PREZIME, EMAIL_ADRESA, KOR_IME, LOZINKA, datum_kreiranja, datum_promjene FROM korisnici WHERE " + "KOR_IME = '" + korisnik + "' and LOZINKA = '" + lozinka + "'";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Korisnik> korisnici = new ArrayList<>();

                while (rs.next()) {
                    String korisnik1 = rs.getString("kor_ime");
                    String ime = rs.getString("ime");
                    String prezime = rs.getString("prezime");
                    String email = rs.getString("email_adresa");
                    Timestamp kreiran = rs.getTimestamp("datum_kreiranja");
                    Timestamp promjena = rs.getTimestamp("datum_promjene");
                    Korisnik k = new Korisnik(korisnik1, ime, prezime, "******", email, kreiran, promjena);
                    korisnici.add(k);

                }
                return korisnici;
            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    /**
     * vraća listu svih korisnika
     *
     * @param korisnik
     * @param lozinka
     * @param bpk
     * @return
     */
    public List<Korisnik> dohvatiSveKorisnikeLista(String korisnik, String lozinka, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT IME, PREZIME, EMAIL_ADRESA, KOR_IME, LOZINKA, datum_kreiranja, datum_promjene FROM korisnici";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Korisnik> korisnici = new ArrayList<>();

                while (rs.next()) {
                    String korisnik1 = rs.getString("kor_ime");
                    String ime = rs.getString("ime");
                    String prezime = rs.getString("prezime");
                    String email = rs.getString("email_adresa");
                    Timestamp kreiran = rs.getTimestamp("datum_kreiranja");
                    Timestamp promjena = rs.getTimestamp("datum_promjene");
                    Korisnik k = new Korisnik(korisnik1, ime, prezime, "******", email, kreiran, promjena);
                    korisnici.add(k);

                }
                return korisnici;
            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }

    /**
     * vraća korisnike iz tablice myairports
     *
     * @param korisnik
     * @param lozinka
     * @param bpk
     * @return
     */
    public List<Korisnik> dohvatiKorisnikeAerodroma(String korisnik, String lozinka, BP_Konfiguracija bpk) {
        String url = bpk.getServerDatabase() + bpk.getUserDatabase();
        String bpkorisnik = bpk.getUserUsername();
        String bplozinka = bpk.getUserPassword();
        String upit = "SELECT DISTINCT korisnici.kor_ime, korisnici.ime, korisnici.prezime, korisnici.lozinka, "
                + "korisnici.email_adresa, korisnici.datum_kreiranja, korisnici.datum_promjene, "
                + "myairports.username FROM korisnici "
                + "INNER JOIN myairports ON myairports.username = korisnici.kor_ime";

        try {
            Class.forName(bpk.getDriverDatabase(url));

            try (
                    Connection con = DriverManager.getConnection(url, bpkorisnik, bplozinka);
                    Statement s = con.createStatement();
                    ResultSet rs = s.executeQuery(upit)) {

                List<Korisnik> korisnici = new ArrayList<>();

                while (rs.next()) {
                    String korisnik1 = rs.getString("kor_ime");
                    String ime = rs.getString("ime");
                    String prezime = rs.getString("prezime");
                    String email = rs.getString("email_adresa");
                    Timestamp kreiran = rs.getTimestamp("datum_kreiranja");
                    Timestamp promjena = rs.getTimestamp("datum_promjene");
                    Korisnik k = new Korisnik(korisnik1, ime, prezime, "******", email, kreiran, promjena);
                    korisnici.add(k);

                }
                return korisnici;
            } catch (SQLException ex) {
                Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
            }
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(KorisnikDAO.class.getName()).log(Level.SEVERE, null, ex);
        }
        return null;
    }
}
