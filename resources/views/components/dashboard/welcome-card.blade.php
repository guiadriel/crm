<div {{ $attributes->merge(['class' => 'card mb-2'])  }} >
  <div class="card-body">
    <h5 class="card-title">Olá {{ auth()->user()->name}}</h5>
    <p class="card-text">
        @if (date('H') < "12")
            Tenha um ótimo dia!
        @endif
        @if (date('H') > "12" && date('H') < "18")
            Tenha uma ótima tarde!
        @endif
        @if (date('H') > "18")
            Tenha uma ótima noite!
        @endif
    </p>
  </div>
</div>
