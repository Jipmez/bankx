import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';

import { DashRouteModule } from '../routing/dash-route.module';
import { DashComponent } from '../layout/dashboard/dash/dash.component';
import { DashcontentComponent } from '../layout/dashboard/dashcontent/dashcontent.component';
import { TransactionsComponent } from '../layout/dashboard/transactions/transactions.component';
import { CardComponent } from '../layout/dashboard/card/card.component';
import { ProfileComponent } from '../layout/dashboard/profile/profile.component';
import { SendComponent } from '../layout/dashboard/send/send.component';

@NgModule({
  declarations: [
    DashComponent,
    DashcontentComponent,
    TransactionsComponent,
    CardComponent,
    ProfileComponent,
    SendComponent,
  ],
  imports: [CommonModule, DashRouteModule, FormsModule, ReactiveFormsModule],
})
export class DashModule {}
