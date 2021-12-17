import { Injectable } from '@angular/core';
import { Resolve } from '@angular/router';
import { ApiService } from '../api.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
import { forkJoin } from 'rxjs/observable/forkJoin';
import { SessionStorageService } from 'angular-web-storage';

@Injectable({
  providedIn: 'root',
})
export class DashService {
  path: string;
  cookieValue: any;

  constructor(
    private server: ApiService,
    public session: SessionStorageService,

    private httpClient: HttpClient
  ) {
    this.path = this.server.Getpath();

    this.cookieValue = this.session.get('sessionID');
  }

  resolve(): Observable<any> {
    let load = {
      Id: this.cookieValue,
      key: 'user',
    };

    let card = {
      Id: this.cookieValue,
      key: 'card',
    };

    let bank = {
      Id: this.cookieValue,
      key: 'bankaccounts',
    };

    return forkJoin([
      this.httpClient.post(this.path, load),
      this.httpClient.post(this.path, card),
      this.httpClient.post(this.path, bank).catch((error) => {
        return Observable.throw(error);
      }),
    ]).map((result) => {
      return {
        types: result[0],
        card: result[1],
        bank: result[2],
      };
    });
  }
}
