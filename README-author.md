# Poznámky autora

Zadání pojato jako vytvoření ukázkové jednoduché API aplikace pro správu soukromých TODO.

Jako resource slouží jediná jednoduchá entita `App\Entity\Task` se základními atributy.

API nad takovým resource je velice jednoduché a tudíž vede k využití uznávaného nástroje pro tvorbu API: [API Platform](https://api-platform.com).
Ta umí sama nad definovaným zdrojem postavit CRUD operace, u kolekcí s možností stránkování, filtrování a řazení. Zároveň je snadno rozšířitelná
o komplexnější úlohy a snadno customizovatelná.

Protože se jedná o základní API use case, díky API Platform není potřeba do projektu zavádět jiné vrstvy (controllery, manažery, repozitáře,..).
Repozitář `App\Repository\TaskRepository` zde slouží pouze pro ukázku, je využit v testech (ačkoliv i tam je takto nahraditelný).
Pro tak jednoduchou ukázku aplikace nebylo využito složitějších technologií, jako CQRS, Event Sourcing. Není však těžké to přidat, např. CQRS
s použitím [Symfony Messenger Component](https://symfony.com/doc/current/messenger.html) lze snadno aplikovat i do API Platfomy:
[Symfony Messenger Integration: CQRS and Async Message Processing](https://api-platform.com/docs/core/messenger).

Celková ukázka je tedy stavěna zejména na konfiguraci v entitě `App\Entity\Task`. Při využití PHP8 již pomocí atributů, bohužel s mixem anotací, jelikož
podpora atributů pro Doctrine ORM je teprve ve fázi vývoje. Jak API Platforma, tak Symfony validace a serializace již lze definovat pomocí atributů.

Statická analýza je implementována pomocí PHPStan, spuštění viz. README.md.

Funkcionální testy jsou implementovány spolu s funkcí obnovy dat databáze, spuštění viz. README.md.

Hlavní projektové technologie:
- Docker
- Symfony 5 Framework
  - Symofny Components
  - API Platform
  - Doctrine
  - PHPUnit
  - PHPStan
- PostgreSQL
- NGINX

Aplikaci lze jednoduše plně spustit v Docker s pomocí Docker Compose. Spolu s aplikací se spustí i databáze PostgreSQL,
ve které aplikace za pomocí migrací vytvoří databázové schéma. Take se spustí webový server NGINX. API endpoint je dostupný
na adrese http://localhost:8080/api, kde je též automaticky generovaná OpenAPI dokumentace s možností uživatelského testování pomocí GUI.
