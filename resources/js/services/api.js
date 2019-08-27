import axios from 'axios'
import { loadProgressBar } from 'axios-progress-bar'
let auth = JSON.parse(localStorage.getItem('auth'));

const api = axios.create({
    baseURL: `/api/`,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + auth.api_token
    }
});

api.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        window.location.href = "/auth/logout";
    }
    return error;
});

export default () => {
    return api
}