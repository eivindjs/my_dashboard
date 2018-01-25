@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="6" rows="3">
    {{--twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a3"></twitter>
    <calendar position="b1:b2"></calendar>
    <music position="c1:d1"></music>
    <uptime position="b3"></uptime>

    <tasks team-member="alex" position="c2"></tasks>
    <tasks team-member="freek" position="d2"></tasks>
    <tasks team-member="seb" position="c3"></tasks>
    <tasks team-member="willem" position="d3"></tasks>
    --}}
    <yr position="a1"></yr>
    <calendar position="f2:f3"></calendar>
    <time-weather position="e1" date-format="ddd DD.MM.YYYY" time-zone="Europe/Oslo" weather-city="Levanger"></time-weather>
    <time-weather position="f1" date-format="ddd DD.MM.YYYY" time-zone="Europe/Oslo" weather-city="Trondheim"></time-weather>
    <!--<internet-connection></internet-connection>-->
</dashboard>

@endsection
