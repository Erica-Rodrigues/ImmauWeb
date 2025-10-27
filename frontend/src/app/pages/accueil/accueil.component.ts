import { Component, OnInit } from '@angular/core';
import { Bien, BienService } from '../../services/bien.service';
import { CommonModule} from '@angular/common';

@Component({
  selector: 'app-accueil',
  imports: [CommonModule],
  templateUrl: './accueil.component.html',
  styleUrl: './accueil.component.css'
})
export class AccueilComponent implements OnInit {
  biens: Bien[] = [];

  constructor(private bienService: BienService){}

  ngOnInit(): void {
    //Called after the constructor, initializing input properties, and the first call to ngOnChanges.
    //Add 'implements OnInit' to the class.
    this.bienService.getBiens().subscribe(biens => {
      console.log('Réponse API :', biens);
      this.biens = biens});
  }
}
