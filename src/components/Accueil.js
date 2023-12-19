import React, { useEffect, useState } from 'react';
import '../App.css';
import Modal from './Modal'; 
import back_x from "../images/images.jpg";

export default function Accueil() {
  const [cards, setCards] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedCard, setSelectedCard] = useState(null);

  //console.log(localStorage.getItem("key"))
  useEffect(() => {
    fetch('https://db.ygoprodeck.com/api/v7/cardinfo.php')
      .then((response) => response.json())
      .then((data) => {
        const first9Cards = data.data.slice(0, 9);
        setCards(first9Cards);
      })
      .catch((error) => console.error(error));
  }, []);

  // Check if a card is already saved in local storage
  const isCardSaved = (card) => {
    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    return savedCards.some(savedCard => savedCard.link === card.card_images[0].image_url);
  };

  // Handle clicking on the card
  const handleCardClick = (card) => {
    if (isCardSaved(card)) return; // Do nothing if card is already saved

    const cardData = {
      link: card.card_images[0].image_url,
      name: card.name 
    };
    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    savedCards.push(cardData);
    localStorage.setItem('savedCardLinks', JSON.stringify(savedCards));
    window.location.reload();
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
            <div className="innerCard"onClick={() => openModal(card)}>
              <div className="frontSide" style={{ backgroundImage: `url('${back_x}')`, backgroundSize: '100% 100%' }}>
                <p className="title">Yu-Gi-Oh</p>
                <p>{card.name}</p> 
                {!isCardSaved(card) && (
                  <button onClick={() => handleCardClick(card)}>Save</button>
                )}
              </div>
              <div className="backSide" style={{ background: `url('${card.card_images[0].image_url}')`, backgroundSize: '100% 100%' }}>
              {!isCardSaved(card) && (
                  <button onClick={() => handleCardClick(card)}>Save</button>
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