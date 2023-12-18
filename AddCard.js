// AddCard.js
async function addCard(cardData) {
    try {
        const response = await fetch('http://localhost:3008/api/cartes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(cardData),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Card added successfully:', data);
    } catch (error) {
        console.error('Error adding card:', error);
    }
}

// Exemple d'utilisation
const newCard = {
    name: "Nom de la Carte",
    type: "Type de la Carte",
    desc: "Description de la Carte",
};

addCard(newCard);
