/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/activite.js ***!
  \**********************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
/**
 * JS Lié à la page activite
 */

var occupe = false;
function majResultat(idJalon, visible, className, message) {
  var errorDiv = document.getElementById("validationError" + idJalon);
  if (visible) {
    errorDiv.className = "alert alert-" + className + " visible";
  } else {
    errorDiv.className = "alert alert-info";
  }
  errorDiv.innerText = message;
}
function changerTab(idJalon) {
  // MAJ class timeline

  var listeItems = document.getElementById('timeline').getElementsByClassName("item");
  for (var i = 0; i < listeItems.length; i++) {
    if (listeItems[i].classList.contains("active")) {
      listeItems[i].classList.remove("active");
    }
  }
  document.getElementById("item" + idJalon).classList.add("active");

  // MAJ class nav
  var listeTabs = document.getElementsByClassName("tabview-tab");
  for (var _i = 0; _i < listeTabs.length; _i++) {
    if (listeTabs[_i].classList.contains("active")) {
      listeTabs[_i].classList.remove("active");
    }
  }
  document.getElementById("tab" + idJalon).classList.add("active");
}
$(document).ready(function () {
  // Modification date champs date à aujourd'hui
  var _iterator = _createForOfIteratorHelper(document.getElementsByClassName("form-control")),
    _step;
  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var element = _step.value;
      if (element.type == "date") {
        element.valueAsDate = new Date();
      }
    }

    // si hash contient l'id, alors on change direct tab
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }
  var hash = window.location.hash.toString();
  if (hash.length > 1) {
    changerTab(hash.substring(1));
  }
  //Test mb
  $('.btn-more').on('click', function (data) {
    var attributsContainer = document.getElementById("attributs");
    if (!attributsContainer.classList.contains("active")) {
      attributsContainer.classList.add("active");
      document.getElementById("btn").innerText = "Voir moins";
    } else {
      attributsContainer.classList.remove("active");
      document.getElementById("btn").innerText = "Voir plus";
    }
  });
  $('.item').on('click', function (data) {
    var target = data.target;

    // on remonte jusqu'à l'item
    while (!target.classList.contains("item") && target.parentNode != null) {
      target = target.parentNode;
    }
    if (target.classList.contains("active")) {
      return;
    }
    changerTab(target.id.substring(4));
  });

  // TODO
  $('.validation-valon-btn').on('click', function (data) {
    if (occupe) {
      return;
    }
    var target = data.target;
    if (!target.hasAttribute('data-jalon')) {
      console.log("Target non valide");
      return;
    }
    var idJalon = target.getAttribute("data-jalon");
    var champMessage = document.getElementById("validationMessage" + idJalon);
    var champDate = document.getElementById("validationDate" + idJalon);
    var champFichiers = document.getElementById("validationFichiers" + idJalon);
    var champNote = document.getElementById("validationNote" + idJalon);
    if (champMessage.value.length <= 0) {
      majResultat(idJalon, true, "danger", "Erreur : Le champ message ne doit pas être vide.");
      return;
    }
    if (champDate.value.length <= 0) {
      majResultat(idJalon, true, "danger", "Erreur : Le champ date ne doit pas être vide.");
      return;
    }
    if (champNote != null) {
      if (champNote.value == null || champNote.value.length <= 0 || isNaN(champNote.value) || parseInt(champNote.value) < 0 || parseInt(champNote.value) > 20) {
        majResultat(idJalon, true, "danger", "Erreur : Le note doit être comprise en 0 et 20.");
        return;
      }
    }

    // preparer form data :

    occupe = true;
    var formData = new FormData();
    formData.append("id_activite", idActivite);
    formData.append("id_jalon", idJalon);
    formData.append("message", champMessage.value);
    formData.append("date", champDate.value);
    if (champNote !== undefined) {
      formData.append("note", parseInt(champNote.value));
    }
    var fichiers = champFichiers.files;

    //formData.append("nombreFichiers", fichiers.length);

    for (var i = 0; i < fichiers.length; i++) {
      formData.append("fichier-" + i, fichiers[i]);
    }
    majResultat(idJalon, false);
    $.ajax({
      url: '/api/activitie/jalon/valider',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      success: function success(data) {
        console.log(data);
        var json = JSON.parse(data);
        if (!json.success) {
          majResultat(idJalon, true, "danger", json.message);
        } else {
          majResultat(idJalon, true, "success", json.message);
          history.pushState({
            path: this.path
          }, "", "#" + idJalon);
          window.location.reload();
        }
        occupe = false;
      },
      error: function error(err) {
        console.log("err");
        console.log(err);
        majResultat(idJalon, false, "danger", "Erreur : " + err);
        occupe = false;
      }
    });
  });
});
/******/ })()
;