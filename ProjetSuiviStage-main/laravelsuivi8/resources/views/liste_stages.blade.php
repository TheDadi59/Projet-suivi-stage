@extends('templateSuivi')


@section('content')

    <div class="row">
        <div class="col-xs-12 titre-page">
            Mes stages
        </div>
    </div>

    <table id="liste-stages">
        <thead>
        <tr>
            <th></th>
            <th scope="col">Type d'activité</th>
            <th scope="col">Utilisateur lié</th>
            <th scope="col">Entreprise</th>
            <th scope="col">Date début</th>
            <th scope="col">Prochaine échéance</th>
            <th></th>

        </tr>

        </thead>

    </table>

@endsection


@section('pagescripts')
    <script type="text/javascript" src="{{asset('js/suivi.js')}}"></script>
@endsection
