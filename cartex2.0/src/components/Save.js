import React, { useEffect, useState } from 'react';
import back_x from "../images/images.jpg";
import '../App.css';

export default function Save() {
  const [savedCards, setSavedCards] = useState([]);

  useEffect(() => {
    const savedData = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    setSavedCards(savedData);
  }, []);

  const clearSavedCards = () => {
    localStorage.removeItem('savedCardLinks'); // Efface les cartes sauvegardées du local storage
    setSavedCards([]); // Met à jour l'état pour refléter le changement
  };

  return (
    <div className='full-page-div'>
      <div className="bottom-image"></div>
      <div className='button_container'>
        <button className='button_clear' onClick={clearSavedCards}>Effacer les Enregistrements</button> 
        </div>
      <div className="article-container">
        {savedCards.map((card, index) => (
          <div className="myCard" key={index}>
            <div className="innerCard">
              <div className="frontSide" style={{ backgroundImage: `url('${back_x}')`, backgroundSize: '100% 100%' }}>
                <p className="title">Yu-Gi-Oh</p>
                <p>{card.name}</p>
              </div>
              <div className="backSide" style={{ background: `url('${card.link}')`, backgroundSize: '100% 100%' }}>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}