import { CommonModule } from '@angular/common';
import { Component, ElementRef, HostListener, Input, ViewChild } from '@angular/core';
import { Bien } from '../../services/bien.service';

@Component({
  selector: 'app-slider',
  imports: [CommonModule],
  templateUrl: './slider.component.html',
  styleUrl: './slider.component.css'
})
export class SliderComponent {
  //permet au accueil component de passer les données(biens)
  @Input() biens: Bien[] = [];
  // @ViewChild décorateur qui permet d'accéder un élément du template
  //on récupère le slider
  @ViewChild('slider', { static: false }) slider!: ElementRef;

  //page actuelle du slider (commence à 0)
  currentIndex = 0;
  //nombre de cartes visibles simultanément
  itemsPerSlide = 1;
  //nombre total de pages
  totalSlides = 1;

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.updateItemsPerSlide();
    this.updateTotalSlides();
  }

  //écoute les événements du navigateur et se déclenche lorsque la fenêtre est redimensionnée
  @HostListener('window:resize')
  //adapte la taille du slider
  onResize(){
    this.updateItemsPerSlide();
    this.updateTotalSlides();
    this.updateTransform();
  }


  // Calcule combien de cartes afficher selon la taille d’écran
  updateItemsPerSlide() {
    const width = window.innerWidth;
    if (width >= 1025) {
      this.itemsPerSlide = 3;
    } else if (width >= 768) {
      this.itemsPerSlide = 2;
    } else {
      this.itemsPerSlide = 1;
    }
  }

  // Calcule combien de "pages" le slider doit avoir
  updateTotalSlides() {
    this.totalSlides = Math.ceil(this.biens.length / this.itemsPerSlide);
    // S’assure qu’on ne dépasse pas la dernière page
    if (this.currentIndex >= this.totalSlides) {
      this.currentIndex = this.totalSlides - 1;
    }
  }


  nextSlide() {
    //vérifie si on est  pas a la fin du slider
    if (this.currentIndex < this.totalSlides - 1) {
      //passe a la page suivante
      this.currentIndex++;
      this.updateTransform();
    }
  }

  prevSlide() {
    //vérifie si on est pas au début du slider
    if (this.currentIndex > 0) {
      // passe a la page précédente
      this.currentIndex--;
      this.updateTransform();
    }
  }

  goToSlide(index: number) {
    this.currentIndex = index;
    this.updateTransform();
  }

  // Fait bouger le slider en fonction de la "page" actuelle
  updateTransform() {
    if (!this.slider) return;
    // récupération de la largeur du conteneur
    const containerWidth = this.slider.nativeElement.offsetWidth;
    // on détermine la largeur d'une carte
    const slideWidth = containerWidth / this.itemsPerSlide;
    // on détermine de combien de pixels on doit décaler
    const offset = this.currentIndex * slideWidth * this.itemsPerSlide;
    //on accède au styles de l'élément et on lui ajoute une propriété transform
    this.slider.nativeElement.style.transform = `translateX(-${offset}px)`;
  }
}
