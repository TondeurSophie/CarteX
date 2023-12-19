import React, { useEffect, useState } from 'react';

export default function Profil() {

    // Pour stocker
   const [blog, setblog] = useState([]); 
   // Pour gérer l'affichage
   const [affichage, setAffichage] = useState(false);

   const [donneesModif, setDonneesModif] = useState({
    pseudo :null
   });

   const recupUtilisateur = async ()=>{
    const id=localStorage.getItem("key") // récupération de l'id de l'utilisateur connecté

    //Chargement BDD
    await fetch(`http://localhost:3008/utilisateurs/${id}`, 
    {method: "GET"})
    .then(reponse => {
        if (reponse.status === 200){
            reponse.json().then(data => {
                setblog(data)
                setAffichage(true)
                console.log(data);
            })
        }else{
            console.log("rien");
        }
    })
      .catch(error => console.error(error));
  };



    useEffect(() => {
        recupUtilisateur()
    },[])


    //permet de modifier le pseudo de l'utilisateur
    const pseudoModif = async ()=>{
        const id=localStorage.getItem("key")
        try {
            const reponse = await fetch(`http://localhost:3010/utilisateurModif/${id}`, 
            {method: "PUT", headers:{'Content-Type':'application/json'} ,body: JSON.stringify(donneesModif)})
              if(reponse.status === 200){
                // console.log(donneesModif);
                window.location.reload();
              }
            }
            catch(error){
              console.error(error);
            }
    }

  return (
    <div>
        <center>
        <h1><u>Gestion du profil</u></h1>
        </center>

        {affichage ? 
         blog.map(utili => (
           <div>
            {console.log(utili)}
             <fieldset>
               <p> Pseudo : {utili.pseudo}</p>
               <p> Mail : {utili.mail} </p>
               <br/>
               <p>Modifier votre pseudo ?</p>
               {/* le onChange permet de récupérer ce que rentre l'utilisateur */}
               <input type="text" placeholder='pseudo' onChange={(e) => setDonneesModif({...donneesModif,pseudo:e.target.value})} ></input>
               <button onClick={()=> pseudoModif(utili.pseudo)}>Valider</button>
               <br/>
             </fieldset>
           </div>
         )) : <p>Chargement ...</p>}
    </div>
  )
}