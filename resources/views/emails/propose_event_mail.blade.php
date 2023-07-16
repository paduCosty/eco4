<!DOCTYPE html>
<html>
<head>
    <title>Confirmare organizare - Acțiune de ecologizare</title>
</head>
<body>
<div>
    <p>Salut {{ $mailData['coordinator_name'] }},</p>
    <p>Ne bucurăm să te anunțăm că am acceptat cu entuziasm propunerea dvs. de a organiza o acțiune de ecologizare din
        data {{ $mailData['due_date'] }}.</p>
    <p>Suntem nerăbdători să participăm și să contribuim la această inițiativă importantă pentru protejarea mediului.
        Apreciem eforturile și angajamentul tău în realizarea unei schimbări pozitive în comunitatea noastră.</p>
    <p>Vom fi prezenți la acțiune și te vom sprijini în tot acest demers. Colaborarea noastră va ajuta la promovarea
        conștientizării și inspirarea altor persoane să se alăture în protejarea mediului.</p>
    <p>Îți mulțumim pentru oportunitatea de a fi parte din această inițiativă și suntem recunoscători pentru contribuția
        ta. Dacă ai întrebări sau ai nevoie de asistență, te rugăm să ne contactezi, folosind datele de mai jos:</p>
    <p>{{ $mailData['institution_name'] }}</p>
    <p>Telefon: {{ $mailData['institution_phone'] }}</p>
    <p>Email: {{ $mailData['institution_email'] }}</p>
    <p>Cu respect și anticipând cu nerăbdare această acțiune de ecologizare extraordinară,</p>
    <p>{{ $mailData['institution_name'] }}, prin Eco4</p>
    <p>PS<br>
        Acum logându-te pe site-ul eco4 și accesând link-ul "Acțiuni ecologizare", vei vedea că statusul acțiunii este
        "acceptat". Folosind link-ul "distribuie link", vei putea să distribui link-ul
        acțiunii {{ $mailData['event_name'] }}, apelând
        la sprijinul altor voluntari dornici. Acest link îți sugerăm să îl trimiți prietenilor pe email, WhatsApp,
        Facebook sau alt mediu în care ai prieteni.</p>
    <p>PPS<br>
        După organizarea acțiunii, vei primi în calitate de coordonator al acesteia, un număr de 50 puncte de implicare
        socială (NZV), ulterior postării pozelor de la eveniment și cantității de deșeuri colectate</p>
</div>
</body>
</html>
