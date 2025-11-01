import { Routes } from '@angular/router';
import { AccueilComponent } from './pages/accueil/accueil.component';
import { LoginComponent } from './pages/login/login.component';
import { RegisterComponent } from './pages/register/register.component';
import { ContactComponent } from './pages/contact/contact.component';
import { LocationComponent } from './pages/location/location.component';
import { VenteComponent } from './pages/vente/vente.component';

export const routes: Routes = [
    {path:'', redirectTo:'accueil',pathMatch:'full'},
    {path:'accueil',component:AccueilComponent},
    {path:'login',component:LoginComponent},
    {path:'register',component:RegisterComponent},
    {path: 'contact', component:ContactComponent},
    {path: 'location', component:LocationComponent},
    {path: 'vente', component:VenteComponent},
];
