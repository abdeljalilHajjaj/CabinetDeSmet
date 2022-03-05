<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Confirmation de votre  Rendez-vous</h2>
    
    @if($sexe == "H")
        Bonjour Monsieur {{$nom}},
    @endif

    @if($sexe == "F")
        Bonjour Madame {{$nom}},
    @endif
    <p>Voici un récapitulatif de votre rendez-vous à venir : </p>

    <br>
    <ul>
      <li><strong>Date et heure du rendez-vous</strong> : {{ $dateRdv }}</li>
      <li><strong>Nom du médecin</strong> :Dr . {{ $medecin }}</li>
      <li><strong>Lieu du rendez-vous</strong>: Rue des trois gardes 344 schaerbeek </li>

     
    
    </ul>
  </body>
</html>