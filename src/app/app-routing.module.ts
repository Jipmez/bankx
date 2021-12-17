import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { NavComponent } from './layout/home/nav/nav.component';
import { HomeComponent } from './layout/home/home/home.component';
import { LoginComponent } from './layout/home/login/login.component';
import { RegisterComponent } from './layout/home/register/register.component';
import { ContactComponent } from './layout/home/contact/contact.component';

const routes: Routes = [
  {
    path: 'dash',
    loadChildren: () =>
      import('./modules/dash.module').then((m) => m.DashModule),
  },
  {
    path: 'siwuyhduhuiwuhuehuhoo',
    loadChildren: () =>
      import('./modules/admin.module').then((m) => m.AdminModule),
  },

  {
    path: '',
    component: NavComponent,
    children: [
      {
        path: '',
        component: HomeComponent,
      },
      {
        path: 'contact',
        component: ContactComponent,
      },
    ],
  },
  {
    path: 'login',
    component: LoginComponent,
  },
  {
    path: 'register',
    component: RegisterComponent,
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, { useHash: false })],
  exports: [RouterModule],
})
export class AppRoutingModule {}
