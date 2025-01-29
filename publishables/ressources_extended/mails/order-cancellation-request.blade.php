<x-front-mail-layout>
    <div class="p-20">

        <p>
            Bonjour,<br>
            {{$user->names()}} souhaite annuler la commande N° "<b>{{ $order->id }}</b>" du {{$order->created_at->format("d/m/Y")}},
            <br>
            pour l'événement {{$event->texts->name}}.
            <br>
            Merci de le contacter directement.
        </p>
        <div class="bg-tint p-3">
            <a class="text-decoration-none" href="{{ $editUrl }}">Voir la commande</a>
        </div>
    </div>

</x-front-mail-layout>
