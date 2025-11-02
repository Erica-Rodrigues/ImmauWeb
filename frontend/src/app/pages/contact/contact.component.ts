import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ContactService } from '../../services/contact.service';
import { catchError, of } from 'rxjs';

@Component({
  selector: 'app-contact',
  imports: [ReactiveFormsModule,CommonModule],
  templateUrl: './contact.component.html',
  styleUrl: './contact.component.css'
})
export class ContactComponent {
  form: FormGroup;

  constructor(private fb: FormBuilder, private contactService: ContactService){
    this.form = this.fb.group({nom: [''], email: [''], sujet: [''], message: ['']});
  }

  onSubmit(){
    if(this.form.valid){
      const contactData = {
        nom: this.form.value.nom,
        email: this.form.value.email,
        sujet: this.form.value.sujet,
        message: this.form.value.message
      };
      this.contactService.createContact(contactData).pipe(
        catchError(err => {
          console.error('Erreur lors de l\'envoie du message', err);
          return of(null);
        })
      )
      .subscribe(response => {
        if(response){
          console.log('Message envoyé avec succès', response);
          this.form.reset();
        }
      })
    }

    
  }
}
