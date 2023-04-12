/**
 * JS Lié à la page activite
 */

let occupe = false;



function majResultat(idJalon, visible, className, message) {

    const errorDiv = document.getElementById("validationError" + idJalon);

    if(visible) {
        errorDiv.className = "alert alert-" + className + " visible";

    } else {
        errorDiv.className = "alert alert-info";
    }

    errorDiv.innerText = message;
}


function changerTab(idJalon)
{
    // MAJ class timeline

    let listeItems = document.getElementById('timeline').getElementsByClassName("item");

    for(let i = 0; i < listeItems.length; i++)
    {
        if(listeItems[i].classList.contains("active"))
        {
            listeItems[i].classList.remove("active");
        }
    }

    document.getElementById("item" + idJalon).classList.add("active");

    // MAJ class nav
    let listeTabs = document.getElementsByClassName("tabview-tab");

    for(let i = 0; i < listeTabs.length; i++)
    {
        if(listeTabs[i].classList.contains("active"))
        {
            listeTabs[i].classList.remove("active")
        }
    }

    document.getElementById("tab" + idJalon).classList.add("active");
}

$(document).ready( function () {

    // Modification date champs date à aujourd'hui
    for(let element of document.getElementsByClassName("form-control"))
    {
        if(element.type == "date")
        {
            element.valueAsDate = new Date();
        }
    }

    // si hash contient l'id, alors on change direct tab
    const hash = window.location.hash.toString();

    if(hash.length > 1)
    {
        changerTab(hash.substring(1));
    }
    //Test mb
    $('.btn-more').on('click', function (data) {

        const attributsContainer = document.getElementById("attributs");

        if (!attributsContainer.classList.contains("active")){

            attributsContainer.classList.add("active");
            document.getElementById("btn").innerText = "Voir moins"


        }
        else {
            attributsContainer.classList.remove("active");
            document.getElementById("btn").innerText = "Voir plus"

        }
    });

    $('.item').on('click', function (data) {


        let target = data.target;


        // on remonte jusqu'à l'item
        while(!target.classList.contains("item") && target.parentNode != null)
        {
            target = target.parentNode;
        }

        if(target.classList.contains("active"))
        {
            return;
        }


        changerTab(target.id.substring(4));



    });

    // TODO
    $('.validation-valon-btn').on('click', function (data) {

        if(occupe)
        {
            return;
        }

        let target = data.target;

        if(!target.hasAttribute('data-jalon'))
        {
            console.log("Target non valide");
            return;
        }

        let idJalon = target.getAttribute("data-jalon");

        const champMessage = document.getElementById("validationMessage" + idJalon);
        const champDate = document.getElementById("validationDate" + idJalon);
        const champFichiers = document.getElementById("validationFichiers" + idJalon);


        const champNote = document.getElementById("validationNote" + idJalon);


        if(champMessage.value.length <= 0)
        {
            majResultat(idJalon, true, "danger", "Erreur : Le champ message ne doit pas être vide.")
            return;
        }


        if(champDate.value.length <= 0)
        {
            majResultat(idJalon, true, "danger", "Erreur : Le champ date ne doit pas être vide.")
            return;
        }



        if(champNote != null)
        {
            if(champNote.value == null || champNote.value.length <= 0 || isNaN(champNote.value) || parseInt(champNote.value) < 0 || parseInt(champNote.value) > 20)
            {
                majResultat(idJalon, true, "danger", "Erreur : Le note doit être comprise en 0 et 20.");
                return;
            }
        }

        // preparer form data :

        occupe = true;

        let formData = new FormData();

        formData.append("id_activite", idActivite);
        formData.append("id_jalon", idJalon);

        formData.append("message", champMessage.value);

        formData.append("date", champDate.value);

        if(champNote !== undefined)
        {
            formData.append("note", parseInt(champNote.value));
        }

        const fichiers = champFichiers.files;

        //formData.append("nombreFichiers", fichiers.length);

        for(let i = 0; i < fichiers.length; i++)
        {
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
            headers: { 'X-CSRF-TOKEN': csrfToken},
            success: function(data){

                console.log(data);

                const json = JSON.parse(data);

                if(!json.success)
                {
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
            error: function(err) {

                console.log("err");
                console.log(err);

                majResultat(idJalon, false, "danger", "Erreur : " + err);
                occupe = false;
            }
        });
    });

});
