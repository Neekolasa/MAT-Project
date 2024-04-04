function actualizarReloj() {
  const durangoTimeZone = 'America/Monterrey'; // Zona horaria de Durango, México
  const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
  const horaActual = new Date().toLocaleTimeString('es-MX', options);
  
  document.getElementById('time').textContent = horaActual;
}

// Actualizar el reloj cada segundo
setInterval(actualizarReloj, 1000); 