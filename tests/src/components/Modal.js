import React from 'react';
import '../styles/Modal.css';

const Modal = ({ isOpen, onClose, card, onSaveCard }) => {
  if (!isOpen || !card) return null;

  const cardImageUrl = card.cards_images ? card.cards_images : '';

  const handleSaveClick = () => {
    onSaveCard(null, card); // Call the onSaveCard function from Accueil
    onClose(); // Close the modal
  };

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
          <button className="button_save" onClick={handleSaveClick}>
            Save
          </button>
        </div>
      </div>
    </div>
  );
};

export default Modal;