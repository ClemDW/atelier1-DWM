class Panier {
    constructor() {
        this.items = this.chargerPanier();
    }

    chargerPanier() {
        const name = 'panier=';
        const decodedCookie = decodeURIComponent(document.cookie);
        const cookieArray = decodedCookie.split('; ');

        for(let i = 0; i < cookieArray.length; i++) {
            let cookie = cookieArray[i].trim();
            if (cookie.indexOf(name) === 0) {
                return JSON.parse(cookie.substring(name.length, cookie.length)).items;
            }
        }
        return [];
    }

    ajouterOutil(outil, date_debut, date_fin, quantite = 1) {
        const item = {
            id: outil.id,
            nom: outil.nom,
            image: outil.image,
            prix: outil.prix,
            date_debut: date_debut,
            date_fin: date_fin,
            quantite: quantite,
            soustotal: outil.prix * quantite * this.calculerDuree(date_debut, date_fin)
        };

        const existingItem = this.items.find(i =>
            i.id === item.id &&
            i.date_debut === item.date_debut &&
            i.date_fin === item.date_fin
        );

        if (existingItem) {
            existingItem.quantite += item.quantite;
            existingItem.soustotal += existingItem.quantite * item.prix * this.calculerDuree(date_debut, date_fin);
        } else {
            this.items.push(item);
        }

        this.sauvegarderPanier();
    }

    calculerDuree(date_debut, date_fin) {
        const date1 = new Date(date_debut);
        const date2 = new Date(date_fin);
        const diffTime = Math.abs(date2 - date1);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24))+1;
    }

    sauvegarderPanier() {
        const panierData = {
            items: this.items,
            dateCreation: new Date().toISOString()
        };
        document.cookie = `panier=${JSON.stringify(panierData)}; path=/; max-age=${60 * 60 * 24 * 7}`;
    }
}

export {Panier};