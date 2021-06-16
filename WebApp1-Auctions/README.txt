WebApp1 - AUKCIJE

Jezik: HTML, CSS, PHP, JavaScript


Uloge: administrator, moderator, registrirani korisnik i anonimni/neprijavljeni korisnici..

Sustav služi za kreiranje i održavanje aukcija. Sustav mora imati mogućnost prijave i odjave korisnika sa sustava. 

U sustavu postoji jedan ugrađeni administrator (korisničko ime: admin, lozinka: foi). Administrator je prijavljeni korisnik koji ima vrstu jednaku nula.

Anonimni/neregistrirani korisnik može vidjeti popis otvorenih aukcija sa nazivom, opisom, ukupnom količinom predmeta na aukciji te datum i vrijeme završetka aukcije sortirano padajuće po datumu i vremenu završetka aukcije. Odabirom otvorene aukcije vidi ograničene detalje o predmetima (naziv, slika, iznos trenutne ponude).

Registrirani korisnik uz svoje funkcionalnosti ima i sve funkcionalnosti kao i neprijavljeni korisnik. Registrirani korisnik može definirati novi predmet (time postaje prodavač) za neku otvorenu aukciju uz unos sljedećih podataka za predmet: naziv, opis, URL do slike na Webu i početnu cijenu u HRK. Ukoliko želi dati ponudu za predmet (time postaje kupac) na otvorenoj aukciji mora predložiti cijenu u HRK koja treba biti veća od početne pri čemu sustav automatski unosi trenutni datum i vrijeme ponude. Prilikom prijave vidi stanja svojih ponuda na otvorenim aukcijama. Također vidi popis svih zatvorenih aukcija na kojima je sudjelovao kao prodavač zajedno sa informacijom o dobitniku i konačnoj cijeni (najveći iznos ponude).

Moderator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i registrirani korisnik te može, pregledavati i zatvoriti dodijeljene aukcije. Nakon prijave vidi popis aukcija sortirano po datumu i vremenu početka aukcije. Unosi i ažurira datum i vrijeme završetka aukcije nakon čega aukcije mogu početi. Odabirom aukcije može vidjeti najveću ponudu po pojedinom predmetu. Prilikom zatvaranja aukcije prihvaćaju se najveće ponude po predmetima te ukoliko je više istih najvećih ponuda odabire se ona koja je prva ponuđena.

Administrator uz svoje funkcionalnosti ima i sve funkcionalnosti kao i moderator. Administrator unosi, ažurira i pregledava korisnike sustava. Unosi, ažurira i pregledava aukcije (npr. automobili, mobiteli, …) te bira moderatora za pojedine aukcije između korisnika koji imaju tip moderator. Jedan moderator može biti zadužen za više aukcija. Administrator kod unosa aukcije mora unijeti naziv, opis i datum i vrijeme početka. Može vidjeti broj prodavača i kupaca po pojedinoj završenoj aukciji unutar odabranog vremenskog intervala na temelju datuma i vremena početka aukcije.

Napomena: Svi datumi moraju se unositi od strane korisnika u formatu „dd.mm.gggg“ a vrijeme u obliku „hh:mm:ss“ ne koristeći date i time HTML tip za input element.
