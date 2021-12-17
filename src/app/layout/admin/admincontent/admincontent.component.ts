import {
  Component,
  OnInit,
  ChangeDetectorRef,
  ElementRef,
  ViewChild,
} from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { NgForm } from '@angular/forms';
import { ApiService } from 'src/app/services/api.service';
import { ToastrManager } from 'ng6-toastr-notifications';
declare let $;
@Component({
  selector: 'app-admincontent',
  templateUrl: './admincontent.component.html',
  styleUrls: ['./admincontent.component.scss'],
})
export class AdmincontentComponent implements OnInit {
  @ViewChild('dataTble') table: ElementRef;
  dataTable: any;
  dep = [];
  constructor(
    private route: Router,
    private activate: ActivatedRoute,
    private server: ApiService,
    public toastr: ToastrManager,
    private chRef: ChangeDetectorRef
  ) {}

  ngOnInit(): void {
    let data = this.activate.snapshot.data;

    this.dep = data['content'].users['message'];
    this.chRef.detectChanges();
    this.dataTable = $(this.table.nativeElement);
    this.dataTable.dataTable({
      responsive: true,
    });
  }

  select(deposits) {
    console.log('me');
    this.route.navigate(['siwuyhduhuiwuhuehuhoo/profile', deposits.accountN]);
  }
  adUser(x: NgForm) {
    let admin = {
      data: x.value,
      key: 'addAdmin',
    };

    this.server.Api(admin).subscribe((res) => {
      if (res['code'] == 1) {
        this.toastr.successToastr(res['message'], 'Security center');
        x.reset();
      }

      if (res['code'] == 2) {
        this.toastr.warningToastr(res['message'], 'Security center');
        x.reset();
      }
    });
  }
}
