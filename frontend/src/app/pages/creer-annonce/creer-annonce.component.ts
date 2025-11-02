import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Bien, BienService } from '../../services/bien.service';
import { Localisation, LocalisationService } from '../../services/localisation.service';
import { PhotoService } from '../../services/photo.service';
import { forkJoin } from 'rxjs';

@Component({
  selector: 'app-creer-annonce',
  imports: [ReactiveFormsModule],
  templateUrl: './creer-annonce.component.html',
  styleUrl: './creer-annonce.component.css'
})
export class CreerAnnonceComponent {
  form: FormGroup;
  images: File[] = [];

  constructor(private fb: FormBuilder, private bienService: BienService, private localisationService: LocalisationService, private photoService: PhotoService){
    this.form = this.fb.group({
      nom: [''],
      type: [''],
      prix: [''],
      surface: [''],
      chambres: [''],
      rue: [''],
      disponibilite: [''],
      statut: [''],
      nomLocalite: [''],
      codePostal: [''],
      ville: [''],
      pays: [''],
      description: [''],
      photos: ['']
    });
  }


  onFileSelected(event: any): void {
    // if (event.target.files) {
    //   this.images = Array.from(event.target.files);
    // }
  }

  onSubmit() {
    // if (this.form.invalid) {
    //   return;
    // }
  
    // const formValues = this.form.value;
  
    // const localisation: Localisation = {
    //   nomLocalite: formValues.nomLocalite,
    //   codePostal: formValues.codePostal,
    //   ville: formValues.ville,
    //   pays: formValues.pays
    // };
  
    // // 1️⃣ Create localisation
    // this.localisationService.createLocalisation(localisation).subscribe({
    //   next: (localisationCree: Localisation) => {
  
    //     // 2️⃣ Create the Bien first (without photos)
    //     const bien: Bien = {
    //       nom: formValues.nom,
    //       typeDeBien: formValues.type,
    //       prix: Number(formValues.prix),
    //       surface: Number(formValues.surface),
    //       nbChambre: Number(formValues.chambres),
    //       rue: formValues.rue,
    //       description: formValues.description,
    //       disponibilite: formValues.disponibilite,
    //       statut: formValues.statut,
    //       localisation: localisationCree,
    //       photos: [] // initially empty
    //     };
  
    //     this.bienService.createBien(bien).subscribe({
    //       next: (createdBien: Bien) => {
    //         // 3️⃣ Upload photos with the created Bien ID
    //         const uploadObservables = this.images.map(file => 
    //           this.photoService.uploadPhoto(file, createdBien.id)
    //         );
  
    //         forkJoin(uploadObservables).subscribe({
    //           next: (photosCreees) => {
    //             console.log('Photos uploadées avec succès :', photosCreees);
    //             alert('Bien et photos créés avec succès');
  
    //             // Reset form & images
    //             this.form.reset();
    //             this.images = [];
    //           },
    //           error: (err) => {
    //             console.error('Erreur lors de l\'upload des photos :', err);
    //           }
    //         });
    //       },
    //       error: (err) => {
    //         console.error('Erreur lors de la création du bien :', err);
    //       }
    //     });
    //   },
    //   error: (err) => {
    //     console.error('Erreur lors de la création de la localisation :', err);
    //   }
    // });
  }
  
}
