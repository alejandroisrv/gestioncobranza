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
    }).interceptors.response.use(function(response) {
        return response
    }, function(error) {
        console.log(error.response.data)
        if (error.response.data.error.statusCode === 401) {
            window.location.href = "/login";
        }
        return Promise.reject(error)
    })
}