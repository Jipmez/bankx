import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { ApiService } from './../../../services/api.service';
import { ToastrManager } from 'ng6-toastr-notifications';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss'],
})
export class RegisterComponent implements OnInit {
  constructor(
    private route: Router,
    private activate: ActivatedRoute,
    private server: ApiService,
    public toastr: ToastrManager
  ) {
    this.activate.queryParams.subscribe((res) => {
      if (res.en != 'unifiedsignup') window.location.href = '';
    });
  }
  ngOnInit(): void {}

  adUser(x: NgForm) {
    let admin = {
      data: x.value,
      key: 'addAdmin',
    };

    this.server.Api(admin).subscribe((res) => {
      if (res['code'] == 1) {
        this.toastr.successToastr(res['message'], 'Security center');
        x.reset();
        this.route.navigate['login'];
      }

      if (res['code'] == 2) {
        this.toastr.warningToastr(res['message'], 'Security center');
        x.reset();
      }
    });
  }
}
