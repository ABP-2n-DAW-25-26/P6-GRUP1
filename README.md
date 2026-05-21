# P6-GRUP1

> Projecte **Hipatia** — Plataforma de gestió d'intercanvis Erasmus per a l'institut Cendrassos.
> Equip **P06 - Cendrasoft**: Solaiman Baraka, Robert Poenaru, Balvinder Singh, Youssef Bakouh.

## URLs de producció (HTTPS)

| Entorn | URL |
|--------|-----|
| Solaiman | https://hipatia.sbaraka.cat/ |
| Balvinder | http://hipatia.balvindermarfil.cat/ |
| Youssef | https://hipatia.ybak.cat |
| Robert | https://hipatia.robertgp.cat |

Eines de desenvolupador que cal tenir instal·lades a l'ordinador

[![Node.js](https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white)](https://nodejs.org/)
[![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white)](https://getcomposer.org/)
[![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)

## Configuració del projecte

Copia el fitxer `.env` des de l'exemple
```bash
cp .env.example .env
```

Instal·la les dependències
```bash
composer run setup
```

Executa el projecte
```bash
composer run dev
```

## Altres comandes útils

Executa els tests
```bash
composer run test
```

Comprova el format sense modificar fitxers
```bash
composer run lint:check
```

Formata el codi
```bash
composer run lint
```

Executa les comprovacions de CI en local
```bash
composer run ci:check
```

Compila els assets del frontend
```bash
npm run build
```

---

## Traducció amb IA

La plataforma inclou un sistema de traducció automàtica amb IA que tradueix tota la interfície a l'idioma escollit per l'usuari sense recarregar la pàgina.

### Com funciona

1. L'usuari selecciona un idioma des del selector de l'encapçalament.
2. El frontend recull tots els nodes de text visibles del DOM.
3. Aquests textos s'envien a l'API del backend (`POST /api/translate`).
4. El backend comprova primer una caché a la base de dades — si la traducció ja existeix, la retorna directament.
5. Per als textos que no estan en caché, crida l'**API de Groq** (model: `llama-3.1-8b-instant`) per traduir des del català.
6. Les traduccions noves es desen a la caché per a futures peticions.
7. Els textos traduïts s'apliquen directament al DOM — sense recarregar la pàgina.
8. En la següent navegació d'Inertia, la pàgina es torna a traduir automàticament.

```
L'usuari tria un idioma
Recull tots els nodes de text del DOM
POST /api/translate  { texts: [...], lang: "es", url: "/exchange" }
Caché === etorna la traducció guardada directament
No caché === crida Groq API = desa a BD = retorna traducció
Aplica les traduccions al DOM (sense recarregar)
```

### Què tradueix

- Tot el text visible de la interfície: etiquetes, botons, títols, missatges.
- Ignora les etiquetes: `<script>`, `<style>`, `<select>`, `<option>`.
- Ignora textos de menys de 2 caràcters.

### Què no tradueix

- Noms de centres i llocs
- Noms de persones
- Nombres i xifres

### Idiomes suportats

| Codi | Idioma |
|------|--------|
| `ca` | Català per defecte|
| `es` | Castellà |
| `en` | Anglès |
| `fr` | Francès |
| `de` | Alemany |

### Ús al frontend

El composable `useTranslate.ts` exposa una única funció:

```ts
import { translatePage, currentLang } from '@/composables/useTranslate';

// Tradueix tota la pàgina al castellà
await translatePage('es');

// Torna al català (restaura el text original)
await translatePage('ca');

// Llegeix l'idioma actual
console.log(currentLang.value);
```

### API del backend

**Endpoint:** `POST /api/translate`

**Cos de la petició:**
```json
{
  "texts": ["Llistat d'intercanvis", "Nou usuari", "Tauler d'administració"],
  "lang": "es",
  "url": "/exchange"
}
```

**Resposta:**
```json
{
  "Llistat d'intercanvis": "Lista de intercambios",
  "Nou usuari": "Nuevo usuario",
  "Tauler d'administració": "Panel de administración"
}
```

### Variable d'entorn necessària

Afegeix això al fitxer `.env` per activar l'API de Groq:

```env
GROQ_API_KEY
```

Sense aquesta clau, el sistema retorna els textos originals sense traduir.

# Us d'IA en el projecte

## Seeders

A l'hora de crear els seeders per als temes predefinits se li va demanar a la IA 2 exemples per col·locar a part del tema principal de la web.
Per crear els seeders dels intercanvis i les seves activitats s'ha utilitzat la IA per poder proporcionar informació verídica a l'hora de fer la demo.
En crear una política de privacitat realista.
El text de les cookies està generat amb IA per donar més impressió de realisme.

## Política d'ús d'IA

La IA es fa servir només com a **suport**. Tot el codi es revisa abans de fer commit.

**Per a què la fem servir:**

- Generar textos legals (privacitat, cookies).
- Crear dades de prova als seeders.
- Resoldre dubtes tècnics puntuals (Copilot Chat).
- Autocompletat de codi (Copilot).

**Què no fem:**

- Enganxar codi sense entendre'l.
- Passar dades reals d'usuari a la IA.

**Cas d'ús destacat:** traducció dinàmica amb l'API de Groq (model `llama-3.1-8b-instant`). Les traduccions es guarden en caché a la BD per no repetir crides. Detalls a la secció [Traducció amb IA](#traducció-amb-ia).

## Accessibilitat (WCAG 2.1)

Objectiu: **nivell AA** a les pàgines públiques.

Què hem fet:

- Contrast de colors suficient (tokens Tailwind).
- Navegació amb teclat a tots els botons i formularis.
- Etiquetes `aria-label` i `alt` a imatges.
- Estructura semàntica (`<header>`, `<main>`, `<footer>`, jerarquia de `<h1>`...`<h6>`).
- Mode clar/fosc segons preferència del sistema.

## Sostenibilitat — ASG

Pàgina completa a [/sostenibilitat](resources/js/pages/Sostenibilitat.vue) (enllaçada al peu de la home).

Petjada de carboni mesurada amb [Website Carbon](https://www.websitecarbon.com/website/hipatia-ybak-cat/) (21/05/2026):

- **0,22 g de CO₂** per visita
- Funciona amb energia sostenible
- Rating: D

Accions aplicades: imatges WebP, Vite minifica el bundle, caché de traduccions, Tailwind purge del CSS no utilitzat.