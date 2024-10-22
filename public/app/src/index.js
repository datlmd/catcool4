import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import LikeButton from './Likebutton';
import reportWebVitals from './reportWebVitals';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <LikeButton />
    <App />
  </React.StrictMode>
);

// let domContainer = document.querySelector('#root');
// ReactDOM.render(<LikeButton />, domContainer);

//<React.StrictMode>
    //<LikeButton />
  //</React.StrictMode>

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
