import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AngularWebStorageModule } from 'angular-web-storage';
import { ToastrModule } from 'ng6-toastr-notifications';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavComponent } from './layout/home/nav/nav.component';
import { HomeComponent } from './layout/home/home/home.component';
import { LoginComponent } from './layout/home/login/login.component';
import { RegisterComponent } from './layout/home/register/register.component';
import { ContactComponent } from './layout/home/contact/contact.component';

@NgModule({
  declarations: [AppComponent, NavComponent, HomeComponent, LoginComponent, RegisterComponent, ContactComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    CommonModule,
    HttpClientModule,
    BrowserAnimationsModule, // required animations module
    HttpClientModule,
    ToastrModule.forRoot(),
    AngularWebStorageModule,
    FormsModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
