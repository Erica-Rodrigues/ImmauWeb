import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

export interface Contact{
  id?: number;
  nom: string;
  email: string;
  message: string;
}

@Injectable({
  providedIn: 'root'
})
export class ContactService {
  private api = 'https://127.0.0.1:8000/api/contacts';

  constructor(private http: HttpClient) { }

  createContact(contact: Contact): Observable<Contact> {
    const headers = {
      'Content-Type': 'application/ld+json',
    };
    return this.http.post<Contact>(this.api, contact, {headers});
  }
}
