<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller

{
    public function index(){
        
        $search = request('search');
        if($search){
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        }
        else{

            $events = Event::all();
        }
        return view('welcome', ['events' => $events, 'search' => $search]);

    }

    public function create(){
        return view('events.create');
    }

    //FUNCAO DE CRIAR EVENTOS E UPAR IMAGEM DO EVENTO




   public function store(Request $req){

    $event = new Event;

    $event->title = $req->title;
    $event->date = $req->date;
    $event->city = $req->city;
    $event->private = $req->private;
    $event->description = $req->description;
    $event->items = $req->items;

    // image upload

    if($req->hasFile('image') ** $req->file('image')->isValid()){
        $reqImage = $req->image;

        $extension = $reqImage->extension();

        $imageName = md5($reqImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
        $req->image->move(public_path('assets/events'), $imageName);

        $event->image = $imageName;
    }

    $user = auth()->user();
    $event->user_id = $user->id;
 
    $event->save();

    return redirect('/')->with('msg','Evento criado com sucesso!');
   }




   //FUNCAO DE RESGATAR DO BANCO DE DADOS OS EVENTOS E MOSTRAR NA TELA
   public function show($id){

    $event = Event::findOrFail($id);
    $user = auth()->user();
    $hasUserJoined = false;
    if($user === true){
        $userEvents = $user->AsParticipant->toArray();
        foreach($userEvents as $UserEvent){
            if($UserEvent['id'] == $id){
                $hasUserJoined = true;
            }
        }
    }
    
    $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined'=>$hasUserJoined]);
    }


   //FUNCAO DE DELETAR OS EVENTOS
    public function destroy($id){
        Event::findOrFail($id)->delete();
        return view('/dashboard')->with('msg', 'Evento deletado com sucesso!');
    }



    //FUNDAO DE EDITAR OS EVENTOS
   public function edit($id){
    $user = auth()->user();

    $event = Event::findOrFail($id);

    if($user->id != $event->user->id)
    {
        return redirect('/dashboard');
    }
    
    return view('events.edit', ['event' => $event]);
   }




   //FUNCAO DE DAR UPDATE NOS EVENTOS JA CRIADOS

   public function update(Request $req){
    $data = $req->all();

    // IMAGE UPLOAD

    if($req->hasFile('image') ** $req->file('image')->isValid()){
        $reqImage = $req->image;

        $extension = $reqImage->extension();

        $imageName = md5($reqImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;
        $req->image->move(public_path('assets/events'), $imageName);

        $data['image'] = $imageName;
    }

    Event::findorFail($req->id)->update($data);
    return redirect('/dashboard')->with('msg','Evento editado com sucesso!');
   }





   //FUNCAO DE CONFIGURACAO E EXIBIÇÃO DE PARTICIPAÇÃO NOS EVENTOS
   public function dashboard(){
    $user = auth()->user();
    $events = $user->events;
    $AsParticipant = $user->AsParticipant;
    return view('events.dashboard', ['events'=>$events, 'ComoParticipante'=>$AsParticipant, 'eventoss'=>$events, 'user'=>$user]);
   }



   //FUNÇÃO DE PARTICIPAR DE UM EVENTO E REGISTRAR PARA TODOS VEREM
   public function joinEvent($id){
    $user = auth()->user();

    $user->eventAsParticipant()->attach($id);

    $event = Event::findOrFail($id);

    return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento: '.$event->title);
   }



   //FUNCAO DE DEIXAR DE SER PARTICIPANTE DO EVENTO
   public function leaveEvent($id){
    $user = auth()->user();
    $user->eventAsParticipant()->detach($id);
    $event = Event::findOrFail($id);
    return redirect('/dashboard')->with('msg','Você saiu com sucesso do evento: "'.$event->title.'"');
   }
}