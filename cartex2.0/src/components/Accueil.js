import React, { useEffect, useState } from 'react';
import '../App.css';
import Modal from './Modal';
import back_x from "../image/images.jpg";

export default function Accueil() {
  const [currentPage, setCurrentPage] = useState(0);
  const cardsPerPage = 9;

  const [cards, setCards] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedCard, setSelectedCard] = useState(null);

  useEffect(() => {
    fetch('http://localhost:3010/api/cartes')
      .then((response) => response.json())
      .then((data) => {
        if (Array.isArray(data)) {
          const startIndex = currentPage * cardsPerPage;
          const selectedCards = data.slice(startIndex, startIndex + cardsPerPage);
          setCards(selectedCards);
        }
      })
      .catch((error) => console.error('Error fetching data:', error));
  }, [currentPage]);

  const handleNextClick = () => {
    setCurrentPage(currentPage + 1);
  };

  const handlePreviousClick = () => {
    if (currentPage > 0) setCurrentPage(currentPage - 1);
  };

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
      <button onClick={handlePreviousClick} disabled={currentPage === 0}>Précédent</button>
      <button onClick={handleNextClick}>Suivant</button>
    </div>
  );
}