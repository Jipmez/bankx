import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { SessionStorageService } from 'angular-web-storage';
import { ToastrManager } from 'ng6-toastr-notifications';
import { ApiService } from '../../../services/api.service';
import { NgForm } from '@angular/forms';

declare let $;
@Component({
  selector: 'app-send',
  templateUrl: './send.component.html',
  styleUrls: ['./send.component.scss'],
})
export class SendComponent implements OnInit {
  id: any;
  acc: [];
  amount: any;
  bank: any;
  send: number = 0;
  trx_id: any;

  constructor(
    public activate: ActivatedRoute,
    private server: ApiService,
    private toastr: ToastrManager,
    private session: SessionStorageService
  ) {
    this.id = this.session.get('sessionID');
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
    this.amount = x.value.amount;
    this.bank = x.value.bank;
    let tr = {
      id: this.id,
      data: x.value,
      key: 'trx',
    };
    this.send = 1;
    this.server.Api(tr).subscribe((res) => {
      if (res['code'] == 1) {
        this.send = 1;

        this.amount = res['message']['amount'];
        this.trx_id = res['message']['trx_id'];
      } else {
        this.send = 4;
      }
    });
  }

  open() {
    $('#pass').click();
  }

  transtk(x: NgForm) {
    let trk = {
      id: this.id,
      data: x.value,
      amount: this.amount,
      trx_id: this.trx_id,
      key: 'trxk',
    };
    this.server.Api(trk).subscribe((res) => {
      if (res['code'] == 1) {
        this.toastr.successToastr('Transaction confirmed', 'Security Center');
        this.send = 2;
        $('#close').click();
      } else if (res['code'] == 2) {
        this.toastr.warningToastr('Could not verify token', 'Security Center');
      } else {
        $('#close').click();
        this.send = 3;
        this.toastr.warningToastr('Transaction Terminated', 'Security Center');
      }
    });
  }
}
