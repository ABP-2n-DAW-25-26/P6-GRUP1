<x-mail::message>

<div style="text-align: center; margin-bottom: 6px;">
    <img src="https://hepatia.sbaraka.cat/cendraquest-256.png"
         alt="{{ config('app.name') }}"
         width="50"
         style="border-radius: 14px;">
</div>

# Benvingut/da a {{ config('app.name') }} 

Ja tens accés a la plataforma com a **alumne/a**.

A partir d’ara podràs gestionar i consultar tota la informació relacionada amb el teu intercanvi.

---

## Accés al sistema

Pots iniciar sessió amb les credencials proporcionades pel professor:

- Email: **{{ $email }}**

@if($isNewUser)
- Contrasenya: **{{ $password }}**

<x-mail::panel>
Per seguretat, et recomanem canviar la contrasenya després del primer accés.
</x-mail::panel>
@endif

<x-mail::button :url="url('/login')">
Iniciar sessió
</x-mail::button>

---

## Què podràs fer com a alumne?

A la plataforma podràs:

- Veure totes les activitats de l’intercanvi en una **agenda**
- Consultar la **pròxima activitat programada**
- Llegir publicacions amb **informació de les activitats**
- Veure **punts d’interès** marcats al mapa dins d’una activitat
- Seguir recorreguts de **visites guiades** amb parades al mapa
- Participar en **gimcanes** amb parades, preguntes i respostes
- Competir amb altres alumnes en les gimcanes i veure **rànquings**
- Veure la **durada, localització i descripció** de cada activitat
- Rebre **notificacions dels intercanvis**

---

## Seguretat del compte

- Pots recuperar la contrasenya en qualsevol moment si l’oblides
- Mantén les credencials segures
- No comparteixis el teu accés amb altres persones

---

Gràcies,<br>
**{{ config('app.name') }}**

</x-mail::message>