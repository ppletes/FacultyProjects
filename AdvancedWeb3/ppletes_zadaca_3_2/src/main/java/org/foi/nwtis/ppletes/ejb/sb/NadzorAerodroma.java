package org.foi.nwtis.ppletes.ejb.sb;

import java.io.IOException;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.List;
import java.util.Queue;
import java.util.Random;
import java.util.concurrent.ConcurrentLinkedQueue;
import javax.ejb.EJB;
import javax.websocket.OnClose;
import javax.websocket.OnError;
import javax.websocket.OnMessage;
import javax.websocket.OnOpen;
import javax.websocket.Session;
import javax.websocket.server.ServerEndpoint;
import org.foi.nwtis.ppletes.ejb.eb.Airports;
import org.foi.nwtis.ppletes.ejb.eb.Korisnici;
import org.foi.nwtis.ppletes.ejb.eb.Myairports;

/**
 *
 * @author Paula
 */
@ServerEndpoint("/aerodromi")
public class NadzorAerodroma {

    static Queue<Session> queue = new ConcurrentLinkedQueue<>();

    List<Myairports> lista = new ArrayList<>();

    @EJB
    KorisniciFacadeLocal kfl;

    @EJB
    AirportsFacadeLocal afl;

    @EJB
    MyairportsFacadeLocal mfl;

    /**
     *
     * @param brojAerodroma
     *
     * vraca broj aerdoroma u preuzimanju
     */
    public static void send(int brojAerodroma) {
        String msg = String.format("%d", brojAerodroma);
        System.out.println("WS: " + msg + " broj aerodroma: " + queue.size());
        try {
            for (Session session : queue) {
                session.getBasicRemote().sendText(msg);
            }
        } catch (IOException ex) {
            System.out.println(ex.getMessage());
        }
    }

    /**
     *
     * @param message
     *
     * prima poruku od klijenta, radi split da bi iz poruke server dobio ident i
     * username i onda pohranjuje u myairports tablicu
     */
    @OnMessage
    public void onMessage(String message) {
        for (Session s : queue) {
            if (s.isOpen()) {
                System.out.println(message);
                String[] split = message.split(",");
                String ident = split[0];
                String username = split[1];
                Airports findA = afl.find(ident);
                Korisnici findK = kfl.find(username);
                java.sql.Date timestamp = new java.sql.Date(System.currentTimeMillis());
                Myairports myairports = new Myairports();
                myairports.setIdent(findA);
                myairports.setUsername(findK);
                myairports.setStored(timestamp);
                mfl.create(myairports);
                
                send(mfl.findAll().size());
                System.out.println(mfl.findAll().size());
            }
        }
    }

    /**
     *
     * @param session
     *
     * otvorena veza
     */
    @OnOpen
    public void openConnection(Session session) {
        queue.add(session);
        System.out.println("Otvorena veza.");
        send(mfl.findAll().size());
    }

    /**
     *
     * @param session
     *
     * zatvorena veza
     */
    @OnClose
    public void closedConnection(Session session) {
        queue.remove(session);
        System.out.println("Zatvorena veza.");
    }

    /**
     *
     * @param session
     * @param t
     *
     * zatvaranje kod pogreske
     */
    @OnError
    public void error(Session session, Throwable t) {
        queue.remove(session);
        System.out.println("Zatvorena veza.");
    }
}
