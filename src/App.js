import './App.css';
import { Routes, Route, Link } from 'react-router-dom';
import SignInImage from './images/signin.png';
import logo from "./images/Yu-Gi-Oh.png";
import save from "./images/save.png";
import Accueil from './components/Accueil.js';
import Connexion from './components/Connexion.js';
import Deconnexion from './components/Deconnexion.js';
import Inscription from './components/Inscription.js';
import Profil from './components/Profil.js';
import Save from './components/Save.js';


function App() {
  return (
    <div>
      <nav className="navbar">
        <div className="navbar-logo">
          <Link to="/">
            <img src={logo} alt="Logo" />
          </Link>
        </div>
        
        <div className="search_div">
          <input className="checkbox" type="checkbox" />
          <div className="mainbox">
            <div className="iconContainer">
              <svg
                viewBox="0 0 512 512"
                height="1em"
                xmlns="http://www.w3.org/2000/svg"
                className="search_icon"
              >
                <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
              </svg>
            </div>
            <input className="search_input" placeholder="rechercher" type="text" />
          </div>
        </div>
        <div className="navbar-buttons">
          <Link to="save">
            <img src={save} alt="save" />
          </Link>
          <Link to="connexion">
            <img src={SignInImage} alt="Utilisateur" />
          </Link>
          <Link to="profil">
          <button type="button" class="btn_compte">Mon Compte</button></Link>
        </div>
      </nav>
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/connexion/*" element={<Connexion />} />
        <Route path="/inscription" element={<Inscription />} />
        <Route path="/profil" element={<Profil />} />
        <Route path="/save" element={<Save/>} />
        <Route path="/deconnexion" element={<Deconnexion />} />
      </Routes>
    </div>
  );
}

export default App;