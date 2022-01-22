<?php
function sendRequest($w, $params){
    $url = "https://api.openweathermap.org/data/2.5/{$w}?";
    foreach ($params as $key=>$value){
        $url .= $key.'='.$value.'&';
    }
    $url .= 'appid=037308f261eee19e33817488249dee46&units=metric';
    return json_decode(file_get_contents($url), true);
}


function weather($w){
    global $lang;

    $tempAvg = (int) $w['main']['temp'];
    $tempMin = (int) $w['main']['temp_min'];
    $tempMax = (int) $w['main']['temp_max'];
    $humidty = (int) $w['main']['humidity'];
    $wind = $w['wind']['speed'];
    $cloud = $w['clouds']['all'];


    if($tempMin == $tempMax && $tempMin>0){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	+{$tempAvg}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }elseif(($tempMin == $tempMax && $tempMin < 0) || $tempMin == $tempMax){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	{$tempAvg}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }
    elseif($tempMin>0){

        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	+{$tempAvg}°C
    ☀️ {$lang['texts']['dailytemp']} +{$tempMin} .. +{$tempMax}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }elseif($tempMin == 0 && $tempAvg>0){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	+{$tempAvg}°C
    ☀️ {$lang['texts']['dailytemp']} {$tempMin} .. +{$tempMax}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }elseif ($tempAvg == 0 && $tempMax>0){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	{$tempAvg}°C
    ☀️ {$lang['texts']['dailytemp']} {$tempMin} .. +{$tempMax}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }elseif ($tempMax == 0 && $tempMin== 0){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	{$tempAvg}°C
    ☀️ {$lang['texts']['dailytemp']} {$tempMax}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }elseif ($tempMax == 0 && $tempAvg<0){
        $m = "
        🗓  {$lang['texts']['info']}  
    ☀️ {$lang['texts']['avgtemp']}	{$tempAvg}°C
    ☀️ {$lang['texts']['dailytemp']} {$tempMin} .. {$tempMax}°C
    ☁️ {$lang['texts']['clouds']} {$cloud}%
    🌬  {$lang['texts']['wind']}	{$wind} m/s
    🌫  {$lang['texts']['humidty']}	{$humidty}%
";
    }

    return $m;
}
