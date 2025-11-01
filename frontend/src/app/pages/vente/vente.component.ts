import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Bien, BienService } from '../../services/bien.service';

@Component({
  selector: 'app-vente',
  imports: [FormsModule, CommonModule],
  templateUrl: './vente.component.html',
  styleUrl: './vente.component.css'
})
export class VenteComponent {
  //liste des biens du service
  biens: Bien[] = [];
  // liste des biens après application des filtres
  biensFiltres: Bien[] = [];
  //liste des biens affichés sur la page actuelle
  biensAffiches: Bien[] = [];

  pageActuelle: number = 1;
  biensParPage: number = 9;
  nombrePages: number = 0;
  pages: number[] = [];

  constructor(private bienService: BienService){}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.bienService.getBiensEnVente().subscribe({
      // next ce qu'on fait quand les données arrive
      next: (data) => {
        // tous les biens récupérés
        this.biens = data;
        // copie des biesn pour appliquer les filtres ensuite
        this.biensFiltres = data;
        // calculer le nombre de pages
        this.calculerPagination();
        //affiche la première page
        this.afficherPage(1);
      },
      error: (err) => {
        console.error('Erreur lors du chargement des biens:', err);
      }
    })
  }

  calculerPagination(){
    //Math.ceil arrondi vers le haut
    this.nombrePages = Math.ceil(this.biensFiltres.length / this.biensParPage);
    //Array.from crée un tableau avec les pages
    this.pages = Array.from({length: this.nombrePages}, (_,i) => i + 1);
  }

  afficherPage(page: number){
    this.pageActuelle = page;
    //calcule l'indice du premier bien a afficher
    const debut = (page - 1) * this.biensParPage;
    //calcule l'indice du dernier bien a afficher
    const fin = debut + this.biensParPage;
    // on extrait une partie de biensFiltres et on stocke dans biensAffiches
    this.biensAffiches = this.biensFiltres.slice(debut, fin);
    //fait défiler la page vers le haut automatiquement lorsqu'on change de page
    window.scrollTo({top: 0, behavior: 'smooth'});
  }

  pagePrecedente(){
    // on vérifie si on est déjà sur la première page
    if(this.pageActuelle > 1){
      // si ce n'est pas le cas on revient à la page précédente
      this.afficherPage(this.pageActuelle - 1);
    }
  }

  pageSuivante(){
    // on vérifie si on est déjà sur la dernière page
    if(this.pageActuelle < this.nombrePages){
      // si ce n'est pas le cas on passe à la page suivante
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

  //méthode qui ouvre le modal lorsqu'on clique sur le bouton
  toggleModalFiltres() {
    this.isModalOpen = !this.isModalOpen;
    this.toggleBodyScroll();
  }

  //méthode qui ferme le modal lorsqu'on appuie sur le X
  closeModalFiltres() {
    this.isModalOpen = false;
    this.toggleBodyScroll();
  }

  // méthode qui ferme le modal lorsqu'on appuie sur l'arrière-plan
  closeModalOnBackdrop(event: Event) {
    if ((event.target as HTMLElement).classList.contains('modal__filtres')) {
      this.closeModalFiltres();
    }
  }

  //méthode qui gère le scroll de l'arrière plan du body
  private toggleBodyScroll() {
    if (this.isModalOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  }

  //remet les filtres a 0
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
    this.biensFiltres = this.biens.filter(bien => {
      const filtreLocalisation = this.filtres.localisation
      ? (typeof bien.localisation === 'object'
        ? bien.localisation.ville.toLowerCase().includes(this.filtres.localisation.toLowerCase()) ||
          bien.localisation.codePostal.toLowerCase().includes(this.filtres.localisation.toLowerCase())
        : false)
      : true;
  
      const filtreType = this.filtres.type
        ? bien.typeDeBien?.toLowerCase() === this.filtres.type.toLowerCase()
        : true;
  
      const filtrePrix = this.filtres.prix ? this.filtrerParPrix(bien.prix, this.filtres.prix) : true;
      const filtreSurface = this.filtres.surface ? this.filtrerParSurface(bien.surface, this.filtres.surface) : true;
      const filtreChambres = this.filtres.chambres ? this.filtrerParChambres(bien.nbChambre, this.filtres.chambres) : true;
  
      return filtreLocalisation && filtreType && filtrePrix && filtreSurface && filtreChambres;
    });
  
    // Mise à jour de la pagination
    this.calculerPagination();
    this.afficherPage(1);
    
    this.closeModalFiltres();
  }

  private filtrerParPrix(prix: number, filtre: string): boolean {
    switch (filtre) {
      case '0-500': return prix <= 500;
      case '500-1000': return prix > 500 && prix <= 1000;
      case '1000-1500': return prix > 1000 && prix <= 1500;
      case '1500+': return prix > 1500;
      default: return true;
    }
  }
  
  private filtrerParSurface(surface: number, filtre: string): boolean {
    switch (filtre) {
      case '0-30': return surface <= 30;
      case '30-50': return surface > 30 && surface <= 50;
      case '50-80': return surface > 50 && surface <= 80;
      case '80+': return surface > 80;
      default: return true;
    }
  }
  
  private filtrerParChambres(nbChambre: number, filtre: string): boolean {
    switch (filtre) {
      case '1': return nbChambre === 1;
      case '2': return nbChambre === 2;
      case '3': return nbChambre === 3;
      case '4+': return nbChambre >= 4;
      default: return true;
    }
  }
}
