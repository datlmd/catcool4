import React from 'react';
import {Spinner} from 'react-bootstrap/Spinner';

const LoadingAlert = () => {
    return (
        <div className='centredDiv'>
            <Spinner size='lg' type='grow' color='dark'/>
        </div>
    );
};

export default LoadingAlert;
