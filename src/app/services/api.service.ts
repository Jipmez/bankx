import { Injectable, Renderer2 } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import 'rxjs/Rx';
import { SessionStorageService } from 'angular-web-storage';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  constructor(
    private serviceBoy: HttpClient,
    public session: SessionStorageService,
    private nav: Router
  ) {}

  path: string = 'https://stcbnk.com/bank/baseApi.php';

  Api(x) {
    return this.serviceBoy.post(this.path, x);
  }

  Getpath() {
    return this.path;
  }

  logOut() {
    let id = this.session.get('sessionID');
    if (id) {
      this.session.remove('sessionID');
      if (this.session.get('sessionID') == null) {
        this.nav.navigate(['/login'], { queryParams: { en: 'unifiedlogin' } });
      }
    }
  }

  AlogOut() {
    let id = this.session.get('adminID');
    if (id) {
      this.session.remove('adminID');
      if (this.session.get('adminID') == null) {
        this.nav.navigate(['']);
      }
    }
  }
}
