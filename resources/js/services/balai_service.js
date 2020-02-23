import {http, httpFile} from './http_service';

export function createBalai(data) {
    return httpFile().post('/balai', data);
}

export function loadDtbalai() {
    return http().get('/balai');
}

export function deleteBalai(id) {
    return http().delete(`balai/${id}`);
}

export function updateBalai(id, data) {
    return httpFile().post(`balai/${id}`,data);
}
