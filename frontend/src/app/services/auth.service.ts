import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { tap } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'https://127.0.0.1:8000/api/login_check';

  constructor(private http: HttpClient) { }

  login(email: string, password: string){
    return this.http.post<{ token: string }>(`${this.apiUrl}`, { username: email, password: password }).pipe(
      tap(response => localStorage.setItem('token', response.token))
    );
  }

  logout(){
    localStorage.removeItem('token');
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  isLoggedIn(): boolean {
    if(this.getToken() != null){
      return true
    }
    return false;
  }

}
