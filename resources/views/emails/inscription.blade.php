<html lang="fr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>Confirmation Inscription</h2>
    @if($data['sexe'] == 'H')
    <p>Bonjour Monsieur {{$data['name']}} </p>
    @endif
    @if($data['sexe'] == 'F')
    <p>Bonjour Madame {{$data['name']}} </p>
    @endif
    <p>Votre inscription en ligne a bien été pris en compte mais celle-ci doit être completé</p>
    <p>Veuillez vous présenter au cabinet  afin de compléter votre inscription</p>
    <p>Pour rappel le cabinet ce situe à l'adresse suivante : Rue des hirondelles 114 1080 Molembeek-saint-jean</p>
    <p>Vous trouverez les horaires d'ouvertures dans la partie contact de notre site</p>
    <br></br>
    <p>Voici un récapitulatif des données que vous avez transmis</p>
    <ul>
      <li><strong>Nom</strong> : {{ $data['name'] }}</li>
      <li><strong>Prénom</strong> : {{ $data['prenom'] }}</li>
      <li><strong>Numéro de registre national</strong> : {{ $data['rn'] }}</li>
      <li><strong>Email</strong> : {{ $data['email'] }}</li>
      <li><strong>Mot de passe</strong> : {{ $data['password'] }}</li>
    
    </ul>
  </body>
</html>