import React, { useEffect, useState } from 'react';
import '../styles/connexion.css';
import register from "../image/register.jpg";
import { Link } from 'react-router-dom';

export default function Inscription() {
  const [confirmPassword, setConfirmPassword] = useState('');
  const [errorMessages, setErrorMessages] = useState({});
  const [donneesUtili, setDonneesUtili] = useState({
    pseudo: null,
    mail: null,
    mdp: null,
    role: null
  });

  useEffect(() => {
    document.body.style.overflow = 'hidden';
    return () => {
      document.body.style.overflow = 'auto';
    };
  }, []);

  const validateForm = () => {
    const errors = {};
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!donneesUtili.mail || !emailRegex.test(donneesUtili.mail)) {
      errors.email = "Email invalide.";
    }
    if (!donneesUtili.mdp || donneesUtili.mdp.length < 6) {
      errors.password = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if (donneesUtili.mdp !== confirmPassword) {
      errors.confirmPassword = "Les mots de passe ne correspondent pas.";
    }
    setErrorMessages(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (!validateForm()) {
      return;
    }

    try {
      const response = await fetch(`http://localhost:3010/api/inscription`, {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(donneesUtili)
      });
      if (response.status === 200) {
        alert("Utilisateur créé avec succès !");
        // Here you might want to navigate the user to a different page or reset the form
      } else if (response.status === 409) {
        setErrorMessages({ duplicate: "Pseudo ou email déjà utilisé." });
      } else {
        console.error("Erreur lors de l'inscription", await response.text());
      }
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <div className='content-container'>
      <div className='container-login'>
        <div className='login-box'>
          <p>Inscription</p>
          <form onSubmit={handleSubmit}>
            <div className='user-box'>
              <input
                type='text'
                onChange={(e) => setDonneesUtili({ ...donneesUtili, pseudo: e.target.value })}
                required
              />
              <label>Pseudo</label>
            </div>
            <div className='user-box'>
              <input
                type='email'
                onChange={(e) => setDonneesUtili({ ...donneesUtili, mail: e.target.value })}
                required
              />
              <label>Email</label>
            </div>
            <div className='user-box'>
              <input
                type='password'
                onChange={(e) => setDonneesUtili({ ...donneesUtili, mdp: e.target.value })}
                required
              />
              <label>Mot de passe</label>
            </div>
            <div className='user-box'>
              <input
                type='password'
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
              />
              <label>Confirmez le Mot de passe</label>
            </div>
            {Object.values(errorMessages).map((msg, index) => (
              <div key={index} className='error-message'>{msg}</div>
            ))}
            <button type='submit'>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Créer compte
            </button>
          </form>
          <p>Vous avez déjà un compte ? <Link to="/Connexion">Connectez-vous ici</Link></p>
        </div>
      </div>
      <div className='image-box'>
        <img src={register} alt='Image de registre' />
      </div>
    </div>
  );
}
