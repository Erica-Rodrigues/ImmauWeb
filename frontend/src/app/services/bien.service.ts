import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, forkJoin, map, switchMap } from 'rxjs';
import { Photo, PhotoService } from './photo.service';

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
  photos?: Photo[];
}

@Injectable({
  providedIn: 'root'
})
export class BienService {
  private api = 'https://127.0.0.1:8000/api/biens';

  constructor(private http: HttpClient, private photoService: PhotoService) { }

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
      map(response => response['member']),
      //switchMap permet de transformer l'observable de biens pour le transformer 
      // en un autre observable de biens avec photos.
      switchMap((biens: Bien[]) => {
        // création d'un tableau d'Observables
        // $ indique un tableau d'Observables
        const biensAvecPhotos$ = biens.map(bien => 
          // this.photoService.getPhotosByBienId(bien.id!) pour chaque bien on crée un Observable qui va récupérer ses photos
          // ! -> indique que id n'est jamais null
          this.photoService.getPhotosByBienId(bien.id!).pipe(
            map(photos => ({
              // copie toutes les propriétés du bien
              ...bien,
              //ajoute le tableau de photos récupéré
              photos
            }))
          )
        );
        //combine plusieurs observables et émet un tableau contenant tous les résultats
        return forkJoin(biensAvecPhotos$);
      })
    );
  }

  getBiensEnLocation(): Observable<Bien[]>{
    return this.http.get<any>(this.api).pipe(
      map(response => response['member']),
      map((biens: Bien[]) => biens.filter(bien => bien.statut === 'location')),
      switchMap((biens: Bien[]) => {
        // création d'un tableau d'Observables
        // $ indique un tableau d'Observables
        const biensAvecPhotos$ = biens.map(bien => 
          // this.photoService.getPhotosByBienId(bien.id!) pour chaque bien on crée un Observable qui va récupérer ses photos
          // ! -> indique que id n'est jamais null
          this.photoService.getPhotosByBienId(bien.id!).pipe(
            map(photos => ({
              // copie toutes les propriétés du bien
              ...bien,
              //ajoute le tableau de photos récupéré
              photos
            }))
          )
        );
        //combine plusieurs observables et émet un tableau contenant tous les résultats
        return forkJoin(biensAvecPhotos$);
      })
    );
  }
}
