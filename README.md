# README

## Descrizione del Progetto

Questo progetto PHP legge una lista di partite IVA scritte in un file CSV, estrae una Partita IVA in modo casuale, la invia a un'API Credit Safe per ottenere dati anagrafici e, infine, salva i dati ottenuti su un database MySQL. L'applicazione utilizza due librerie esterne: `vlucas/dotenv` versione 5.6 per la gestione delle variabili d'ambiente e `guzzlehttp/guzzle` versione 7.8 per effettuare richieste HTTP.

## Requisiti del Sistema

-   PHP 7.0 o versioni successive
-   Composer installato globalmente

## Installazione

1. Clonare il repository:

    ```
    git clone https://github.com/marcogiammari/bitbull-customers.git
    cd bitbull-customers
    ```

2. Installare le dipendenze con Composer:

    ```
    composer install
    ```

3. Inserisci il tuo file .csv nella directory principale

4. Creare un file `.env` nella directory principale copiando il file `.env.sample` e sostituendo le seguenti variabili d'ambiente:

    ```
    DB_HOST= il-tuo-host
    DB_USER= il-tuo-username
    DB_PASSWORD= la-tua-password
    DB_NAME= il-tuo-database
    CS_USERNAME= il-tuo-username
    CS_PASSWORD= la-tua-password
    CSV_FILENAME= il-nome-del-file-csv
    ```

5. Per creare il database e le tabelle necessarie, eseguire il seguente comando:

    ```
    php .\config\migrate.php
    ```

## Utilizzo

Per usare l'applicazione, eseguire il seguente comando:

    php index.php
