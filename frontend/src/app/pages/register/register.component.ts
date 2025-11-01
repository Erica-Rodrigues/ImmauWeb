import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  imports: [ReactiveFormsModule,CommonModule],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {
  form: FormGroup;
  errorMessage =  '';

  constructor(private fb: FormBuilder, private authService: AuthService, private router: Router){
    this.form = this.fb.group({nom: [''], prenom: [''], email: [''], password: [''], type: ['proprietaire']});
  }

  onSubmit(){
    const {email, password, nom, prenom, type} = this.form.value;

    this.authService.register(email, password, nom, prenom, type).subscribe({
      next: (response) => {
        console.log('création réussi');
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error('erreur de connexion', err);
        this.errorMessage = 'Erreur Création impossible.';
      }
    })
  }
}
