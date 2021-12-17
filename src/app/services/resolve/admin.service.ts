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
export class AdminService {
  path: string;
  cookieValue: any;

  constructor(
    private server: ApiService,
    public session: SessionStorageService,

    private httpClient: HttpClient
  ) {
    this.path = this.server.Getpath();
  }

  resolve(): Observable<any> {
    let load = {
      key: 'allU',
    };

    return forkJoin([
      this.httpClient.post(this.path, load).catch((error) => {
        return Observable.throw(error);
      }),
    ]).map((result) => {
      return {
        users: result[0],
      };
    });
  }
}
