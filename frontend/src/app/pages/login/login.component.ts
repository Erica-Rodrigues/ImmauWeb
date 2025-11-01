import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  imports: [ReactiveFormsModule,CommonModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  form: FormGroup;
  errorMessage = '';

  constructor(private fb: FormBuilder, private authService: AuthService, private router: Router){
    this.form = this.fb.group({email: [''], password: ['']});
  }

  onSubmit(){
    const {email, password} = this.form.value;

    this.authService.login(email, password).subscribe({
      next: (response) => {
        console.log('Login réussi');
        this.router.navigate(['/profil']);
      },
      error: (err) => {
        console.error('erreur de connexion', err);
        this.errorMessage = 'Identifiant incorrect.';
      }
    })
  }
}
