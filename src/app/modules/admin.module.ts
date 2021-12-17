import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { AdmindashComponent } from '../layout/admin/admindash/admindash.component';
import { AdmincontentComponent } from '../layout/admin/admincontent/admincontent.component';
import { AdminRouteModule } from '../routing/admin-route.module';
import { RouterModule } from '@angular/router';
import { ProfileComponent } from '../layout/admin/profile/profile.component';

@NgModule({
  declarations: [AdmindashComponent, AdmincontentComponent, ProfileComponent],
  imports: [CommonModule, AdminRouteModule, RouterModule, FormsModule],
})
export class AdminModule {}
