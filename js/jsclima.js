document.getElementById('city').addEventListener('input', function () {
    var city = this.value;
    obtenerClima(city);
});

async function obtenerClima() {
    try {
        var city = document.getElementById('city').value;
        console.log('Tandil:', city);

        const response = await axios.get('https://api.openweathermap.org/data/2.5/forecast', {
            params: {
                q: city,
                appid: 'b1a519fdb6566e96051641bd9720b887',
                units: 'metric'
            },
        });
        const currentTemperature = response.data.list[0].main.temp;

        document.querySelector('.weather-temp').textContent = Math.round(currentTemperature) + 'ºC';

        const forecastData = response.data.list;

        const dailyForecast = {};
        forecastData.forEach((data) => {
            const day = new Date(data.dt * 1000).toLocaleDateString('es-ES', { weekday: 'long' });
            if (!dailyForecast[day]) {
                dailyForecast[day] = {
                    minTemp: data.main.temp_min,
                    maxTemp: data.main.temp_max,
                    description: data.weather[0].description,
                    humidity: data.main.humidity,
                    windSpeed: data.wind.speed,
                    icon: data.weather[0].icon,
                };
            } else {
                dailyForecast[day].minTemp = Math.min(dailyForecast[day].minTemp, data.main.temp_min);
                dailyForecast[day].maxTemp = Math.max(dailyForecast[day].maxTemp, data.main.temp_max);
            }
        });

        document.querySelector('.date-dayname').textContent = new Date().toLocaleDateString('es-ES', { weekday: 'long' });

        const date = new Date().toUTCString();
        const extractedDateTime = date.slice(5, 16);
        document.querySelector('.date-day').textContent = extractedDateTime;

        const currentWeatherIconCode = dailyForecast[new Date().toLocaleDateString('es-ES', { weekday: 'long' })].icon;
        const weatherIconElement = document.querySelector('.weather-icon');
        weatherIconElement.innerHTML = obtenerIconoClima(currentWeatherIconCode);

        document.querySelector('.location').textContent = response.data.city.name;
        document.querySelector('.weather-desc').textContent = dailyForecast[new Date().toLocaleDateString('es-ES', { weekday: 'long' })].description.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

        document.querySelector('.humidity .value').textContent = dailyForecast[new Date().toLocaleDateString('es-ES', { weekday: 'long' })].humidity + ' %';
        document.querySelector('.wind .value').textContent = dailyForecast[new Date().toLocaleDateString('es-ES', { weekday: 'long' })].windSpeed + ' m/s';

        const dayElements = document.querySelectorAll('.day-name');
        const tempElements = document.querySelectorAll('.day-temp');
        const iconElements = document.querySelectorAll('.day-icon');

        dayElements.forEach((dayElement, index) => {
            const day = Object.keys(dailyForecast)[index];
            const data = dailyForecast[day];
            if (data) {
                dayElement.textContent = day;
                tempElements[index].textContent = `${Math.round(data.minTemp)}º / ${Math.round(data.maxTemp)}º`;
                iconElements[index].innerHTML = obtenerIconoClima(data.icon);
            }
        });

    } catch (error) {
        console.error('Error al obtener los datos:', error.message);
    }
}

function obtenerIconoClima(iconCode) {
    const iconBaseUrl = 'https://openweathermap.org/img/wn/';
    const iconSize = '@2x.png';
    return `<img src="${iconBaseUrl}${iconCode}${iconSize}" alt="Icono del clima">`;
}

// Llamar a obtenerClima al cargar la página
document.addEventListener("DOMContentLoaded", function () {
    obtenerClima();
    // Actualizar cada 15 minutos
    setInterval(obtenerClima, 900000); // 900000 milisegundos = 15 minutos
});