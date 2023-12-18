import React, { useEffect, useState } from 'react';
import '../App.css'


function Connexion() {
  const [mail, setMail] = useState('');
  const [mdp, setMdp] = useState('');

  const [donneesConn, setDonneesConn] = useState({
    mail:null,
    mdp:null,
});

// permet de récupérer tous les utilisateurs
const connexion = async ()=>{
  //Chargement BDD
  await fetch(`http://localhost:3010/utilisateursBDD`, 
  {method: "GET"})
  .then(reponse => reponse.json()).then(data => {
      setMail(data);
      setMdp(data);
    })
  .catch(error => console.error(error));
};


//permet d'utiliser que l'utilisateur qui correspond au mail et mdp
  const handleLogin = async () => {
    
    await fetch(`http://localhost:3010/utilisateursBDD`, 
    {method: "POST",headers:{'Content-Type':'application/json'} ,body: JSON.stringify(donneesConn)})
    .then(reponse => 
      {if (reponse.status === 200){
        // console.log(reponse);
        reponse.json().then(data => localStorage.setItem("key", data.id))
        console.log("OK")
      }}
      )

      .catch(error => console.error(error));
  };

  useEffect(() => {
    connexion()
},[])


  return (
    <>
    <div className='formulaire'>
    <center>
      <h2>Connexion</h2>
      <form>
        <label>Mail: 
          <input
            type="email"
            onChange={(e) => setDonneesConn({...donneesConn,mail:e.target.value})}
          />
        </label>
        <br/>
        <label>Mot de passe:
          <input
            type="password"
            onChange={(e) => setDonneesConn({...donneesConn,mdp:e.target.value})}
          />
        </label>
        <br/>
        <button type="button" onClick={handleLogin}>Se Connecter</button>
      </form>
      </center>
    </div>
    
    </>
  );
}

export default Connexion;