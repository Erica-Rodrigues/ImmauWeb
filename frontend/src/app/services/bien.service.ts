import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';

export interface Bien {
  id?: number;
  nom: string;
  typeDeBien: string;
  prix: number;
  surface: number;
  nbChambre: number;
  rue: string;
  description: string;
  disponibilite: string;
  statut: string;
  datePublication?: string;
  user?: string | number;
  localisation: string | number;
  photos?: string[] | number[];
}

@Injectable({
  providedIn: 'root'
})
export class BienService {
  private api = 'https://127.0.0.1:8000/api/biens';

  constructor(private http: HttpClient) { }

  getBiens():Observable<Bien[]>{
    // angular envoie une requete HTTP GET à mon URL stoker dans api
    // et me renvoie exactement ce que apiPlatform répond
    // la réponse renvoyer est un objet racine qui contient des métadonnées(infos) 
    // et member une clé qui contient la liste de mes biens
    // {
    //   "totalItems": 2,
    //   "page": 1,
    //   "itemsPerPage": 10,
    //   "member": [
    //     { "id": 1, "nom": "Appartement A" },
    //     { "id": 2, "nom": "Maison B" }
    //   ]
    // }
    // ng for ne fonctionne pas sur les objets mais sur des tableaux ou des objets itérables pas sur un simple objet
    // pipe(map ) fonction qui permet de transformer la réponse reçu avant de l'envoyer a subscribe 
    // [
    //   {
    //     "id": 1,
    //     "nom": "Appartement de test",
    //     "typeDeBien": "Appartement"
    //   }
    // ]

    return this.http.get<any>(this.api).pipe(
      map(response => response['member'])
    );
  }
}
