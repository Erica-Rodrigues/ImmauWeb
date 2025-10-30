import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';

export interface Localisation {
  id?: number;
  nomLocalite: string;
  codePostal: string;
  ville: string;
  pays: string;
}

@Injectable({
  providedIn: 'root'
})
export class LocalisationService {
  private api = 'https://127.0.0.1:8000';

  constructor(private http: HttpClient) { }

  getLocalisationByIri(iri: string): Observable<Localisation>{
    return this.http.get<any>(`${this.api}${iri}`)
  }
}
