import './App.css'; //relie cette page au css App.css
import { Routes, Route, Link } from 'react-router-dom'; //permet l'utilisation de routes

import Accueil from './components/Accueil.js';
import Connexion from './components/Connexion.js';
import Inscription from './components/Inscription.js';


function App() {
  return (

    <div>
    <div className="App">
      
      <Link to="/">Accueil</Link>
      <Link className="button" to="/connexion">Connexion</Link>
      <Link className="button" to="/inscription">Inscription</Link>
      
    </div>
    <Routes>     
        {/* <Route exact path="/" component={<Accueil/>} /> */}

        {/* permt la naviguation */}
        <Route path="/"           element={<Accueil/>}/>
        
        <Route path="/connexion/*"  element={<Connexion/>} />
        <Route path="/inscription"      element={<Inscription/>} />
    </Routes>
    </div>
  );
}

export default App;
