import React, { useEffect, useState } from 'react';
import back_x from "../image/images.jpg";

export default function Save() {
  const [savedCardonLink, setSavedCardonLink] = useState("");

  useEffect(() => {
    // Récupérer le contenu du local storage
    const storedCardonLink = localStorage.getItem('selectedCardonLink');
    
    if (storedCardonLink) {
      setSavedCardonLink(storedCardonLink);
    }
  }, []);

  return (
    <div className='full-page-div'>
      <div className="bottom-image"></div>
      <div className="article-container">
        <div className="myCard">
          <div className="innerCard">
            <div className="frontSide" style={{ backgroundImage: `url('${back_x}')`, backgroundSize: '100% 100%' }}>
              <p className="title">Yu-Gi-Oh</p>
              <p>Saved Card Link:</p>
              <p>{savedCardLink}</p>
            </div>
            <div className="backSide" style={{ background: `url('${savedCardLink}')`, backgroundSize: '100% 100%' }}>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
