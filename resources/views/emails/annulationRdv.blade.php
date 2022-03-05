<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Annulation de votre rendez-vous</h2>
    @if($data['sexe'] == 'H')
    <p>Bonjour Monsieur {{$data['nom']}} </p>
    @endif
    @if($data['sexe'] == 'F')
    <p>Bonjour Madame {{$data['nom']}} </p>
    @endif
    
    <br>
    <p>Votre rendez-vous du <strong>{{$data['dateRdv']}} </strong> a été annulé </p>
    <br>

    <p>Récapitulatif de votre rendez-vous :</p>
    <br>
    <ul>
      <li><strong>date et heure du rendez-vous</strong>{{ $data['dateRdv'] }}</li>
      <li><strong>Nom du médecin</strong> :Dr . {{ $data['medecin'] }}</li>
      <li><strong>Lieu du rendez-vous</strong>: Rue des trois gardes 344 schaerbeek </li>
    </ul>
    
  </body>
</html>