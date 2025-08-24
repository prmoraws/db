
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

// Importa as imagens dos ícones
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

// Corrige o problema dos ícones que não aparecem
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

// Torna o 'L' do Leaflet acessível globalmente
window.L = L;



import './bootstrap';
import Chart from 'chart.js/auto';
window.Chart = Chart;

import generatePdf from './politica/pdf-generator.js';
window.generatePdf = generatePdf; // Torna a função acessível globalmente para o Alpine.js
