import React, { useEffect, useState } from 'react';
import '../styles/connexion.css';
import register from "../images/register.jpg";
import { Link } from 'react-router-dom';

export default function Inscription() {
  const [donneesUtili, setDonneesUtili] = useState({
    pseudo: '',
    mail: '',
    mdp: '',
    role: 1 // Assurez-vous que 'role' est nécessaire et correctement géré
  });
  const [confirmPassword, setConfirmPassword] = useState('');
  const [errorMessages, setErrorMessages] = useState({});

  useEffect(() => {
    document.body.style.overflow = 'hidden';
    return () => {
      document.body.style.overflow = 'auto';
    };
  }, []);

  //validation du formulaire
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

  const handleInputChange = (event) => {
    setDonneesUtili({ ...donneesUtili, [event.target.name]: event.target.value });
  };

  //ajoute l'utilisateur
  const handleSubmit = async (event) => {
    event.preventDefault();
    if (!validateForm()) {
      return;
    }
    console.log("Données du formulaire soumises:", donneesUtili);
    try {
      const response = await fetch('http://localhost:3010/api/inscription', {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(donneesUtili)
      });
      if (response.status === 200) {
        alert("Inscription réussie");
        // Rediriger vers une autre page ou réinitialiser le formulaire
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
                name='pseudo'
                onChange={handleInputChange}
                required
              />
              <label>Pseudo</label>
            </div>
            <div className='user-box'>
              <input
                type='email'
                name='mail'
                onChange={handleInputChange}
                required
              />
              <label>Email</label>
            </div>
            <div className='user-box'>
              <input
                type='password'
                name='mdp'
                onChange={handleInputChange}
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
              Inscription
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
