import React, {useState} from 'react';
import {clearState, loadJWT} from './utils/LocalStorage';
import Authentication from './components/authentication/Authentication';
import Dashboard from './components/restricted/dashboard/Index';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';

const Root = () => {
    const [isAuthenticated, setIsAuthenticated] = useState(!!loadJWT());

    const onLogin = () => {
        setIsAuthenticated(true);
    };

    const onLogout = () => {
        clearState();
        setIsAuthenticated(false);
    };

    return !isAuthenticated ?
        <Authentication
            setIsAuthenticated={onLogin}
        />
        :
        <Dashboard
            logout={onLogout}
        />;
};

function App() {
  return (
    <Root />
  );
}

export default App;
