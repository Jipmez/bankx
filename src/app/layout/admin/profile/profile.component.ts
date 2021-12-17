import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { ToastrManager } from 'ng6-toastr-notifications';
import { SessionStorageService } from 'angular-web-storage';
import { ApiService } from '../../../services/api.service';
declare let $;
@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {
  id: string;
  dep = [];
  email: any;
  username: any;
  fileToUpload: File = null;
  imageUrl: string;
  accountbal: any;
  restrain: any;
  constructor(
    private route: ActivatedRoute,
    private server: ApiService,
    public toastr: ToastrManager,
    private session: SessionStorageService,
    private rout: Router
  ) {}

  ngOnInit(): void {
    this.id = this.route.snapshot.paramMap.get('id');

    let user = {
      proid: this.id,
      key: 'proUser',
    };

    this.server.Api(user).subscribe(
      (res) => {
        if (res['code'] == 1) {
          this.username = res['message'][0]['fname'];

          this.accountbal = res['message'][0]['balance'];

          this.email = res['message'][0]['email'];

          this.imageUrl = res['message'][0]['image_url'];

          this.restrain = res['message'][0]['restrain'];

          this.dep = res['dep'];
        }
      },
      () => {},
      () => {}
    );
  }

  person(so: NgForm) {}

  account(po: NgForm) {}

  Ctrx(x: NgForm) {
    let Ctrx = {
      id: this.id,
      data: x.value,
      key: 'Ctrx',
    };
    this.server.Api(Ctrx).subscribe((res) => {
      if (res) {
        this.toastr.infoToastr(res['message']);
        x.reset();
      }
      x.reset();
    });
    x.reset();
  }

  Dtrx(x: NgForm) {
    let Dtrx = {
      id: this.id,
      data: x.value,
      key: 'Dtrx',
    };
    this.server.Api(Dtrx).subscribe((res) => {
      if (res) {
        this.toastr.infoToastr(res['message']);
        x.reset();
      }
      x.reset();
    });
    x.reset();
  }

  restrict(x) {
    let perm = {
      id: this.id,
      data: x,
      key: 'perm',
    };

    this.server.Api(perm).subscribe((res) => {
      if (res) {
        this.toastr.infoToastr(res['message']);
      }
    });
  }

  delete(x) {
    let Deltrx = {
      id: this.id,
      data: x,
      key: 'Deltrx',
    };

    this.server.Api(Deltrx).subscribe((res) => {
      if (res) {
        this.toastr.infoToastr(res['message']);
        $('#' + x).remove();
      }
      $('#' + x).remove();
    });
  }

  handlePic(file: FileList) {
    this.fileToUpload = file.item(0);
    var reader = new FileReader();
    reader.onload = (event: any) => {
      this.imageUrl = event.target.result;
    };
    reader.readAsDataURL(this.fileToUpload);
  }

  sub() {
    const fd = new FormData();

    fd.append('key', 'uPix');
    fd.append('id', this.id);
    fd.append('photo', this.fileToUpload, this.fileToUpload.name);
    this.server.Api(fd).subscribe((res) => {
      if (res['code'] == 1) {
        this.imageUrl = res['message'];
        console.log(res);
        /*  this.server.currentMessage.subscribe(message => this.imageUrl = res.message) */
      }
    });
  }
}
