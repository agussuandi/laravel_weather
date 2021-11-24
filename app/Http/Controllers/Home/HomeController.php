<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use AppHelper;
use Exception;

use App\Models\Home\MWeather;
use App\Models\Home\MWeatherDetail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try
        {
            $dateNow = date('Y-m-d');
            $mWeather = MWeather::whereDate('created_at', $dateNow)
                ->orderBy('id', 'DESC')
            ->first();

            return view('home.index', [
                'isAlreadySync' => $mWeather ? true : false
            ]);
        }
        catch (Exception $e)
        {
            dd($e->getMessage());
        }
    }

    public function currentWeather(Request $request)
    {
        try
        {
            $weather = AppHelper::getWeather($request->lat, $request->lon);
            $weather = json_decode($weather['response']);
            $objKey = [
                'current-latitude'   => $request->lat,
                'current-longitude'  => $request->lon,
                'current-timezone'   => $weather->timezone,
                'current-pressure'   => $weather->current->pressure,
                'current-humidity'   => $weather->current->humidity,
                'current-wind-speed' => $weather->current->wind_speed
            ];

            return response()->json([
                'status' => true,
                'data'   => $objKey
            ]);
        }
        catch (Exception $e)
        {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function handleWeather(Request $request)
    {
        try
        {
            $weather  = AppHelper::getWeather($request->lat, $request->lon);
            $weather  = json_decode($weather['response']);
            $timezone = $weather->timezone;

            DB::beginTransaction();
            foreach ($weather->daily as $keyWeather => $valWeather)
            {
                $mWeather               = new MWeather;
                $mWeather->latitude     = $request->lat;
                $mWeather->longitude    = $request->lon;
                $mWeather->timezone     = $timezone;
                $mWeather->dt           = $valWeather->dt;
                $mWeather->pressure     = $valWeather->pressure;
                $mWeather->humidity     = $valWeather->humidity;
                $mWeather->wind_speed   = $valWeather->wind_speed;
                $mWeather->created_by   = Auth::user()->id;
                $mWeather->created_at   = date('Y-m-d H:i:s');
                $mWeather->save();

                foreach ($valWeather->weather as $keyDetail => $valDetail)
                {
                    $mWeatherDetail                   = new MWeatherDetail;
                    $mWeatherDetail->weather_id       = $mWeather->id;
                    $mWeatherDetail->weather_api_id   = $valDetail->id;
                    $mWeatherDetail->main             = $valDetail->main;
                    $mWeatherDetail->description      = $valDetail->description;
                    $mWeatherDetail->created_by       = Auth::user()->id;
                    $mWeatherDetail->created_at       = date('Y-m-d H:i:s');
                    $mWeatherDetail->save();
                }
            }
            DB::commit();
            
            return response()->json([
                'status'  => true,
                'message' => 'Success get Daily Weather'
            ]);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function table(Type $var = null)
    {
        $dataWeather = DB::table('m_weather as a')
            ->selectRaw('a.*,
                (select group_concat(main) from m_weather_detail where weather_id = a.id) as main,
                (select group_concat(description) from m_weather_detail where weather_id = a.id) as description,
                (select group_concat(weather_api_id) from m_weather_detail where weather_id = a.id) as weather_api_id
            ')
        ->paginate(10);
        
        return response()->json([
            'weathers'   => $dataWeather->items(),
            'pagination' => (string) $dataWeather->onEachSide(1)->links()
        ]);
    }
}