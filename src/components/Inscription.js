import React, { useState } from 'react';
import '../App.css';


export default function Inscription() {

  //récupération des valeurs de l'utilisateur du formulaire
  const [donneesUtili, setDonneesUtili] = useState({
    pseudo:null,
    mail:null,
    mdp:null,
    role:null
});



   //ajout utilisateur dans la BDD grace au back
  const handleLogin = async () => {
    try {
      console.log(donneesUtili)
    const reponse = await fetch(`http://localhost:3010/api/inscription`, 
    {method: "POST", headers:{'Content-Type':'application/json'} ,body: JSON.stringify(donneesUtili)})
      if(reponse.status === 200){
        alert("inscription réussie")
        window.location.reload();
      }else{
        console.error("Erreur lors de l'inscription", await reponse.text())
      }
    }
    catch(error){
      console.error(error);
    }
  };

  return (
    <div>
<div className='formulaire'>
    <center>
      <h2>Inscription</h2>
      <form>
      <label>Pseudo: 
          <input
            type="text"
            onChange={(e) => setDonneesUtili({...donneesUtili,pseudo:e.target.value})}
          />
        </label>
        <br/>
        <label>Mail: 
          <input
            type="email"
            onChange={(e) => setDonneesUtili({...donneesUtili,mail:e.target.value})}
          />
        </label>
        <br/>
        <label>Mot de passe:
          <input
            type="password"
            onChange={(e) => setDonneesUtili({...donneesUtili,mdp:e.target.value})}
          />
        </label>
        <br/>
        <label>Role: 
          <input
            type="role"
            onChange={(e) => setDonneesUtili({...donneesUtili,role:e.target.value})}
          />
        </label>
        <br/>
        <button type="button" onClick={handleLogin}>S'inscrire</button>
      </form>
      </center>
    </div>
    </div>
  )
}