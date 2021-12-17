import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { NgForm } from '@angular/forms';
import { ApiService } from 'src/app/services/api.service';
import { SessionStorageService } from 'angular-web-storage';
import { ToastrManager } from 'ng6-toastr-notifications';
import { FormGroup, FormControl } from '@angular/forms';
import { Validators } from '@angular/forms';

declare var $;
@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.scss'],
})
export class CardComponent implements OnInit {
  cards = [];
  bank = [];
  val: any;

  constructor(
    public activate: ActivatedRoute,
    private server: ApiService,
    public session: SessionStorageService,
    private toastr: ToastrManager
  ) {
    this.val = this.session.get('sessionID');
    let data = this.activate.snapshot.data;
    console.log(data);
    this.cards = data['news'].card['message'];
    this.bank = data['news'].bank['message'];
  }

  AddbankForm = new FormGroup({
    country: new FormControl('nigeria'),
    accname: new FormControl('', Validators.required),
    bankname: new FormControl('', Validators.required),
    accnumber: new FormControl('', Validators.required),
    key: new FormControl('addB'),
    id: new FormControl(this.val),
  });

  ngOnInit(): void {}

  Addcard(x: NgForm) {
    console.log(x.value);
    let card = {
      new: x.value,
      id: this.val,
      key: 'addC',
    };

    this.server.Api(card).subscribe((res) => {
      this.toastr.successToastr(res['message'], 'security');
      x.reset();
      $('#close').click();
    });
    x.reset();
  }

  editC(x: NgForm, p) {
    let card = {
      ecard: x.value,
      id: p,
      key: 'eddC',
    };

    this.server.Api(card).subscribe((res) => {
      this.toastr.successToastr(res['message'], 'security');
      x.reset();
      $('#close' + p).click();
    });

    x.reset();
  }

  delete(x) {
    let card = {
      id: x,
      key: 'delC',
    };

    this.server.Api(card).subscribe((res) => {
      this.toastr.successToastr(res['message'], 'security');
      $('#close' + x).remove();
    });

    x.reset();
  }

  addBank(x: NgForm) {
    let bank = {
      data: x.value,
      key: 'addB',
      id: this.val,
    };
    this.server.Api(bank).subscribe((res) => {
      this.toastr.successToastr(res['message'], 'security');
      $('#dls').click();
    });
  }

  deleteB(x) {
    let card = {
      id: x,
      key: 'delB',
    };

    this.server.Api(card).subscribe((res) => {
      this.toastr.successToastr(res['message'], 'security');
      $('#close' + x).remove();
    });
  }
}
