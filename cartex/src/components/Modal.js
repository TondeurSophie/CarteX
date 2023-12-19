import React from 'react';
import '../styles/Modal.css'; // Assurez-vous d'importer le fichier CSS

const Modal = ({ isOpen, onClose, card }) => {
  if (!isOpen || !card) return null;

  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <div className="modal-header">
          <button onClick={onClose}>Close</button>
        </div>
        <div className="modal-body">
          <div className="card-image">
            <img src={card.card_images[0].image_url} alt={card.name} />
          </div>
          <div className="card-info">
            <h2>{card.name}</h2>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Modal;
