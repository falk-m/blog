# ePA

- Patientengeführte Akte
  - Nutzer kann selbst Dokumente einstellen oder löschen
- Nutzt Standards
  - SOAP Services
  - SAML 2.0
  - TLS

## Komponents

- Aktensystem
  - Ausbewahrung der Akten
- Autorisierungskomponente
  - Aufbeharung des Schlüsselmaterial
- Authentisierungs
  - Nutzeridentifikation
- SGD - Schlüsselgenerierungsdienste
  - Bereitstellung von Ableitungsschlüssel
- FdV - Frontend des Versicherten
  - App, Client

Komponenten wie Gateway, etc. sind zur Erklärung der Funktionsweise in diesem Kokument nicht relevant



---------------------------------------------------------------------------------------------------------

- verschlüsselung
  - Das Dokument wird mit einem für das Dokument spezifischen symmetrischen Dokumentenschlüssel (DocumentKey) verschlüsselt.
  - Der DocumentKey wird mit einem für die Versichertenakte spezifischen symmetrischen Aktenschlüssel (RecordKey) verschlüsselt.
  - Der RecordKey wird mittels Schlüsselableitung gemäß [gemSpec_SGD_ePA] verschlüsselt.



## Akten verschlüsselung

Aktenschlüssel
  Symmetrischer Schlüssel, der alle Dokumente eines
  Versicherten schützt, indem der Aktenschlüssel die zu den
  Dokumenten gehörigen Dokumentenschlüssel verschlüsselt.
Kontextschlüssel
  Symmetrischer Schlüssel mit dem Metadaten der Dokumente,
  Policy Documents für die Zugriffssteuerung und das
  Zugriffsprotokoll für die persistente Speicherung im ePA-
  Aktensystem verschlüsselt werden.
AuthorizationKey
  doppelt verschlüsselter Akten und-kontext schlüssel
  mit AD daten zu SGD1 und 2 Vektoren
  zusammen abgelegt in Komponente Authorierierung

Für die Verschlüsselung eines Dokumentes wird ein dokumentenindividueller
symmetrischer Dokumentenschlüssel verwendet. Dieser wird mit einem
versichertenindividuellen Aktenschlüssel verschlüsselt. Der Aktenschlüssel wird mit
nutzerindividuellen Schlüsseln des SGD1 und SGD2 verschlüsselt und anschließend in der
Komponente Autorisierung abgelegt. Nutzer sind berechtigte LEI, Kassen und Vertreter
des Versicherten.
Die mit dem Dokumentenschlüssel gesicherten Dokumente und die mit dem
Aktenschlüssel verschlüsselten Dokumentenschlüssel werden mit einem aus einem
betreiberspezifischen Schlüssel abgeleiteten aktenspezifischen Schlüssel nochmals
verschlüsselt und anschließend im Aktensystem abgelegt.
Die Metadaten werden mit dem versichertenindividuellen Kontextschlüssel verschlüsselt.
Die verschlüsselten Metadaten werden nochmals mit dem aus dem betreiberspezifischen
Schlüssel abgeleiteten aktenspezifischen Schlüssel verschlüsselt und im Aktensystem
abgelegt. Die Kontextschlüssel werden mit den nutzerindividuellen Schlüsseln des
Schlüsselgenerierungsdienstes 1 und 2 (SGD1 und SGD2) s

## Frontend FdV

- Gerät muss über separaten Benachrichtigungskanal autorisiert werden
- Dokumente bis 25MB
- Kein Ausführen von aktiven Inhalten bei der Anzeige
- Policies auslisten, setzen, ändern, schlüsselmaterial erzeugen

### Login

Für die Anmeldung des Nutzers mit seiner eGK wird eine 2-Faktor-Authentisierung (eGK
+ PIN) verwendet. Als weitere Möglichkeit kann die alternative
kryptographische Versichertenidentität genutzt werden. Nach erfolgreicher
Authentisierung inklusive Gültigkeitsprüfung der eGK und Autorisierung wird das
empfängerverschlüsselte Schlüsselmaterial heruntergeladen und das Öffnen des
Aktenkontextes in der Komponente "Dokumentenverwaltung" für das referenzierte
Aktenkonto durchgeführt.

## Authentisierung

- login (LoginCreateChallenge, LoginCreateToken)
  C fordert S auf, einen Authentisierungs-Token zu erstellen.
  • S antwortet C mit der Aufforderung (Challenge), eine Zufallszahl zu signieren, um
  sicherzustellen, dass die nachfolgende Authentisierungsnachricht frisch erzeugt
  wird.
  • C antwortet auf die Challenge mit seinem Zertifikat und mit einer Signatur für die Zufallszahl aus der
  Challenge. Die Signatur erzeugt er mittels der Authentisierungsidentität
  ID.CH.AUT der eGK oder der alternativen Versichertenidentität ID.CH.AUT_ALT.
  • S authentifiziert C durch Prüfung der Signatur.
  S stellt eine Authentifizierungsbestätigung aus und sendet sie an C.

- Authentisierungs-Token ist SAML Token mit 5 minuten gültigkeit
- renew: gibt neuen Authentisierungs-Token aus
  - Die Authentifizierungsbestätigung (Token) wird mit einer kurzen Lebensdauer erstellt.
    Innerhalb dieser Lebensdauer kann über die Operation Renew ein neuer Token wieder
    mit einer kurzen Lebensdauer ausgestellt werden. Durch Aufruf der Logout Operation
    wird die Möglichkeit eines erneuten Renew unterbunden. Die Gesamtlebensdauer, über
    die ein Renew erfolgen kann, wird beschränkt.
- nach maximal 120 minuten muss ein neuer login erfolgen
- logout: kein renew mit alten token mehr möglich
  - token wird von whitelist entfernt

### Frage

- nur eine zentrale komonente?

## Fachmodul

- erlaubt das Einstellen, Suchen, Abrufen und Löschen von Dokumenten sowie die Aktualisierung von Metadaten bestehender Dokumente
- Um eine im ePA-Aktensystem eingehende Suchanfrage nach Dokumenten im ePA-Aktensystem trotz verschlüsselter Daten durchführen zu können, wird für jedes Dokument zusätzlich ein Satz an unverschlüsselten Metadaten gespeichert. Dazu gehören das Dokumentenformat (z. B. PDF), der Dokumententyp (z. B. Notfalldatensatz), Erstellungsdatum und -uhrzeit und der Autor des Dokuments.
- Login über Versicherung erzeugt AuthenticationAssertion
- mit hilfe dieser wird an der Komponente  Chiffrat die Akten- und Kontextschlüssel sowie eine Autorisierungsbestätigung (AuthorizationAssertion) zur Kommunikation mit der Dokumentenverwaltung ausgehändigt

## VAU

- Vertrauenswürdige Ausführungsumgebung.
- Geschütze Nutzer-Session individuelle, nicht einsehbare umgebung im Aktensystem
- Nutzer überträgt über verschlüsselten und authentisierten Datenkanal Kontextschlüssel in diese
- in VAU werden Kontext informationen entschlüsselt, zum Beispiel für Suche

## Aktensystem

- Aufbewahrung der verschlüsselten akte
- Die ePA-Dokumentenverwaltung verwaltet verschlüsselte Dokumente: Die Dokumente
selbst sind mit einem dokumentenspezifischen Dokumentenschlüssel verschlüsselt, der
wiederum mit dem Aktenschlüssel verschlüsselt wird und so verpackt dem Dokument
beigelegt wird. Die Dokumentenmetadaten, das Protokoll des Versicherten sowie die
Policy-Dokumente werden zudem über einen Kontextschlüssel gesichert. Akten- und
Kontextschlüssel sind für die gesamte Akte des Versicherten gültig.

- Ein Aktenrepository je Anbieter (Home Community ID)
- Innerhalb dessen hat jeder Nzter seine Akte (Patient ID)
- Innerhalb dessen liegen verschlüsselte Dokumente (Record Identifier)

- beim ersetzten von dokumenten wird altes dokuments als depricated markiert und ist weiterhin vorhande.

### Policy documents

Die Fachanwendung ePA verwendet das APPC-Profil für die Durchsetzung von
Zugriffsregeln (Autorisierung) auf Dokumente. Die Zugriffsregeln werden gemäß APPC in
Policy Documents beschrieben und als technische Dokumente im Aktenkonto des
Versicherten hinterlegt.
Für jeden Versicherten, Vertreter, jede berechtigte Leistungserbringerinstitution (LEI),
den berechtigten Kostenträger (KTR) und den Aktenkontoinhaber wird je ein Policy
Document im Aktenkonto verwaltet.

Bei der Neuvergabe/bearbeitung einer Berechtigung für Vertreter, LEI oder KTR erstellt das ePA-
Frontend des Versicherten ein neues Policy Document und lädt es in das Aktenkonto
hoch.

Die ePA-Dokumentenverwaltung wertet die in den Policy Documents hinterlegten
Zugriffsregeln aus. Es entscheidet unter Berücksichtigung der Dokumentenmetadaten, ob
der anfragende Nutzer den Dokumentenzugriff (bspw. Einstellen von Dokumenten)
durchführen darf oder ob der Dokumentenzugriff ablehnt wird. Das ePA-Frontend des
Versicherten verarbeitet Policy Documents nur intern.

### Dokuemnten Meta Daten
- title
- author
- comments
- creationTime
- languageCode
- mimeType
- size


### Umschlüsselung

Auf eigenen Wunsch kann der Versicherte eine Umschlüsselung seiner Akte anstoßen.
Dabei werden Akten- und Kontextschlüssel ausgetauscht. Die Dokumentenschlüssel
werden nicht gewechselt. Die Aufgabe besteht also darin, die verschlüsselten
Dokumentenschlüssel mit dem alten Aktenschlüssel zu entschlüsseln, mit dem neuen
Aktenschlüssel wieder zu verschlüsseln und das entstandene neue Paket wieder dem
entsprechenden Dokument in der Dokumentenverwaltung zuzuordnen. Da die
Dokumentenverwaltung niemals Zugriff auf den Aktenschlüssel im Klartext bekommt,
muss die Ent- und Verschlüsselung im Client stattfinden.

## Komponente Autorisierung

- aufbewahrung der verschlüsselten schlüssel
Die Komponente Autorisierungsdienst ePA verwaltet das empfängerverschlüsselte
Schlüsselmaterial der Nutzer eines Aktenkontos eines Versicherten
Mit dem Vorhandensein einer kryptografischen Berechtigung ist ein
Nutzer in der Lage, auf den symmetrischen Aktenschlüssel sowie den Kontextschlüssel
zuzugreifen.
- Schlüsselmaterial wird extern erzeugt und kann nur vom versichterten geändert werden

## SGD

- generiert AES-256-Bit-Schlüssel für eine Entität
- Schlüsselableitung auf Grundlage von geheimen SGD-spezifischen Ableitungsschlüsseln (Masterkeys) und Ableitungsvektoren 
- Diese Ableitungsvektoren enthalten konstante Merkmale, entweder die KVNR oder die Telematik-ID
- Deterministisch
- Der geheime Ableitungsschlüssel eines Schlüsselgenerierungsdienstes (SGD) wird regelmäßig neu erzeugt, so dass auch dort eine Schlüsseldiversifizierung vorhanden ist. Alte Ableitungsschlüssel müssen in den SGD weiter vorgehalten werden, solange sie potentiell benötigt werden. In einem späteren Release wird die (regelmäßige) Umschlüsselung einer ePA-Akte spezifikatorisch bearbeitet.
- Random seed fließt in vektor mit ein. Zum Chiffrat wird seed und master key name gespeichert
- zweifach verschlüsselte Chiffrat im "Zwiebelschalenprinzip" mittels AES-GCM
- Wird Dritten Zugriff gegeben, wird Schlüssel für diese abgeholt und Akten und Kontext schlüssel mit diesen verschlüsselt
- Die zwei SGD sind technisch, organisatorisch und wirtschaftlich unabhängig voneinander
- Ein SGD kommt niemals mit dem Akten- und Kontextschlüssel eines Versicherten in Berührung.
- KVNR des Versicherten bleibt auch bei Verlust der eGK nd Neuausstellung gleich
- Die Akten- und Kontextschlüssel dürfen sich unverschlüsselt nur in Clients befinden und nur temporär
- Verwendung von symmetrischen Verschlüsselungsverfahren
- Ableitung erfolt in speziellen Fimware modul. Betreiben kann prozess und darin enthalten geheimen Ableitungsschlüssel nicht einsehen
- Der geheime Ableitungsschlüssel eines Schlüsselgenerierungsdienstes (SGD) wird regelmäßig neu erzeugt, so dass auch dort eine Schlüsseldiversifizierung vorhanden ist
- eleptic curve verfahren verschlüsselt kommunikation zwischen client und Modul.
  - client und SGD-HSM handeln über challenge schlüssel aus um kanal zu sichern
  - So kann Anbieter des SGD die Schlüssel nicht lesen
- Alle anfragen über https 
- verschlüsselte Anfrage von client enthalten immer eine neu generierte Request id (wiederholungsattackern schutz)

### Ablauf
- verschlüsselten und beidseitig authentisierten Datenkanal zwischen Client und SGD-HSM
- GetPublicKey
  - client holt sich von averierter SGD-HSM den ECIES-Schlüssel
    - AUT-Zertifikat des clients wird geprüft und der client prüft signatur den Schlüssels (verwenung von CA-Zertifikaten der TI)
- client erzeugt ECIES-Schlüsselpaar für zukünfitge kommunikation mit SGD-HSM
- GetAuthenticationToken: client sendet AUT-Zertifikat, client-ECIES-Schlüssel mit signatur und für SGD-HSM verschlüsselte Challenge (Zufallswert)
  - SGD-HSM prügt AUT-Zertifikat und signatur des client-ECIES-Schlüssel
  - Authentisierungstoken Hash aus aktuellen Ableitungsschlüssel, client-ECIES-Schlüssel und AUT-Zertifikat
  - sendes verschlüsselte Nachricht mit Challenge, Authentisierungstoken und hash (von AUT-Zertifikat und client-ECIES-Schlüssel) zurück
  - client entschlüsselt nachricht
    - wenn challenge enthalten ist, kam Nachricht von SGD-HSM 
    - prüft hash um sicher zu stellen, dass SGD-HSM auch das vom client gesendete AUT-Zertifikat zur aktuellen anfrage gesehen hat
    - Authentisierungstoken stellt zukünfitg sicher, dass auth token dem ersteller des clinet-ECIES-Schlüssel zuzuordnen ist 
- KeyDerivation
  - client sendet Authentisierungstoken, zufällig gewählte Request-ID und Ableitungsregel
  - SGD-HMS prüft das AUT-Zertifikat, die Client-Signatur des Client-ECIES-Schlüssels
    - entschlüsselt die Nachricht des Client
    - überprüft, ob das Authentisierungstoken konsistent mit dem Client-ECIES-Schlüssel und dem AUT-Zertifikat des Client ist
    - prüft ob client für ableitungsregel berechtigt ist 
    - Das Ergebnis der Ableitung verschlüsselt inkl. Authentisierungstoken, Request-ID und Ableitungsvektor das SGD-HSM für den Client

-SGD-HSM erzeugt mindestens alle 15 Minuten ein neues ECIES-Schlüsselpaar, der dann 30 Minuten gültig ist
-SHA-256-Hashwert
    - 7 KiB Ableitungsschlüssel
- KeyDerivation
  - AES-256(SHA-256(Vector),Ableitungsschlüssel)

### Ableitungsvektoren
- Kontoinhaber/Versicherter: 
  - initial: 
    - Anfrage Ableitungsregel: r1:<KVNR>
    - Rückgabe von SGD: <AES-256-Bit-Schlüssel-in-Hexform> r1:<256-Bit-RND-in-Hexform>:<KVNR>:<aktueller Ableitungsschlüsselbezeichner>
    - RND wert wird bei späteren "umschlüsselungen" genutzt
    - CLient verschlüsselt im Zwiebelschalen prinzip akten und kontext schlüssel
    - Zurück gegebener Vekor wird als "associated data" im Aktensystem zum schlüssel chiffrat gespeichert
  - Schlüsselableitung
    - Anfrage Ableitungsregel: r1:<256-Bit-RND-in-Hexform>:<KVNR>:<aktueller Ableitungsschlüsselbezeichner>
    - Rückgabe: <AES-256-Bit-Schlüssel-in-Hexform> r1:<256-Bit-RND-in-Hexform>:<KVNR>:<aktueller Ableitungsschlüsselbezeichner>
    - client kann im Zwiebelschalen prinzip akten und kontext schlüssel entschlüsseln
- Berechtigungsempfänger
  - Initial:
    - Anfrage: r2:<KVNR-Vertreter oder Telematik-ID>
    - Antwort: <AES-256-Bit-Schlüssel-in-Hexform> r2:<256-Bit-RND-in-Hexform>:<KVNR-Kontoinhaber>:<KVNR-Vertreter oder Telematik-ID>:<aktueller Ableitungsschlüsselbezeichner>
    - Mit beiden erhaltenen Schlüsseln verschlüsselt der Client den Akten- und Kontextschlüssel
    - schiffrat und vektor werden zusammen hinterlegt
  - Schlüsselableitung
    - client holt sich chiffrag und AD-Daten mit den Vektoren darin
    - Anfrage: r2:<256-Bit-RND-in-Hexform>:<KVNR-Kontoinhaber>:<KVNR-Vertreter oder Telematik-ID>:<Ableitungsschlüsselbezeichner>
    - Antwort: <AES-256-Bit-Schlüssel-in-Hexform> r2:<256-Bit-RND-in-Hexform>:<KVNR-Kontoinhaber>:<KVNR-Vertreter oder Telematik-ID>:<Ableitungsschlüsselbezeichner>
- einen durch einen Vertreter berechtigten Berechtigten
  - Analog zu Berechtigten, nit mit zusätzlicher id
  - r3:<256-Bit-RND-in-Hexform>:<KVNR-Kontoinhaber>:<KVNR-Vertreter>:<Telematik-ID>:<aktueller Ableitungsschlüsselbezeichner>

### Meinung
- keine Datenbank notwendig
- mehrere Parteien involviert zur sicherstellung das einzelner Akteur nicht zugriff hat
- Schwachstelle sind Ableitungsschlüssel, welche desshalb sehr gut gesichert sein müssen.