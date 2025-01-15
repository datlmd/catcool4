import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-type'] = 'application/json';
window.axios.defaults.headers.common['Content-type'] = 'multipart/form-data';
