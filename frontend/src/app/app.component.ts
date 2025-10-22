import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { NavigationComponent } from "./composant/navigation/navigation.component";
import { FooterComponent } from "./composant/footer/footer.component";

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, AccueilComponent, NavigationComponent, FooterComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend';
}
