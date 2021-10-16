import { Component, OnInit } from '@angular/core';
import { RiderService } from '../api/rider.service';

@Component({
  selector: 'app-rider',
  templateUrl: './rider.component.html',
  styleUrls: ['./rider.component.css']
})
export class RiderComponent implements OnInit {

  currentlyOffline: any;
  currentlyOnline: any;
  residential: any;
  current: any;
  riderRecord: any;

  
  constructor(private riderService: RiderService) { }

  ngOnInit(): void {
    this.riderService.getRider()
    .subscribe(
      data => {
        this.riderRecord = data.user[0];
      },
      error => {
        console.log(error);
      });
    this.currentlyOffline = true;
  }

  selectedAddressType(event: any) {
    if (event.target.value == 'Current') {
      this.current = true;
      this.residential = false;
    } else {
      this.residential = true;
      this.current = false;
    }

  }

  online() {
    this.currentlyOnline = true;
    this.currentlyOffline = false;
    this.current = false;
    this.residential = true;
  }

  offline() {
    this.currentlyOffline = true;
    this.currentlyOnline = false;
    this.current = false;
    this.residential = true;
  }

}
