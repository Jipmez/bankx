import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
declare let $;
@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent implements OnInit {
  rout: any;
  constructor(private ac: ActivatedRoute) {}

  ngOnInit(): void {
    this.ac.queryParams.subscribe((res) => {
      this.rout = res.en;
      console.log(this.rout);
    });

    $('#carousel-example').on('slide.bs.carousel', function (e) {
      /*
          CC 2.0 License Iatek LLC 2018 - Attribution required
      */
      var $e = $(e.relatedTarget);
      var idx = $e.index();
      var itemsPerSlide = 1;
      var totalItems = $('.carousel-item').length;

      if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
          // append slides to end
          if (e.direction == 'left') {
            $('.carousel-item').eq(i).appendTo('.carousel-inner');
          } else {
            $('.carousel-item').eq(0).appendTo('.carousel-inner');
          }
        }
      }
    });
  }
}
