<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <p>Salutare,</p>
    <p>Primiți acest email deoarece sunteți reprezentantul UAT {{ $partnerName }}.</p>
    <p>În data de {{ $dueDate }}, urmează să fie realizată o nouă acțiune de ecologizare la
        locația {{ $address }},
        acțiune inițiată de {{ $coordinatorName }}.</p>
    <p>Intrați în secțiunea de administrare a site-ului, dând click <a href="{{ $url }}">aici</a>, secțiunea
        "Acțiuni
        ecologizare", pentru a vedea datele de contact ale coordonatorului și a stabili toate detaliile pentru o acțiune
        reușită.</p>
    <p>Tot din aceeași secțiune, puteți schimba statusul propunerii în "acceptat", dacă totul este clar, sau "refuzat",
        dacă
        acțiunea propusă necesită alte detalii care nu sunt puse la punct.</p>
    <p>Mulțumim tare mult,</p>
    <p>Echipa eco4</p>
</div>
</body>
</html>
