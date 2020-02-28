# Výpisky
Oficiální vyvíjená verze Výpisků.
Jedná se o projekt, který se snaží usnadnit komunikaci mezi studenty. Každý student dostává své uživatelské jméno a heslo, následně
mu může být uděleno oprávnění sdílet své soubory/webové adresy se svými kolegy. Ostatní mohou tyto soubory/odkazy volně navštěvovat.
Součástí tohoto projektu je i jednoduchá chatroom s podporou odkazů a obrázků. Dále se ve Výpiscích nachází i diář pro plánování nadcházejících zkoušek, prací, atd.

# Požadavky
- Server s podporou PHP 5 nebo PHP 7
- Databáze MySQL 5 a vyšší
- Podpora https (vyšší bezpečnost + podpora PWA)
- PHP extensions: pdo_mysql, MySQLi, gd2

# Instalace
1) Ze složky "db - viz README" přidejte přiložené tabulky
2) Ostatní soubory umístěte na server
3) V souboru "config.php" nastavte přístup k databázi
4) V souboru "config.php" nastavte složku s obrázky z Chatroom

# Oprávnění uživatelů
- "o" (=owner) - plný přístup, možnost mazat výpisky, události, přidávat soubory o velikosti až 10 MB
- "w" (=writer) - možnost přidávat události a nahrávat výpisky o velikosti až 2 MB
- "u" (=untrusted writer) - totožné, jako "writer", jen velikost výpisků je max. 250 kB
- "r" (=reader) - uživatel, který nesmí výpisky nahrávat, pouze stahovat
- "n" (=nagger) - totožné, jako "reader", ale bez přístupu k Chatroom
- "p" (=paused) - pozastavený účet, bez možnosti přihlášení

> Vyvíjeno ve spolupráci s @github/vojta478

# Projekt bude v budoucnu nahrazen projektem Open School System for Students.
