{strip}
	{if !empty($weather.name)}
		<div class="text-start mb-4 p-3 text-dark border-bottom">

			<div data-bs-toggle="collapse" href="#collapse_weather" role="button" aria-expanded="false" aria-controls="collapse_weather">
				<h4 class="m-0 text-center text-dark d-inline">{$weather.name}</h4>
				<img src="http://openweathermap.org/img/w/{$weather.weather[0].icon}.png" width="50" alt="Weather" />
				<strong>{$weather.main.temp}°C</strong>
			</div>
			<div class="collapse" id="collapse_weather">

				<strong>{ucwords($weather.weather[0].description)}</strong><br/>
				<span>Nhiệt độ: <strong>{$weather.main.temp}°C</strong></span><br/>
				<span>Độ ẩm: <b>{$weather.main.humidity}%</b></span><br/>
				<span>Sức gió: <b>{$weather.wind.speed} km/h</b></span>

				</div>
			</div>


		</div>

	{/if}
{/strip}
