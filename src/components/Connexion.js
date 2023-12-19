import React, { useEffect, useState } from 'react';
import '../styles/connexion.css';
import image_sign from "../images/sign_in.jpg";
import { Link } from 'react-router-dom';

function Connexion() {
  const [donneesConn, setDonneesConn] = useState({
    mail: '',
    mdp: ''
  });

  useEffect(() => {
    document.body.style.overflow = 'hidden';
    return () => {
      document.body.style.overflow = 'auto';
    };
  }, []);

  const handleLogin = async (event) => {
    event.preventDefault(); // Prevent default form submission behavior

    try {
      const response = await fetch(`http://localhost:3010/utilisateursBDD`, {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(donneesConn)
      });

      if (response.status === 200) {
        const data = await response.json();
        localStorage.setItem("key", data.id);
        console.log("Connexion réussie");
        // Redirect or perform additional actions after successful login
      } else {
        console.error("Erreur lors de la connexion");
        // Handle error case
      }
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className='content-container'>
      <div className='container-login'>
        <div className='login-box'>
          <p>Connexion</p>
          <form onSubmit={handleLogin}>
            <div className='user-box'>
              <input
                type='email'
                value={donneesConn.mail}
                onChange={(e) =>
                  setDonneesConn({ ...donneesConn, mail: e.target.value })
                }
                required
              />
              <label>Email</label>
            </div>
            <div className='user-box'>
              <input
                type='password'
                value={donneesConn.mdp}
                onChange={(e) =>
                  setDonneesConn({ ...donneesConn, mdp: e.target.value })
                }
                required
              />
              <label>Mot de passe</label>
            </div>
            <button type='submit'>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Connexion
            </button>
          </form>
          <p>Vous n'avez pas de compte ?<Link to="/Inscription">Inscrivez-vous ici</Link></p>
        </div>
      </div>
      <div className='image-box'>
        <img src={image_sign} alt='Image de connexion' />
      </div>
    </div>
  );
}

export default Connexion;