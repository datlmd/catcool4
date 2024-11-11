import axios from 'axios';

type RequestType = "GET" | "POST" | "PUT" | "DELETE";

export const API = axios.create({
  baseURL: process.env.HOST ? process.env.HOST : window.base_url,
  responseType: 'json',
  headers: {
    "Content-type": "application/json",
    "X-Requested-With": "XMLHttpRequest"
  }
});

export const getRequestToken = (authorization?: string) => {
  if (!authorization) return;

  const headers = {
      'Authorization': `Bearer ${authorization}`,
  };
  
  return { headers };
};

export const makeRequest = ({
                              url,
                              values = null,
                              successCallback,
                              failureCallback,
                              requestType = 'POST',
                              authorization = "",
                            }: {
                              url: string,
                              values?: any,
                              successCallback?: any,
                              failureCallback?: any,
                              requestType?: RequestType,
                              authorization?: string,
                            }) => {
    
  const requestConfiguration = getRequestToken(authorization);
  let promise;
  
  switch (requestType) {
    case 'GET':
      promise = API.get(url, requestConfiguration);
      break;
    case 'POST':
    case 'PUT':
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
      console.log(error);
      if (error.response) {
          failureCallback(error.response.data);
      }
    });
};
