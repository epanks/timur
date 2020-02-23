import {http, httpFile} from './http_service';

export function createPaket(data) {
    return httpFile().post('/paket', data);
}

export function loadDtpaket() {
    return http().get('/paket');
}

export function deletePaket(id) {
    return http().delete(`paket/${id}`);
}

export function updatePaket(id, data) {
    return httpFile().post(`paket/${id}`,data);
}
