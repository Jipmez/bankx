import { Component, OnInit } from '@angular/core';
import { ToastrManager } from 'ng6-toastr-notifications';
import { SessionStorageService } from 'angular-web-storage';
import { ActivatedRoute } from '@angular/router';
import { ApiService } from '../../../services/api.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {
  id: any;
  user: any;
  balance: any;
  credit: any;
  tran: any;
  lname: any;
  accountN: any;
  imageUrl: string;
  email: any;
  constructor(
    public activate: ActivatedRoute,
    private server: ApiService,
    private toastr: ToastrManager,
    private session: SessionStorageService
  ) {
    this.id = this.session.get('sessionID');
    let data = this.activate.snapshot.data;
    this.user = data['news'].types['message'][0]['fname'];
    this.lname = data['news'].types['message'][0]['lname'];
    this.balance = data['news'].types['message'][0]['balance'];
    this.accountN = data['news'].types['message'][0]['accountN'];
    this.credit = data['news'].types['message'][0]['credit_available'];
    this.imageUrl = data['news'].types['message'][0]['image_url'];
    this.tran = data['news'].types['trans'];
    this.email = data['news'].types['message'][0]['email'];
  }

  ngOnInit(): void {}
}
