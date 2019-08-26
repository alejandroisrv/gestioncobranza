import axios from 'axios'
import { loadProgressBar } from 'axios-progress-bar'

export default () => {
    let auth = JSON.parse(localStorage.getItem('auth'));
    return axios.create({
        baseURL: `/api/`,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + auth.api_token
        }
    })
}