<?php
session_start();
if (empty($_SESSION['username'])) {
	header("Location:login.php?pesan=belum_login");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bengkelku</title>

	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

	<!-- leaflet routing machine -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

	<!-- leaflet locate -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>


	<style>
		html,
		body {
			height: 100%;
			margin: 0;
		}

		.leaflet-container {
			height: 400px;
			width: 600px;
			max-width: 100%;
			max-height: 100%;
		}

		.nav-link.text-center,
		.btn.text-center {
			display: flex;
			align-items: center;
			justify-content: center;
			height: 100%;
			/* Pastikan item menyesuaikan tinggi */
		}
	</style>

	<!-- local css -->
	<link rel="stylesheet" href="assets/css/style.css">

	<!-- bootstrap css -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>

<body class="content">
	<!-- leaflet js locate -->
	<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.79.0/dist/L.Control.Locate.min.js" charset="utf-8"></script>

	<!-- leaflet js routing machine -->
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

	<nav class="navbar navbar-expand-lg bg-orange border-bottom" style="background-color: #FF8800; border-color: #cc6f00;">
		<div class="container-fluid">
			<a class="navbar-brand text-center fw-bold" href="index.php" style="color: #FFff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); text-align: center;">
				MENU
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="border-color: #FFD700;">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link text-yellow fw-bold text-center" href="motor.html" style="color: #FFff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);">
							Motor
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-yellow fw-bold text-center" href="mobil.html" style="color: #FFff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);">
							Mobil
						</a>
					</li>
				</ul>
				<a class="btn btn-danger btn-lg fw-bold text-center" href="logout.php" style="background-color: #FF2929; border: none; color: #fff;">
					Logout
				</a>
			</div>
		</div>
	</nav>


	<center>
		<div id="map" style="width: 1600px; height: 650px;"></div>
	</center>

	<script>
		// Peta dasar
		const map = L.map('map').setView([-7.782274292480382, 110.41588778862362], 17);
		L.control.locate().addTo(map);

		const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);

		// API Key OpenWeatherMap
		const apiKey = "00471c88ff9f8d3fd25a47f532b36aa7"; // Ganti dengan API Key Anda

		// Fungsi untuk mendapatkan cuaca
		const getWeather = (lat, lng) => {
			const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=${apiKey}&units=metric`;
			return fetch(url)
				.then(response => response.json())
				.catch(error => console.error("Gagal mengambil data cuaca:", error));
		};

		// Marker lokasi bengkel
		const markers = [{
				lat: -7.780470,
				lng: 110.415613,
				name: 'Bengkel Motor Jogja',
				category: 'motor'
			},
			{
				lat: -7.779699,
				lng: 110.408605,
				name: 'Surya Ambarukmo Motor',
				category: 'motor'
			},
			{
				lat: -7.773397,
				lng: 110.414583,
				name: 'Rubenk Motor Panggilan Jogja',
				category: 'motor'
			},
			{
				lat: -7.775782,
				lng: 110.406005,
				name: 'Jaya Baru Motor',
				category: 'motor'
			},
			{
				lat: -7.777695,
				lng: 110.416390,
				name: 'Bengkel Motor Jogja R-TECH',
				category: 'motor'
			},
			{
				lat: -7.783138,
				lng: 110.410624,
				name: 'Motor Budi Jaya',
				category: 'motor'
			},
			{
				lat: -7.782905,
				lng: 110.399670,
				name: 'Muda Jaya Motor',
				category: 'motor'
			},
			{
				lat: -7.775474,
				lng: 110.408733,
				name: 'Bengkel Timur Jaya Motor',
				category: 'motor'
			},
			{
				lat: -7.770882,
				lng: 110.409119,
				name: 'Bengkel Purnomo Motor',
				category: 'motor'
			},
			{
				lat: -7.774581,
				lng: 110.404870,
				name: 'Wahyu Motor',
				category: 'motor'
			},
			{
				lat: -7.782907,
				lng: 110.417287,
				name: 'SERVICE MOBIL RESMI SUZUKI SBAM',
				category: 'mobil'
			},
			{
				lat: -7.783064,
				lng: 110.413466,
				name: 'Service Sepion Lampu Mobil janti',
				category: 'mobil'
			},
			{
				lat: -7.783483,
				lng: 110.409194,
				name: 'Bengkel Mobil Honda',
				category: 'mobil'
			},
			{
				lat: -7.773959,
				lng: 110.416107,
				name: 'Babarsari Auto Service Bengkel',
				category: 'mobil'
			},
			{
				lat: -7.783518413990467,
				lng: 110.41795896085854,
				name: 'Setiawan Spooring Janti',
				category: 'mobil'
			},
		];

		// Tambahkan marker
		const mobilIcon = L.icon({
			iconUrl: 'assets/img/car3.png',
			iconSize: [38, 38],
			iconAnchor: [19, 38],
			popupAnchor: [0, -38]
		});

		const motorIcon = L.icon({
			iconUrl: 'assets/img/motor.png',
			iconSize: [38, 38],
			iconAnchor: [19, 38],
			popupAnchor: [0, -38]
		});

		markers.forEach(marker => {
			const icon = marker.category === 'motor' ? motorIcon : mobilIcon;
			L.marker([marker.lat, marker.lng], {
					icon: icon
				})
				.addTo(map)
				.bindPopup(`<b>${marker.name}</b>`);
		});


		// Geolokasi pengguna
		map.locate({
			setView: true,
			maxZoom: 16
		});

		map.on('locationfound', function(e) {
			const userLocation = L.marker(e.latlng).addTo(map)
				.bindPopup('Lokasi Anda').openPopup();

			// Ambil cuaca untuk lokasi pengguna
			getWeather(e.latlng.lat, e.latlng.lng).then(data => {
				const weatherInfo = `
					<b>Cuaca:</b> ${data.weather[0].description}<br>
					<b>Suhu:</b> ${data.main.temp}°C<br>
					<b>Angin:</b> ${data.wind.speed} m/s
				`;
				L.popup()
					.setLatLng(e.latlng)
					.setContent(weatherInfo)
					.openOn(map);
			});

			// Event klik untuk lokasi target dan cuaca
			map.on('click', function(event) {
				L.Routing.control({
					waypoints: [
						L.latLng(e.latlng.lat, e.latlng.lng), // Lokasi pengguna
						L.latLng(event.latlng.lat, event.latlng.lng) // Klik lokasi target
					]
				}).addTo(map);

				// Ambil cuaca untuk lokasi yang diklik
				getWeather(event.latlng.lat, event.latlng.lng).then(data => {
					console.log(data);

					const weatherInfo = `
						<b>Lokasi:</b> (${event.latlng.lat.toFixed(2)}, ${event.latlng.lng.toFixed(2)})<br>
						<b>Cuaca:</b> ${data.weather[0].description}<br>
						<b>Suhu:</b> ${data.main.temp}°C<br>
						<b>Angin:</b> ${data.wind.speed} m/s
					`;
					L.popup()
						.setLatLng(event.latlng)
						.setContent(weatherInfo)
						.openOn(map);
				});
			});
		});

		// Geolokasi gagal
		map.on('locationerror', function(e) {
			alert(`Tidak dapat menemukan lokasi Anda: ${e.message}`);
		});
	</script>

	<!-- moving letter js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>

	<!-- bootstrap js -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

	<!-- local js -->
	<script src="assets/js/script.js"></script>
</body>

</html>