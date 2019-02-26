import Places from 'places.js'
import Map from './modules/map'

const $ = require('jquery');

require('select2');
require('../css/app.css');
require('select2/dist/css/select2.css');

Map.init()

let inputAddress = document.querySelector('#customer_adress')
if (inputAddress !== null) {
    let place = Places({
        container: inputAddress
    })
    place.on('change', e => {
        document.querySelector('#customer_city').value = e.suggestion.city
        document.querySelector('#customer_postal_code').value = e.suggestion.postcode
        document.querySelector('#customer_lat').value = e.suggestion.latlng.lat
        document.querySelector('#customer_lng').value = e.suggestion.latlng.lng
    })
}

let searchAddress = document.querySelector('#search_address')
if (searchAddress !== null) {
    let place = Places({
        container: searchAddress
    })
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat
        document.querySelector('#lng').value = e.suggestion.latlng.lng
    })
}

$('select').select2();