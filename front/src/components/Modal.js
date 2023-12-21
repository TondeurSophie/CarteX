import React from 'react';
import '../styles/Modal.css';

const Modal = ({ isOpen, onClose, card }) => {
  if (!isOpen || !card) return null;

  const cardImageUrl = card.cards_images ? card.cards_images : '';

  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <div className="modal-header">
          <button onClick={onClose}></button>
        </div>
        <div className="modal-body">
          <div className="card-image">
            <img src={cardImageUrl} alt={card.name} />
          </div>
          <div className="card-info">
            <h2>{card.name}</h2>
            <p>Type: {card.type}</p>
            <p>Description: {card.description}</p>
            <p>Race: {card.race}</p>
            <p>Archetype: {card.archetype}</p>
            <p>Price: {card.cards_price}</p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Modal;