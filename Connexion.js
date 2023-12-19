document.getElementById('connexionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const mail = document.getElementById('mail').value;
    const mdp = document.getElementById('mdp').value;

    fetch('http://localhost:3020/api/connexion', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ mail, mdp }), // Modification ici
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Erreur de connexion : ' + data.error);
        } else {
            alert('Connexion réussie');
        }
    })
    .catch((error) => {
        console.error('Erreur:', error);
    });
});
