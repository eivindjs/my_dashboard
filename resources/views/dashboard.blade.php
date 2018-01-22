@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'pusherCluster', 'usingNodeServer'))

<dashboard id="dashboard" columns="6" rows="3">
   {{--}} <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a3"></twitter>
    <uptime position="a1:a3"></uptime>
    <packagist position="b1"></packagist>
    <npm position="b2"></npm>
    <github position="b3"></github>
    <music position="c1:d1"></music>
    <tasks team-member="alex" position="c2"></tasks>
    <tasks team-member="brent" position="d2"></tasks>
    <tasks team-member="freek" position="e2"></tasks>
    <tasks team-member="harish" position="c3"></tasks>
    <tasks team-member="seb" position="d3"></tasks>
    <tasks team-member="willem" position="e3"></tasks>--}}
    <uptime position="a1:a3"></uptime>
    <calendar position="f2:f3"></calendar>
    <time-weather position="e1" date-format="ddd DD.MM.YYYY" time-zone="Europe/Oslo" weather-city="Levanger"></time-weather>
    <time-weather position="f1" date-format="ddd DD.MM.YYYY" time-zone="Europe/Oslo" weather-city="Trondheim"></time-weather>
    <internet-connection></internet-connection>
</dashboard>

@endsection
