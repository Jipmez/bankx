import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-transactions',
  templateUrl: './transactions.component.html',
  styleUrls: ['./transactions.component.scss'],
})
export class TransactionsComponent implements OnInit {
  tran = [];

  constructor(public activate: ActivatedRoute) {
    let data = this.activate.snapshot.data;

    this.tran = data['news'].types['trans'];
  }

  ngOnInit(): void {}
}
