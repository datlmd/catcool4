import { useState } from 'react';
import { API } from '../src/utils/callApi';

export function contentContact() {
    const result = API.get('frontend/api/contact').then((response) => {
        return response.data;
     }).catch((error) => {
        console.log(error);
     });

    return result;
}
