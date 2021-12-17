import { Component, OnInit } from '@angular/core';
import { SessionStorageService } from 'angular-web-storage';
import { Router, ActivatedRoute, NavigationEnd } from '@angular/router';
import { ApiService } from '../../../services/api.service';
declare let $;
@Component({
  selector: 'app-admindash',
  templateUrl: './admindash.component.html',
  styleUrls: ['./admindash.component.scss'],
})
export class AdmindashComponent implements OnInit {
  currentUrl: string;
  cookieValue: string;
  sidebarVisible: boolean;
  user: any;

  constructor(
    private server: ApiService,
    public session: SessionStorageService,
    private activate: ActivatedRoute,
    private route: Router
  ) {
    route.events.subscribe((_: NavigationEnd) => (this.currentUrl = _.url));
    this.sidebarVisible = true;
  }

  ngOnInit() {
    this.cookieValue = this.session.get('sessionID');

    if (window.innerWidth <= 920) {
      this.sidebarVisible = false;
    }
  }

  toggle() {
    $('.sidenav').toggleClass('active');
  }

  toggleme() {
    if (this.sidebarVisible === true) {
      this.sidebarClose();

      this.sidebarVisible = false;
    } else {
      this.sidebarOpen();

      this.sidebarVisible = true;
    }
  }
  sidebarClose() {
    $('.sidenav').css('margin-left', '-260px');
    $('.main-content').css('margin-left', '0px');
    $('.our-nav').css('margin-left', '0px');
    if (window.innerWidth <= 920) {
      $('.main-content').css('position', 'relative');
    }
  }
  sidebarOpen() {
    $('.sidenav').css('margin-left', '0px');
    $('.main-content').css('margin-left', '260px');
    $('.our-nav').css('margin-left', '260px');
    if (window.innerWidth <= 920) {
      $('.main-content').css('position', 'fixed');
    }
  }

  AlogOut() {
    this.server.AlogOut();
  }
}
