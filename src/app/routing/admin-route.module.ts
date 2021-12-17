import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Routes, RouterModule } from '@angular/router';
import { AdmindashComponent } from '../layout/admin/admindash/admindash.component';
import { AdmincontentComponent } from '../layout/admin/admincontent/admincontent.component';
import { AdminService } from '../services/resolve/admin.service';
import { ProfileComponent } from '../layout/admin/profile/profile.component';

const routes: Routes = [
  {
    path: '',
    component: AdmindashComponent,
    children: [
      {
        path: '',
        component: AdmincontentComponent,
        resolve: {
          content: AdminService,
        },
      },
      {
        path: 'profile/:id',
        component: ProfileComponent,
      },
    ],
    resolve: {
      content: AdminService,
    },
  },
];

@NgModule({
  declarations: [],
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdminRouteModule {}
