import React, { useEffect, useState } from 'react';

export default function Profil() {

   const [cartes, setcartes] = useState([]); 
   const [affichage, setAffichage] = useState(false);

   const [donneesModif, setDonneesModif] = useState({
    pseudo :null
   });

   const recupUtilisateur = async ()=>{
    const id=localStorage.getItem("key") 
      console.log(id)
    await fetch(`http://localhost:3010/utilisateurs/${id}`, 
    {method: "GET"})
    .then(reponse => {
        if (reponse.status === 200){
            reponse.json().then(data => {
                setcartes(data)
                setAffichage(true)
                console.log(data);
            })
        }
    })
      .catch(error => console.error(error));
  };



    useEffect(() => {
        recupUtilisateur()
    },[])


    const pseudoModif = async ()=>{
        const id=localStorage.getItem("key")
        console.log("id : ",id)
        try {
            const reponse = await fetch(`http://localhost:3010/api/utilisateurModif/${id}`, 
            {method: "PUT", headers:{'Content-Type':'application/json'} ,body: JSON.stringify(donneesModif)})
              if(reponse.status === 200){
                window.location.reload();
              }
            }
            catch(error){
              console.error(error);
            }
    }
return (
    <div className='couleur'>
        <center>
        <h1><u>Gestion du profil</u></h1>
        </center>

        {affichage ? 
         cartes.map(utili => (
           <div>
            {console.log(utili)}
             <fieldset>
               <p> Pseudo : {utili.pseudo}</p>
               <p> Mail : {utili.mail} </p>
               <br/>
               <p>Modifier votre pseudo ?</p>
               <input type="text" placeholder='pseudo' onChange={(e) => setDonneesModif({...donneesModif,pseudo:e.target.value})} ></input>
               <button onClick={()=> pseudoModif(utili.pseudo)}>Valider</button>
               <br/>
             </fieldset>
           </div>
         )) : <p>Chargement ...</p>}
    </div>
  )
}