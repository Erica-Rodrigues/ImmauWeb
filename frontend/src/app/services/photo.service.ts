import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';

export interface Photo {
  id?: number;
  urlPhoto: string;
}

@Injectable({
  providedIn: 'root'
})
export class PhotoService {
  private api = 'https://127.0.0.1:8000';

  constructor(private http: HttpClient) { }

  getPhotosByBienId(bienId: number): Observable<Photo[]>{
    return this.http.get<any>(`${this.api}/api/photos?bien.id=${bienId}`).pipe(
      map(response => response['member'])
    );
  }

  uploadPhoto(file: File, bienId?: number): Observable<Photo> {
    const formData = new FormData();
    formData.append('imageFile', file);

    if (bienId) {
      formData.append('bien', `/api/biens/${bienId}`);
    }

    return this.http.post<Photo>(this.api, formData);
  }
}
