{strip}
	{if !empty($weather.name)}
		<div class="text-start mb-4 p-3 bg-success text-white border rounded">
			<h4 class="m-0 text-center text-white">{$weather.name}</h4>
			<img src="http://openweathermap.org/img/w/{$weather.weather[0].icon}.png" width="50" alt="Weather" />
			<strong>{$weather.main.temp}°C</strong><br/>
			<strong>{ucwords($weather.weather[0].description)}</strong><br/>
			<span>Độ ẩm: {$weather.main.humidity}%</span><br/>
			<span>Sức gió: {$weather.wind.speed} km/h</span>
		</div>

	{/if}
{/strip}
