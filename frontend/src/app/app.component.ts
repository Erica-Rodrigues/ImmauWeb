import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { NavigationComponent } from "./composant/navigation/navigation.component";
import { FooterComponent } from "./composant/footer/footer.component";
import { AccueilComponent } from "./pages/accueil/accueil.component";

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, NavigationComponent, FooterComponent, AccueilComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'frontend';
}
