# Chatbot

[odkaz na specifikaci](https://docs.google.com/document/d/14DRHdTtwY4aQcFWJZlGKAe5Y4F5RFz9tmOefzaeQu2g/edit?usp=sharing)

## Flow

Začínáme originálně na `index.php`. Tam pomocí JS (**funkční na Linux\Chromium, nefunkční ve Linux\Firefox!**) uživatel po kliknutí na mikrofon hlasově zadá vstup, potom se automaticky odešle formulář na stránku `process.php`. Pokud mikrofon není vidět, hlasový vstup není podporovaný. 

Soubor `process.php` pošle CURL dotaz na wit.ai, vyparsuje výsledek a uloží ho do `$_SESSION` proměnné. Potom vyvolá opět `index.php`, který proměnné vypisuje. 

Pomocný soubor `clearSession.php` pouze vymaže celou proměnnou `$_SESSION` a vyvolá zpět `index.php`. 

Všechna nastavení jsou v souboru `Config/settings.ini`. 

## Deadlines (a deliverables):

 - [x] 23/10: Specifikace semestrálního projektu. Seznam osob, zvolená technologie, role v teamu, jednoduchý popis prvního usecase. Rozsah cca 1 A4, PDF.
 - [ ] 6/11: Odevzdání písemného reportu. Zvolená technologie, tým, role v týmu, rozdělení úkolů, časový plán, požadavky na aplikaci. Popis prvního usecase, screenshoty prvního dema (nebo odkaz na video). PDF. 
 - [ ] 20/11: Prezentace (rozšíření usecase na 3 případy), předvedení. Kontrola plnění časového plánu. Odevzdavejte PDF.
 - [ ] 4/12: Průběžný report (stav projektu, plnění úloh). PDF
 - [ ] 11/12: (evaluace cizího projektu; neodevzdává se nic). Tzn. musíte druhému teamu (a cvičícím v kopii) předat link na funkční aplikaci a odeslat doposud vypracované písemné zprávy.
 - [ ] 18/12: Prezentace finální aplikace (odevzdani PDF), odevzdání hodnoticí zprávy konkurenčního projektu (PDF).
 - [ ] 8/1: Odevzdání závěrečná práce (písemný report, PDF), Dokumentace projektu (PDF/web)

## Požadavky

 - Ukládání kontextu
 - Detekce zacyklení (odkaz na lidského pracovníka) např. při 3x špatně zadaném vstupu
 - Správné návrhové postupy (viz web, úvodní webový dokument, apod.)
 - Přístupné online (k vyzkoušení a evaluaci)
 - Hlasové ovládání

Link na wiki: https://cw.fel.cvut.cz/wiki/courses/a6m33li/projekt_chatbot
