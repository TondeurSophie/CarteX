export default function Deconnexion() {
  //vider le localStorage
  localStorage.clear();
  window.location.reload()
  window.location.href = './';

}