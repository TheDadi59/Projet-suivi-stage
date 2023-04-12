@extends('templateSuivi')


@section('content')


    <div class="activity-container">


        <div class="attributes-container" id="attributs">
            <div class="list">
                <div>
                    <h3>Type d'activité</h3>
                    <p>{{$activite->template->libelle }}</p>
                </div>
                <div  >
                    <h3>Utilisateur suivi</h3>
                    <p>{{$activite->utilisateurSuivi->lib_nom." ". $activite->utilisateurSuivi->lib_prenom }}</p>
                </div>
                @for($i=0; $i<2; $i++)
                <div>



                        <h3>{{$attributs[$i]->libelle}}</h3>

                    @if($valeurs_attributs->contains($i))
                        <p>{{$valeurs_attributs[$i]->valeur}}</p>
                    @else
                        <p>Non défini</p>
                    @endif

                </div>
                @endfor

            </div>


            <div class="see-more" >
                @for($i=2; $i<count($valeurs_attributs); $i++)
                    @foreach($attributs as $attribut)
                        @if($attribut->id_attribut == $valeurs_attributs[$i]->id_attribut)
                            <h3>{{$attribut->libelle}}</h3>
                        @endif
                    @endforeach
                    <p>{!! nl2br(e($valeurs_attributs[$i]->valeur)) !!}</p>

                @endfor
            </div>
            @if(count($valeurs_attributs)>2)
                <div class="show-more">
                    <button id ="btn" class="btn-more">Voir plus</button>
                </div>
            @endif
        </div>

        <div class="tabview-container">

            <div class="tabview-nav">

                <div class="timeline" id="timeline">




                    @foreach($jalons as $validationJalon)


                        @if($validationJalon->valide)

                            <div class="item valide" id="item{{$validationJalon->id_jalon}}">
                                <div class="line">
                                    <div class="node">

                                        <div class="circle"></div>
                                        <div class="details">
                                            <h5>{{$validationJalon->libelle}}</h5>
                                            <h6>{{$validationJalon->formaterDateEcheance($activite)}}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @else

                            @if ($validationJalon->relativite == -1)
                                <div class="item retard" id="item{{$validationJalon->id_jalon}}">
                                    <div class="line">
                                        <div class="node">

                                            <div class="circle"></div>
                                            <div class="details">
                                                <h5>{{$validationJalon->libelle}}</h5>
                                                <h6>{{$validationJalon->formaterDateEcheance($activite)}}</h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @elseif($validationJalon->relativite == 0)
                                <div class="item today" id="item{{$validationJalon->id_jalon}}">
                                    <div class="line">
                                        <div class="node">

                                            <div class="circle"></div>
                                            <div class="details">
                                                <h5>{{$validationJalon->libelle}}</h5>
                                                <h6>{{$validationJalon->formaterDateEcheance($activite)}}</h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="item" id="item{{$validationJalon->id_jalon}}">
                                    <div class="line">
                                        <div class="node">

                                            <div class="circle"></div>
                                            <div class="details">
                                                <h5>{{$validationJalon->libelle}}</h5>
                                                <h6>{{$validationJalon->formaterDateEcheance($activite)}}</h6>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endif

                    @endforeach
                </div>



            </div>

            <div class="tabview-content">

                <div class="tabview-tab active tutorial">

                    <h5>Veuillez cliquer sur un jalon pour afficher le détail de celui-ci.</h5>

                </div>


                @foreach($jalons as $jalon)


                    @if($jalon->etat == -1)
                        <div class="tabview-tab late" id="tab{{$jalon->id_jalon}}">

                    @elseif($jalon->etat == 0)
                        <div class="tabview-tab today" id="tab{{$jalon->id_jalon}}">

                    @elseif($jalon->etat == 1)
                        <div class="tabview-tab validated" id="tab{{$jalon->id_jalon}}">

                    @else
                                <div class="tabview-tab" id="tab{{$jalon->id_jalon}}">
                    @endif



                        <h3>{{$jalon->libelle}}</h3>

                        <div class="deadline">

                            <span>Pour le {{$jalon->formaterDateEcheance($activite)}}</span>
                            <span>-</span>

                            <span class="date">{{$jalon->etatFormate}}</span>



                        </div>

                        <h5>Résumé</h5>

                        <p>{{$jalon->description}}</p>

                        @if(count($jalon->ressources) > 0)
                            <h5>Ressources</h5>

                            <div class="ressources">



                                @foreach($jalon->ressources as $ressource)

                                    <a href="{{$ressource->url}}" target="_blank">{{$ressource->libelle}}</a>
                                @endforeach

                            </div>
                        @endif

                        <h5>Validation</h5>

                        @if(!$jalon->valide)







                            <div class="validation" id="form-validation-{{$jalon->id_jalon}}">


                                <div class="validation-form">

                                    <div class="form-group">
                                        <label for="validationMessage{{$jalon->id_jalon}}">Message</label>
                                        <textarea class="form-control" id="validationMessage{{$jalon->id_jalon}}" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationDate{{$jalon->id_jalon}}">Date de validation</label>
                                        <input type="date" class="form-control" id="validationDate{{$jalon->id_jalon}}" placeholder="JJ/MM/AAAA">
                                    </div>
                                    <div class="form-group">
                                        <label for="validationFichiers{{$jalon->id_jalon}}">Fichiers</label>
                                        <input type="file" class="form-control" id="validationFichiers{{$jalon->id_jalon}}" multiple>
                                    </div>

                                    @if($jalon->notable)
                                        <div class="form-group">
                                            <label for="validationNote{{$jalon->id_jalon}}">Note</label>
                                            <input type="number" class="form-control" id="validationNote{{$jalon->id_jalon}}" min="0" max="20">
                                        </div>

                                    @endif

                                </div>

                                <button data-jalon="{{$jalon->id_jalon}}"  class="btn btn-success validation-valon-btn">Valider ce jalon</button>


                                <div id="validationError{{$jalon->id_jalon}}" class="alert alert-danger">Erreur</div>

                            </div>


                        @else

                            <spannpm >Ce jalon a été validé le {{$jalon->formaterDateValidation()}}</spannpm>

                        @endif



                    </div>

                @endforeach





            </div>



        </div>




    </div>


@endsection
@section('pagescripts')

    <script>


        const csrfToken = "{{ csrf_token() }}";
        const idActivite = "{{$activite->id_activite}}";

    </script>

    <script type="text/javascript" src="{{asset('js/activite.js')}}"></script>

    <script>var baseUrl = <?php echo json_encode(url('/')); ?>;</script>
@endsection
