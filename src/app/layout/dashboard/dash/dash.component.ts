import {
  Component,
  OnInit,
  ViewContainerRef,
  Inject,
  Renderer2,
} from '@angular/core';
import { ApiService } from '../../../services/api.service';
import { Router, NavigationEnd, ActivatedRoute } from '@angular/router';
import { SessionStorageService } from 'angular-web-storage';
import { DOCUMENT } from '@angular/common';

declare var $;
@Component({
  selector: 'app-dashboard',
  templateUrl: './dash.component.html',
  styleUrls: ['./dash.component.scss'],
})
export class DashComponent implements OnInit {
  currentUrl: string;
  cookieValue: string;
  sidebarVisible: boolean;
  user: any;
  payed: any;
  imageUrl: string;
  country: any;

  constructor(
    private server: ApiService,
    public session: SessionStorageService,
    private activate: ActivatedRoute,
    private _renderer2: Renderer2,
    private route: Router,
    @Inject(DOCUMENT) private _document: Document
  ) {
    route.events.subscribe((_: NavigationEnd) => (this.currentUrl = _.url));
    this.sidebarVisible = true;
  }

  ngOnInit() {
    /*     this.server.render(
      this._renderer2,
      'https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=false',
      this._document
    ); */

    $('title').text('STCB');
    $('link[rel=icon]').attr(
      'href',
      'https://av.sc.com/assets/global/images/components/header/standard-chartered-trustmark.svg '
    );

    this.cookieValue = this.session.get('sessionID');

    let data = this.activate.snapshot.data;
    this.user = data['news'].types['message'][0]['fname'];
    this.imageUrl = data['news'].types['message'][0]['image_url'];
    /*   this.payed = data['news'].dep['message'][0]['payed'];
    this.country = data['news'].dep['message'][0]['country']; */

    /* if (this.payed == '0' && this.country !== 'Nigerian') {
      this.route.navigate(['/dashboard']);
    } else {
      this.route.navigate(['/dashboard']);
    } */

    if (window.innerWidth <= 920) {
      this.sidebarCloseLap();
    }
  }

  toggleme() {
    if (window.innerWidth > 920) {
      if (this.sidebarVisible === true) {
        this.sidebarCloseLap();
        this.sidebarVisible = false;
      } else {
        this.sidebarOpenLap();
        this.sidebarVisible = true;
      }
    }

    if (window.innerWidth <= 920) {
      if (this.sidebarVisible === true) {
        this.sidebarCloseMob();
        this.sidebarVisible = false;
      } else {
        this.sidebarOpenMob();
        this.sidebarVisible = true;
      }
    }
  }

  sidebarCloseLap() {
    $('.main-nav').addClass('close_icon');
  }
  sidebarOpenLap() {
    $('.main-nav').removeClass('close_icon');
  }

  sidebarCloseMob() {
    $('.main-nav').addClass('close_icon');
  }

  sidebarOpenMob() {
    $('.main-nav').removeClass('close_icon');
  }

  logOut() {
    this.server.logOut();
  }
}
