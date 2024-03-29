import React, { useEffect, useState } from 'react';
import '../styles/connexion.css';
import image_sign from "../images/sign_in.jpg";
import { Link } from 'react-router-dom';
import Cookies from 'js-cookie';

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
    event.preventDefault(); 

    try {
      const response = await fetch(`http://localhost:3010/utilisateursBDD`, {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(donneesConn)
      });
      //si bon mail et bon mdp
      if (response.status === 200) {
        const data = await response.json();
        localStorage.setItem("key", data.id);
        localStorage.setItem("role", data.role);
        console.log(data.id);
        console.log(data);
        console.log("Connexion rÃ©ussie");
        Cookies.set('role', data.role);
        //sécurité de la plateforme
        const cookieRole = Cookies.get('role');
        console.log('Valeur du cookie role :', cookieRole);
        
        window.location.reload()
        window.location.href = './';

        // si pas correcte
      } else {
        console.error("Erreur lors de la connexion");
        //message erreur
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