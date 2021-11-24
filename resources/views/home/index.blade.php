@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            Current Weather (API)
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td width="30%">Latitude</td>
                        <td width="70%" id="current-latitude">-</td>
                    </tr>
                    <tr>
                        <td width="30%">Longitude</td>
                        <td width="70%" id="current-longitude">-</td>
                    </tr>
                    <tr>
                        <td width="30%">Timezone</td>
                        <td width="70%" id="current-timezone">-</td>
                    </tr>
                    <tr>
                        <td width="30%">Pressure</td>
                        <td width="70%" id="current-pressure">-</td>
                    </tr>
                    <tr>
                        <td width="30%">Humidity</td>
                        <td width="70%" id="current-humidity">-</td>
                    </tr>
                    <tr>
                        <td width="30%">Wind Speed</td>
                        <td width="70%" id="current-wind-speed">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-header">
            Daily Weather (Database)
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="table-daily">
                <thead>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Timezone</th>
                    <th>Pressure</th>
                    <th>Humidity</th>
                    <th>Wind Speed</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    {{-- javascript --}}
                </tbody>
            </table>
            <div id="pagination-daily" class="float-right">
                {{-- javascript --}}
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getLocation()
        })

        getLocation = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                showMessage('failed', 'Browser tidak support / lokasi pada browser disabled')
            }
        }

        showPosition = async (position) => {
            showLoading(`Fetch API..`)
            await currentWeather(position)
            if (!Boolean({{ $isAlreadySync }})) await dailyWeather(position)
            await recursiveDaily(`{{ url('/home/table') }}`)
        }

        currentWeather = (position) => {
            sendRequest(`POST`, `{{ url('/json/currentWeather') }}`, {
                lat: position.coords.latitude,
                lon: position.coords.longitude
            }, true)
            .then(res => {
                if (res.status) {
                    Object.keys(res.data).forEach(key => {
                        document.getElementById(`${key}`).innerHTML = res.data[key]
                    });
                }
                else {
                    showMessage('failed', res.message)
                }
            })
            .catch(err => {
                showMessage('failed', 'Failed get Current Weather.')
            })
        }

        dailyWeather = (position) => {
            sendRequest(`POST`, `{{ url('/handleWeather') }}`, {
                lat: position.coords.latitude,
                lon: position.coords.longitude
            }, true)
            .then(res => {
                if (res.status) {
                    showMessage('success', res.message)
                }
                else {
                    showMessage('failed', res.message)
                }
            })
            .catch(err => {
                showMessage('failed', 'Failed get Daily Weather.')
            })
        }

        recursiveDaily = (url) => {
            showLoading(`Fetch Data..`)
            sendRequest(`GET`, url, {}, true)
            .then(res => {
                tableJson(`table-daily`, (table) => {
                    res.weathers.forEach((data, i) => {
                        const row   = table.insertRow(0)
                        const cell0 = row.insertCell(0)
                        const cell1 = row.insertCell(1)
                        const cell2 = row.insertCell(2)
                        const cell3 = row.insertCell(3)
                        const cell4 = row.insertCell(4)
                        const cell5 = row.insertCell(5)
                        const cell6 = row.insertCell(6)

                        cell0.innerHTML = data.latitude
                        cell1.innerHTML = data.longitude
                        cell2.innerHTML = data.timezone
                        cell3.innerHTML = data.pressure
                        cell4.innerHTML = data.humidity
                        cell5.innerHTML = data.wind_speed
                        cell6.innerHTML = `
                            <li>Weather API ID: ${data.weather_api_id}</li>
                            <li>Main: ${data.main}</li>
                            <li>Description: ${data.description}</li>
                        `
                    })
                })

                pagination(`pagination-daily`, res.pagination, url => {
                    recursiveDaily(url)
                })
            })
            .catch(err => {
                showMessage('failed', 'Failed get Daily Weather.')
            })
        }
    </script>
@endsection