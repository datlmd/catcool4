{strip}
	{if !empty($weather.name)}
		<div class="btn-group text-secondary">
			<div id="dropdown_weather" data-bs-toggle="dropdown" aria-expanded="false">
				<span class="m-0 text-center d-inline">{$weather.name}</span>
				<img src="http://openweathermap.org/img/w/{$weather.weather[0].icon}.png" width="30" alt="Weather" />
				<span>{round($weather.main.temp)}°C</span>

			</div>
			<i class="fas fa-angle-down pt-2 ps-2" data-bs-toggle="dropdown" aria-expanded="false"></i>
			<div class="dropdown-menu text-end p-2">
				<strong>{ucwords($weather.weather[0].description)}</strong><br/>
				<span>Nhiệt độ: <strong>{$weather.main.temp}°C</strong></span><br/>
				<span>Độ ẩm: <b>{$weather.main.humidity}%</b></span><br/>
				<span>Sức gió: <b>{$weather.wind.speed} km/h</b></span>

				<span style="display: none;">{$weather.getloc}</span>
			</div>
		</div>
	{/if}
{/strip}
