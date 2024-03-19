@extends('layouts.main')

@section('content')

<div class="show-events-container">

<div id="search-container" class='col-md-12'>

    <h1>Busque um evento</h1>
    <form action="/" method="GET">
        <input type="text" id='search' name='search' class='form-control' placeholder="Procurar...">
    </form>
</div>

<div id="event-container" class="col-md-12">

        @if($search)
        <h2 class="event-container-title">Buscando por: "{{$search }}"</h2>
        @else
        <h2 class="event-container-title">Próximos eventos</h2>
        <p class="event-container-subtitle">Veja os eventos dos próximos dias</p>
        @endif 
    
    <div id="cards-container" class="row">
        @foreach ($events as $event)
            <div class="card card-section col-md-3">
                <img src='/assets/events/{{ $event->image }}' alt={{$event->title}} class='event-placeholder-image' onclick='(window.location="/events/{{$event->id}}")'>
                <div class="card-body">
                    <p class="card-date">{{ date('d/m/y', strtotime($event->date)) }}</p>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-participantes">{{count($event->users)}} - participantes</p>
                    <a href="/events/{{$event->id}}" class="btn btn-primary">Saber mais</a>
                </div>
            </div>
        @endforeach
        @if (count($events) == 0 && $search)
        <p>Não foi possível encontrar nenhum evento com "{{ $search}}" <a href='/'> Ver todos</a></p>
        @elseif (count($events) == 0)
            <p>Não há eventos disponíveis...</p>
        @endif
    </div> 
</div>
</div>
<script>

</script>


@endsection
