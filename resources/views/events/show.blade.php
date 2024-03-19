@extends('layouts.main')

@section('title', $event->title)

@section('content')
<div class="col-md-10 offset-md-1">
    <div class="row">
        <div id="image-container" class="col-md-6">
            <div class="info-container col-md-6 show-event-image-container">
                <img src='/assets/events/{{$event->image}}' alt={{ $event->title }} class='img-fluid show-event-image'>
            </div>
        </div>
        <div id="info-container" class="col-md-6">
            <div class="event-info">
                <h2 class="show-event-title">{{ $event->title }}</h1>
                <p class="event-city"><ion-icon class='location-outline'></ion-icon> {{ $event->city }}</p>
                <p class="events-participants"><ion-icon class='people-outline'></ion-icon>{{count($event->users)}} - participantes</p>
                <p class="event-owner"><ion-icon class='star-outline'></ion-icon>{{ $eventOwner['name'] }}</p>
                @if ($hasUserJoined === false) 
                    <form action="/events/join/{{$event->id}}" method="POST">
                        @csrf
                        <a href="/events/join/{{$event->id}}" class="btn btn-primary" id='event-submit' onclick="event.preventDefault();this.closest('form').submit();">Confirmar Presença</a>
                    </form> 
                @else
                    <p class="already-joined-msg">Você já está participando deste evento!</p>
                @endif
            </div>
            <div class="col-md-12" id="description-container">
                <h3 class="event-show about-event-subtitle">Sobre o evento: </h3>
                <p class="event-description">{{$event->description}}</p>
            </div>
            <div class="structure-container">
                <h3>O evento conta com: </h3>
                @foreach ($event->items as $item)
                    <p class="show-event-has-items">{{$item}}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection