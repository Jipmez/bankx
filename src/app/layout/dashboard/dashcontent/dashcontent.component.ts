import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ApiService } from '../../../services/api.service';
import { NgForm } from '@angular/forms';
import { SessionStorageService } from 'angular-web-storage';
import { ToastrManager } from 'ng6-toastr-notifications';
declare let $;
@Component({
  selector: 'app-dashcontent',
  templateUrl: './dashcontent.component.html',
  styleUrls: ['./dashcontent.component.scss'],
})
export class DashcontentComponent implements OnInit {
  user: any;
  balance: any;
  credit: any;
  tran = [];
  id: any;
  acc = [];

  constructor(
    public activate: ActivatedRoute,
    private server: ApiService,
    private toastr: ToastrManager,
    private session: SessionStorageService
  ) {
    this.id = this.session.get('sessionID');
    let data = this.activate.snapshot.data;
    this.user = data['news'].types['message'][0]['fname'];
    this.balance = data['news'].types['message'][0]['balance'];
    this.credit = data['news'].types['message'][0]['credit_available'];
    this.tran = data['news'].types['trans'];
  }

  ngOnInit(): void {
    let acc = {
      id: this.id,
      key: 'getAcc',
    };
    this.server.Api(acc).subscribe((res) => {
      if (res['message']) {
        this.acc = res['message'];
      }
    });
  }

  trans(x: NgForm) {
    let tr = {
      id: this.id,
      data: x.value,
      key: 'trx',
    };
    this.server.Api(tr).subscribe((res) => {
      if (res['code'] == 1) {
        $('#pass').click();
      }
    });
  }

  transtk(x: NgForm) {
    let trk = {
      id: this.id,
      data: x.value,
      key: 'trxk',
    };
    this.server.Api(trk).subscribe((res) => {
      if (res['code'] == 1) {
        this.toastr.successToastr('Transaction confirmed', 'Security Center');
      } else {
        this.toastr.warningToastr('Could not verify token', 'Security Center');
      }
    });
  }
}
