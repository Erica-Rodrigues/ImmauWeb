import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Bien, BienService} from '../../services/bien.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-location',
  imports: [FormsModule, CommonModule],
  templateUrl: './location.component.html',
  styleUrl: './location.component.css'
})
export class LocationComponent {
  biens: Bien[] = [];
  biensFiltres: Bien[] = [];
  biensAffiches: Bien[] = [];

  pageActuelle: number = 1;
  biensParPage: number = 9;
  nombrePages: number = 0;
  pages: number[] = [];

  constructor(private bienService: BienService){}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.bienService.getBiensEnLocation().subscribe({
      next: (data) => {
        this.biens = data;
        this.biensFiltres = data;
        this.calculerPagination();
        this.afficherPage(1);
      },
      error: (err) => {
        console.error('Erreur lors du chargement des biens:', err);
      }
    })
  }

  calculerPagination(){
    this.nombrePages = Math.ceil(this.biensFiltres.length / this.biensParPage);
    this.pages = Array.from({length: this.nombrePages}, (_,i) => i + 1);
  }

  afficherPage(page: number){
    this.pageActuelle = page;
    const debut = (page - 1) * this.biensParPage;
    const fin = debut + this.biensParPage;
    this.biensAffiches = this.biensFiltres.slice(debut, fin);

    window.scrollTo({top: 0, behavior: 'smooth'});
  }

  pagePrecedente(){
    if(this.pageActuelle > 1){
      this.afficherPage(this.pageActuelle - 1);
    }
  }

  pageSuivante(){
    if(this.pageActuelle < this.nombrePages){
      this.afficherPage(this.pageActuelle + 1);
    }
  }

  isModalOpen = false;
  
  filtres = {
    localisation: '',
    type: '',
    prix: '',
    surface: '',
    chambres: ''
  };

  toggleModalFiltres() {
    this.isModalOpen = !this.isModalOpen;
    this.toggleBodyScroll();
  }

  closeModalFiltres() {
    this.isModalOpen = false;
    this.toggleBodyScroll();
  }

  closeModalOnBackdrop(event: Event) {
    if ((event.target as HTMLElement).classList.contains('modal__filtres')) {
      this.closeModalFiltres();
    }
  }

  reinitialiserFiltres() {
    this.filtres = {
      localisation: '',
      type: '',
      prix: '',
      surface: '',
      chambres: ''
    };
  }

  appliquerFiltres() {

  }


  

  private toggleBodyScroll() {
    if (this.isModalOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  }
}
