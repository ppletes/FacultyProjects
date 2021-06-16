package org.foi.nwtis.ppletes.web.podaci;

import java.sql.Timestamp;
import lombok.Getter;
import lombok.Setter;
import org.foi.nwtis.podaci.Airport;

/**
 *
 * @author Paula
 */
public class Airplanes {

    @Getter
    @Setter
    private String icao24;
    @Getter
    @Setter
    private int firstSeen;
    @Getter
    @Setter
    private String estDepartureAirport;
    @Getter
    @Setter
    private int lastSeen;
    @Getter
    @Setter
    private String estArrivalAirport;
    @Getter
    @Setter
    private String callsign;
    @Getter
    @Setter
    private int estDepartureAirportHorizDistance;
    @Getter
    @Setter
    private int estDepartureAirportVertDistance;
    @Getter
    @Setter
    private int estArrivalAirportHorizDistance;
    @Getter
    @Setter
    private int estArrivalAirportVertDistance;
    @Getter
    @Setter
    private int departureAirportCandidatesCount;
    @Getter
    @Setter
    private int arrivalAirportCandidatesCount;
    @Getter
    @Setter
    private String stored;

    /**
     * Sluzi za dohvaćanje i postavljanje podataka o avionima
     */
    public Airplanes() {
    }

    /**
     *
     * @param icao24
     * @param firstSeen
     * @param estDepartureAirport
     * @param lastSeen
     * @param estArrivalAirport
     * @param callsign
     * @param estDepartureAirportHorizDistance
     * @param estDepartureAirportVertDistance
     * @param estArrivalAirportHorizDistance
     * @param estArrivalAirportVertDistance
     * @param departureAirportCandidatesCount
     * @param arrivalAirportCandidatesCount
     * @param stored
     */
    public Airplanes(String icao24, int firstSeen, String estDepartureAirport, int lastSeen, String estArrivalAirport, String callsign, int estDepartureAirportHorizDistance, int estDepartureAirportVertDistance, int estArrivalAirportHorizDistance, int estArrivalAirportVertDistance, int departureAirportCandidatesCount, int arrivalAirportCandidatesCount) {
        this.icao24 = icao24;
        this.firstSeen = firstSeen;
        this.estDepartureAirport = estDepartureAirport;
        this.lastSeen = lastSeen;
        this.estArrivalAirport = estArrivalAirport;
        this.callsign = callsign;
        this.estDepartureAirportHorizDistance = estDepartureAirportHorizDistance;
        this.estDepartureAirportVertDistance = estDepartureAirportVertDistance;
        this.estArrivalAirportHorizDistance = estArrivalAirportHorizDistance;
        this.estArrivalAirportVertDistance = estArrivalAirportVertDistance;
        this.departureAirportCandidatesCount = departureAirportCandidatesCount;
        this.arrivalAirportCandidatesCount = arrivalAirportCandidatesCount;
    }

    Airplanes(String icao24, int firstSeen, String estDepartureAirport, String estArrivalAirport, int lastSeen, String callsign, int estDepartureAirportHorizDistance,
            int estDepartureAirportVertDistance, int estArrivalAirportHorizDistance, int estArrivalAirportVertDistance,
            int departureAirportCandidatesCount, int arrivalAirportCandidatesCount) {
        this.icao24 = icao24;
        this.firstSeen = firstSeen;
        this.estDepartureAirport = estDepartureAirport;
        this.lastSeen = lastSeen;
        this.estArrivalAirport = estArrivalAirport;
        this.callsign = callsign;
        this.estDepartureAirportHorizDistance = estDepartureAirportHorizDistance;
        this.estDepartureAirportVertDistance = estDepartureAirportVertDistance;
        this.estArrivalAirportHorizDistance = estArrivalAirportHorizDistance;
        this.estArrivalAirportVertDistance = estArrivalAirportVertDistance;
        this.departureAirportCandidatesCount = departureAirportCandidatesCount;
        this.arrivalAirportCandidatesCount = arrivalAirportCandidatesCount;
    }
}
