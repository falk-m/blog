<?php

namespace app;

class Counter
{

    public function __construct(private string $counterDir) {}

    public function count(string $area)
    {

        // Dateiname für den aktuellen Monat (z. B. "counter_2025-02.json")
        $currentMonth = date('Y-m');
        $counterFile = "$this->counterDir/{$area}_{$currentMonth}.json";

        // Aktuelle URL abrufen (ohne Query-Parameter für eine saubere Statistik)
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');

        // Sicherstellen, dass die Datei existiert
        if (!file_exists($counterFile)) {
            file_put_contents($counterFile, json_encode([], JSON_PRETTY_PRINT));
        }

        // Datei mit Sperre öffnen (verhindert gleichzeitigen Zugriff)
        $fp = fopen($counterFile, 'r+');

        if (flock($fp, LOCK_EX)) { // Exklusive Sperre setzen
            $data = fread($fp, filesize($counterFile));
            $counters = json_decode($data, true) ?: [];

            // Falls die URL noch nicht existiert, initialisiere mit 0
            if (!isset($counters[$currentUrl])) {
                $counters[$currentUrl] = 0;
            }

            // Zähler für die aktuelle URL erhöhen
            $counters[$currentUrl]++;

            // Datei zurücksetzen und aktualisierte JSON-Daten schreiben
            ftruncate($fp, 0); // Datei leeren
            rewind($fp); // Zum Anfang der Datei gehen
            fwrite($fp, json_encode($counters, JSON_PRETTY_PRINT));

            // Sperre aufheben und Datei schließen
            flock($fp, LOCK_UN);
        }

        fclose($fp);
    }
}
