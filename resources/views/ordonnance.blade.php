<html lang="fr">
  <head>
    <meta charset="utf-8">
   
       
    
  </head>
  <body style="width: 100%;height:100%;">
    <div style="height: 10%;border:solid 1px black;width:100%;"><div></div><div style="margin-left:24%;">{!!DNS1D::getBarcodeHTML($codeBarre,'C39+',2,80,'black')!!}  </div><div style="text-align: center;">{{$codeBarre}}</div></div>
    <div style="height: 5%;border:solid 1px black;text-align:center"><p><strong>PREUVE DE PRESCRIPTION ELECTRONIQUE</strong> </p> </div>
    <div style="height: 7%;border:solid 1px black"><p style="margin-left: 20px;font-size: 15px;">Veuillez présenter ce document à votre pharmacien pour scanner le code-barres et vous délivrer les médicaments prescrits</p>  </div>
    <div style="height: 8%;border:solid 1px black">
        <p style="margin-left: 20px;"><strong>Prescripteur: </strong> Dr. {{$nomMedecin}} {{$prenomMedecin}} </p>
        <p  style="margin-left: 20px;"><strong>Numéro INAMI:  </strong> {{$inami}} </p>
    </div>

    <div  style="height: 8%;border:solid 1px black">
        <p  style="margin-left: 20px;"><strong>Bénéficiaire: </strong> {{$nomPatient}}  {{$prenomPatient}} </p>
        <p style="margin-left: 20px;"><strong>NISS: </strong> {{$rn}} </p>
    </div>
    <div style="border: solid 1px black;">
      <p style="text-align: center;"><strong>Contenu de la prescription électronique</strong> </p>
    </div>
    <div style="height: 35%;border:solid 1px black">
      <table style="width:100%;border-collapse: collapse;">
        
      <tbody style="height: 40%;width: 100%;">
      @foreach($medicament as $medic)
     
          <tr style="width: 100%;" >
            <td style="border:solid 1px black;width:7%;text-align:center;height:5%;padding:1em; ">{{($loop->index)+1}} </td>
            <td style="width: 92%;border:solid 1px;padding:1em">{{$medic}} </td>
          </tr>
        
         

        
    
        
      @endforeach
      </tbody>
      </table>
      </div>

      <div style="height: 6%;border:solid 1px black"><p style="margin-left: 20px;font-size: 15px;">Attention : Aucun ajout manuscrit à ce document ne sera pris en compte. </p> </div>

      <div style="height: 6%;border:solid 1px black;"><p style="margin-left: 20px;margin-bottom: 20px;">Date:  {{date('d/m/Y')}} </p>  </div>
     
      <div style="height: 6%;border:solid 1px black;"><p style="margin-left: 20px;margin-bottom: 20px;">Exécutable à partir du :  {{date('d/m/Y')}} </p>  </div>
    
  </body>
</html>