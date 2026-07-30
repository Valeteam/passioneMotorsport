const API_BASE = "http://localhost/psmrt_new/api/";

const ENDPOINT = {
    news: "newss.php",
    categorie: "categoriee.php",
    calendario: "calendarioo.php",
    sponsor: "sponsorAttivi.php",
    richiesteSponsor: "richiesteSponsor.php",
    messaggi: "messaggii.php",
    candidature: "candidaturee.php"
};

const AdminDB = (() => {

    function getAll(collection) {
        return fetch(API_BASE + ENDPOINT[collection])
        .then(r=> r.json());
    }

    function add(collection, item ) {
        return fetch(API_BASE + ENDPOINT[collection], {
            method: "POST",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify(item)
        })
        .then(r=> r.json());
    }

    function update(collection, id, changes) {
        return fetch(API_BASE + ENDPOINT[collection], {
            method: "PUT",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({...changes, id:id})
        })
        .then(r=> r.json());
    }

    function remove(collection, id) {
        return fetch(API_BASE + ENDPOINT[collection], {
            method: "DELETE",
            headers: {"Content-Type" : "application/json"},
            body: JSON.stringify({id:id})
        })
        .then(r=> r.json());
    }

    return { getAll, add, update, remove };
})();