import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../../services/api.service';
import { NgForm } from '@angular/forms';
import { ToastrManager } from 'ng6-toastr-notifications';
import { SessionStorageService } from 'angular-web-storage';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  constructor(
    private server: ApiService,
    private toastr: ToastrManager,
    public session: SessionStorageService,
    private route: Router,
    private ac: ActivatedRoute
  ) {
    this.ac.queryParams.subscribe((res) => {
      if (res.en != 'unifiedlogin') window.location.href = '';
    });
  }
  verified = 1;
  ngOnInit(): void {}

  logIn(x: NgForm) {
    var emailRe = /^.+@.+\..{2,4}$/;
    if (x.value.accountn.length == 11 || x.value.accountn.match(emailRe)) {
      let comingUser = [x.value.accountn, x.value.password];

      let err = [
        'account number is incorrect',
        'password should not be less than three',
      ];

      let p = 0;
      let count = 0;

      while (p < comingUser.length) {
        if (comingUser[p].length < 4) {
          this.toastr.warningToastr(err[p]);
          break;
        } else {
          count++;
        }
        p++;
      }

      if (count == comingUser.length) {
        let logInfo = {
          accountn: x.value.accountn,
          password: x.value.password,
          key: 'log',
        };

        this.server.Api(logInfo).subscribe(
          (res) => {
            if (res['code'] == 1) {
              this.toastr.successToastr(res['message'], 'Security center');
              this.verified = 2;
              /*   let bag = res['token'];
              this.session.set('sessionID', bag); */
              // this.cookieService.set("logID", bag);
              /*
              this.route.navigate(['dash']); */
            }

            if (res['code'] == 2) {
              this.toastr.successToastr(
                res['message'],
                'Redirecting to dashboard'
              );
              let bag = res['token'];
              this.session.set('adminID', bag);
              this.route.navigate(['siwuyhduhuiwuhuehuhoo']);
            }

            if (res['code'] == 3) {
              this.toastr.warningToastr(res['message'], 'Security center');
            } else {
              this.toastr.infoToastr(res['message']);
            }
          },
          () => {},
          () => {}
        );
      }
    } else {
    }
  }

  verify(x: NgForm) {
    let token = {
      token: x.value.token,
      key: 'token',
    };

    this.server.Api(token).subscribe((res) => {
      if (res['code'] == 2) {
        this.toastr.successToastr(res['message'], 'Security center');
        this.verified = 2;
        let bag = res['token'];
        this.session.set('sessionID', bag);
        this.route.navigate(['dash']);
      } else {
        this.toastr.warningToastr(res['message'], 'Security center');
      }
    });
  }
}
