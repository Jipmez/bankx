import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DashcontentComponent } from './dashcontent.component';

describe('DashcontentComponent', () => {
  let component: DashcontentComponent;
  let fixture: ComponentFixture<DashcontentComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DashcontentComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DashcontentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
