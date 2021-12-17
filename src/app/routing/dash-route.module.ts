import { NgModule } from '@angular/core';

import { Routes, RouterModule } from '@angular/router';
import { DashComponent } from '../layout/dashboard/dash/dash.component';
import { DashcontentComponent } from '../layout/dashboard/dashcontent/dashcontent.component';
import { TransactionsComponent } from '../layout/dashboard/transactions/transactions.component';
import { ProfileComponent } from '../layout/dashboard/profile/profile.component';
import { CardComponent } from '../layout/dashboard/card/card.component';
import { SendComponent } from '../layout/dashboard/send/send.component';
import { DashService } from '../services/resolve/dash.service';

const routes: Routes = [
  {
    path: '',
    component: DashComponent,
    children: [
      {
        path: '',
        component: DashcontentComponent,
        resolve: {
          news: DashService,
        },
      },
      {
        path: 'transactions',
        component: TransactionsComponent,
        resolve: {
          news: DashService,
        },
      },
      {
        path: 'profile',
        component: ProfileComponent,
        resolve: {
          news: DashService,
        },
      },
      {
        path: 'card',
        component: CardComponent,
        resolve: {
          news: DashService,
        },
      },
      {
        path: 'send',
        component: SendComponent,
      },
    ],
    resolve: {
      news: DashService,
    },
  },
];
@NgModule({
  declarations: [],
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DashRouteModule {}
