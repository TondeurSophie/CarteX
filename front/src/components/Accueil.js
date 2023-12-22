import React, { useEffect, useState } from 'react';
import '../App.css';
import Modal from './Modal';
import back_x from "../images/images.jpg";
import face from "../images/face.png";
import twitter from "../images/twitter.png";
import youtube from "../images/youtube.png";
import instagram from "../images/instagram.png";


export default function Accueil() {
  const [currentPage, setCurrentPage] = useState(0);
  const cardsPerPage = 6;
  const isLoggedIn = localStorage.getItem("key") !== null;
  const [cards, setCards] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedCard, setSelectedCard] = useState(null);
  const [secondPage, setSecondPage] = useState(Math.floor((306 - 1) / cardsPerPage));
  const [secondSetOfCards, setSecondSetOfCards] = useState([]);

  //lister les cartes de la base de données
  useEffect(() => {
    fetch('http://localhost:3010/api/cartes')
      .then((response) => response.json())
      .then((data) => {
        if (Array.isArray(data)) {
          const startIndex = currentPage * cardsPerPage;
          setCards(data.slice(startIndex, startIndex + cardsPerPage));

          const secondStartIndex = secondPage * cardsPerPage;
          setSecondSetOfCards(data.slice(secondStartIndex, secondStartIndex + cardsPerPage));
        }
      })
      .catch((error) => console.error('Error fetching data:', error));
  }, [currentPage, secondPage]);

  //bouton suivant
  const handleNextClick = () => {
    setCurrentPage(currentPage + 1);
  };

  //bouton précédent
  const handlePreviousClick = () => {
    if (currentPage > 0) setCurrentPage(currentPage - 1);
  };
  // Gestionnaires pour le second ensemble de cartes
  const handleSecondNextClick = () => {
    setSecondPage(secondPage + 1);
  };

  const handleSecondPreviousClick = () => {
    if (secondPage > Math.floor((200 - 1) / cardsPerPage)) setSecondPage(secondPage - 1);
  };
  //sauvegarde des cartes
  const isCardSaved = (card) => {
    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    return savedCards.some(savedCard => savedCard.link === card.cards_images);
  };

  //bouton de sauvegarde des cartes
  const handleCardClick = (e, card) => {
    if (e && e.stopPropagation) {
      e.stopPropagation();
    }
    
    if (isCardSaved(card)) return;
  
    const cardData = {
      link: card.cards_images,
      name: card.name
    };
  
    const savedCards = JSON.parse(localStorage.getItem('savedCardLinks')) || [];
    savedCards.push(cardData);
    localStorage.setItem('savedCardLinks', JSON.stringify(savedCards));
  };

  //affiche le détail des cartes
  const openModal = (card) => {
    setSelectedCard(card);
    setIsModalOpen(true);
  };

  //ferme le détail des cartes
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
                    <label className="ui-bookmark">
                      
                    {isLoggedIn && (
                    <label className="ui-bookmark">
                      <input type="checkbox" checked={isCardSaved(card)} onChange={(e) => handleCardClick(e, card)} />
                      <div className="bookmark">
                        <svg className="contoursvg" viewBox="0 0 29 50">
                          <g>
                            <path d="M27 4v27a1 1 0 0 1-1.625.781L16 24.281l-9.375 7.5A1 1 0 0 1 5 31V4a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                          </g>
                        </svg>
                      </div>
                    </label>
                  )}

              </label>
                <p>{card.name}</p>

              </div>
              <div className="backSide" style={{ background: `url('${card.cards_images}') no-repeat center center / cover` }}>
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
          onSaveCard={handleCardClick}
        />
      )}
      <div className="center-buttons">
        <button className="bouton-prcedent" onClick={handlePreviousClick} disabled={currentPage === 0}>
          Précédent
        </button>
        <button className="bouton-suivant" onClick={handleNextClick}>
          Suivant
        </button>
      </div>
      <div className="bottom-image2"></div>  
      <div class="centered-div">
        <h2 class="impact-text">Notre équipe, composée de KONE Aboubakar, TONDEUR Sophie, VERSAYO Franklin et HARRE Morgane, a développé en seulement 4 jours une
         interface web dédiée à la gestion de cartes Yu-Gi-Oh!. Cette plateforme permet aux utilisateurs de créer leur compte, d'explorer une vaste bibliothèque de 
         cartes, de marquer leurs cartes préférées en tant que favoris de manière éphémère, et d'accéder à des informations détaillées sur chaque carte. L'interface 
         offre une expérience conviviale pour les fans de Yu-Gi-Oh!, simplifiant la gestion de leurs collections et favoris.</h2>
    </div>  
    <div className="bottom-image3"></div> 
    <div class="centered-div">
        <h2 class="impact-text">CARTE EXCLUSIVE</h2>
    </div>  
    <div className="article-container">
      {secondSetOfCards.map((card, index) => (
          <div className="myCard" key={index}>
            <div className="innerCard" onClick={() => openModal(card)}>
              <div className="frontSide" style={{ backgroundImage: `url('${back_x}')`, backgroundSize: '100% 100%' }}>
                <p className="title">Yu-Gi-Oh</p>
                    <label className="ui-bookmark">
                      
                    {isLoggedIn && (
                    <label className="ui-bookmark">
                      <input type="checkbox" checked={isCardSaved(card)} onChange={(e) => handleCardClick(e, card)} />
                      <div className="bookmark">
                        <svg className="contoursvg" viewBox="0 0 29 50">
                          <g>
                            <path d="M27 4v27a1 1 0 0 1-1.625.781L16 24.281l-9.375 7.5A1 1 0 0 1 5 31V4a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z"></path>
                          </g>
                        </svg>
                      </div>
                    </label>
                  )}

              </label>
                <p>{card.name}</p>

              </div>
              <div className="backSide" style={{ background: `url('${card.cards_images}') no-repeat center center / cover` }}>
              </div>

            </div>
          </div>
        ))}
      </div>
      <div className="center-buttons">
        <button className="bouton-prcedent" onClick={handleSecondPreviousClick} disabled={secondPage === Math.floor((200 - 1) / cardsPerPage)}>
          Précédent
        </button>
        <button className="bouton-suivant" onClick={handleSecondNextClick}>
          Suivant
        </button>
      </div>

      <footer class="footer">
  <div class="waves">
    <div class="wave" id="wave1"></div>
    <div class="wave" id="wave2"></div>
    <div class="wave" id="wave3"></div>
    <div class="wave" id="wave4"></div>
  </div>
  <ul class="social-icon">
  <li class="social-icon__item">
    <a class="social-icon__link" href="https://www.facebook.com/?locale=fr_FR">
      <img src={face} alt="Facebook" />
    </a>
  </li>
  <li class="social-icon__item">
    <a class="social-icon__link" href="https://twitter.com/?lang=fr">
      <img src={twitter} alt="Twitter" />
    </a>
  </li>
  <li class="social-icon__item">
    <a class="social-icon__link" href="https://www.youtube.com/">
      <img src={youtube} alt="Youtube" />
    </a>
  </li>
  <li class="social-icon__item">
    <a class="social-icon__link" href="https://www.instagram.com/">
      <img src={instagram} alt="Instagram" />
    </a>
  </li>
</ul>

  <ul class="menu">
  <li class="menu__item"><a class="menu__link" href="#">Home</a></li>
      <li class="menu__item"><a class="menu__link" href="#">About</a></li>
      <li class="menu__item"><a class="menu__link" href="#">Services</a></li>
      <li class="menu__item"><a class="menu__link" href="#">Team</a></li>
      <li class="menu__item"><a class="menu__link" href="#">Contact</a></li>
  </ul>
  <p>&copy;2023 Versayo,Kone,Sophie,Morgane | All Rights Reserved</p>
</footer>

    </div>
    
  );
}