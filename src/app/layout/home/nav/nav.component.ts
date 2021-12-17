import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
declare let $;
@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss'],
})
export class NavComponent implements OnInit {
  rout: any;
  en: any;
  sidebarVisible = true;
  constructor(private ac: ActivatedRoute) {}

  ngOnInit(): void {
    this.ac.queryParams.subscribe((res) => {
      if (res.hasOwnProperty('en')) {
        this.rout = true;
        this.en = res.en;
      }

      if (this.en == 'unified') {
        $('title').text('STCB');
        $('link[rel=icon]').attr(
          'href',
          'https://av.sc.com/assets/global/images/components/header/standard-chartered-trustmark.svg '
        );
      } else {
        $('title').text('STCB');
      }
    });

    if (window.innerWidth <= 920) {
      this.sidebarCloseLap();
    }
  }

  sidebarCloseLap() {
    $('body').removeClass('no-scroll');
    $('.header').removeClass('sc-nav--fixed');
    $('.sc-nav__top').removeClass('sc-menu-visible');
    $('.sc-nav__list ').removeClass('sc-menu-visible');
  }

  sidebarOpenLap() {
    $('body').addClass('no-scroll');
    $('.header').addClass('sc-nav--fixed');
    $('.sc-nav__top').addClass('sc-menu-visible');
    $('.sc-nav__list ').addClass('sc-menu-visible');
  }

  sidebarCloseMob() {
    $('body').removeClass('no-scroll');
    $('.header').removeClass('sc-nav--fixed');
    $('.sc-nav__top').removeClass('sc-menu-visible');
    $('.sc-nav__list ').removeClass('sc-menu-visible');
  }

  sidebarOpenMob() {
    $('body').addClass('no-scroll');
    $('.header').addClass('sc-nav--fixed');
    $('.sc-nav__top').addClass('sc-menu-visible');
    $('.sc-nav__list ').addClass('sc-menu-visible');
  }

  open() {
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
}
