<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Mail informatif</h2>
    
    @if($data['sexe'] == "H")
        Bonjour Monsieur {{$data['nom']}},
    @endif

    @if($data['sexe'] == "F")
        Bonjour Madame {{$data['nom']}},
    @endif

    <p>Par la présente, nous avons l'honneur de vous annoncer que votre inscription a été cloturé avec succès</p>
    <p>Vous pouvez dès lors prendre rendez-vous</p>

    


    <p></p>
  </body>
</html>