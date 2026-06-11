<nav class="nav">
    <a class="nav-link {{ Request::routeIs('deces.details', ['identifiant' => $dece->identifiant]) ? 'active_classe' : '' }} "
        aria-current="page" href="{{ route('deces.details', ['identifiant' => $dece->identifiant]) }}">Biographie
    </a>
    <a class="nav-link {{ Request::routeIs('deces.details.photo', ['identifiant' => $dece->identifiant]) ? 'active_classe' : '' }} "
        href="{{ route('deces.details.photo', ['identifiant' => $dece->identifiant]) }}">Photos</a>
    <a class="nav-link {{ Request::routeIs('deces.details.programme', ['identifiant' => $dece->identifiant]) ? 'active_classe' : '' }} "
        href="{{ route('deces.details.programme', ['identifiant' => $dece->identifiant]) }}">Programme</a>
    <a class="nav-link  {{ Request::routeIs('deces.details.temoignage', ['identifiant' => $dece->identifiant]) ? 'active_classe' : '' }}"
        href="{{ route('deces.details.temoignage', ['identifiant' => $dece->identifiant]) }}">Témoignage</a>
</nav>

<div class="mt-5"></div>
<div class="mt-5"></div>
<div class="mt-5"></div>
