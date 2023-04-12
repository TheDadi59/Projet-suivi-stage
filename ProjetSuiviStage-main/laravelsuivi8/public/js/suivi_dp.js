/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/suivi_dp.js ***!
  \**********************************/
/**
 * Création du sous tableau contenant les attributs
 * @param d
 * @returns {string}
 */
function format(d) {
  var contenu = '<table class="attributes-table">';
  Object.keys(d.attributs).forEach(function (cle, index) {
    var attribut = d.attributs[cle];
    contenu = contenu + '<tr>' + '<td>' + attribut.libelle + ' :</td>' + '<td>' + attribut.valeur + '</td>' + '</tr>';
  });
  contenu = contenu + '</table>';
  return contenu;
}
var idTemplateSelectionne = -1;
var table = null;
function chargerDatatable(idTemplate) {
  // aucune modif
  if (idTemplate == idTemplateSelectionne) {
    return;
  }
  idTemplateSelectionne = idTemplate;
  if (table != null) {
    table.destroy();
  }
  table = $('#liste-stages').DataTable({
    ajax: '/api/activites/' + idTemplateSelectionne + '?vueDp=1',
    columns: [{
      className: 'dt-control',
      orderable: false,
      data: null,
      defaultContent: ''
    }, {
      data: 'libelle_template',
      title: "Type"
    }, {
      data: 'utilisateur_lie',
      title: "Etudiant"
    }, {
      data: 'utilisateur_referent',
      title: "Tuteur"
    }, {
      data: 'date_prochain_jalon',
      title: "Prochaine écheance"
    }, {
      data: 'destinataire_prochain_jalon',
      title: "Pour le"
    }, {
      data: 'etat_formate',
      title: "Etat",
      className: "etat"
    }, {
      data: null,
      orderable: false,
      render: function render(data, type, row) {
        return '<a class="btn btn-info" href="/activite/' + data.id_activite + '">Détails</a>';
      }
    }],
    rowCallback: function rowCallback(row, data) {
      // colorer le texte selon les attributs de la ligne
      if (data.etat == 1) {
        console.log("done");
        $('.etat', row).addClass("late");
      }
      if (data.etat == 2) {
        $('.etat', row).addClass("today");
      }
    },
    order: [[1, 'asc']]
  });

  /**
   * Affichage détail pour une ligne
   */
  $('#liste-stages').on('click', 'td.dt-control', function () {
    console.log("tt");
    var tr = $(this).closest('tr');
    var row = table.row(tr);
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
}
$(document).ready(function () {
  // Quand le document en prêt

  // si hash contient un id de template, alors on load direct ce template
  var hash = window.location.hash.toString();
  if (hash.length > 1) {
    chargerDatatable(hash.substring(1));
  }
  $('#template-select').on('change', function () {
    //const valeur = this.value;

    console.log("maj change");
    if (this.value != null) {
      chargerDatatable(this.value);
    }
  });
});
/******/ })()
;