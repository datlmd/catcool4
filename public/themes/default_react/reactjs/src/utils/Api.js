import axios from 'axios';

const API = axios.create({
    baseURL: 'https://localhost:8443/dev/catcool4/public/',
    responseType: 'json',
});

const getRequestConfiguration = (authorization) => {
    const headers = {
        'Content-Type': 'application/json',
    };
    if (authorization) headers.Authorization = `Bearer ${authorization}`;
    return { headers };
};

export const makeRequest = ({
                                url,
                                values,
                                successCallback,
                                failureCallback,
                                requestType = 'POST',
                                authorization = null,
                            }) => {
    
    const requestConfiguration = getRequestConfiguration(authorization);
    let promise;
   
    switch (requestType) {
        case 'GET':
            promise = API.get(url, requestConfiguration);
            break;
        case 'POST':
            promise = API.post(url, values, requestConfiguration);
            break;
        case 'DELETE':
            promise = API.delete(url, requestConfiguration);
            break;
        default:
            return;
    }
   
    promise
        .then((response) => {
            const { data } = response;
            successCallback(data);
        })
        .catch((error) => {
            if (error.response) {
                failureCallback(error.response.data);
            }
        });
};
