import React from 'react';
import Alert from 'react-bootstrap/Alert';

const SuccessAlert = ({
                          message,
                          onTimeout
                      }) => {

    setTimeout(onTimeout, 4000);

    return (
        <div style={{margin: '20px'}}>
            <UncontrolledAlert color='success'>
                {message}
            </UncontrolledAlert>
        </div>
    )
}

export default SuccessAlert;
