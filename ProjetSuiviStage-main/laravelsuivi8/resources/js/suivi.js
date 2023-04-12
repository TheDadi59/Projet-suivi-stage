/**
 * Création du sous tableau contenant les attributs
 * @param d
 * @returns {string}
 */
function format(d){
    let contenu = '<table class="attributes-table">';

    Object.keys(d.attributs).forEach((cle, index) => {

        let attribut = d.attributs[cle];

        contenu  = contenu +'<tr>' +
            '<td>'+attribut.libelle+' :</td>' +
            '<td>' +
            attribut.valeur +
            '</td>'+
            '</tr>'

    })


    contenu = contenu + '</table>';
    return contenu;
}

$(document).ready( function () {

    // Quand le document en prêt

    console.log("Loading datatable ...");
   // $('#liste-stages').DataTable();
    var table = $('#liste-stages').DataTable({
        ajax: '/api/activites/1',
        columns: [
            {
                className: 'dt-control',
                orderable: false,
                data: null,
                defaultContent: '',
            },
            {data: 'libelle_template'},
            {data: 'utilisateur_lie'},
            {data: 'attributs.2.valeur'},
            {data: 'date_debut'},
            {
                data: 'etat_formate',
                className: 'etat'
            },

            { data: null, orderable: false,
                render: function ( data, type, row ) {
                    return '<a class="btn btn-info" href="/activite/' + data.id_activite +'">Détails</a>'
                }
            }

        ],
        rowCallback: function( row, data ) {

            // colorer le texte selon les attributs de la ligne
            if(data.etat == 1)
            {
                console.log("done");
                $('.etat', row).addClass("late");
            }

            if(data.etat == 2)
            {
                $('.etat', row).addClass("today");
            }
        },
        order: [[1, 'asc']],
    });

    /**
     * Affichage détail pour une ligne
     */
    $('#liste-stages').on('click',  'td.dt-control',function () {
        let tr = $(this).closest('tr');
        let row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});
