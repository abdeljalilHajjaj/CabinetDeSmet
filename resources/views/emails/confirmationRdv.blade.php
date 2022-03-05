<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Confirmation de votre  Rendez-vous</h2>
    
    @if($data['sexe'] == "H")
        Bonjour Monsieur {{$data['nom']}},
    @endif

    @if($data['sexe'] == "F")
        Bonjour Madame {{$data['nom']}},
    @endif

    <ul>
      <li><strong>Date et heure du rendez-vous</strong> : {{ $data['dateRdv'] }}</li>
      <li><strong>Nom du médecin</strong> :Dr . {{ $data['medecin'] }}</li>
      <li><strong>Lieu du rendez-vous</strong>: Rue des trois gardes 344 schaerbeek </li>

     
    
    </ul>
  </body>
</html>