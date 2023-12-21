import React, { useState, useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import Modal from './Modal'; 
import back_x from "../images/images.jpg";
import '../App.css';

function useQuery() {
  return new URLSearchParams(useLocation().search);
}

function Rechercher() {
    const [cards, setCards] = useState([]); 
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [selectedCard, setSelectedCard] = useState(null); 
    const location = useLocation(); 
  
    useEffect(() => {
      const params = new URLSearchParams(location.search);
      const searchTerm = params.get('nom');
  
      if (searchTerm) {
        fetch(`http://localhost:3010/api/recherche/cartes?nom=${searchTerm}`)
          .then(response => response.json())
          .then(data => {console.log("Résultats de recherche :", data); 
            setCards(data);}) 
          .catch(error => console.error('Error:', error));
      }
      if (searchTerm == "AZ") {
        fetch(`http://localhost:3010/api/recherche/cartes?nom=AZ`)
          .then(response => response.json())
          .then(data => {console.log("Résultats de recherche :", data); 
            setCards(data);}) 
          .catch(error => console.error('Error:', error));
      }
    }, [location]);
  

  const isCardSaved = (card) => {
    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    return savedCards.some(savedCard => savedCard.link === card.cards_images);
  };

  const handleCardClick = (e, card) => {
    e.stopPropagation();
    if (isCardSaved(card)) return;

    const cardData = {
      link: card.cards_images,
      name: card.name
    };

    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    savedCards.push(cardData);
    localStorage.setItem('savedCardLinks', JSON.stringify(savedCards));
  };

  const openModal = (card) => {
    setSelectedCard(card);
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setIsModalOpen(false);
  };

  return (
    <div className='full-page-div'>
      <div className="bottom-image"></div>
      <div className="article-container">
        {cards.map((card, index) => (
          <div className="myCard" key={index}>
            <div className="innerCard" onClick={() => openModal(card)}>
              <div className="frontSide" style={{ backgroundImage: `url('${back_x}')`, backgroundSize: '100% 100%' }}>
                <p className="title">Yu-Gi-Oh</p>
                <p>{card.name}</p>
                {!isCardSaved(card) && (
                  <button className="button-savef" onClick={(e) => handleCardClick(e, card)}>Save</button>
                )}
              </div>
              <div className="backSide" style={{ background: `url('${card.cards_images}') no-repeat center center / cover` }}>
                {!isCardSaved(card) && (
                  <button className='button_save' onClick={(e) => handleCardClick(e, card)}>Save</button>
                )}
              </div>

            </div>
          </div>
        ))}
      </div>
      {isModalOpen && (
        <Modal
          isOpen={isModalOpen}
          onClose={closeModal}
          card={selectedCard}
        />
      )}
    </div>
  );
}

export default Rechercher;
