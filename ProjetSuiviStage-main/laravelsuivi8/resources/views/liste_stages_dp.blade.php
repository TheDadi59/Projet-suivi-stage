@extends('templateSuivi')


@section('content')

    <div class="row">
        <div class="col-xs-12 titre-page">
            Suivi des stages
        </div>

        <div class="col-xs-12">
            <select id="template-select" class="form-select" aria-label="Default select example">

                <option selected>Choisir une catégorie</option>

                @foreach($listeTemplates as $template)
                    <option value="{{$template->id_template}}">{{$template->libelle}}</option>
                @endforeach

            </select>
        </div>


    </div>



    <table id="liste-stages">
        <!--<thead>
        <tr>
            <th></th>
            <th scope="col">Type d'activité</th>
            <th scope="col">Etudiant</th>
            <th scope="col">Tuteur</th>
            <th scope="col">Prochaine écheance</th>
            <th scope="col">Pour</th>
            <th scope="col">Etat</th>
            <th></th>

        </tr>

        </thead>-->

    </table>

@endsection


@section('pagescripts')
    <script type="text/javascript" src="{{asset('js/suivi_dp.js')}}"></script>
@endsection
