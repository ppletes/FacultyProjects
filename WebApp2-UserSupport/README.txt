WebApp2 - KORISNIČKA PODRŠKA

Jezik: HTML, CSS, PHP, JavaScript


Uloge: administrator, moderator, registrirani korisnik i anonimni/neprijavljeni korisnici..

Sustav omogućuje komunikaciju korisnika preko Web stranice. Sustav mora imati mogućnost prijave i odjave korisnika sa sustava. U sustavu postoji jedan ugrađeni administrator (korisničko ime: admin, lozinka: foi). Administrator je prijavljeni korisnik koji ima vrstu jednaku jedan. 

Anonimni/neregistrirani korisnik može vidjeti popis tvrtki i odabirom tvrtke vide naslove postojećih pitanja sa statusom (ima ili nema odgovor) sortirano silazno po datumu i vremenu. Može postaviti novo pitanje na način da prvo odabire tvrtku te unosi naslov pitanja, tekst pitanja, URL do neke slike na Webu, te opcionalno URL do nekog videa na Webu a datum i vrijeme pitanja se automatski upisuje u tablicu.

Registrirani korisnik uz svoje funkcionalnosti ima i sve funkcionalnosti kao i neprijavljeni korisnik. Vidi popis pitanja za svoju tvrtku, a u zaglavlju stranice vidi broj preostalih odgovora za tvrtku. Odabirom pitanja prikazuje se tekst pitanja, datum i vrijeme postavljanja, slike i video ako je priložen. Može dati odgovor na pitanje ako ima slobodnog mjesta za odgovore. U odgovoru na postavljeno pitanje upisuje tekst odgovora dok se datum i vrijeme odgovora automatski upisuje u tablicu. Nakon upisa odgovora smanjuje se u tablici tvrtka broj preostalih odgovora za 1. Na jedno pitanje jedan korisnik može dati samo jedan odgovor. Kod popisa naslova pitanja za odabranu tvrtku ima mogućnost odabira pitanja. Odabirom pitanja dobije sve informacije o pitanju i njegovom odgovoru.

Moderator uz svoje funkcionalnosti ima sve funkcionalnosti kao i registrirani korisnik te uz to unositi i pregledati zaposlenike svoje tvrtke. Unos novog zaposlenika (dozvoljen je samo ako ima slobodnog mjesta za zaposlenje) obavlja se odabirom iz popisa korisnika koji još nisu zaposlenici u drugim tvrtkama i nisu moderatori. Vidi popis pitanja svoje tvrtke i u kojem su trenutnom statusu. Za svoju tvrtku može poslati zahtjev za pravo na dodatnih 10 odgovora (što se evidentira u tablici tvrtka za stupac zahtjev kao vrijednost 1) ukoliko nema prethodnog zahtjeva koji čeka na odobrenje (u tablici tvrtka stupac zahtjev vrijednost 0). Može vidjeti statistiku broja odgovora po zaposleniku svoje tvrtke za odabrano vremensko razdoblje davanja pitanja. Razdoblje se definira s datumom i vremenom od i do.

Administrator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i moderator. Unosi, ažurira i pregledava korisnike sustava te definira i ažurira njihove tipove. Unosi, pregledava i ažurira tvrtke (npr. Styria, NTH, Diverto, ...) i bira moderatora za pojedinu tvrtku između korisnika koji imaju tip moderator. Jedan moderator može biti zadužen samo za jednu tvrtku. Kod unosa tvrtke mora unijeti naziv, opcionalno opis i broj zaposlenika tvrtke te iste može ažurirati. Inicijalno stupci zahtjev i preostali odgovori imaju vrijednost 0. Vidi popis tvrtki za koje postoji zahtjev za povećanjem broja pitanja. Zahtjev se odobrava tako da se u tablici tvrtka stupac zahtjev postavi na 0, a stupac preostaliOdgovori se poveća za 10. Može vidjeti statistiku broja pitanja i broja odgovora po tvrtkama. Može vidjeti rang listu zaposlenika (i iz koje je tvrtke) koji su dali najviše odgovra.

Napomena: Svi datumi moraju se unositi od strane korisnika u formatu „dd.mm.gggg“ a vrijeme u obliku „hh:mm:ss“ ne koristeći date i time HTML tip za input element.
