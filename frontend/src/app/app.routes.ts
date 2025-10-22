import { Routes } from '@angular/router';
import { AccueilComponent } from './pages/accueil/accueil.component';

export const routes: Routes = [
    {path:'', redirectTo:'accueil',pathMatch:'full'},
    {path:'accueil',component:AccueilComponent},
];
